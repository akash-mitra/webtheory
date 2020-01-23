<?php

namespace Tests\Feature;

use Tests\TestDataSetup;
use App\PageComment;

class PageCommentTest extends TestDataSetup
{
    /* PageComment Index */
    public function test_pagecomment_index()
    {
        $pagecomment = factory(PageComment::class)->create([
            'reference_id' => $this->page->id,
            'user_id' => $this->adminUser->id,
        ]);

        /* Unauthenticated user can view pagecomments listing */
        $response = $this->get('/api/comments/pages');
        $response->assertStatus(200)
            ->assertJsonStructureExact([
                '*' => [
                    'id', 'category_id', 'user_id', 'title', 'summary', 'metakey', 'metadesc', 'media_id', 'status',
                    'created_at', 'updated_at', 'deleted_at', 
                    'url', 'created_ago', 'updated_ago', 
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
        $this->assertDatabaseHas('page_comments', ['body' => $pagecomment->body]);

        /* Authenticated user can view pagecomments listing */
        $response = $this->actingAs($this->adminUser)->get('/api/comments/pages');
        $response->assertStatus(200)
            ->assertJsonStructureExact([
                '*' => [
                    'id', 'category_id', 'user_id', 'title', 'summary', 'metakey', 'metadesc', 'media_id', 'status',
                    'created_at', 'updated_at', 'deleted_at', 
                    'url', 'created_ago', 'updated_ago', 
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
        $this->assertDatabaseHas('page_comments', ['body' => $pagecomment->body]);
    }

    /* PageComment Show */
    public function test_pagecomment_show()
    {
        $pagecomment = factory(PageComment::class)->create([
            'reference_id' => $this->page->id,
            'user_id' => $this->adminUser->id,
        ]);

        /* Unauthenticated user can view pagecomment */
        $response = $this->get('/api/comments/pages/' . $pagecomment->id);
        $response->assertStatus(200)
            ->assertJsonFragment(['body' => $pagecomment->body])
            ->assertJsonStructureExact([
                'id', 'parent_id', 'reference_id', 'user_id', 'body', 'likes', 'dislikes', 
                'created_at', 'updated_at', 'deleted_at', 'created_ago', 'updated_ago', 
            ]);
        $this->assertDatabaseHas('page_comments', ['body' => $pagecomment->body]);

        /* Authenticated user can view pagecomment */
        $response = $this->actingAs($this->adminUser)->get('/api/comments/pages/' . $pagecomment->id);
        $response->assertStatus(200)
            ->assertJsonFragment(['body' => $pagecomment->body])
            ->assertJsonStructureExact([
                'id', 'parent_id', 'reference_id', 'user_id', 'body', 'likes', 'dislikes', 
                'created_at', 'updated_at', 'deleted_at', 'created_ago', 'updated_ago', 
            ]);
        $this->assertDatabaseHas('page_comments', ['body' => $pagecomment->body]);
    }

    /* PageComment Store */
    public function test_pagecomment_store()
    {
        $pagecomment = factory(PageComment::class)->make([
            'reference_id' => $this->page->id,
        ]);

        /* Unauthenticated user cannot save pagecomment */
        // $response = $this->post('/api/comments/pages', $pagecomment->toArray(), ['Accept' => 'application/json']);
        // $response->assertStatus(401)
        //     ->assertJson(['message' => 'Unauthenticated.']);

        /* Authenticated user can save pagecomment */
        $response = $this->actingAs($this->adminUser)->post('/api/comments/pages', $pagecomment->toArray());
        $response->assertStatus(200)
            ->assertJsonFragment(['body' => $pagecomment->body])
            ->assertJsonStructureExact([
                'parent_id', 'reference_id', 'user_id', 'body', 
                'updated_at', 'created_at', 'id', 'created_ago', 'updated_ago', 
            ]);
        $this->assertDatabaseHas('page_comments', ['body' => $pagecomment->body]);
    }

    /* PageComment Update */
    public function test_pagecomment_update()
    {
        $pagecomment = factory(PageComment::class)->create([
            'reference_id' => $this->page->id,
            'user_id' => $this->adminUser->id,
            'body' => 'Test PageComment',
        ]);
        $pagecomment->body = 'Test PageComment Updated';

        /* Unauthenticated user cannot update pagecomment */
        // $response = $this->put('/api/comments/pages/' . $pagecomment->id, $pagecomment->toArray(), ['Accept' => 'application/json']);
        // $response->assertStatus(401)
        //     ->assertJson(['message' => 'Unauthenticated.']);

        /* Authenticated user can update pagecomment */
        $response = $this->actingAs($this->adminUser)->put('/api/comments/pages/' . $pagecomment->id, $pagecomment->toArray());
        $response->assertStatus(200)
            ->assertJsonFragment(['body' => 'Test PageComment Updated'])
            ->assertJsonStructureExact([
                'id', 'parent_id', 'reference_id', 'user_id', 'body', 'likes', 'dislikes', 
                'created_at', 'updated_at', 'deleted_at', 'created_ago', 'updated_ago', 
            ]);
        $this->assertDatabaseHas('page_comments', ['body' => 'Test PageComment Updated']);
        $this->assertDatabaseMissing('page_comments', ['body' => 'Test PageComment']);
    }

    /* PageComment Destroy */
    public function test_pagecomment_destroy()
    {
        $pagecomment = factory(PageComment::class)->create([
            'reference_id' => $this->page->id,
            'user_id' => $this->adminUser->id
        ]);

        /* Unauthenticated user cannot delete pagecomment */
        // $response = $this->delete('/api/comments/pages/' . $pagecomment->id, [], ['Accept' => 'application/json']);
        // $response->assertStatus(401)
        //     ->assertJson(['message' => 'Unauthenticated.']);

        /* Authenticated user can delete pagecomment */
        $response = $this->actingAs($this->adminUser)->delete('/api/comments/pages/' . $pagecomment->id);
        $response->assertStatus(204);
        $this->assertSoftDeleted('page_comments', ['body' => $pagecomment->body]);
    }

    /* PageComment Like */
    public function test_pagecomment_like()
    {
        $pagecomment = factory(PageComment::class)->create([
            'reference_id' => $this->page->id,
            'user_id' => $this->adminUser->id,
        ]);

        /* Unauthenticated user cannot give pagecomment like */
        // $response = $this->put('/api/comments/pages/' . $pagecomment->id . '/like');
        // $response->assertStatus(200)
        //     ->assertJsonFragment(['body' => $pagecomment->body])
        //     ->assertJsonStructureExact([
        //         'id', 'parent_id', 'reference_id', 'user_id', 'body', 'likes', 'dislikes', 
        //         'created_at', 'updated_at', 'deleted_at', 'created_ago', 'updated_ago', 
        //     ]);
        // $this->assertDatabaseHas('page_comments', ['likes' => $pagecomment->likes + 1]);

        /* Authenticated user can give pagecomment like */
        $response = $this->actingAs($this->adminUser)->put('/api/comments/pages/' . $pagecomment->id . '/like');
        $response->assertStatus(200)
            ->assertJsonFragment(['likes' => $pagecomment->likes + 1])
            ->assertJsonStructureExact([
                'id', 'parent_id', 'reference_id', 'user_id', 'body', 'likes', 'dislikes', 
                'created_at', 'updated_at', 'deleted_at', 'created_ago', 'updated_ago', 
            ]);
        $this->assertDatabaseHas('page_comments', ['likes' => $pagecomment->likes + 1]);
    }

    /* PageComment Dislike */
    public function test_pagecomment_dislike()
    {
        $pagecomment = factory(PageComment::class)->create([
            'reference_id' => $this->page->id,
            'user_id' => $this->adminUser->id,
        ]);

        /* Unauthenticated user cannot give pagecomment dislike */
        // $response = $this->put('/api/comments/pages/' . $pagecomment->id . '/dislike');
        // $response->assertStatus(200)
        //     ->assertJsonFragment(['body' => $pagecomment->body])
        //     ->assertJsonStructureExact([
        //         'id', 'parent_id', 'reference_id', 'user_id', 'body', 'likes', 'dislikes', 
        //         'created_at', 'updated_at', 'deleted_at', 'created_ago', 'updated_ago', 
        //     ]);
        // $this->assertDatabaseHas('page_comments', ['body' => $pagecomment->body]);

        /* Authenticated user can give pagecomment dislike */
        $response = $this->actingAs($this->adminUser)->put('/api/comments/pages/' . $pagecomment->id . '/dislike');
        $response->assertStatus(200)
            ->assertJsonFragment(['dislikes' => $pagecomment->dislikes + 1])
            ->assertJsonStructureExact([
                'id', 'parent_id', 'reference_id', 'user_id', 'body', 'likes', 'dislikes', 
                'created_at', 'updated_at', 'deleted_at', 'created_ago', 'updated_ago', 
            ]);
        $this->assertDatabaseHas('page_comments', ['dislikes' => $pagecomment->dislikes + 1]);
    }
}
