<?php

namespace App\Models\Concerns;

use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait Votable
{
    /**
     * Relasi polimorfik ke model Vote.
     */
    public function votes(): MorphMany
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    /**
     * Relasi untuk mengambil vote dari user yang sedang login.
     * Memungkinkan eager loading.
     */
    public function userVote(): MorphOne
    {
        return $this->morphOne(Vote::class, 'votable')
            ->where('user_id', auth()->id());
    }

    /**
     * Relasi untuk menghitung upvotes.
     */
    public function upvotes(): MorphMany
    {
        return $this->votes()->where('type', 'upvote');
    }

    /**
     * Relasi untuk menghitung downvotes.
     */
    public function downvotes(): MorphMany
    {
        return $this->votes()->where('type', 'downvote');
    }

    /**
     * Method untuk memberikan vote.
     *
     * @param string $type Tipe vote ('upvote' atau 'downvote').
     */
    public function vote(User $user, string $type): void
    {
        $existingVote = $this->votes()
            ->where('user_id', $user->id)
            ->first();

        // Jika user sudah vote dengan tipe yang sama, batalkan vote.
        if ($existingVote && $existingVote->type === $type) {
            $existingVote->delete();
            return;
        }

        // Jika user vote dengan tipe berbeda atau belum vote, buat/update vote.
        $this->votes()->updateOrCreate(
            ['user_id' => $user->id],
            ['type' => $type]
        );
    }

    /**
     * Accessor untuk mendapatkan skor total dari vote.
     * Menggunakan eager-loaded counts jika tersedia.
     */
    public function getScoreAttribute(): int
    {
        // Cek apakah _count properti sudah di-load
        if (isset($this->attributes['upvotes_count'])) {
            return (int) ($this->upvotes_count - $this->downvotes_count);
        }
        // Fallback jika tidak di-load
        return $this->upvotes()->count() - $this->downvotes()->count();
    }

    /**
     * Accessor untuk mengecek apakah model ini sudah di-vote oleh user.
     * Menggunakan eager-loaded relationship jika tersedia.
     */
    public function getIsVotedByUserAttribute(): ?string
    {
        // Cek apakah relasi userVote sudah di-load
        if ($this->relationLoaded('userVote')) {
            return $this->userVote->type ?? null;
        }
        // Fallback jika tidak di-load
        return $this->votes()->where('user_id', auth()->id())->value('type');
    }
}
