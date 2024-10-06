<?php

namespace App\Repositories\Client;

use App\Models\Client;
use App\Enums\TypeEnum;
use App\Models\Contact;
use App\Models\Message;
use App\Models\BotGroup;
use App\Models\Campaign;
use Illuminate\Support\Str;
use App\Models\Conversation;
use App\Traits\RepoResponse;
use App\Models\ClientSetting;
use App\Traits\TelegramTrait;
use App\Models\GroupSubscriber;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Laravel\Facades\Telegram;

class SettingRepository
{
    use RepoResponse,TelegramTrait;

    private $model;

    private $botGroup;

    private $groupSubscriber;

    private $contact;

    private $conversation;

    private $campaign;

    private $message;
    private $client;

    public function __construct(
        ClientSetting $model,
        BotGroup $botGroup,
        GroupSubscriber $groupSubscriber,
        Contact $contact,
        Conversation $conversation,
        Campaign $campaign,
        Message $message,
        Client $client
    ) {
        $this->model           = $model;
        $this->botGroup        = $botGroup;
        $this->groupSubscriber = $groupSubscriber;
        $this->contact         = $contact;
        $this->conversation    = $conversation;
        $this->campaign        = $campaign;
        $this->message         = $message;
        $this->client         = $client;
    }

    public function update($request)
    {

        DB::beginTransaction();
        try {
            $is_connected = 0;
            $accessToken  = $request->access_token;
            $url          = 'https://graph.facebook.com/debug_token?input_token='.$accessToken.'&access_token='.$accessToken;
            $ch           = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            $response     = curl_exec($ch);
            $responseData = json_decode($response, true);
            if (isset($responseData['error'])) {
                return $this->formatResponse(false, $responseData['error']['message'], 'client.whatsapp.settings', []);
            } else {
                if (isset($responseData['data']['is_valid']) && $responseData['data']['is_valid'] === true) {
                    $is_connected = 1;
                } else {
                    return $this->formatResponse(false, __('Access token is not valid.'), 'client.whatsapp.settings', []);
                }
            }
            curl_close($ch);
            $client       = $this->model
                ->where('type', TypeEnum::WHATSAPP->value)
                ->where('client_id', Auth::user()->client->id)
                ->first();
            if ($client) {
                $client                      = $this->model->where('type', TypeEnum::WHATSAPP)->where('client_id', Auth::user()->client->id)->first();
                $client->access_token        = $accessToken;
                $client->phone_number_id     = $request->phone_number_id;
                $client->business_account_id = $request->business_account_id;
                $client->app_id              = $request->app_id;
                $client->is_connected        = $is_connected;
                $client->update();
            } else {
                $client = $this->model->create([
                    'type'                => TypeEnum::WHATSAPP,
                    'client_id'           => Auth::user()->client->id,
                    'access_token'        => $accessToken,
                    'phone_number_id'     => $request->phone_number_id,
                    'business_account_id' => $request->business_account_id,
                    'app_id'              => $request->app_id,
                    'is_connected'        => $is_connected,
                ]);
            }
            DB::commit();

            return $this->formatResponse(true, __('updated_successfully'), 'client.whatsapp.settings', []);
        } catch (\Throwable $e) {
            DB::rollback();
            if (config('app.debug')) {
                dd($e->getMessage());            
            }
            \Log::info('Whatsapp Setting Update', [$e->getMessage()]);
            return $this->formatResponse(false, __('an_unexpected_error_occurred_please_try_again_later.'), 'client.whatsapp.settings', []);
        }
    }

    public function telegramUpdate($request)
    {
        DB::beginTransaction();
        try {
            $result           = [];
            $is_connected     = 0;
            $webhook_verified = 0;
            $accessToken      = $request->access_token;
            config(['telegram.bots.mybot.token' => $accessToken]);
            $result           = Telegram::getMe();
            if (isset($result) && $result['is_bot'] === true) {
                $is_connected                = 1;
                $can_join_groups             = $result['can_join_groups'];
                $can_read_all_group_messages = isset($result['can_read_all_group_messages']) ? (string) $result['can_read_all_group_messages'] : 0;
                $supports_inline_queries     = isset($result['supports_inline_queries']) ? (string) $result['supports_inline_queries'] : 0;
                $webhookResponse             = $this->setWebhook($accessToken);
                if (! empty($webhookResponse) && $webhookResponse == true) {
                    $webhook_verified = 1;
                }
            } else {
                return $this->formatResponse(false, __('Access token is not valid.'), 'client.telegram.settings', []);
            }
            $clientSetting    = $this->model
                ->where('type', TypeEnum::TELEGRAM->value)
                ->where('client_id', Auth::user()->client->id)
                ->first();
            if ($clientSetting) {
                $clientSetting                              = $this->model->where('type', TypeEnum::TELEGRAM)->where('client_id', Auth::user()->client->id)->first();
                $clientSetting->access_token                = $accessToken;
                $clientSetting->is_connected                = $is_connected;
                $clientSetting->webhook_verified            = $webhook_verified;
                $clientSetting->bot_id                      = $result['id'];
                $clientSetting->name                        = $result['first_name'];
                $clientSetting->username                    = $result['username'];
                $clientSetting->can_join_groups             = $can_join_groups;
                $clientSetting->can_read_all_group_messages = $can_read_all_group_messages;
                $clientSetting->supports_inline_queries     = $supports_inline_queries;
                $clientSetting->update();
            } else {
                $clientSetting = $this->model->create([
                    'type'                        => TypeEnum::TELEGRAM,
                    'client_id'                   => Auth::user()->client->id,
                    'bot_id'                      => $result['id'],
                    'name'                        => $result['first_name'],
                    'username'                    => $result['username'],
                    'can_join_groups'             => $can_join_groups,
                    'can_read_all_group_messages' => $can_read_all_group_messages,
                    'supports_inline_queries'     => $supports_inline_queries,
                    'access_token'                => $accessToken,
                    'phone_number_id'             => $request->phone_number_id,
                    'business_account_id'         => $request->business_account_id,
                    'is_connected'                => $is_connected,
                    'webhook_verified'            => $webhook_verified,
                ]);
            }
            DB::commit();

            return $this->formatResponse(true, __('updated_successfully'), 'client.telegram.settings', []);
        } catch (\Throwable $e) {
            DB::rollback();

            if (config('app.debug')) {
                dd($e->getMessage());            
            }
            \Log::info('Telegram Setting Update', [$e->getMessage()]);
            return $this->formatResponse(false, __('an_unexpected_error_occurred_please_try_again_later.'), 'client.telegram.settings', []);
        }
    }

    public function removeTelegramToken($request, $id)
    {
        if (isDemoMode()) {
            return $this->formatResponse(false, __('this_function_is_disabled_in_demo_server'), 'client.telegram.settings', []);
        }
        DB::beginTransaction();
        try {
            $clientSetting = $this->model->where('type', TypeEnum::TELEGRAM)
                ->where('client_id', Auth::user()->client->id)
                ->where('id', $id)
                ->withTrashed()
                ->firstOrFail();
            // $botgroups = $this->botGroup->withTrashed()
            $botgroups     = $this->botGroup->where('client_setting_id', $clientSetting->id)
                ->get();
            foreach ($botgroups as $botgroup) {
                // $this->groupSubscriber->withTrashed()
                $this->groupSubscriber->where('group_id', $botgroup->id)
                    ->delete();
                // $this->contact->withTrashed()
                $this->contact->where('group_id', $botgroup->id)
                    ->delete();
                $messages = $this->message->whereHas('contact', function ($query) use ($botgroup) {
                    $query->where('group_id', $botgroup->id);
                })->get();
                foreach ($messages as $message) {
                    $message->delete();
                }
                $botgroup->delete();
            }
            $clientSetting->delete();
            DB::commit();

            return $this->formatResponse(true, __('deleted_successfully'), 'client.telegram.settings', []);
        } catch (\Throwable $e) {
            DB::rollback();
            if (config('app.debug')) {
                dd($e->getMessage());            
            }
            \Log::info('Telegram Setting Remove', [$e->getMessage()]);
            return $this->formatResponse(false, __('an_unexpected_error_occurred_please_try_again_later.'), 'client.telegram.settings', []);
        }
    }
 
    public function removeWhatsAppToken($request, $id)
    {
        if (isDemoMode()) {
            return $this->formatResponse(false, __('this_function_is_disabled_in_demo_server'), 'client.whatsapp.settings', []);
        }
        DB::beginTransaction();
        try {

            $clientSetting = $this->model->where('type', TypeEnum::WHATSAPP)
                ->where('client_id', Auth::user()->client->id)
                ->where('id', $id)
                // ->withTrashed()
                ->firstOrFail();
            $clientSetting->delete();

            Client::where('id', Auth::user()->client->id)->update([
                'webhook_verify_token' => Str::random(40)
            ]);

            DB::commit();
            return $this->formatResponse(true, __('deleted_successfully'), 'client.whatsapp.settings', []);
        } catch (\Throwable $e) {
            DB::rollback();
            if (config('app.debug')) {
                dd($e->getMessage());            
            }

            \Log::info('WhatsApp Setting Remove', [$e->getMessage()]);

            return $this->formatResponse(false, __('an_unexpected_error_occurred_please_try_again_later.'), 'client.whatsapp.settings', []);
        }
    }

    public function billingDetailsUpdate($request, $id)
    {
        $client                   = Client::findOrFail($id);
        $client->billing_name     = $request->billing_name;
        $client->billing_email    = $request->billing_email;
        $client->billing_address  = $request->billing_address;
        $client->billing_city     = $request->billing_city;
        $client->billing_state    = $request->billing_state;
        $client->billing_zip_code = $request->billing_zipcode;
        $client->billing_country  = $request->billing_country;
        $client->billing_phone    = $request->billing_phone;
        $client->save();
    }

    public function aiCredentialUpdate($request)
    {

        DB::beginTransaction();
        try {
            $client = $this->client->where('id',Auth::user()->client->id)->update(
                [
                    'open_ai_key' => $request->ai_secret_key,
                ]);
            DB::commit();
            return $this->formatResponse(true, __('updated_successfully'), 'ai_writer.setting', []);
        } catch (\Throwable $e) {
            DB::rollback();
            if (config('app.debug')) {
                dd($e->getMessage());            
            }
            \Log::info('AI Credential Update', [$e->getMessage()]);
            return $this->formatResponse(false, __('an_unexpected_error_occurred_please_try_again_later.'), 'ai_writer.setting', []);
        }
    }
}
