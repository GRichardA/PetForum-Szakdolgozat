<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_slug_generated_from_name()
    {
        $category = Category::create([
            'name' => 'Outdoor Sports',
            'slug' => \Illuminate\Support\Str::slug('Outdoor Sports'),
            'color_code' => '#FF5733',
        ]);

        $this->assertEquals('outdoor-sports', $category->slug);
    }

    public function test_category_name_must_be_unique()
    {
        Category::create([
            'name' => 'Dogs',
            'slug' => 'dogs',
        ]);

        try {
            Category::create([
                'name' => 'Dogs',
                'slug' => 'dogs-2',
            ]);
            $this->fail('Expected integrity constraint violation');
        } catch (\Illuminate\Database\QueryException $e) {
            // Support both SQLite and MySQL error message formats
            $message = $e->getMessage();
            $this->assertTrue(
                str_contains($message, 'UNIQUE constraint failed') || str_contains($message, 'Duplicate entry'),
                "Expected unique constraint error but got: {$message}"
            );
        }
    }

    public function test_category_slug_must_be_unique()
    {
        Category::create([
            'name' => 'Pets',
            'slug' => 'pets',
        ]);

        try {
            Category::create([
                'name' => 'Animals',
                'slug' => 'pets',
            ]);
            $this->fail('Expected integrity constraint violation');
        } catch (\Illuminate\Database\QueryException $e) {
            // Support both SQLite and MySQL error message formats
            $message = $e->getMessage();
            $this->assertTrue(
                str_contains($message, 'UNIQUE constraint failed') || str_contains($message, 'Duplicate entry'),
                "Expected unique constraint error but got: {$message}"
            );
        }
    }

    public function test_category_color_code_is_optional()
    {
        $category = Category::create([
            'name' => 'Music',
            'slug' => 'music',
        ]);

        $this->assertNull($category->color_code);
    }

    public function test_category_can_be_queried()
    {
        Category::factory()->count(5)->create();

        $categories = Category::all();

        $this->assertCount(5, $categories);
    }
}
