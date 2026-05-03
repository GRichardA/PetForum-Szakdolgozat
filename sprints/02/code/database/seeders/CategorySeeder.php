<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Séta', 'slug' => 'seta', 'color_code' => '#22c55e'],
            ['name' => 'Agility', 'slug' => 'agility', 'color_code' => '#3b82f6'],
            ['name' => 'Egészség', 'slug' => 'egeszseg', 'color_code' => '#ef4444'],
            ['name' => 'Kutyaovi', 'slug' => 'kutyaovi', 'color_code' => '#f59e0b'],
            ['name' => 'Kozmetika', 'slug' => 'kozmetika', 'color_code' => '#ec4899'],
            ['name' => 'Adoptálás', 'slug' => 'adoptalas', 'color_code' => '#8b5cf6'],
            ['name' => 'Jóga', 'slug' => 'joga', 'color_code' => '#10b981'],
            ['name' => 'Suli', 'slug' => 'suli', 'color_code' => '#6366f1'],
            ['name' => 'Sport', 'slug' => 'sport', 'color_code' => '#f97316'],
            ['name' => 'Túra', 'slug' => 'tura', 'color_code' => '#15803d'],
            ['name' => 'Show', 'slug' => 'show', 'color_code' => '#a855f7'],
            ['name' => 'Tippek', 'slug' => 'tippek', 'color_code' => '#64748b'],
            ['name' => 'Játék', 'slug' => 'jatek', 'color_code' => '#fbbf24'],
            ['name' => 'Mentés', 'slug' => 'mentes', 'color_code' => '#dc2626'],
            ['name' => 'Város', 'slug' => 'varos', 'color_code' => '#06b6d4'],
            ['name' => 'Szimat', 'slug' => 'szimat', 'color_code' => '#4ade80'],
            ['name' => 'Terápia', 'slug' => 'terapia', 'color_code' => '#d946ef'],
            ['name' => 'Etetés', 'slug' => 'etetes', 'color_code' => '#78350f'],
            ['name' => 'Klikker', 'slug' => 'klikker', 'color_code' => '#2dd4bf'],
            ['name' => 'Vizes', 'slug' => 'vizes', 'color_code' => '#0ea5e9'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}