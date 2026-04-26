<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiContractTest extends TestCase
{
    use RefreshDatabase;

    public function test_events_index_contract(): void
    {
        $user = User::factory()->create(['name' => 'Contract User']);
        $category = Category::factory()->create(['name' => 'Contract Category', 'slug' => 'contract-category']);

        Event::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Contract Event',
            'location' => 'Budapest',
        ]);

        $response = $this->getJson('/api/v1/events');

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'title',
                        'event_date',
                        'location',
                        'description',
                        'category' => ['id', 'name', 'slug'],
                        'user' => ['id', 'name'],
                    ],
                ],
                'meta' => ['count'],
            ])
            ->assertJsonPath('meta.count', 1)
            ->assertJsonPath('data.0.title', 'Contract Event')
            ->assertJsonPath('data.0.category.slug', 'contract-category');
    }

    public function test_event_show_contract_includes_comments(): void
    {
        $user = User::factory()->create(['name' => 'Owner']);
        $commenter = User::factory()->create(['name' => 'Commenter']);
        $category = Category::factory()->create();

        $event = Event::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Detailed Contract Event',
        ]);

        $parent = Comment::create([
            'event_id' => $event->id,
            'user_id' => $commenter->id,
            'body' => 'Parent comment',
            'parent_id' => null,
        ]);

        Comment::create([
            'event_id' => $event->id,
            'user_id' => $commenter->id,
            'body' => 'Child comment',
            'parent_id' => $parent->id,
        ]);

        $response = $this->getJson('/api/v1/events/' . $event->id);

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'event_date',
                    'location',
                    'description',
                    'category' => ['id', 'name', 'slug'],
                    'user' => ['id', 'name'],
                    'comments' => [
                        [
                            'id',
                            'body',
                            'user' => ['id', 'name'],
                            'children' => [
                                [
                                    'id',
                                    'body',
                                    'user' => ['id', 'name'],
                                ],
                            ],
                        ],
                    ],
                ],
            ])
            ->assertJsonPath('data.title', 'Detailed Contract Event')
            ->assertJsonPath('data.comments.0.body', 'Parent comment')
            ->assertJsonPath('data.comments.0.children.0.body', 'Child comment');
    }

    public function test_event_show_returns_404_for_missing_event(): void
    {
        $response = $this->getJson('/api/v1/events/999999');

        $response->assertNotFound();
    }

    public function test_health_contract_shape(): void
    {
        $response = $this->getJson('/api/v1/health');

        $response
            ->assertOk()
            ->assertJsonStructure(['status', 'database', 'storage']);
    }
}
