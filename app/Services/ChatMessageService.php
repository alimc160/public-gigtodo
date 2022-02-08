<?php

namespace App\Services;

use App\Models\ChatMessage;
use App\Models\ChatSubscription;
use Carbon\Carbon;

class ChatMessageService
{
    public function __construct()
    {
        $this->chatMessage = new ChatMessage;
        $this->chatSub = new ChatSubscription;
    }

    /**
     * @param $request
     * @param $user
     * @return array
     */
    public function createChatMessage($request, $user)
    {
        $now = Carbon::now();
        $chatSub = $this->chatSub->where('user_id', $user->id)->first();
        if (!$chatSub) {
            return ['result' => 'You are not subscribe any package for chat', 'status' => 'fail'];
        }
        $expiryDate = Carbon::parse($chatSub->expire_at);
        if ($now > $expiryDate) {
            return ['result' => 'You are not subscribe any package for chat', 'status' => 'fail'];
        }
        $message = $this->chatMessage->create([
            'sender_id' => $user->id,
            'receiver_id' => $request['receiver_id'],
            'message' => $request['message']
        ]);
        return ['result' => $message, 'total' => 1];
    }

    public function getMessages($user, $request)
    {
        $messages = $this->chatMessage->where([
            'sender_id' => $user->id,
            'receiver_id' => $request['receiver_id'],
        ]);
        $total = $messages->count();
        $messages = $messages->get();
        return ['result' => $messages, 'total' => $total];
    }
}
