<?php

namespace App\Livewire;

use App\Models\Thread;
use Livewire\Attributes\On;
use Livewire\Component;

class ShowComments extends Component
{
    public Thread $thread;
    public $body = '';
    public $comments;

    public function mount(Thread $thread)
    {
        $this->thread = $thread;
        $this->loadComments();
    }

    #[On('commentDeleted')]
    public function loadComments()
    {
        $this->comments = $this->thread
            ->comments()
            ->whereNull('parent_id')
            ->with('author')
            ->withCount('replies')
            ->latest()
            ->get();
    }

    public function postComment()
    {
        if (!auth()->check()) {
            return $this->redirect(route('login'));
        }

        $this->validate(['body' => 'required|min:3']);

        $this->thread->comments()->create([
            'user_id' => auth()->id(),
            'body' => $this->body,
        ]);

        $this->body = '';
        $this->loadComments();
    }

    public function render()
    {
        return view('livewire.show-comments');
    }
}
