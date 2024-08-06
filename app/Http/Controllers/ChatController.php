<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $message = new Message();
        $message->content = $request->input('message');
        $message->sender_id = auth()->id();

        $sender = auth()->user();
        if ($sender->isAdmin()) {
            $message->receiver_id = $request->input('receiver_id');
        } else {
            $message->receiver_id = User::where('usertype', 'admin')->first()->id;
        }

        $message->save();

        return response()->json(['status' => 'Message sent']);
    }

    public function getMessages()
    {
        $user = auth()->user();

        $messages = Message::where(function($query) use ($user) {
            $query->where('sender_id', $user->id)
                ->orWhere('receiver_id', $user->id);
        })->get();

        return response()->json($messages);
    }
}
