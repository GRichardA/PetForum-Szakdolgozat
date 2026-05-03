<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_have_admin_role()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->assertTrue($admin->is_admin);
    }

    public function test_regular_user_is_not_admin()
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->assertFalse($user->is_admin);
    }

    public function test_user_is_not_admin_by_default()
    {
        $user = User::factory()->create();

        $this->assertFalse($user->is_admin);
    }

    public function test_user_can_be_promoted_to_admin()
    {
        $user = User::factory()->create(['is_admin' => false]);

        $user->update(['is_admin' => true]);
        $user->refresh();

        $this->assertTrue($user->is_admin);
    }

    public function test_user_has_avatar_url()
    {
        $user = User::factory()->create();

        $this->assertNotNull($user->avatar_url);
    }

    public function test_user_password_is_hashed()
    {
        $user = User::factory()->create(['password' => bcrypt('password123')]);

        $this->assertNotEquals('password123', $user->password);
    }
}
