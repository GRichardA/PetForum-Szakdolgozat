<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = \App\Models\Category::class;

    public function definition()
    {
        // Use predefined short names to avoid truncation issues and unique constraint exhaustion
        $names = ['Outdoor', 'Sports', 'Music', 'Art', 'Tech', 'Food', 'Travel', 'Health', 'Gaming', 'Books'];
        $name = $this->faker->randomElement($names) . ' ' . random_int(1, 999);

        return [
            'name' => Str::limit($name, 16, ''),
            'slug' => Str::slug($name),
            'color_code' => '#'.substr(md5($this->faker->word()), 0, 6),
        ];
    }
}
