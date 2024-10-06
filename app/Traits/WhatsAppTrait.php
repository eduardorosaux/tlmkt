<?php
namespace App\Traits;
use App\Models\Client;
use App\Models\Contact;
use App\Models\Message;
use App\Models\BotReply;
use App\Enums\StatusEnum;
use App\Enums\MessageEnum;
use App\Enums\BotReplyType;
use App\Traits\CommonTrait;
use Orhanerday\OpenAi\OpenAi;
use App\Enums\MessageStatusEnum;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Netflie\WhatsAppCloudApi\WhatsAppCloudApi;
use Netflie\WhatsAppCloudApi\Message\Media\LinkID;
use Netflie\WhatsAppCloudApi\Message\Template\Component;

trait WhatsAppTrait
{
    use SendNotification, CommonTrait;

    public $facebook_api = 'https://graph.facebook.com/v19.0/';

    private function sendWhatsAppCampaignMessage($message)
    {
        $client = Client::find($message->client_id);
        try {
            $accessToken             = getClientWhatsAppAccessToken($client);
            $whatspp_phone_number_id = getClientWhatsAppPhoneID($client);
            $template                = $message->campaign->template ?? $message->template;
            if (!empty($template)) {
                $contact                 = $message->contact;
                if ($message->contact->status == 1) {
                    $whatsapp_cloud_api = new WhatsAppCloudApi([
                        'from_phone_number_id' => $whatspp_phone_number_id,
                        'access_token'         => $accessToken,
                    ]);
                    $component_header   = json_decode($message->component_header)  ?? [];
                    $component_body     = json_decode($message->component_body)    ?? [];
                    $component_buttons  = json_decode($message->component_buttons) ?? [];
                    $components         = new Component($component_header, $component_body, $component_buttons);
                    $message_api        = $whatsapp_cloud_api->sendTemplate($contact->phone, $template->name, $template->language, $components);
                    $message_body       = json_decode($message_api->body(), true);
                    if (!empty($message_body['messages'])) {
                        $message->message_id = $message_body['messages'][0]['id'];
                        $message->status     = MessageStatusEnum::SENT;
                        $message->update();
                    } else {
                        $message->error  = isset($message_body['error']) ? $message_body['error']['message'] : 'Unknown';
                        $message->status = MessageStatusEnum::FAILED;
                        $message->update();
                    }
                }
                if ($message->campaign) {
                    $campaign = $message->campaign;
                    $campaignMessages = $campaign->messages();
                    if ($campaignMessages->count() == 1) {
                        DB::table('campaigns')->where('id', $campaign->id)->update([
                            'status' => StatusEnum::PROCESSED
                        ]);
                    }
                }
                return true;
            } else {
                $message->error  = 'Template is empty';
                $message->status = MessageStatusEnum::FAILED;
                $message->update();
                return false;
            }
        } catch (\Exception $e) {
            if ($message->campaign) {
                $campaign = $message->campaign;
                DB::table('campaigns')->where('id', $campaign->id)->update([
                    'status' => StatusEnum::PROCESSED
                ]);
            }
            $errorMessage = isset(json_decode($e->getMessage(), true)['error']['message']) ? json_decode($e->getMessage(), true)['error']['message'] : 'Unknown';
            $message->error = $errorMessage;
            $message->status = MessageStatusEnum::FAILED;
            $message->save();

            \Log::info('send Whatsapp Campaign', [$e->getMessage()]);

            return false;
        }
    }

    public function sendWhatsAppMessage($message, $message_type)
    {
        Log::info('sendWhatsAppMessage called : ', [1]);
        Log::info('send WhatsApp Message: ', [$message]);

        $client = Client::find($message->client_id);
        try {
            $accessToken = getClientWhatsAppAccessToken($client);
            $whatsapp_phone_number_id = getClientWhatsAppPhoneID($client);
            $contact = $message->contact;
            $whatsapp_cloud_api = new WhatsAppCloudApi([
                'from_phone_number_id' => $whatsapp_phone_number_id,
                'access_token' => $accessToken,
            ]);
             if ($message_type == 'text') {
                Log::error($message_type);
                $response = $whatsapp_cloud_api->sendTextMessage($contact->phone, $message->value);

            } elseif ($message_type == 'image') {
                Log::info($message_type);
                $link_id = new LinkID($message->header_image);
                $response = $whatsapp_cloud_api->sendImage($contact->phone, $link_id);
            } elseif ($message_type == 'audio') {
                Log::error($message_type);
                $link_id = new LinkID($message->header_audio);
                $response = $whatsapp_cloud_api->sendAudio($contact->phone, $link_id);
            } elseif ($message_type == 'video') {
                Log::error($message_type);
                $caption = '';
                $link_id = new LinkID($message->header_video);
                $response = $whatsapp_cloud_api->sendVideo($contact->phone, $link_id, $caption);

            } elseif ($message_type == 'document') {
                Log::error($message_type);
                $document_name = basename($message->header_document);
                $document_caption = '';
                $document_link = $message->header_document;
                $link_id = new LinkID($document_link);
                $response = $whatsapp_cloud_api->sendDocument($contact->phone, $link_id, $document_name, $document_caption);
            }

            $message_body = json_decode($response->body(), true);
            if (!empty($message_body['messages'])) {
                $message->message_id = $message_body['messages'][0]['id'];
                $message->status = MessageStatusEnum::SENT;
            } else {
                $message->error = isset($message_body['error']) ? $message_body['error']['message'] : 'Unknown';
                $message->status = MessageStatusEnum::FAILED;
                // $this->conversationUpdate($message->client_id, $message->contact_id);
                // return true;
            }
            $message->update(); 

            $this->conversationUpdate($message->client_id, $message->contact_id);
            return true;
        } catch (\Exception $e) {
            if (config('app.debug')) {
                dd($e->getMessage());            
            }
            $errorMessage = isset(json_decode($e->getMessage(), true)['error']['message']) ? json_decode($e->getMessage(), true)['error']['message'] : 'Unknown';
            $message->error = $errorMessage;
            $message->status = MessageStatusEnum::FAILED;
            $message->save();
            \Log::info('send Whatsapp Message', [$e->getMessage()]);
            return false;
        }
    }

    public function QuickReply($message)
{
    Log::info('QuickReply how many time call ', [1]);

    try {
        $bot_replies = BotReply::where('client_id', $message->client_id)->where('status', 1)->get();
        Log::info('bot_replies ', [$bot_replies]);

        $contact = Contact::where('id', $message->contact_id)->first();
        Log::info('contact ', [$contact]);

        $client = Client::where('id', $message->client_id)->first();
        Log::info('client ', [$client]);

        $conversation_text = strtolower($message->value);
        $message_text = '';

        foreach ($bot_replies as $reply) {
            $keywords = explode(',', $reply->keywords);
            foreach ($keywords as $keyword) {
                $keyword = trim($keyword);

                if ($reply->reply_type == BotReplyType::EXACT_MATCH && $conversation_text === $keyword) {
                    if ($reply->reply_using_ai == 1 && !empty($client->open_ai_key)) {
                        $message_text = $this->AIReply($keyword, $client);
                    } else {
                        $message_text = $reply->reply_text;
                    }
                    break 2; // Break out of both loops
                } elseif ($reply->reply_type == BotReplyType::CONTAINS && stripos($conversation_text, $keyword) !== false) {
                    if ($reply->reply_using_ai == 1 && !empty($client->open_ai_key)) {
                        $message_text = $this->AIReply($keyword, $client);
                    } else {
                        $message_text = $reply->reply_text;
                    }
                    break 2; // Break out of both loops
                }
            }
        }

        if ($message_text) {
            $pattern = '/{{\s*([^}]+)\s*}}/';
            preg_match_all($pattern, $message_text, $matches);
            $variables = $matches[1];
            foreach ($variables as $variable) {
                switch ($variable) {
                    case 'name':
                        $message_text = str_replace('{{' . $variable . '}}', $contact->name, $message_text);
                        break;
                    case 'phone':
                        $message_text = str_replace('{{' . $variable . '}}', $contact->phone, $message_text);
                        break;
                }
            }

            $reply_message = new Message();
            $reply_message->components = null;
            $reply_message->campaign_id = null;
            $reply_message->contact_id = $contact->id;
            $reply_message->client_id = $client->id;
            $reply_message->value = $message_text;
            $reply_message->message_type = MessageEnum::TEXT;
            $reply_message->status = MessageStatusEnum::SENDING;
            $reply_message->save();
            Log::info('reply_message ', [$reply_message]);

            
        }
        $this->sendWhatsAppMessage($reply_message, 'text');
            return true;
        return false; // No suitable reply found
    } catch (\Exception $e) {
        Log::info('send Quick Reply Message', [$e->getMessage()]);

        return false;
    }
}
    public function AIReply($keyword,$client)
    {
        if (isDemoMode()) {
            return __('demo_mode_notice');
        }
        $message     = null;
        $open_ai_key = $client->open_ai_key;
        $open_ai     = new OpenAi($open_ai_key);
        $use_case    = 'WhatsApp Chat Reply';
        $prompt      = 'Write a ' . $use_case . ' About ' . $keyword;
        $variants    = intval(1);
        $length      = 269 * 1;
        $result      = $open_ai->completion([
            'model'             => 'gpt-3.5-turbo-instruct',
            'prompt'            => $prompt,
            'temperature'       => 0.9,
            'max_tokens'        => (int) $length,
            'frequency_penalty' => 0,
            'presence_penalty'  => 0.6,
            'n'                 => (int) 1,
        ]);
        $result      = json_decode($result);
        if (property_exists($result, 'error')) {
            Log::info('AI Reply error: ', [$result->error->message]);
        }
        if ($result->choices[0]) {
            $message = $result->choices[0]->text;
        } else {
            Log::info('AI Reply error 2: ', ['someting went wrong']);
        }
        return $message;
    }

    public function handleReceivedMedia($client, $media_id, $fileExtension = '.jpg')
    {
        $storage = setting('default_storage') != '' || setting('default_storage') != null ? setting('default_storage') : 'local';
        $url = $this->facebook_api . $media_id;
        $accessToken = getClientWhatsAppAccessToken($client);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->get($url);
            $content = json_decode($response->body(), true);
            $responseImage = $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
            ])->get($content['url']);
            $fileContents = $responseImage->getBody()->getContents();

            if ($fileContents === false) {
                Log::error('Error downloading and storing media');
                throw new \Exception('Error downloading image');
            }

            if ($storage == 'wasabi') {
                $fileName = "images/media/{$content['id']}{$fileExtension}";
                $path = Storage::disk('wasabi')->put($fileName, $fileContents, 'public');
                return Storage::disk('wasabi')->url($fileName);
            } elseif ($storage == 's3') {
                $fileName = "images/media/{$content['id']}{$fileExtension}";
                $path = Storage::disk('s3')->put($fileName, $fileContents, 'public');
                return Storage::disk('s3')->url($fileName);
            } else {
                $directory = public_path('images/media');
                if (!file_exists($directory)) {
                    mkdir($directory, 0755, true); // Create the directory if it doesn't exist
                }

                $fileName = "{$content['id']}{$fileExtension}";
                $filePath = "{$directory}/{$fileName}";

                file_put_contents($filePath, $fileContents);

                return asset("public/images/media/{$fileName}");
            }
        } catch (\Exception $e) {
            Log::error('Error whatsapp downloading and storing media: ' . $e->getMessage());
            return null;
        }
    }

}
