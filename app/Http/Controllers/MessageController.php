<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use App\Events\MessageSent; // Changed from NewMessage to MessageSent
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    /**
     * Display the messaging interface.
     */
    public function index()
    {
        $currentUser = Auth::user();
        
        // Get only connected users
        $connectedUserIds = DB::table('connections')
            ->where(function($query) use ($currentUser) {
                $query->where('user_id', $currentUser->id)
                      ->where('status', 'accepted');
            })
            ->orWhere(function($query) use ($currentUser) {
                $query->where('connected_user_id', $currentUser->id)
                      ->where('status', 'accepted');
            })
            ->select(
                DB::raw('CASE WHEN user_id = ' . $currentUser->id . ' THEN connected_user_id ELSE user_id END as connected_id')
            )
            ->pluck('connected_id');
        
        // Get users who are connected
        $users = User::whereIn('id', $connectedUserIds)
                     ->get();
        
        $usersWithMessages = [];
        
        foreach ($users as $user) {
            // Get the last message between current user and this user
            $lastMessage = Message::where(function($query) use ($currentUser, $user) {
                $query->where('sender_id', $currentUser->id)
                      ->where('receiver_id', $user->id);
            })
            ->orWhere(function($query) use ($currentUser, $user) {
                $query->where('sender_id', $user->id)
                      ->where('receiver_id', $currentUser->id);
            })
            ->latest()
            ->first();
            
            // Count unread messages
            $unreadCount = Message::where('sender_id', $user->id)
                                 ->where('receiver_id', $currentUser->id)
                                 ->where('is_read', false)
                                 ->count();
            
            $usersWithMessages[] = [
                'id' => $user->id,
                'name' => $user->name,
                'image' => $user->image ?? 'default-avatar.png',
                'last_message' => $lastMessage ? $lastMessage->content : null,
                'last_message_time' => $lastMessage ? $lastMessage->created_at->diffForHumans() : null,
                'unread_count' => $unreadCount
            ];
        }
        
        // Sort users with messages first, then by last message time
        usort($usersWithMessages, function($a, $b) {
            // If one has a message and the other doesn't, the one with a message comes first
            if ($a['last_message'] && !$b['last_message']) return -1;
            if (!$a['last_message'] && $b['last_message']) return 1;
            
            // If both have messages or both don't have messages, sort by unread count
            if ($a['unread_count'] != $b['unread_count']) {
                return $b['unread_count'] - $a['unread_count']; // Higher unread count first
            }
            
            // If unread counts are the same, sort alphabetically by name
            return strcmp($a['name'], $b['name']);
        });
        
        // Pass the users data to the view
        return view('messages.index', ['users' => $usersWithMessages]);
    }
    
    /**
     * Get users with their latest message.
     */
    public function getUsers()
    {
        $currentUser = Auth::user();
        
        // Get only connected users
        $connectedUserIds = DB::table('connections')
            ->where(function($query) use ($currentUser) {
                $query->where('user_id', $currentUser->id)
                      ->where('status', 'accepted');
            })
            ->orWhere(function($query) use ($currentUser) {
                $query->where('connected_user_id', $currentUser->id)
                      ->where('status', 'accepted');
            })
            ->select(
                DB::raw('CASE WHEN user_id = ' . $currentUser->id . ' THEN connected_user_id ELSE user_id END as connected_id')
            )
            ->pluck('connected_id');
        
        // Get users who are connected
        $users = User::whereIn('id', $connectedUserIds)->get();
        
        $usersWithMessages = [];
        
        foreach ($users as $user) {
            // Get the last message between current user and this user
            $lastMessage = Message::where(function($query) use ($currentUser, $user) {
                $query->where('sender_id', $currentUser->id)
                      ->where('receiver_id', $user->id);
            })
            ->orWhere(function($query) use ($currentUser, $user) {
                $query->where('sender_id', $user->id)
                      ->where('receiver_id', $currentUser->id);
            })
            ->latest()
            ->first();
            
            // Count unread messages
            $unreadCount = Message::where('sender_id', $user->id)
                                 ->where('receiver_id', $currentUser->id)
                                 ->where('is_read', false)
                                 ->count();
            
            $usersWithMessages[] = [
                'id' => $user->id,
                'name' => $user->name,
                'image' => $user->image ?? 'default-avatar.png',
                'last_message' => $lastMessage ? $lastMessage->content : null,
                'last_message_time' => $lastMessage ? $lastMessage->created_at : null,
                'unread_count' => $unreadCount
            ];
        }
        
        return response()->json(['users' => $usersWithMessages]);
    }
    
    /**
     * Get conversation with a specific user.
     */
    public function getConversation(User $user)
    {
        $currentUser = Auth::user();
        
        // Mark messages as read
        Message::where('sender_id', $user->id)
            ->where('receiver_id', $currentUser->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        // Get messages between the two users
        $messages = Message::where(function($query) use ($currentUser, $user) {
                $query->where('sender_id', $currentUser->id)
                      ->where('receiver_id', $user->id);
            })
            ->orWhere(function($query) use ($currentUser, $user) {
                $query->where('sender_id', $user->id)
                      ->where('receiver_id', $currentUser->id);
            })
            ->orderBy('created_at', 'asc')
            ->get();
        
        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'image' => $user->image
            ],
            'messages' => $messages
        ]);
    }
    
    /**
     * Send a new message.
     */
    public function sendMessage(Request $request, User $user)
    {
        $request->validate([
            'content' => 'required|string'
        ]);
        
        $currentUser = Auth::user();
        
        $message = Message::create([
            'sender_id' => $currentUser->id,
            'receiver_id' => $user->id,
            'content' => $request->content,
            'is_read' => false
        ]);
        
        // Broadcast the message event
        broadcast(new MessageSent($message, $currentUser, $user))->toOthers();
        
        return response()->json(['success' => true, 'message' => $message]);
    }
    
    /**
     * Get unread message count.
     */
    public function getUnreadCount()
    {
        $count = Message::where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->count();
        
        return response()->json(['count' => $count]);
    }
}
