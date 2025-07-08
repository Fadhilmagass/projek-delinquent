<?php

namespace App\Livewire;

use App\Models\Thread;
use Livewire\Component;

class ShowComments extends Component
{
    public Thread $thread;
    public $body = '';

    public function postComment()
    {
        if (! auth()->check()) {
            return $this->redirect(route('login'));
        }

        $this->validate(['body' => 'required|min:3']);

        $newComment = $this->thread->comments()->create([
            'user_id' => auth()->id(),
            'body' => $this->body,
        ]);

        $this->body = ''; // Reset input
        $this->thread = $this->thread->fresh(); // Refresh thread untuk mendapatkan comment baru
    }

    public function render()
    {
        $this->thread->load('comments.author');
        return view('livewire.show-comments');
    }
}
