<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Thread;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class CommentComponent extends Component
{
    public Comment $comment;
    public Thread $thread;

    public bool $isEditing = false;
    public string $editBody = '';


    public bool $isReplying = false;
    public string $replyBody = '';
    public bool $showReplies = false;
    public Collection $replies;

    public function mount()
    {
        $this->replies = new Collection();
    }

    public function startReplying()
    {
        $this->isReplying = true;
    }

    public function cancelReplying()
    {
        $this->isReplying = false;
        $this->replyBody = '';
    }

    public function postReply()
    {
        if (! auth()->check()) {
            return $this->redirect(route('login'));
        }

        $this->validate([
            'replyBody' => 'required|min:3',
        ]);

        $reply = $this->thread->comments()->create([
            'user_id' => auth()->id(),
            'body' => $this->replyBody,
            'parent_id' => $this->comment->id,
        ]);

        $this->replyBody = '';
        $this->isReplying = false;

        $this->loadReplies();
    }

    public function toggleReplies()
    {
        $this->showReplies = ! $this->showReplies;

        if ($this->showReplies && $this->replies->isEmpty()) {
            $this->loadReplies();
        }
    }

    public function loadReplies()
    {
        $this->replies = $this->comment->replies()->with('author')->latest()->get();
    }

    protected $listeners = ['deleteComment'];

    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);
        $this->authorize('delete', $comment);
        $comment->delete();

        $this->dispatch('commentDeleted'); // opsional buat notifikasi
    }

    public function startEditing()
    {
        $this->isEditing = true;
        $this->editBody = $this->comment->body;
    }

    public function cancelEditing()
    {
        $this->isEditing = false;
        $this->editBody = '';
    }

    public function updateComment()
    {
        $this->authorize('update', $this->comment);

        $this->validate([
            'editBody' => 'required|min:3',
        ]);

        $this->comment->update([
            'body' => $this->editBody,
        ]);

        $this->isEditing = false;
    }

    public function render()
    {
        return view('livewire.comment-component');
    }
}
