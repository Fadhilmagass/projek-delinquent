<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Thread;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\On;
use Livewire\Component;

class CommentComponent extends Component
{
    use AuthorizesRequests;

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

        $this->thread->comments()->create([
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

        if ($this->showReplies) {
            $this->loadReplies();
        }
    }

    #[On('commentDeleted')]
    public function loadReplies()
    {
        $this->replies = $this->comment->replies()
            ->with(['author', 'userVote'])
            ->withCount(['upvotes', 'downvotes'])
            ->latest()
            ->get();
    }

    public function confirmDelete()
    {
        $this->authorize('delete', $this->comment);

        $this->comment->delete();

        $this->dispatch('commentDeleted', $this->comment->id);
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
