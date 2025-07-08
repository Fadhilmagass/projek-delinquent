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

        $this->thread->comments()->create([
            'user_id' => auth()->id(),
            'body' => $this->body,
        ]);

        $this->body = '';
        $this->thread = $this->thread->fresh();
    }

    public function render()
    {
        $this->thread->load(['comments' => function ($query) {
            $query->whereNull('parent_id')->with('author')->withCount('replies');
        }]);
        return view('livewire.show-comments');
    }
}
