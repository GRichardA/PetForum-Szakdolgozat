<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\User;

class AvatarUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_avatar_upload_and_processing()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $this->actingAs($user);

        $file = UploadedFile::fake()->image('avatar.jpg', 600, 600)->size(500);

        $response = $this->put(route('profile.update'), [
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => $file,
        ]);

        $response->assertRedirect();
        Storage::disk('public')->assertExists('avatars');
    }

    public function test_profile_update_rejects_non_image_avatar_file()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $this->actingAs($user);

        $file = UploadedFile::fake()->create('not-image.txt', 20, 'text/plain');

        $response = $this->from(route('profile.edit'))->put(route('profile.update'), [
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => $file,
        ]);

        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHasErrors('avatar');
    }

    public function test_user_can_choose_default_avatar()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->put(route('profile.update'), [
            'name' => $user->name,
            'email' => $user->email,
            'avatar_choice' => 'default-1.svg',
        ]);

        $response->assertRedirect(route('profile.edit'));

        $user->refresh();
        $this->assertNull($user->avatar);
        $this->assertSame('default-1.svg', $user->avatar_choice);
    }
}
