<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type'
    ];

    public function votable(): MorphTo
    {
        return $this->morphTo();
    }
}
