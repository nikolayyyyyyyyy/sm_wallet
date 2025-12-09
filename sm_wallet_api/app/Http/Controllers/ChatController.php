<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;

class ChatController extends Controller
{
    public function getMessages(Request $request)
    {
        $currentUserId = $request->user()->id;
        $otherUserId = $request->input('user_id');

        if (!$otherUserId) {
            return response()->json(['error' => 'User ID is required'], 400);
        }

        $messages = Message::where(function ($query) use ($currentUserId, $otherUserId) {
            $query->where('sender_id', $currentUserId)
                  ->where('receiver_id', $otherUserId);
        })->orWhere(function ($query) use ($currentUserId, $otherUserId) {
            $query->where('sender_id', $otherUserId)
                  ->where('receiver_id', $currentUserId);
        })
        ->with(['sender:id,name,middle_name,last_name', 'receiver:id,name,middle_name,last_name'])
        ->orderBy('created_at', 'asc')
        ->get();

        // Mark messages as read
        Message::where('sender_id', $otherUserId)
            ->where('receiver_id', $currentUserId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json($messages, 200);
    }

    public function sendMessage(Request $request)
    {
        $currentUserId = $request->user()->id;
        $receiverId = $request->input('receiver_id');
        $messageText = $request->input('message');

        $message = Message::create([
            'sender_id' => $currentUserId,
            'receiver_id' => $receiverId,
            'message' => $messageText,
            'is_read' => false
        ]);

        $message->load(['sender:id,name,middle_name,last_name', 'receiver:id,name,middle_name,last_name']);

        return response()->json($message, 201);
    }

    public function getConversations(Request $request)
    {
        $currentUserId = $request->user()->id;

        // Get all unique users the current user has conversations with
        $conversationUserIds = Message::where('sender_id', $currentUserId)
            ->orWhere('receiver_id', $currentUserId)
            ->get()
            ->map(function ($message) use ($currentUserId) {
                return $message->sender_id == $currentUserId ? $message->receiver_id : $message->sender_id;
            })
            ->unique()
            ->values();

        // Get latest message for each conversation
        $conversations = collect($conversationUserIds)->map(function ($userId) use ($currentUserId) {
            $otherUser = User::where('id', $userId)->first();
            $lastMessage = Message::where(function ($query) use ($currentUserId, $userId) {
                $query->where('sender_id', $currentUserId)
                      ->where('receiver_id', $userId);
            })->orWhere(function ($query) use ($currentUserId, $userId) {
                $query->where('sender_id', $userId)
                      ->where('receiver_id', $currentUserId);
            })
            ->orderBy('created_at', 'desc')
            ->first();

            return [
                'user' => $otherUser,
                'last_message' => $lastMessage,
                'unread_count' => Message::where('sender_id', $userId)
                    ->where('receiver_id', $currentUserId)
                    ->where('is_read', false)
                    ->count()
            ];
        })->sortByDesc(function ($conversation) {
            return $conversation['last_message'] ? $conversation['last_message']->created_at : null;
        })->values();

        return response()->json($conversations, 200);
    }

    public function getUnreadMessages(Request $request)
    {
        $currentUserId = $request->user()->id;

        // Get all unread messages for the current user
        $unreadMessages = Message::where('receiver_id', $currentUserId)
            ->where('is_read', false)
            ->with(['sender:id,name,middle_name,last_name,email'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('sender_id')
            ->map(function ($messages, $senderId) {
                $sender = $messages->first()->sender;
                $latestMessage = $messages->first();
                
                return [
                    'sender' => $sender,
                    'latest_message' => $latestMessage,
                    'unread_count' => $messages->count(),
                    'latest_message_time' => $latestMessage->created_at
                ];
            })
            ->sortByDesc('latest_message_time')
            ->values();

        // Get total unread count
        $totalUnreadCount = Message::where('receiver_id', $currentUserId)
            ->where('is_read', false)
            ->count();

        return response()->json([
            'messages' => $unreadMessages,
            'total_unread_count' => $totalUnreadCount
        ], 200);
    }
}
