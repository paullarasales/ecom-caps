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

        // If the sender is a user, send the message to all managers
        if ($sender->usertype === 'user') {
            $managerIds = User::where('usertype', 'manager')->pluck('id')->toArray();
            // Loop through each manager and send the message
            foreach ($managerIds as $receiverId) {
                $messageClone = $message->replicate(); // Clone the message for each manager
                $messageClone->receiver_id = $receiverId;
                $messageClone->save();
            }
            return response()->json(['status' => 'Message sent to all managers']);
        }

        // If the sender is an admin, send the message to a specific receiver
        if ($sender->isAdmin()) {
            $message->receiver_id = $request->input('receiver_id');
            $message->save();
            return response()->json(['status' => 'Message sent']);
        }

        if ($sender->isOwner()) {
            $message->receiver_id = $request->input('receiver_id');
            $message->save();
            return response()->json(['status' => 'Message sent']);
        }
        
        return response()->json(['status' => 'Message not sent'], 400);
    }

    public function getMessagesForUser(Request $request)
    {
        $user = auth()->user();

        // Validate if the user type is 'user'
        if ($user->usertype !== 'user') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Fetch messages sent by all managers to the current user
        $messages = Message::where(function ($query) use ($user) {
            $query->where('receiver_id', $user->id)
                ->whereHas('sender', function($query) {
                    $query->where('usertype', 'manager');
                });
        })
        ->orWhere(function ($query) use ($user) {
            $query->where('sender_id', $user->id)
                ->where('receiver_id', '!=', $user->id); // Exclude messages sent to the user
        })
        ->get()
        ->unique('created_at') // Filter out duplicates by created_at
        ->values(); // Reindex the collection

        return response()->json($messages);
    }





    public function getMessages(Request $request)
    {
        $user = auth()->user();
        $receiverId = $request->query('receiver_id');

        if (!$receiverId) {
            return response()->json(['error' => 'Error fetching user id'], 404);
        }

        $messages = Message::where(function($query) use ($user, $receiverId) {
            $query->where(function ($q) use ($user, $receiverId) {
                $q->where('sender_id', $user->id)
                ->where('receiver_id', $receiverId);
            })
            ->orWhere(function ($q) use ($user, $receiverId) {
                $q->where('sender_id', $receiverId)
                ->where('receiver_id', $user->id);
            });
        })->get();

        return response()->json($messages);
    }

    // Send message to all managers
    public function sendMessageToManagers(Request $request)
    {
        $message = new Message();
        $message->content = $request->input('message');
        $message->sender_id = auth()->id();

        // Get all manager IDs
        $managerIds = User::where('usertype', 'manager')->pluck('id')->toArray();

        // Loop through each manager and send the message
        foreach ($managerIds as $receiverId) {
            $messageClone = $message->replicate(); // Clone the message for each manager
            $messageClone->receiver_id = $receiverId;
            $messageClone->save();
        }

        return response()->json(['status' => 'Message sent to all managers']);
    }

    // Get messages for all managers
    public function getMessagesForManagers(Request $request)
{
    $receiverId = $request->input('receiver_id');
    $currentUserId = auth()->id();
    $receiverType = User::find($receiverId)->usertype;

    if ($receiverType === 'user') {
        // User is of type 'user', fetch messages with all managers.
        $messages = Message::where(function ($query) use ($currentUserId, $receiverId) {
                $query->where('sender_id', $currentUserId)
                      ->where('receiver_id', $receiverId);
            })
            ->orWhere(function ($query) use ($currentUserId, $receiverId) {
                $query->where('sender_id', $receiverId)
                      ->where('receiver_id', $currentUserId);
            })
            ->orWhere(function ($query) use ($receiverId) {
                $query->where('receiver_id', $receiverId)
                      ->whereHas('sender', function ($q) {
                          $q->where('usertype', 'manager');
                      });
            })
            ->with('sender')
            ->get();
    } else {
        // Receiver is admin or owner, fetch messages privately between manager and admin/owner.
        $messages = Message::where(function ($query) use ($currentUserId, $receiverId) {
                $query->where('sender_id', $currentUserId)
                      ->where('receiver_id', $receiverId);
            })
            ->orWhere(function ($query) use ($currentUserId, $receiverId) {
                $query->where('sender_id', $receiverId)
                      ->where('receiver_id', $currentUserId);
            })
            ->with('sender')
            ->get();
    }

    return response()->json($messages);
}



    



    public function sendMessageToUser(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'receiver_id' => 'required|exists:users,id'
        ]);

        $message = new Message();
        $message->content = $request->input('message');
        $message->sender_id = auth()->id();
        $message->receiver_id = $request->input('receiver_id');
        $message->save();

        return response()->json(['status' => 'Message sent to user']);
    }

    



    public function getUsers()
    {
        $currentUserId = auth()->id(); // Get the ID of the currently authenticated user

        $users = User::whereIn('usertype', ['user', 'admin', 'manager', 'owner']) // Include admins
                ->whereNotNull('email') // Check for non-null emails
                ->where('id', '!=', $currentUserId) // Exclude the current user
                ->orderByRaw("CASE 
                WHEN usertype = 'admin' THEN 1
                WHEN usertype = 'owner' THEN 2
                WHEN usertype = 'manager' THEN 3
                WHEN usertype = 'user' THEN 4
                ELSE 5 END")
                ->get();

        return response()->json($users);
    }


    public function getAdminAcc()
    {
        // Assuming 'manager' is the user type for managers
        $users = User::where('usertype', 'manager')->orWhere('usertype', 'admin')->get();

        return response()->json($users);
    }

    public function getManagers()
    {
        // Fetch managers from the database
        $users = User::where('usertype', 'manager')->get();

        // Return the users as a JSON response
        return response()->json($users);
    }

}
