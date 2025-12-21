<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatMessage;
class ChatController extends Controller
{
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
