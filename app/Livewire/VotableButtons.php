<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class VotableButtons extends Component
{
    public Model $model;
    public int $score;
    public ?string $userVote;

    public function mount(Model $model)
    {
        $this->model = $model;
        $this->updateState();
    }

    /**
     * Method untuk memberikan vote ('upvote' atau 'downvote').
     */
    public function vote(string $type): void
    {
        if (! auth()->check()) {
            $this->redirect(route('login'), navigate: true);
            return;
        }

        // Panggil method vote dari trait Votable
        $this->model->vote(auth()->user(), $type);

        // Refresh model dan state komponen
        $this->model->refresh();
        $this->updateState();
    }

    /**
     * Memperbarui properti publik komponen dari state model.
     */
    private function updateState(): void
    {
        $this->score = $this->model->score;
        $this->userVote = $this->model->is_voted_by_user;
    }

    public function render()
    {
        return view('livewire.votable-buttons');
    }
}
