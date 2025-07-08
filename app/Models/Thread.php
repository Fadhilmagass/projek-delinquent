<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Thread extends Model
{
    use HasFactory;

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
}
