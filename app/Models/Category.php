<?php

namespace App\Models;

use App\Models\Thread;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'name',
        'slug',
        'description,'
    ];

    /**
     * Get the options for generating the slug
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * TAMBAHKAN RELASI INI
     * Mendefinisikan bahwa sebuah Category memiliki banyak Thread.
     */
    public function threads(): HasMany
    {
        // Nanti kita akan membuat model Thread
        return $this->hasMany(Thread::class);
    }
}
