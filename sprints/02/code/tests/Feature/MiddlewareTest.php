<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_is_admin_middleware_allows_admin()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertStatus(200);
    }

    public function test_is_admin_middleware_blocks_non_admin()
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(403);
    }

    public function test_is_admin_middleware_blocks_unauthenticated()
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/login');
    }

    public function test_admin_can_access_category_routes()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get('/admin/categories');

        $response->assertStatus(200);
    }

    public function test_non_admin_cannot_access_category_routes()
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get('/admin/categories');

        $response->assertStatus(403);
    }
}
