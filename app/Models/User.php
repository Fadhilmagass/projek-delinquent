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

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

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
    ];

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

    /**
     * Relasi many-to-many ke Genre
     */
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

    /**
     * Helper untuk mendapatkan URL acatar.
     * Jika user punya catar, tampilkan. Jika tidak, generate dari Laravolt.
     */
    public function getAvatarUrl()
    {
        if ($this->avatar_path && Storage::disk('public')->exists($this->avatar_path)) {
            return Storage::url($this->avatar_path);
        }

        // Menggunakan Laravolt Avatar sebagai fallback
        return \Laravolt\Avatar\Facade::create($this->name)->toBase64();
    }
}
