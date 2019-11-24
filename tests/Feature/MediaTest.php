<?php

namespace Tests\Feature;

use Tests\TestDataSetup;
use Laravel\Passport\Passport;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Media;

class MediaTest extends TestDataSetup
{
    // Media Index
    public function test_media_index()
    {
        $media = factory(Media::class)->create(['user_id' => $this->user->id]);

        // Unauthenticated user cannot view media listing
        $response = $this->get('/api/media', ['Accept' => 'application/json']);
        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

        // Authenticated user can view media listing
        Passport::actingAs($this->user);
        $response = $this->get('/api/media');
        $response->assertStatus(200)
            ->assertJsonStructureExact([
                '*' => [
                    'id', 'name', 'type', 'size', 'path', 'url', 'storage', 'user_id', 
                    'created_at', 'updated_at', 
                    'created_ago', 'updated_ago',
                    'author' => [
                        'id', 'name', 'email', 'email_verified_at', 
                        'created_at', 'updated_at'
                    ]
                ]
            ]);
        $this->assertDatabaseHas('media', ['name' => $media->name]);
    }

    // Media Show
    public function test_media_show()
    {
        $media = factory(Media::class)->create(['user_id' => $this->user->id]);

        // Unauthenticated user cannot view media
        $response = $this->get('/api/media/' . $media->id, ['Accept' => 'application/json']);
        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

        // Authenticated user can view media
        Passport::actingAs($this->user);
        $response = $this->get('/api/media/' . $media->id);
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $media->name])
            ->assertJsonStructureExact([
                'id', 'name', 'type', 'size', 'path', 'url', 'storage', 'user_id', 
                'created_at', 'updated_at', 
                'created_ago', 'updated_ago',
                'author' => [
                    'id', 'name', 'email', 'email_verified_at', 
                    'created_at', 'updated_at'
                ]
            ]);
        $this->assertDatabaseHas('media', ['name' => $media->name]);
    }

    // Media Upload
    public function test_media_store()
    {
        $image = UploadedFile::fake()->image('testimage.png');
        $media = [
            'image' => $image
        ];

        // Unauthenticated user cannot save media
        $response = $this->post('/api/media', $media, ['Accept' => 'application/json']);
        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

        // Authenticated user can save media
        Passport::actingAs($this->user);
        $response = $this->post('/api/media', $media);
        $media_id = $response->getOriginalContent()['file']['id'];
        $file_path = $response->getOriginalContent()['file']['path'];
        $response->assertStatus(200)
            ->assertJsonStructureExact([
                'success', 
                'file' => [
                    'id', 'path', 'url'
                ]
            ]);
        
        $this->assertDatabaseHas('media', ['name' => 'testimage.png']);
        Storage::disk('public')->assertExists($file_path);

        // Removing the testimage file
        $response = $this->delete('/api/media/' . $media_id);
        $response->assertStatus(204);
        $this->assertDatabaseMissing('media', ['name' => 'testimage.png']);
    }

    // Media Remove
    public function test_media_destroy()
    {
        $media = factory(Media::class)->create(['user_id' => $this->user->id]);

        // Unauthenticated user cannot delete media
        $response = $this->delete('/api/media/' . $media->id, [], ['Accept' => 'application/json']);
        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

        // Authenticated user can delete media
        Passport::actingAs($this->user);
        $response = $this->delete('/api/media/' . $media->id);
        $response->assertStatus(204);
        $this->assertDatabaseMissing('media', ['name' => $media->name]);
    }
}
