<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()->latest()->paginate(15);
        
        return view('notifications.index', compact('notifications'));
    }
    
    public function getUnreadCount()
    {
        $count = auth()->user()->notifications()->where('read', false)->count();
        
        return response()->json(['count' => $count]);
    }
    
    public function getLatest()
    {
        $notifications = auth()->user()->notifications()
            ->with('sender')
            ->latest()
            ->take(5)
            ->get();
            
        return response()->json(['notifications' => $notifications]);
    }
    
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        
        if ($notification->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $notification->update(['read' => true]);
        
        return response()->json(['success' => true]);
    }
    
    public function markAllAsRead()
    {
        auth()->user()->notifications()->update(['read' => true]);
        
        return response()->json(['success' => true]);
    }
}