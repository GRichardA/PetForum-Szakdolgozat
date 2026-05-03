<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'user_id',
        'parent_id',
        'body',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id')->orderBy('created_at', 'asc');
    }

    /**
     * Recursively delete all children when comment is deleted
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($comment) {
            // Recursively delete all child comments
            $comment->children()->each(function ($child) {
                $child->delete();
            });
        });
    }

    /**
     * Check if user can delete this comment (owner or admin)
     */
    public function canBeDeletedBy($user = null): bool
    {
        if (!$user) {
            return false;
        }

        // User can delete their own comment
        if ($this->user_id === $user->id) {
            return true;
        }

        // Admin can delete any comment
        return $user->is_admin === true;
    }
}
