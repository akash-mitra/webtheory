<?php

namespace Tests\Feature;

use Tests\TestDataSetup;
use App\PageComment;

class PageCommentTest extends TestDataSetup
{
    /* PageComment Index */
    public function test_pagecomment_index()
    {
        $pagecomment = factory(PageComment::class)->create();

        /* Unauthenticated user can view pagecomments listing */
        $response = $this->get('/api/pages/' . $this->page->id . '/comments');
        $response->assertStatus(200)->assertJsonStructureExact([
            'current_page',
            'data' => [
                '*' => [
                    array_merge($this->comment_attributes, [
                        'user' => $this->user_attributes,
                        'replies',
                    ]),
                ],
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

        /* Authenticated user can view pagecomments listing */
        $response = $this->actingAs($this->adminUser)->get(
            '/api/pages/' . $this->page->id . '/comments'
        );
        $response->assertStatus(200)->assertJsonStructureExact([
            'current_page',
            'data' => [
                '*' => [
                    array_merge($this->comment_attributes, [
                        'user' => $this->user_attributes,
                        'replies',
                    ]),
                ],
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
        $this->assertDatabaseHas('page_comments', ['body' => $pagecomment->body]);
    }

    /* PageComment Store */
    public function test_pagecomment_store()
    {
        $pagecomment = factory(PageComment::class)->make();

        /* Unauthenticated user cannot save pagecomment */
        $response = $this->post(
            '/api/pages/' . $this->page->id . '/comments',
            $pagecomment->toArray(),
            ['Accept' => 'application/json']
        );
        $response->assertStatus(401)->assertJson(['message' => 'Unauthenticated.']);

        /* Authenticated user can save pagecomment */
        $response = $this->actingAs($this->adminUser)->post(
            '/api/pages/' . $this->page->id . '/comments',
            $pagecomment->toArray()
        );
        $response
            ->assertStatus(200)
            ->assertJsonFragment(['body' => $pagecomment->body])
            ->assertJsonStructureExact($this->comment_attributes_store);
        $this->assertDatabaseHas('page_comments', ['body' => $pagecomment->body]);
    }

    /*

    // PageComment Destroy
    public function test_pagecomment_destroy()
    {
        $pagecomment = factory(PageComment::class)->create([
            'reference_id' => $this->page->id,
            'user_id' => $this->adminUser->id
        ]);

        // Unauthenticated user cannot delete pagecomment
        $response = $this->delete('/api/comments/pages/' . $pagecomment->id, [], ['Accept' => 'application/json']);
        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

        // Authenticated user can delete pagecomment
        $response = $this->actingAs($this->adminUser)->delete('/api/comments/pages/' . $pagecomment->id);
        $response->assertStatus(204);
        $this->assertSoftDeleted('page_comments', ['body' => $pagecomment->body]);
    }

    // PageComment Like
    public function test_pagecomment_like()
    {
        $pagecomment = factory(PageComment::class)->create([
            'reference_id' => $this->page->id,
            'user_id' => $this->adminUser->id,
        ]);

        // Unauthenticated user cannot give pagecomment like
        $response = $this->put('/api/comments/pages/' . $pagecomment->id . '/like');
        $response->assertStatus(200)
            ->assertJsonFragment(['body' => $pagecomment->body])
            ->assertJsonStructureExact($this->comment_attributes);
        $this->assertDatabaseHas('page_comments', ['likes' => $pagecomment->likes + 1]);

        // Authenticated user can give pagecomment like
        $response = $this->actingAs($this->adminUser)->put('/api/comments/pages/' . $pagecomment->id . '/like');
        $response->assertStatus(200)
            ->assertJsonFragment(['likes' => $pagecomment->likes + 1])
            ->assertJsonStructureExact($this->comment_attributes);
        $this->assertDatabaseHas('page_comments', ['likes' => $pagecomment->likes + 1]);
    }

    // PageComment Dislike
    public function test_pagecomment_dislike()
    {
        $pagecomment = factory(PageComment::class)->create([
            'reference_id' => $this->page->id,
            'user_id' => $this->adminUser->id,
        ]);

        // Unauthenticated user cannot give pagecomment dislike
        $response = $this->put('/api/comments/pages/' . $pagecomment->id . '/dislike');
        $response->assertStatus(200)
            ->assertJsonFragment(['body' => $pagecomment->body])
            ->assertJsonStructureExact($this->comment_attributes);
        $this->assertDatabaseHas('page_comments', ['body' => $pagecomment->body]);

        // Authenticated user can give pagecomment dislike
        $response = $this->actingAs($this->adminUser)->put('/api/comments/pages/' . $pagecomment->id . '/dislike');
        $response->assertStatus(200)
            ->assertJsonFragment(['dislikes' => $pagecomment->dislikes + 1])
            ->assertJsonStructureExact($this->comment_attributes);
        $this->assertDatabaseHas('page_comments', ['dislikes' => $pagecomment->dislikes + 1]);
    }

    */
}
