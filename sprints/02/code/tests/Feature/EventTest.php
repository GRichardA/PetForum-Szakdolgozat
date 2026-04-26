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

    public function test_guest_cannot_create_event()
    {
        $category = Category::factory()->create();

        $response = $this->post(route('events.store'), [
            'title' => 'Guest event',
            'event_date' => now()->addDay()->format('Y-m-d H:i:s'),
            'location' => 'Guest place',
            'description' => 'Guest description',
            'category_id' => $category->id,
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseMissing('events', ['title' => 'Guest event']);
    }

    public function test_event_creation_requires_valid_category()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->from(route('events.create'))->post(route('events.store'), [
            'title' => 'Invalid category event',
            'event_date' => now()->addDay()->format('Y-m-d H:i:s'),
            'location' => 'Somewhere',
            'description' => 'Description',
            'category_id' => 999999,
        ]);

        $response->assertRedirect(route('events.create'));
        $response->assertSessionHasErrors('category_id');
    }

    public function test_owner_can_update_event()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $category = Category::factory()->create();
        $event = \App\Models\Event::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Old title',
        ]);

        $response = $this->put(route('events.update', $event), [
            'title' => 'Updated title',
            'event_date' => now()->addDays(2)->format('Y-m-d H:i:s'),
            'location' => 'Updated location',
            'description' => 'Updated description',
            'category_id' => $category->id,
        ]);

        $response->assertRedirect(route('events.show', $event));
        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'title' => 'Updated title',
        ]);
    }

    public function test_non_owner_cannot_update_event()
    {
        $owner = User::factory()->create();
        $intruder = User::factory()->create();
        $category = Category::factory()->create();

        $event = \App\Models\Event::factory()->create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
            'title' => 'Owner title',
        ]);

        $this->actingAs($intruder);

        $response = $this->put(route('events.update', $event), [
            'title' => 'Hacked title',
            'event_date' => now()->addDays(2)->format('Y-m-d H:i:s'),
            'location' => 'Hacked location',
            'description' => 'Hacked description',
            'category_id' => $category->id,
        ]);

        $response->assertRedirect(route('events.index'));
        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'title' => 'Owner title',
        ]);
    }

    public function test_owner_can_delete_event()
    {
        $owner = User::factory()->create();
        $event = \App\Models\Event::factory()->create(['user_id' => $owner->id]);

        $this->actingAs($owner);

        $response = $this->delete(route('events.destroy', $event));

        $response->assertRedirect(route('events.index'));
        $this->assertDatabaseMissing('events', ['id' => $event->id]);
    }

    public function test_non_owner_cannot_delete_event()
    {
        $owner = User::factory()->create();
        $intruder = User::factory()->create();
        $event = \App\Models\Event::factory()->create(['user_id' => $owner->id]);

        $this->actingAs($intruder);

        $response = $this->delete(route('events.destroy', $event));

        $response->assertRedirect(route('events.index'));
        $this->assertDatabaseHas('events', ['id' => $event->id]);
    }

    public function test_my_events_requires_authentication()
    {
        $response = $this->get(route('events.myEvents'));

        $response->assertRedirect(route('login'));
    }

    public function test_my_events_shows_only_authenticated_users_events()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        \App\Models\Event::factory()->create([
            'user_id' => $user->id,
            'title' => 'Own event',
        ]);
        \App\Models\Event::factory()->create([
            'user_id' => $otherUser->id,
            'title' => 'Other event',
        ]);

        $this->actingAs($user);

        $response = $this->get(route('events.myEvents'));

        $response->assertStatus(200);
        $response->assertSee('Own event');
        $response->assertDontSee('Other event');
    }
}
