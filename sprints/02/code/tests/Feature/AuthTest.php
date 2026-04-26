<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_and_login()
    {
        $response = $this->post('/register', [
            'name' => 'User A',
            'email' => 'usera@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', ['email' => 'usera@example.com']);

        $response = $this->post('/login', [
            'email' => 'usera@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect();
    }

    public function test_registration_requires_unique_email()
    {
        User::factory()->create(['email' => 'dupe@example.com']);

        $response = $this->from('/register')->post('/register', [
            'name' => 'User B',
            'email' => 'dupe@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors('email');
    }

    public function test_login_fails_with_wrong_password()
    {
        User::factory()->create([
            'email' => 'userc@example.com',
            'password' => bcrypt('correct-password'),
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => 'userc@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_authenticated_user_is_redirected_from_login_and_register_forms()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->get('/login')->assertRedirect(route('events.index'));
        $this->get('/register')->assertRedirect(route('events.index'));
    }

    public function test_guest_can_open_login_and_register_forms()
    {
        $this->get('/login')->assertStatus(200);
        $this->get('/register')->assertStatus(200);
    }

    public function test_logout_invalidates_session_and_authentication()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('logout'));

        $response->assertRedirect(route('events.index'));
        $this->assertGuest();
    }
}
