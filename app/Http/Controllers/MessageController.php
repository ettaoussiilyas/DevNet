<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use App\Events\NewMessage;
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
        $users = User::where('id', '!=', Auth::id())->get();
        
        return view('messages.index', compact('users'));
    }
    
    /**
     * Get conversation with a specific user.
     */
    public function getConversation(User $user)
    {
        // Mark all unread messages from this user as read
        Message::where('sender_id', $user->id)
            ->where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        // Get messages between the authenticated user and the selected user
        $messages = Message::where(function($query) use ($user) {
                $query->where('sender_id', Auth::id())
                      ->where('receiver_id', $user->id);
            })
            ->orWhere(function($query) use ($user) {
                $query->where('sender_id', $user->id)
                      ->where('receiver_id', Auth::id());
            })
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();
        
        return response()->json([
            'messages' => $messages,
            'user' => $user
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
        
        $message = new Message();
        $message->sender_id = Auth::id();
        $message->receiver_id = $user->id;
        $message->content = $request->content;
        $message->is_read = false;
        $message->save();
        
        // Load the sender relationship for broadcasting
        $message->load('sender');
        
        // Broadcast the new message
        event(new NewMessage($message));
        
        return response()->json([
            'message' => $message,
            'success' => true
        ]);
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
    
    /**
     * Get users with their latest message.
     */
    public function getUsersWithLatestMessage()
    {
        $users = DB::table('users as u')
            ->leftJoin(DB::raw('(
                SELECT 
                    CASE 
                        WHEN sender_id = ' . Auth::id() . ' THEN receiver_id
                        ELSE sender_id
                    END as user_id,
                    MAX(created_at) as latest_message_time
                FROM messages
                WHERE sender_id = ' . Auth::id() . ' OR receiver_id = ' . Auth::id() . '
                GROUP BY user_id
            ) as lm'), 'lm.user_id', '=', 'u.id')
            ->leftJoin('messages as m', function($join) {
                $join->on(function($query) {
                    $query->on('m.created_at', '=', 'lm.latest_message_time')
                        ->where(function($q) {
                            $q->where(function($subq) {
                                $subq->where('m.sender_id', '=', DB::raw('u.id'))
                                    ->where('m.receiver_id', '=', Auth::id());
                            })->orWhere(function($subq) {
                                $subq->where('m.sender_id', '=', Auth::id())
                                    ->where('m.receiver_id', '=', DB::raw('u.id'));
                            });
                        });
                });
            })
            ->where('u.id', '!=', Auth::id())
            ->select('u.id', 'u.name', 'u.image', 'm.content as last_message', 'm.created_at as last_message_time', 
                DB::raw('(SELECT COUNT(*) FROM messages WHERE sender_id = u.id AND receiver_id = ' . Auth::id() . ' AND `is_read` = 0) as unread_count'))
            ->orderByDesc('lm.latest_message_time')
            ->get();
        
        return response()->json(['users' => $users]);
    }
    
    public function getUsers()
    {
        $currentUser = Auth::user();
        
        // Get only connected users
        $connectedUsers = User::whereHas('connections', function($query) use ($currentUser) {
            $query->where(function($q) use ($currentUser) {
                $q->where('user_id', $currentUser->id)
                  ->orWhere('connected_user_id', $currentUser->id);
            })->where('status', 'accepted');
        })->where('id', '!=', $currentUser->id)->get();
        
        $usersWithMessages = [];
        
        foreach ($connectedUsers as $user) {
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
                                 ->where('is_read', false) // Changed from 'read' to 'is_read'
                                 ->count();
            
            $usersWithMessages[] = [
                'id' => $user->id,
                'name' => $user->name,
                'image' => $user->image,
                'last_message' => $lastMessage ? $lastMessage->content : null,
                'last_message_time' => $lastMessage ? $lastMessage->created_at : null,
                'unread_count' => $unreadCount
            ];
        }
        
        return response()->json(['users' => $usersWithMessages]);
    }
}
