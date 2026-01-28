<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;

class EventTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_events_index()
    {
        $response = $this->get(route('events.index'));
        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_create_event()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $category = Category::factory()->create();

        $response = $this->post(route('events.store'), [
            'title' => 'Teszt esemény',
            'event_date' => now()->addDay()->format('Y-m-d H:i:s'),
            'location' => 'Teszt hely',
            'description' => 'Leírás',
            'category_id' => $category->id,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('events', ['title' => 'Teszt esemény']);
    }
}
