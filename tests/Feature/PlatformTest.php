<?php

namespace Tests\Feature;

use App\Models\Creator;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PlatformTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_registered_user_has_a_creator_profile(): void
    {
        $user = User::factory()->create();

        $this->assertDatabaseHas('creators', [
            'user_id' => $user->id,
            'name' => $user->name,
        ]);
    }

    public function test_creator_can_update_their_profile(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $creator = $user->creator;

        $response = $this->actingAs($user)->put(route('creator.update'), [
            'name' => 'New Display Name',
            'slug' => 'new-slug',
            'bio' => 'A creative bio here.',
            'avatar_image' => UploadedFile::fake()->image('avatar.jpg'),
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('creators', [
            'id' => $creator->id,
            'name' => 'New Display Name',
            'slug' => 'new-slug',
            'bio' => 'A creative bio here.',
        ]);

        $creator->refresh();
        $this->assertNotNull($creator->avatar_url);
        
        // El guardado del avatar real es algo como avatars/xxxx.jpg
        // Nos aseguramos de que el avatar_url apunte a storage
        $this->assertStringContainsString('storage/avatars', $creator->avatar_url);
    }

    public function test_creator_can_add_a_link(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('links.store'), [
            'title' => 'My YouTube',
            'url' => 'https://youtube.com/mychannel',
        ]);

        $response->assertRedirect();
        
        $this->assertDatabaseHas('links', [
            'creator_id' => $user->creator->id,
            'title' => 'My YouTube',
            'url' => 'https://youtube.com/mychannel',
        ]);
    }

    public function test_user_can_send_support_to_a_creator(): void
    {
        $user = User::factory()->create();
        $creator = $user->creator;
        $creator->slug = 'test-creator';
        $creator->save();

        $response = $this->post(route('support.store', $creator->slug), [
            'supporter_name' => 'John Doe',
            'amount' => 50,
            'message' => 'Keep up the good work!',
        ]);

        $response->assertRedirect();
        
        $this->assertDatabaseHas('supports', [
            'creator_id' => $creator->id,
            'supporter_name' => 'John Doe',
            'amount' => 50,
            'message' => 'Keep up the good work!',
        ]);
    }
}
