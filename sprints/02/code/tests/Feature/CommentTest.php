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

    public function test_user_can_delete_own_comment()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();
        $comment = Comment::create([
            'event_id' => $event->id,
            'user_id' => $user->id,
            'body' => 'My comment',
        ]);

        $response = $this->actingAs($user)->delete(
            route('events.comments.destroy', [$event->id, $comment->id])
        );

        $response->assertRedirect(route('events.show', $event->id));
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }

    public function test_user_cannot_delete_others_comment()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $event = Event::factory()->create();
        $comment = Comment::create([
            'event_id' => $event->id,
            'user_id' => $otherUser->id,
            'body' => 'Other comment',
        ]);

        $response = $this->actingAs($user)->delete(
            route('events.comments.destroy', [$event->id, $comment->id])
        );

        $response->assertStatus(403);
        $this->assertDatabaseHas('comments', ['id' => $comment->id]);
    }

    public function test_admin_can_delete_any_comment()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $otherUser = User::factory()->create();
        $event = Event::factory()->create();
        $comment = Comment::create([
            'event_id' => $event->id,
            'user_id' => $otherUser->id,
            'body' => 'Comment to be deleted by admin',
        ]);

        $response = $this->actingAs($admin)->delete(
            route('events.comments.destroy', [$event->id, $comment->id])
        );

        $response->assertRedirect(route('events.show', $event->id));
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }

    public function test_deleting_comment_cascades_to_children()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();
        
        $parent = Comment::create([
            'event_id' => $event->id,
            'user_id' => $user->id,
            'body' => 'Parent comment',
        ]);

        $child1 = Comment::create([
            'event_id' => $event->id,
            'user_id' => $user->id,
            'body' => 'Child comment 1',
            'parent_id' => $parent->id,
        ]);

        $child2 = Comment::create([
            'event_id' => $event->id,
            'user_id' => $user->id,
            'body' => 'Child comment 2',
            'parent_id' => $parent->id,
        ]);

        $grandchild = Comment::create([
            'event_id' => $event->id,
            'user_id' => $user->id,
            'body' => 'Grandchild comment',
            'parent_id' => $child1->id,
        ]);

        // Delete parent comment
        $this->actingAs($user)->delete(
            route('events.comments.destroy', [$event->id, $parent->id])
        );

        // All comments should be deleted
        $this->assertDatabaseMissing('comments', ['id' => $parent->id]);
        $this->assertDatabaseMissing('comments', ['id' => $child1->id]);
        $this->assertDatabaseMissing('comments', ['id' => $child2->id]);
        $this->assertDatabaseMissing('comments', ['id' => $grandchild->id]);
    }
}
