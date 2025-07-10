<?php

namespace App\Models;

use App\Models\Concerns\Votable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes, Votable;

    protected $fillable = [
        'user_id',
        'body',
        'parent_id'
    ];

    protected static function boot()
    {
        parent::boot();

        // Ketika komentar dihapus secara lunak, hapus lunak juga semua balasannya
        static::deleting(function (Comment $comment) {
            $comment->replies->each(function (Comment $reply) {
                $reply->delete(); // Ini akan memicu event deleting pada balasan juga (rekursif)
            });
        });
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
