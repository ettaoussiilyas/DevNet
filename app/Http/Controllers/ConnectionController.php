<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Connection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\NotificationService;


class ConnectionController extends Controller
{
    protected $notificationService;
    
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }
    
    public function index()
    {
        $user = Auth::user();
    
        // Get users who are not connected or pending with the current user
        $userss = User::where('id', '!=', $user->id)
            ->whereNotIn('id', function($query) use ($user) {
                $query->select('connected_user_id')
                    ->from('connections')
                    ->where('user_id', $user->id)
                    ->whereIn('status', ['accepted', 'pending']);
            })
            ->whereNotIn('id', function($query) use ($user) {
                $query->select('user_id')
                    ->from('connections')
                    ->where('connected_user_id', $user->id)
                    ->whereIn('status', ['accepted', 'pending']);
            })
            ->get();
    
        // Fix: Use direct query instead of relationship method
        $pendingRequests = Connection::where('connected_user_id', $user->id)
            ->where('status', 'pending')
            ->with('user')
            ->get();
    
        return view('connections.index', compact('user', 'userss', 'pendingRequests'));
    }

    public function sendRequest(User $user)
    {
        // Check if connection already exists
        $existingConnection = Connection::where(function($query) use ($user) {
            $query->where('user_id', Auth::id())
                  ->where('connected_user_id', $user->id);
        })->orWhere(function($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->where('connected_user_id', Auth::id());
        })->first();

        if ($existingConnection) {
            return back()->with('error', 'Connection already exists');
        }

        Connection::create([
            'user_id' => Auth::id(),
            'connected_user_id' => $user->id,
            'status' => Connection::STATUS_PENDING
        ]);
        
        // Create notification for the user receiving the connection request
        $this->notificationService->createConnectionNotification($user, Auth::user());

        return back()->with('success', 'Connection request sent');
    }

    public function acceptRequest(User $user)
    {
        $connection = Connection::where('user_id', $user->id)
            ->where('connected_user_id', Auth::id())
            ->where('status', Connection::STATUS_PENDING)
            ->first();
    
        if ($connection) {
            $connection->update(['status' => Connection::STATUS_ACCEPTED]);
            
            // Notify the original requester that their connection was accepted
            $this->notificationService->createConnectionAcceptedNotification($user, Auth::user());
        }
    
        return back()->with('success', 'Connection accepted successfully');
    }

    public function rejectRequest(User $user)
    {
        $connection = Connection::where('user_id', $user->id)
            ->where('connected_user_id', Auth::id())
            ->where('status', Connection::STATUS_PENDING)
            ->first();

        if ($connection) {
            $connection->update(['status' => Connection::STATUS_REJECTED]);
        }

        return back()->with('success', 'Connection request rejected');
    }
}
