<?php

namespace Tests\Feature;

use Tests\TestDataSetup;
use App\CategoryComment;

class CategoryCommentTest extends TestDataSetup
{
    /* CategoryComment Index */
    public function test_categorycomment_index()
    {
        $categorycomment = factory(CategoryComment::class)->create();

        /* Unauthenticated user can view categorycomments listing */
        $response = $this->get('/api/categories/' . $this->category->id . '/comments');
        $response->assertStatus(200)
            ->assertJsonStructureExact([
                'current_page',
                'data' => [
                    '*' => [
                        array_merge($this->comment_attributes, [
                            'user' => $this->user_attributes,
                            "replies"
                        ])
                    ]
                ],
                'first_page_url', 'from', 'last_page', 'last_page_url', 'next_page_url', 'path', 'per_page', 'prev_page_url', 'to', 'total', 
            ]);

        /* Authenticated user can view categorycomments listing */
        $response = $this->actingAs($this->adminUser)->get('/api/categories/' . $this->category->id . '/comments');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'current_page',
                'data' => [
                    '*' => [
                        array_merge($this->comment_attributes, [
                            'user' => $this->user_attributes,
                            "replies"
                        ])
                    ]
                ],
                'first_page_url', 'from', 'last_page', 'last_page_url', 'next_page_url', 'path', 'per_page', 'prev_page_url', 'to', 'total', 
            ]);
        $this->assertDatabaseHas('category_comments', ['body' => $categorycomment->body]);
    }

    /* CategoryComment Store */
    public function test_categorycomment_store()
    {
        $categorycomment = factory(CategoryComment::class)->make();

        /* Unauthenticated user cannot save categorycomment */
        $response = $this->post('/api/categories/' . $this->category->id . '/comments', $categorycomment->toArray(), ['Accept' => 'application/json']);
        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

        /* Authenticated user can save categorycomment */
        $response = $this->actingAs($this->adminUser)->post('/api/categories/' . $this->category->id . '/comments', $categorycomment->toArray());
        $response->assertStatus(200)
            ->assertJsonFragment(['body' => $categorycomment->body])
            ->assertJsonStructure($this->comment_attributes_store);
        $this->assertDatabaseHas('category_comments', ['body' => $categorycomment->body]);
    }

    /*

    // CategoryComment Destroy
    public function test_categorycomment_destroy()
    {
        $categorycomment = factory(CategoryComment::class)->create([
            'reference_id' => $this->category->id,
            'user_id' => $this->adminUser->id
        ]);

        // Unauthenticated user cannot delete categorycomment
        $response = $this->delete('/api/comments/categories/' . $categorycomment->id, [], ['Accept' => 'application/json']);
        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

        // Authenticated user can delete categorycomment
        $response = $this->actingAs($this->adminUser)->delete('/api/comments/categories/' . $categorycomment->id);
        $response->assertStatus(204);
        $this->assertSoftDeleted('category_comments', ['body' => $categorycomment->body]);
    }

    // CategoryComment Like
    public function test_categorycomment_like()
    {
        $categorycomment = factory(CategoryComment::class)->create([
            'reference_id' => $this->category->id,
            'user_id' => $this->adminUser->id,
        ]);

        // Unauthenticated user cannot give categorycomment like
        $response = $this->put('/api/comments/categories/' . $categorycomment->id . '/like');
        $response->assertStatus(200)
            ->assertJsonFragment(['body' => $categorycomment->body])
            ->assertJsonStructureExact($this->comment_attributes);
        $this->assertDatabaseHas('category_comments', ['likes' => $categorycomment->likes + 1]);

        // Authenticated user can give categorycomment like
        $response = $this->actingAs($this->adminUser)->put('/api/comments/categories/' . $categorycomment->id . '/like');
        $response->assertStatus(200)
            ->assertJsonFragment(['likes' => $categorycomment->likes + 1])
            ->assertJsonStructure($this->comment_attributes);
        $this->assertDatabaseHas('category_comments', ['likes' => $categorycomment->likes + 1]);
    }

    // CategoryComment Dislike
    public function test_categorycomment_dislike()
    {
        $categorycomment = factory(CategoryComment::class)->create([
            'reference_id' => $this->category->id,
            'user_id' => $this->adminUser->id,
        ]);

        // Unauthenticated user cannot give categorycomment dislike
        $response = $this->put('/api/comments/categories/' . $categorycomment->id . '/dislike');
        $response->assertStatus(200)
            ->assertJsonFragment(['body' => $categorycomment->body])
            ->assertJsonStructureExact($this->comment_attributes);
        $this->assertDatabaseHas('category_comments', ['body' => $categorycomment->body]);

        // Authenticated user can give categorycomment dislike
        $response = $this->actingAs($this->adminUser)->put('/api/comments/categories/' . $categorycomment->id . '/dislike');
        $response->assertStatus(200)
            ->assertJsonFragment(['dislikes' => $categorycomment->dislikes + 1])
            ->assertJsonStructure($this->comment_attributes);
        $this->assertDatabaseHas('category_comments', ['dislikes' => $categorycomment->dislikes + 1]);
    }

    */

}
