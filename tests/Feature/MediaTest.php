<?php

namespace Tests\Feature;

use Tests\TestDataSetup;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Media;

class MediaTest extends TestDataSetup
{
    private $media_attributes = [
        'id', 'name', 'type', 'size', 'path', 'url', 'storage', 'user_id',
        'created_at', 'updated_at',
        'created_ago', 'updated_ago'
    ];

    // Media Index
    public function test_media_index()
    {
        $media = factory(Media::class)->create(['user_id' => $this->user->id]);

        // Unauthenticated user cannot view media listing
        $response = $this->get('/api/media', ['Accept' => 'application/json']);
        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

        /* Authenticated user can view media listing */
        $response = $this->actingAs($this->adminUser)->get('/api/media');
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                '*' => $this->media_attributes
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

        /* Authenticated user can view media */
        $response = $this->actingAs($this->adminUser)->get('/api/media/' . $media->id);
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $media->name])
            ->assertJsonStructure(
                array_merge(
                    $this->media_attributes,
                    ['author']
                )
            );

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

        /* Authenticated user can save media */
        $response = $this->actingAs($this->adminUser)->post('/api/media', $media, ['Accept' => 'application/json']);
        $media_id = $response->getOriginalContent()['file']['id'];
        $file_path = $response->getOriginalContent()['file']['path'];
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'file' => $this->media_attributes
            ]);

        $this->assertDatabaseHas('media', ['name' => 'testimage.png']);
        Storage::disk('public')->assertExists($file_path);

        // Removing the testimage file
        $response = $this->delete('/api/media/' . $media_id);
        $response->assertStatus(204);
        $this->assertDatabaseMissing('media', ['name' => 'testimage.png']);

        // Unacceptable file type
        $image = UploadedFile::fake()->create('document.pdf');
        $media = [
            'image' => $image
        ];

        $response = $this->actingAs($this->adminUser)->post('/api/media', $media, ['Accept' => 'application/json']);
        $response->assertStatus(422)
            ->assertJson(['message' => 'The given data was invalid.']);

        // Unacceptable file size
        $image = UploadedFile::fake()->image('testimage.png')->size(12 * 1024 * 1024);
        $media = [
            'image' => $image
        ];

        $response = $this->actingAs($this->adminUser)->post('/api/media', $media, ['Accept' => 'application/json']);
        $response->assertStatus(422)
            ->assertJson(['message' => 'The given data was invalid.']);
    }

    // Media Remove
    public function test_media_destroy()
    {
        $media = factory(Media::class)->create(['user_id' => $this->user->id]);

        // Unauthenticated user cannot delete media
        $response = $this->delete('/api/media/' . $media->id, [], ['Accept' => 'application/json']);
        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

        /* Authenticated user can delete media */
        $response = $this->actingAs($this->adminUser)->delete('/api/media/' . $media->id);
        $response->assertStatus(204);
        $this->assertDatabaseMissing('media', ['name' => $media->name]);
    }
}
