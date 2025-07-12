<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the specified user's profile.
     */
    public function show(User $user): View
    {
        $threads = $user->threads()->latest()->paginate(10);
        $articles = $user->articles()->latest()->paginate(10);

        return view('users.show', compact('user', 'threads', 'articles'));
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $genres = \App\Models\Genre::all();

        return view('profile.edit', [
            'user' => $request->user(),
            'genres' => $genres,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($user->avatar && file_exists(public_path('storage/' . $user->avatar))) {
                unlink(public_path('storage/' . $user->avatar));
            }
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar_path = $avatarPath;
        }

        $user->save();

        // Sinkronkan genres jika ada
        if ($request->has('genres')) {
            $user->genres()->sync($request->input('genres'));
        } else {
            $user->genres()->detach(); // Hapus semua jika tidak ada yang dipilih
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Display the specified user's followers.
     */
    public function followers(User $user): View
    {
        $followers = $user->followers()->paginate(20);
        return view('users.followers', compact('user', 'followers'));
    }

    /**
     * Display the specified user's following.
     */
    public function following(User $user): View
    {
        $following = $user->following()->paginate(20);
        return view('users.following', compact('user', 'following'));
    }
}