<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->with('sender')
            ->latest()
            ->paginate(15);
                
        return view('notifications.index', compact('notifications'));
    }
    
    public function getUnreadCount()
    {
        $count = Notification::where('user_id', Auth::id())
            ->where('read', false)
            ->count();
        
        return response()->json(['count' => $count]);
    }
    
    public function getLatest()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->with('sender')
            ->latest()
            ->take(5)
            ->get()
            ->map(function($notification) {
                return [
                    'id' => $notification->id,
                    'message' => $notification->message,
                    'read' => $notification->read,
                    'created_at' => $notification->created_at->diffForHumans(),
                    'sender' => $notification->sender ? [
                        'name' => $notification->sender->name,
                        'image' => $notification->sender->image
                    ] : null,
                    'type' => $notification->type,
                    'post_id' => $notification->post_id
                ];
            });
            
        return response()->json(['notifications' => $notifications]);
    }
    
    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', Auth::id())
            ->findOrFail($id);
        $notification->update(['read' => true]);
        
        return response()->json(['success' => true]);
    }
    
    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->update(['read' => true]);
        
        // return response()->json(['success' => true]);
        return redirect()->back();
    }
}