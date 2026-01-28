<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class EventFactory extends Factory
{
    protected $model = \App\Models\Event::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(4),
            'event_date' => Carbon::now()->addDays($this->faker->numberBetween(1, 30)),
            'location' => $this->faker->city(),
            'description' => $this->faker->paragraph(),
            'category_id' => \App\Models\Category::factory(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
