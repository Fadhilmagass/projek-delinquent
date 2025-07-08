<?php

namespace App\Models\Concerns;

use App\Models\Vote;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Votable
{
    public function votes(): MorphMany
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    public function getVoteScoreAttribute(): int
    {
        return (int) $this->votes()->sum('vote');
    }
}
