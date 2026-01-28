<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Event;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_post_comment()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $event = Event::factory()->create(['user_id' => $user->id]);

        $response = $this->post(route('events.comments.store', $event->id), [
            'body' => 'Ez egy teszt komment',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('comments', ['body' => 'Ez egy teszt komment']);
    }
}
