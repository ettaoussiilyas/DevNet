<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    public function show($userId = null): View
    {
        $user = $userId ? User::findOrFail($userId) : auth()->user();

        $stats = [
            // Count both sent and received accepted connections
            'connections_count' => $user->connections()->count() +
                $user->belongsToMany(User::class, 'connections', 'receiver_id', 'sender_id')
                    ->wherePivot('status', 'accepted')
                    ->count(),
            'posts_count' => $user->posts()->count(),
            'projects_count' => $user->posts()->where('type', 'project')->count(),
        ];

        $isOwnProfile = $userId === null || $userId == auth()->id();

        // Check if users are connected (either as sender or receiver)
        $isConnected = !$isOwnProfile && (
                auth()->user()->connections()
                    ->where('receiver_id', $user->id)
                    ->where('status', 'accepted')
                    ->exists() ||
                auth()->user()->belongsToMany(User::class, 'connections', 'receiver_id', 'sender_id')
                    ->where('sender_id', $user->id)
                    ->where('status', 'accepted')
                    ->exists()
            );

        return view('profile', compact('user', 'stats', 'isOwnProfile', 'isConnected'));
    }


    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'biography' => 'nullable|string|max:1000',
            'skills' => 'nullable|string',
            'gitProfile' => 'nullable|url|max:255',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $user = auth()->user();

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $path;
        }

        $user->update($validated);

        return redirect()->route('profile')->with('status', 'Profile updated successfully!');
    }

    public function connect(User $user): RedirectResponse
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot connect with yourself');
        }

        // Check if connection already exists
        $existingConnection = auth()->user()->connections()
            ->where('receiver_id', $user->id)
            ->first();

        if ($existingConnection) {
            // Remove connection if it exists
            $existingConnection->delete();
            $message = 'Connection removed';
        } else {
            // Create new pending connection
            auth()->user()->connections()->create([
                'receiver_id' => $user->id,
                'status' => 'pending'
            ]);
            $message = 'Connection request sent';
        }

        return back()->with('status', $message);
    }


    public function edit(): View
    {
        return view('profile.edit', [
            'user' => auth()->user()
        ]);
    }
}
