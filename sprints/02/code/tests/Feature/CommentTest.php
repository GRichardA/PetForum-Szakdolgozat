<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Event;
use App\Models\Comment;

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

    public function test_guest_cannot_post_comment()
    {
        $event = Event::factory()->create();

        $response = $this->post(route('events.comments.store', $event->id), [
            'body' => 'Guest comment',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseMissing('comments', ['body' => 'Guest comment']);
    }

    public function test_comment_requires_body()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $event = Event::factory()->create(['user_id' => $user->id]);

        $response = $this->from(route('events.show', $event->id))
            ->post(route('events.comments.store', $event->id), [
                'body' => '',
            ]);

        $response->assertRedirect(route('events.show', $event->id));
        $response->assertSessionHasErrors('body');
    }

    public function test_authenticated_user_can_reply_to_comment()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $event = Event::factory()->create(['user_id' => $user->id]);
        $parent = Comment::create([
            'event_id' => $event->id,
            'user_id' => $user->id,
            'body' => 'Parent comment',
        ]);

        $response = $this->post(route('events.comments.store', $event->id), [
            'body' => 'Reply comment',
            'parent_id' => $parent->id,
        ]);

        $response->assertRedirect(route('events.show', $event->id));
        $this->assertDatabaseHas('comments', [
            'body' => 'Reply comment',
            'parent_id' => $parent->id,
            'event_id' => $event->id,
        ]);
    }
}
