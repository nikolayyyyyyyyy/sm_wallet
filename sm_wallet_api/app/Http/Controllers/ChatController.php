<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatMessage;
class ChatController extends Controller
{
    public function storeMessage(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $user = $request->user();

        $chatMessage = new ChatMessage();
        $chatMessage->sender_id = $user->id;
        $chatMessage->receiver_id = $id;
        $chatMessage->message = $request->input('message');
        $chatMessage->save();

        $chatMessage->load(['sender', 'receiver']);

        if ($chatMessage->sender && isset($chatMessage->sender->profile_photo) && $chatMessage->sender->profile_photo) {
            $chatMessage->sender->profile_photo = asset($chatMessage->sender->profile_photo);
        }

        if ($chatMessage->receiver && isset($chatMessage->receiver->profile_photo) && $chatMessage->receiver->profile_photo) {
            $chatMessage->receiver->profile_photo = asset($chatMessage->receiver->profile_photo);
        }

        return response()->json($chatMessage, 201);
    }

    public function getMessages(Request $request, $id)
    {
        $user = $request->user();

        $messages = ChatMessage::where(function ($query) use ($user, $id) {
            $query->where('sender_id', $user->id)
                  ->where('receiver_id', $id);
        })->orWhere(function ($query) use ($user, $id) {
            $query->where('sender_id', $id)
                  ->where('receiver_id', $user->id);
        })
        ->with(['sender', 'receiver'])
        ->orderBy('created_at', 'asc')
        ->get();

        $messages->transform(function ($message) {
            if ($message->sender && isset($message->sender->profile_photo) && $message->sender->profile_photo) {
                $message->sender->profile_photo = asset($message->sender->profile_photo);
            }

            if ($message->receiver && isset($message->receiver->profile_photo) && $message->receiver->profile_photo) {
                $message->receiver->profile_photo = asset($message->receiver->profile_photo);
            }

            return $message;
        });

        return response()->json($messages, 200);
    }
}
