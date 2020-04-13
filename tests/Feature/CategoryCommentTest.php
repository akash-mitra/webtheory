<?php

namespace Tests\Feature;

use Tests\TestDataSetup;
use App\CategoryComment;

class CategoryCommentTest extends TestDataSetup
{
    /* CategoryComment Index */
    public function test_categorycomment_index()
    {
        $categorycomment = factory(CategoryComment::class)->create([
            'reference_id' => $this->category->id,
            'user_id' => $this->adminUser->id,
        ]);

        /* Unauthenticated user cannot view categorycomments listing */
        $response = $this->get('/api/comments/categories');
        $response->assertStatus(302);

        /* Authenticated user can view categorycomments listing */
        $response = $this->actingAs($this->adminUser)->get('/api/comments/categories');
        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id', 'name', 'parent_id', 'description', 'metakey', 'metadesc', 'media_id', 'user_id',
                    'created_at', 'updated_at', 'deleted_at',
                    'url', 'permalink', 'created_ago', 'updated_ago',
                    'comments' => [
                        '*' => [
                            'id', 'parent_id', 'reference_id', 'user_id', 'body', 'likes', 'dislikes',
                            'created_at', 'updated_at', 'deleted_at', 'created_ago', 'updated_ago',
                            'user' => [
                                'id', 'name', 'email', 'email_verified_at', 'role', 'avatar', 'about_me', 'gender', 'dob', 'preferences',
                                'created_at', 'updated_at', 'deleted_at'
                            ]
                        ]
                    ]
                ]
            ]);
        $this->assertDatabaseHas('category_comments', ['body' => $categorycomment->body]);
    }

    /* CategoryComment Show */
    public function test_categorycomment_show()
    {
        $categorycomment = factory(CategoryComment::class)->create([
            'reference_id' => $this->category->id,
            'user_id' => $this->adminUser->id,
        ]);

        /* Unauthenticated user cannot view categorycomment */
        $response = $this->get('/api/comments/categories/' . $categorycomment->id);
        $response->assertStatus(302);

        /* Authenticated user can view categorycomment */
        $response = $this->actingAs($this->adminUser)->get('/api/comments/categories/' . $categorycomment->id);
        $response->assertStatus(200)
            ->assertJsonFragment(['body' => $categorycomment->body])
            ->assertJsonStructure([
                'id', 'parent_id', 'reference_id', 'user_id', 'body', 'likes', 'dislikes',
                'created_at', 'updated_at', 'deleted_at', 'created_ago', 'updated_ago',
            ]);
        $this->assertDatabaseHas('category_comments', ['body' => $categorycomment->body]);
    }

    /* CategoryComment Store */
    public function test_categorycomment_store()
    {
        $categorycomment = factory(CategoryComment::class)->make([
            'reference_id' => $this->category->id,
        ]);

        /* Unauthenticated user cannot save categorycomment */
        // $response = $this->post('/api/comments/categories', $categorycomment->toArray(), ['Accept' => 'application/json']);
        // $response->assertStatus(401)
        //     ->assertJson(['message' => 'Unauthenticated.']);

        /* Authenticated user can save categorycomment */
        $response = $this->actingAs($this->adminUser)->post('/api/comments/categories', $categorycomment->toArray());
        $response->assertStatus(200)
            ->assertJsonFragment(['body' => $categorycomment->body])
            ->assertJsonStructure([
                'parent_id', 'reference_id', 'user_id', 'body',
                'updated_at', 'created_at', 'id', 'created_ago', 'updated_ago',
            ]);
        $this->assertDatabaseHas('category_comments', ['body' => $categorycomment->body]);
    }

    /* CategoryComment Update */
    public function test_categorycomment_update()
    {
        $categorycomment = factory(CategoryComment::class)->create([
            'reference_id' => $this->category->id,
            'user_id' => $this->adminUser->id,
            'body' => 'Test CategoryComment',
        ]);
        $categorycomment->body = 'Test CategoryComment Updated';

        /* Unauthenticated user cannot update categorycomment */
        // $response = $this->put('/api/comments/categories/' . $categorycomment->id, $categorycomment->toArray(), ['Accept' => 'application/json']);
        // $response->assertStatus(401)
        //     ->assertJson(['message' => 'Unauthenticated.']);

        /* Authenticated user can update categorycomment */
        $response = $this->actingAs($this->adminUser)->put('/api/comments/categories/' . $categorycomment->id, $categorycomment->toArray());
        $response->assertStatus(200)
            ->assertJsonFragment(['body' => 'Test CategoryComment Updated'])
            ->assertJsonStructure([
                'id', 'parent_id', 'reference_id', 'user_id', 'body', 'likes', 'dislikes',
                'created_at', 'updated_at', 'deleted_at', 'created_ago', 'updated_ago',
            ]);
        $this->assertDatabaseHas('category_comments', ['body' => 'Test CategoryComment Updated']);
        $this->assertDatabaseMissing('category_comments', ['body' => 'Test CategoryComment']);
    }

    /* CategoryComment Destroy */
    public function test_categorycomment_destroy()
    {
        $categorycomment = factory(CategoryComment::class)->create([
            'reference_id' => $this->category->id,
            'user_id' => $this->adminUser->id
        ]);

        /* Unauthenticated user cannot delete categorycomment */
        // $response = $this->delete('/api/comments/categories/' . $categorycomment->id, [], ['Accept' => 'application/json']);
        // $response->assertStatus(401)
        //     ->assertJson(['message' => 'Unauthenticated.']);

        /* Authenticated user can delete categorycomment */
        $response = $this->actingAs($this->adminUser)->delete('/api/comments/categories/' . $categorycomment->id);
        $response->assertStatus(204);
        $this->assertSoftDeleted('category_comments', ['body' => $categorycomment->body]);
    }

    /* CategoryComment Like */
    public function test_categorycomment_like()
    {
        $categorycomment = factory(CategoryComment::class)->create([
            'reference_id' => $this->category->id,
            'user_id' => $this->adminUser->id,
        ]);

        /* Unauthenticated user cannot give categorycomment like */
        // $response = $this->put('/api/comments/categories/' . $categorycomment->id . '/like');
        // $response->assertStatus(200)
        //     ->assertJsonFragment(['body' => $categorycomment->body])
        //     ->assertJsonStructureExact([
        //         'id', 'parent_id', 'reference_id', 'user_id', 'body', 'likes', 'dislikes',
        //         'created_at', 'updated_at', 'deleted_at', 'created_ago', 'updated_ago',
        //     ]);
        // $this->assertDatabaseHas('category_comments', ['likes' => $categorycomment->likes + 1]);

        /* Authenticated user can give categorycomment like */
        $response = $this->actingAs($this->adminUser)->put('/api/comments/categories/' . $categorycomment->id . '/like');
        $response->assertStatus(200)
            ->assertJsonFragment(['likes' => $categorycomment->likes + 1])
            ->assertJsonStructure([
                'id', 'parent_id', 'reference_id', 'user_id', 'body', 'likes', 'dislikes',
                'created_at', 'updated_at', 'deleted_at', 'created_ago', 'updated_ago',
            ]);
        $this->assertDatabaseHas('category_comments', ['likes' => $categorycomment->likes + 1]);
    }

    /* CategoryComment Dislike */
    public function test_categorycomment_dislike()
    {
        $categorycomment = factory(CategoryComment::class)->create([
            'reference_id' => $this->category->id,
            'user_id' => $this->adminUser->id,
        ]);

        /* Unauthenticated user cannot give categorycomment dislike */
        // $response = $this->put('/api/comments/categories/' . $categorycomment->id . '/dislike');
        // $response->assertStatus(200)
        //     ->assertJsonFragment(['body' => $categorycomment->body])
        //     ->assertJsonStructureExact([
        //         'id', 'parent_id', 'reference_id', 'user_id', 'body', 'likes', 'dislikes',
        //         'created_at', 'updated_at', 'deleted_at', 'created_ago', 'updated_ago',
        //     ]);
        // $this->assertDatabaseHas('category_comments', ['body' => $categorycomment->body]);

        /* Authenticated user can give categorycomment dislike */
        $response = $this->actingAs($this->adminUser)->put('/api/comments/categories/' . $categorycomment->id . '/dislike');
        $response->assertStatus(200)
            ->assertJsonFragment(['dislikes' => $categorycomment->dislikes + 1])
            ->assertJsonStructure([
                'id', 'parent_id', 'reference_id', 'user_id', 'body', 'likes', 'dislikes',
                'created_at', 'updated_at', 'deleted_at', 'created_ago', 'updated_ago',
            ]);
        $this->assertDatabaseHas('category_comments', ['dislikes' => $categorycomment->dislikes + 1]);
    }
}
