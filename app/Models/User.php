<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Thread;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'bio',
        'lokasi',
        'avatar_path',
        'slug',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    public function threads(): HasMany
    {
        return $this->hasMany(Thread::class, 'user_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function getAvatarUrl()
    {
        if ($this->avatar_path && Storage::disk('public')->exists($this->avatar_path)) {
            return Storage::url($this->avatar_path);
        }

        return \Laravolt\Avatar\Facade::create($this->name)->toBase64();
    }

    /**
     * The users that are following this user.
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'followed_user_id', 'user_id');
    }

    /**
     * The users that this user is following.
     */
    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'followed_user_id');
    }

    /**
     * Check if the current user is following another user.
     */
    public function isFollowing(User $user)
    {
        return $this->following()->where('followed_user_id', $user->id)->exists();
    }
}
