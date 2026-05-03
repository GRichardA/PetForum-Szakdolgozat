<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Ezt hozzáadtam a típushinting miatt
use Illuminate\Database\Eloquent\Relations\HasMany; // Ezt hozzáadtam a típushinting miatt

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'event_date',
        'location',
        'description',
        'category_id',
        'user_id',
    ];

    protected $casts = [
        'event_date' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(\App\Models\Comment::class)->whereNull('parent_id')->orderBy('created_at', 'asc');
    }
}
