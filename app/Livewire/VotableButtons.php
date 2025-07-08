<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class VotableButtons extends Component
{
    public Model $model;
    public int $voteScore;

    public function mount(Model $model)
    {
        $this->model = $model;
        $this->voteScore = $model->vote_score ?? 0;
    }

    public function vote(int $voteValue)
    {
        if (! auth()->check()) {
            return $this->redirect(route('login'));
        }

        // Jika user sudah vote dengan nilai yg sama, batalkan vote
        if ($this->model->votes()->where('user_id', auth()->id())->where('vote', $voteValue)->exists()) {
            $this->model->votes()->where('user_id', auth()->id())->delete();
        } else {
            // Jika belum atau vote beda, buat/update vote
            $this->model->votes()->updateOrCreate(
                ['user_id' => auth()->id()],
                ['vote' => $voteValue]
            );
        }

        // Refresh score
        $this->voteScore = $this->model->fresh()->vote_score;
    }

    public function render()
    {
        return view('livewire.votable-buttons');
    }
}
