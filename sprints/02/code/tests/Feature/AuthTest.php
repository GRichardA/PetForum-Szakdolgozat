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
}
