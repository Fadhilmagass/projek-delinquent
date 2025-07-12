<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class FollowButton extends Component
{
    public User $user;
    public bool $isFollowing;
    public bool $isFollowedByAuthUser;

    public function mount(User $user, bool $isFollowedByAuthUser)
    {
        $this->user = $user;
        $this->isFollowing = Auth::user() ? Auth::user()->isFollowing($user) : false;
        $this->isFollowedByAuthUser = $isFollowedByAuthUser;
    }

    public function toggleFollow()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $currentUser = Auth::user();

        if ($currentUser->id === $this->user->id) {
            return; // Tidak bisa mengikuti diri sendiri
        }

        if ($currentUser->isFollowing($this->user)) {
            $currentUser->following()->detach($this->user->id);
            $this->isFollowing = false;
            $this->dispatch('userFollowStatusUpdated');
        } else {
            $currentUser->following()->attach($this->user->id);
            $this->isFollowing = true;
            $this->dispatch('userFollowStatusUpdated');
        }
    }

    public function render()
    {
        return view('livewire.follow-button');
    }
}
