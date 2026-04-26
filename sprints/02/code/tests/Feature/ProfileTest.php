<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_profile()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->put(route('profile.update'), [
            'name' => 'Frissített Név',
            'email' => $user->email,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', ['name' => 'Frissített Név']);
    }

    public function test_profile_page_requires_authentication()
    {
        $response = $this->get(route('profile.edit'));

        $response->assertRedirect(route('login'));
    }

    public function test_user_cannot_update_profile_with_duplicate_email()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create(['email' => 'taken@example.com']);

        $this->actingAs($user);

        $response = $this->from(route('profile.edit'))->put(route('profile.update'), [
            'name' => 'Frissített Név',
            'email' => $otherUser->email,
        ]);

        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHasErrors('email');
    }

    public function test_password_update_requires_confirmation()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->from(route('profile.edit'))->put(route('profile.update'), [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'new-secret-password',
            'password_confirmation' => 'different-password',
        ]);

        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHasErrors('password');
    }

    public function test_user_can_update_password()
    {
        $user = User::factory()->create(['password' => bcrypt('old-password')]);
        $this->actingAs($user);

        $response = $this->put(route('profile.update'), [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'new-secret-password',
            'password_confirmation' => 'new-secret-password',
        ]);

        $response->assertRedirect(route('profile.edit'));
        $user->refresh();
        $this->assertTrue(Hash::check('new-secret-password', $user->password));
    }
}
