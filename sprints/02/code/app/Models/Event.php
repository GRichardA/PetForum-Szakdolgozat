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
        'allowed_animal_types',
        'allowed_breeds',
        'vaccination_required',
        'capacity',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'allowed_animal_types' => 'array',
        'allowed_breeds' => 'array',
        'vaccination_required' => 'boolean',
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

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function confirmedRegistrations(): HasMany
    {
        return $this->hasMany(Registration::class)->where('status', 'confirmed');
    }

    public function allowsAnimalType(?string $animalType): bool
    {
        $allowedTypes = array_filter(array_map('mb_strtolower', $this->allowed_animal_types ?? []));

        if (empty($allowedTypes)) {
            return true;
        }

        return in_array(mb_strtolower((string) $animalType), $allowedTypes, true);
    }

    public function allowsBreed(?string $breed): bool
    {
        $allowedBreeds = array_filter(array_map('mb_strtolower', $this->allowed_breeds ?? []));

        if (empty($allowedBreeds)) {
            return true;
        }

        return in_array(mb_strtolower((string) $breed), $allowedBreeds, true);
    }

    public function canRegisterPet(Pet $pet): bool
    {
        return $this->allowsAnimalType($pet->animal_type)
            && $this->allowsBreed($pet->breed)
            && (! $this->vaccination_required || $pet->isVaccinated());
    }

    public function isFull(): bool
    {
        if ($this->capacity === null) {
            return false;
        }

        return $this->confirmedRegistrations()->count() >= $this->capacity;
    }

    public function availableSpots(): ?int
    {
        if ($this->capacity === null) {
            return null;
        }

        return max(0, $this->capacity - $this->confirmedRegistrations()->count());
    }
}
