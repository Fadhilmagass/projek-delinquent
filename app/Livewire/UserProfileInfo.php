<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class UserProfileInfo extends Component
{
    public User $user;

    protected $listeners = ['userFollowStatusUpdated' => 'refreshUser'];

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function refreshUser()
    {
        $this->user->loadCount(['followers', 'following']);
    }

    public function render()
    {
        return view('livewire.user-profile-info');
    }
}
