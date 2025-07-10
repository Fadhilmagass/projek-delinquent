<?php

namespace App\Livewire;

use App\Models\Thread;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\On;
use Livewire\Component;

class ShowComments extends Component
{
    public Model $model;
    public $body = '';
    public $comments;

    public function mount(Model $model)
    {
        $this->model = $model;
        $this->loadComments();
    }

    #[On('commentDeleted')]
    public function loadComments()
    {
        $this->comments = $this->model
            ->comments()
            ->whereNull('parent_id')
            ->with(['author', 'userVote'])
            ->withCount(['replies', 'upvotes', 'downvotes'])
            ->latest()
            ->get();
    }

    public function postComment()
    {
        if (! auth()->check()) {
            return $this->redirect(route('login'));
        }

        $this->validate(['body' => 'required|min:3']);

        // Gunakan $this->model, bukan $this->thread
        $this->model->comments()->create([
            'user_id' => auth()->id(),
            'body' => $this->body,
        ]);

        $this->body = '';
        $this->loadComments(); // Panggil untuk memuat ulang komentar setelah posting
    }

    public function render()
    {
        return view('livewire.show-comments');
    }
}
