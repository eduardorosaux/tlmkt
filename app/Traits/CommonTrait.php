<?php

namespace App\Traits;

use App\Models\Client;
use App\Models\Conversation;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

trait CommonTrait
{
    public function conversationUpdate($client_id, $contact_id)
    {
        if ($client_id === null || $contact_id === null) {
            return;
        }
        $client                 = Client::find($client_id);
        if (! $client || ! $client->activeSubscription) {
            return;
        }
        $subscription           = $client->activeSubscription;
        $conversation_remaining = $subscription->conversation_remaining ?? 0;
        $last_24_hours          = Carbon::now()->subHours(24);
        // $existingConversation = Conversation::where('client_id', $client_id)
        // ->where('contact_id', $contact_id)
        // ->whereHas('contact', function ($query) use ($last_24_hours) {
        //     $query->where('last_conversation_at', '>', $last_24_hours);
        // })
        // ->first();
        $existingConversation   = Conversation::select('conversations.*', 'contacts.last_conversation_at')
            ->where('conversations.client_id', $client_id)
            ->join('contacts', 'contacts.id', '=', 'conversations.contact_id')
            ->where('conversations.contact_id', $contact_id)
            // ->where('created_at', '>', $last_24_hours)
            ->where('contacts.last_conversation_at', '>', $last_24_hours)
            ->first();
        if ($existingConversation) {
            return $existingConversation->id;
        }
        if ($conversation_remaining > 0) {
            try {
                $conversation_remaining--;
                $subscription->conversation_remaining = $conversation_remaining;
                $subscription->save();
                $conversation                         = new Conversation();
                $conversation->unique_id              = Str::upper(uniqid());
                $conversation->contact_id             = $contact_id;
                $conversation->client_id              = $client_id;
                $conversation->subscription_id        = $subscription->id;
                $conversation->save();

                return $conversation->id;
            } catch (\Exception $e) {
                \Log::error('Error occurred while updating conversation: '.$e->getMessage());

                return;
            }
        }

        return null;
    }
}
