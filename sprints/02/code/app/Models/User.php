<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'avatar_choice',
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
     * Visszaadja a felhasználó által létrehozott eseményeket.
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Return a public URL for the user's avatar.
     */
    public function getAvatarUrlAttribute(): string
    {
        // Uploaded avatar stored on the public disk
        if ($this->avatar) {
            // Use a Laravel route to serve avatars (works around symlink/webserver issues)
            return route('user.avatar', ['filename' => basename($this->avatar)]);
        }

        // Chosen default avatar from public images
        if ($this->avatar_choice) {
            return asset("images/avatars/{$this->avatar_choice}.svg");
        }

        // Fallback default
        return asset('images/avatars/default-avatar.svg');
    }
}