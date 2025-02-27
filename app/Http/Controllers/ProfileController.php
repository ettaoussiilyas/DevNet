<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;


class ProfileController extends Controller
{
    public function show($userId = null): View
    {
        $user = $userId ? User::findOrFail($userId) : auth()->user();
//        $projects = $user->projects()->count();

        $stats = [
            // Count both sent and received accepted connections
            'connections_count' => $user->connections()->count() +
                $user->belongsToMany(User::class, 'connections', 'receiver_id', 'sender_id')
                    ->wherePivot('status', 'accepted')
                    ->count(),
            'posts_count' => $user->posts()->count(),
            'projects_count' => $user->projects()->count(),
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

        return view('profile.profile', compact('user', 'stats', 'isOwnProfile', 'isConnected'));
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
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    public function deleteAvatar(): RedirectResponse
    {
        $user = auth()->user();

        if ($user->avatar) {
            try {
                $path = str_replace('/storage/', '', $user->avatar);
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
                $user->update(['avatar' => null]);
                return back()->with('status', 'avatar-deleted');
            } catch (\Exception $e) {
                return back()->withErrors(['avatar' => 'Failed to delete avatar: ' . $e->getMessage()]);
            }
        }

        return back()->with('status', 'avatar-deleted');
    }


    public function update(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'biography' => ['nullable', 'string', 'max:1000'],
            'skills' => ['nullable', 'string', 'max:1000'],
            'gitProfile' => ['nullable', 'url', 'max:1000'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        if ($request->hasFile('avatar')) {
            try {
                // Delete old avatar if exists
                if ($user->avatar) {
                    $oldPath = str_replace('/storage/', '', $user->avatar);
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }

                // Store new avatar
                $path = $request->file('avatar')->store('avatars', 'public');
                $validated['avatar'] = '/storage/' . $path;

            } catch (\Exception $e) {
                return back()->withErrors(['avatar' => 'Failed to upload avatar: ' . $e->getMessage()]);
            }
        }

        $user->update($validated);

        return back()->with('status', 'profile-updated');
    }


}
