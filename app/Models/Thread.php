<?php

namespace App\Models;

use App\Models\Concerns\Votable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Thread extends Model
{
    use HasFactory, Votable;

    /**
     * TAMBAHKAN BARIS INI
     * Secara eksplisit menentukan nama tabel yang digunakan oleh model.
     *
     * @var string
     */
    protected $table = 'thread';

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'body',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')->latest();
    }
}
