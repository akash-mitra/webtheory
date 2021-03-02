<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\TestResponse;
use Tests\TestDataSetup;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Asset;

class AssetTest extends TestDataSetup
{
    use WithFaker;

    /* Asset Index */
    public function test_media_index()
    {
        $media = factory(Asset::class)->create(['user_id' => $this->user->id]);

        // Unauthenticated user cannot view media listing
        $response = $this->get('/api/media', ['Accept' => 'application/json']);
        $response->assertStatus(401)->assertJson(['message' => 'Unauthenticated.']);

        // Authenticated user can view media listing
        $response = $this->actingAs($this->adminUser)->get('/api/media');
        $response->assertStatus(200);

        $response->assertJsonStructureExact([
            'current_page',
            'data' => [
                '*' => $this->media_attributes,
            ],
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total',
        ]);
        $this->assertDatabaseHas('media', ['name' => $media->name]);
    }

    /* Asset Show */
    public function test_media_show()
    {
        $media = factory(Asset::class)->create(['user_id' => $this->user->id]);

        // Unauthenticated user cannot view media
        $response = $this->get('/api/media/' . $media->id, ['Accept' => 'application/json']);
        $response->assertStatus(401)->assertJson(['message' => 'Unauthenticated.']);

        // Authenticated user can view media
        $response = $this->actingAs($this->adminUser)->get('/api/media/' . $media->id);
        $response
            ->assertStatus(200)
            ->assertJsonFragment(['name' => $media->name])
            ->assertJsonStructure(array_merge($this->media_attributes, ['author']));

        $this->assertDatabaseHas('media', ['name' => $media->name]);
    }

    /* Asset Upload */
    public function test_media_store_and_delete()
    {
        $image = UploadedFile::fake()->image('testimage.png');

        // Unauthenticated user cannot save media
        $response = $this->attempt_to_upload(null, $image);
        $response->assertStatus(401)->assertJson(['message' => 'Unauthenticated.']);

        // Authenticated user can save media
        $response = $this->attempt_to_upload($this->adminUser, $image);
        $response
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'file' => $this->media_attributes]);

        // test entry present in database
        $this->assertDatabaseHas('media', ['name' => 'testimage.png']);

        // test file present in disk
        $file_path = $response->getOriginalContent()['file']['path'];
        Storage::disk('public')->assertExists($file_path);

        // test media delete
        $media_id = $response->getOriginalContent()['file']['id'];
        $response = $this->delete('/api/media/' . $media_id);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('media', ['name' => 'testimage.png']);
        Storage::disk('public')->assertMissing($file_path);
    }

    public function test_unacceptable_media_types_can_not_be_uploaded()
    {
        // create and upload an .exe file
        $response = $this->attempt_to_upload($this->adminUser, UploadedFile::fake()->create('document.exe'));

        $response->assertStatus(400)->assertJson(['message' => 'File type not allowed.']);
    }


    public function test_files_bigger_than_allowed_limit_can_not_be_uploaded()
    {
        $size_in_mb = 26;

        $response = $this->attempt_to_upload($this->adminUser, UploadedFile::fake()->image('too-big-file.png')->size($size_in_mb * 1024 * 1024));

        $response->assertStatus(422)->assertJson(['message' => "The given data was invalid."]);
    }

    /* Asset URL Upload */
    public function test_media_url_store()
    {
        $data = [
            'url' => 'https://source.unsplash.com/100x100?profile',
        ];

        // Unauthenticated user cannot save media url
        $response = $this->post('/api/media/fetchUrl', $data, ['Accept' => 'application/json']);
        $response->assertStatus(401)->assertJson(['message' => 'Unauthenticated.']);

        // Authenticated user can save media url
        $response = $this->actingAs($this->adminUser)->post('/api/media/fetchUrl', $data, [
            'Accept' => 'application/json',
        ]);

        $media_id = $response->getOriginalContent()['file']['id'];
        $file_path = $response->getOriginalContent()['file']['path'];
        $file_name = $response->getOriginalContent()['file']['name'];

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'file' => $this->media_attributes]);

        $this->assertDatabaseHas('media', ['name' => $file_name]);
        Storage::disk('public')->assertExists($file_path);

        // Removing the test image file
        $response = $this->delete('/api/media/' . $media_id);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('media', ['name' => 'test']);
    }

    /* Asset Remove */
    public function test_media_destroy()
    {
        $media = factory(Asset::class)->create(['user_id' => $this->user->id]);

        // Unauthenticated user cannot delete media
        $response = $this->delete('/api/media/' . $media->id, [], ['Accept' => 'application/json']);
        $response->assertStatus(401)->assertJson(['message' => 'Unauthenticated.']);

        // Authenticated user can delete media
        $response = $this->actingAs($this->adminUser)->delete('/api/media/' . $media->id);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('media', ['name' => $media->name]);
    }

    public function test_base64_image_upload()
    {
        // create encoded media uri
        $imageContent = file_get_contents('https://s3-ap-southeast-1.amazonaws.com/pravatar.cc/1.jpg');
        $dataUri = 'data:image/' . 'jpeg' . ';base64,' . base64_encode($imageContent);

        $this->actingAs($this->adminUser);

        $image = Asset::storeFromBase64($dataUri, "test_image");

        $this->assertDatabaseHas('media', [
            'id' => $image->id,
            'name' => "test_image.jpeg"
        ]);

        Storage::disk('public')->assertExists($image->path);

        // This is a clean up step to make sure we do not keep the test file in the storage media.
        Asset::destroy($image->id);

    }

    private function attempt_to_upload($user, $media): TestResponse
    {
        if ($user == null) return $this->post('/api/media', ['file' => $media], ['Accept' => 'application/json']);

        return $this->actingAs($user)->post('/api/media', ['file' => $media], [
            'Accept' => 'application/json',
        ]);
    }
}
