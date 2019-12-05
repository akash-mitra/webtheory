<?php

namespace Tests\Feature;

use Tests\TestDataSetup;
use Laravel\Passport\Passport;
use App\Page;
use App\PageContent;
use App\PageComment;

class PageTest extends TestDataSetup
{
    /* Page Index */
    public function test_page_index()
    {
        $page = factory(Page::class)->create([
            'category_id' => $this->category->id,
            'user_id' => $this->adminUser->id,
        ]);

        /* Unauthenticated user can view pages listing */
        $response = $this->get('/api/pages');
        $response->assertStatus(200)
            ->assertJsonStructureExact([
                '*' => [
                    'id', 'category_id', 'user_id', 'title', 'summary', 'metakey', 'metadesc', 'media_id', 'status',
                    'created_at', 'updated_at', 'deleted_at', 
                    'url', 'created_ago', 'updated_ago',
                    'category' => [
                        'id', 'name', 'parent_id', 'description', 'metakey', 'metadesc', 'media_id', 'user_id', 
                        'created_at', 'updated_at', 'deleted_at', 
                        'url', 'created_ago', 'updated_ago'
                    ],
                    'author' => [
                        'id', 'name', 'email', 'email_verified_at', 'role', 'avatar', 'about_me', 'gender', 'dob', 'preferences', 
                        'created_at', 'updated_at', 'deleted_at'
                    ], 
                    'media' 
                ]
            ]);
        $this->assertDatabaseHas('pages', ['title' => $page['title']]);

        /* Authenticated user can view pages listing */
        // Passport::actingAs($this->adminUser);
        // $response = $this->get('/api/pages');

        $response = $this->actingAs($this->adminUser)->get('/api/pages');
        $response->assertStatus(200)
            ->assertJsonStructureExact([
                '*' => [
                    'id', 'category_id', 'user_id', 'title', 'summary', 'metakey', 'metadesc', 'media_id', 'status',
                    'created_at', 'updated_at', 'deleted_at', 
                    'url', 'created_ago', 'updated_ago',
                    'category' => [
                        'id', 'name', 'parent_id', 'description', 'metakey', 'metadesc', 'media_id', 'user_id', 
                        'created_at', 'updated_at', 'deleted_at', 
                        'url', 'created_ago', 'updated_ago'
                    ],
                    'author' => [
                        'id', 'name', 'email', 'email_verified_at', 'role', 'avatar', 'about_me', 'gender', 'dob', 'preferences', 
                        'created_at', 'updated_at', 'deleted_at'
                    ], 
                    'media' 
                ]
            ]);
        $this->assertDatabaseHas('pages', ['title' => $page['title']]);
    }

    /* Page Show */
    public function test_page_show()
    {
        $page = factory(Page::class)->create([
            'category_id' => $this->category->id,
            'user_id' => $this->adminUser->id,
        ]);
        $pagecontent = factory(PageContent::class)->create(['page_id' => $page->id]);

        /* Unauthenticated user can view page */
        $response = $this->get('/api/pages/' . $page->id);
        $response->assertStatus(200)
            ->assertJsonFragment(['title' => $page->title])
            ->assertJsonStructureExact([
                'id', 'category_id', 'user_id', 'title', 'summary', 'metakey', 'metadesc', 'media_id', 'status',
                'created_at', 'updated_at', 'deleted_at', 
                'url', 'created_ago', 'updated_ago',
                'content' => [
                    'id', 'page_id', 'body_json', 'body_html', 
                    'created_at', 'updated_at'
                ],
                'category' => [
                    'id', 'name', 'parent_id', 'description', 'metakey', 'metadesc', 'media_id', 'user_id', 
                    'created_at', 'updated_at', 'deleted_at', 
                    'url', 'created_ago', 'updated_ago'
                ],
                'author' => [
                    'id', 'name', 'email', 'email_verified_at', 'role', 'avatar', 'about_me', 'gender', 'dob', 'preferences', 
                    'created_at', 'updated_at', 'deleted_at'
                ], 
                'media' 
            ]);
        $this->assertDatabaseHas('pages', ['title' => $page->title]);

        /* Authenticated user can view page */
        // Passport::actingAs($this->adminUser);
        // $response = $this->get('/api/pages/' . $page->id);

        $response = $this->actingAs($this->adminUser)->get('/api/pages/' . $page->id);
        $response->assertStatus(200)
            ->assertJsonFragment(['title' => $page->title])
            ->assertJsonStructureExact([
                'id', 'category_id', 'user_id', 'title', 'summary', 'metakey', 'metadesc', 'media_id', 'status',
                'created_at', 'updated_at', 'deleted_at', 
                'url', 'created_ago', 'updated_ago',
                'content' => [
                    'id', 'page_id', 'body_json', 'body_html', 
                    'created_at', 'updated_at'
                ],
                'category' => [
                    'id', 'name', 'parent_id', 'description', 'metakey', 'metadesc', 'media_id', 'user_id', 
                    'created_at', 'updated_at', 'deleted_at', 
                    'url', 'created_ago', 'updated_ago'
                ],
                'author' => [
                    'id', 'name', 'email', 'email_verified_at', 'role', 'avatar', 'about_me', 'gender', 'dob', 'preferences', 
                    'created_at', 'updated_at', 'deleted_at'
                ], 
                'media' 
            ]);
        $this->assertDatabaseHas('pages', ['title' => $page->title]);

        /* Page with media */
        $page = factory(Page::class)->create([
            'category_id' => $this->category->id,
            'user_id' => $this->adminUser->id,
            'media_id' => $this->media->id
        ]);
        $pagecontent = factory(PageContent::class)->create(['page_id' => $page->id]);
        
        /* Authenticated user can view page */
        // Passport::actingAs($this->adminUser);
        // $response = $this->get('/api/pages/' . $page->id);

        $response = $this->actingAs($this->adminUser)->get('/api/pages/' . $page->id);
        $response->assertStatus(200)
            ->assertJsonFragment(['title' => $page->title])
            ->assertJsonStructureExact([
                'id', 'category_id', 'user_id', 'title', 'summary', 'metakey', 'metadesc', 'media_id', 'status',
                'created_at', 'updated_at', 'deleted_at', 
                'url', 'created_ago', 'updated_ago',
                'content' => [
                    'id', 'page_id', 'body_json', 'body_html', 
                    'created_at', 'updated_at'
                ],
                'category' => [
                    'id', 'name', 'parent_id', 'description', 'metakey', 'metadesc', 'media_id', 'user_id', 
                    'created_at', 'updated_at', 'deleted_at', 
                    'url', 'created_ago', 'updated_ago'
                ],
                'author' => [
                    'id', 'name', 'email', 'email_verified_at', 'role', 'avatar', 'about_me', 'gender', 'dob', 'preferences', 
                    'created_at', 'updated_at', 'deleted_at'
                ], 
                'media' => [
                    'id', 'name', 'type', 'size', 'path', 'url', 'storage', 'user_id', 
                    'created_at', 'updated_at', 
                    'created_ago', 'updated_ago' 
                ]
            ]);
        $this->assertDatabaseHas('pages', ['title' => $page->title]);
    }

    /* Page Store */
    public function test_page_store()
    {
        $page = [
            'category_id' => $this->category->id,
            'title' => 'Test Title',
            'summary' => 'Test Summary',
            'metakey' => 'Test, Meta, Key',
            'metadesc' => 'Test Meta Description',
            'body_json' => '{"blocks":[{"type":"header","data":{"level":1,"text":"Test Heading."}},{"type":"paragraph","data":{"text":"Test Paragraph"}}]}'
        ];

        /* Unauthenticated user cannot save page */
        // $response = $this->post('/api/pages', $page, ['Accept' => 'application/json']);
        // $response->assertStatus(401)
        //     ->assertJson(['message' => 'Unauthenticated.']);

        /* Authenticated user can save page */
        // Passport::actingAs($this->adminUser);
        // $response = $this->post('/api/pages', $page);

        $response = $this->actingAs($this->adminUser)->post('/api/pages', $page, ['Accept' => 'application/json']);
        $response->assertStatus(200)
            ->assertJsonFragment(['title' => $page['title']])
            ->assertJsonStructureExact([
                'category_id', 'user_id', 'title', 'summary', 'metakey', 'metadesc', 'media_id', 'status',
                'updated_at', 'created_at', 
                'id', 'url', 'created_ago', 'updated_ago',
                'content' => [
                    'id', 'page_id', 'body_json', 'body_html', 
                    'created_at', 'updated_at'
                ]
            ]);
        $this->assertDatabaseHas('pages', ['title' => $page['title']]);
    }

    /* Page Update */
    public function test_page_update()
    {
        $page = factory(Page::class)->create([
            'category_id' => $this->category->id,
            'user_id' => $this->adminUser->id,
            'title' => 'Test Title',
            'summary' => 'Test Summary',
            'metakey' => 'Test, Meta, Key',
            'metadesc' => 'Test Meta Description',
        ]);
        $pagecontent = factory(PageContent::class)->create([
            'page_id' => $page->id, 
            'body_json' => '{"blocks":[{"type":"header","data":{"level":1,"text":"Test Heading."}},{"type":"paragraph","data":{"text":"Test Paragraph"}}]}'
        ]);
        
        $page->title = 'Test Title Updated';
        $page->body_json = '{"blocks":[{"type":"header","data":{"level":1,"text":"Test Heading Updated."}},{"type":"paragraph","data":{"text":"Test Paragraph Updated"}}]}';

        /* Unauthenticated user cannot update page */
        // $response = $this->put('/api/pages/' . $page->id, $page->toArray(), ['Accept' => 'application/json']);
        // $response->assertStatus(401)
        //     ->assertJson(['message' => 'Unauthenticated.']);

        /* Authenticated user can update page */
        // Passport::actingAs($this->adminUser);
        // $response = $this->put('/api/pages/' . $page->id, $page->toArray());

        $response = $this->actingAs($this->adminUser)->put('/api/pages/' . $page->id, $page->toArray());
        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'Test Title Updated'])
            ->assertJsonStructureExact([
                'id', 'category_id', 'user_id', 'title', 'summary', 'metakey', 'metadesc', 'media_id', 'status',
                'created_at', 'updated_at', 'deleted_at', 
                'url', 'created_ago', 'updated_ago',
                'content' => [
                    'id', 'page_id', 'body_json', 'body_html',
                    'created_at', 'updated_at'
                ]
            ]);
        $this->assertDatabaseHas('pages', ['title' => 'Test Title Updated']);
        $this->assertDatabaseMissing('pages', ['title' => 'Test Title']);
    }

    /* Page Destroy */
    public function test_page_destroy()
    {
        $page = factory(Page::class)->create([
            'category_id' => $this->category->id,
            'user_id' => $this->adminUser->id,
            'title' => 'Test Title',
            'summary' => 'Test Summary',
            'metakey' => 'Test, Meta, Key',
            'metadesc' => 'Test Meta Description',
        ]);

        /* Unauthenticated user cannot delete page */
        // $response = $this->delete('/api/pages/' . $page->id, [], ['Accept' => 'application/json']);
        // $response->assertStatus(401)
        //     ->assertJson(['message' => 'Unauthenticated.']);

        /* Authenticated user can delete page */
        // Passport::actingAs($this->adminUser);
        // $response = $this->delete('/api/pages/' . $page->id);

        $response = $this->actingAs($this->adminUser)->delete('/api/pages/' . $page->id);
        $response->assertStatus(204);
        $this->assertSoftDeleted('pages', ['title' => $page->title]);
    }

    /* Page Comments */
    public function test_page_comments()
    {
        $page = factory(Page::class)->create([
            'category_id' => $this->category->id,
            'user_id' => $this->adminUser->id,
        ]);

        $pagecomment = factory(PageComment::class)->create([
            'reference_id' => $page->id,
            'user_id' => $this->adminUser->id,
        ]);

        /* Unauthenticated user can view page comments */
        $response = $this->get('/api/pages/' . $page->id . '/comments');
        $response->assertStatus(200)
            ->assertJsonFragment(['body' => $pagecomment->body])
            ->assertJsonStructureExact([
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
                        ], 
                        "subcomments"
                    ]
                ]
            ]);
        $this->assertDatabaseHas('page_comments', ['reference_id' => $page->id]);

        /* Authenticated user can view page comments */
        // Passport::actingAs($this->adminUser);
        // $response = $this->get('/api/pages/' . $page->id . '/comments');
        
        $response = $this->actingAs($this->adminUser)->get('/api/pages/' . $page->id . '/comments');
        $response->assertStatus(200)
            ->assertJsonFragment(['body' => $pagecomment->body])
            ->assertJsonStructureExact([
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
                        ], 
                        "subcomments"
                    ]
                ]
            ]);
        $this->assertDatabaseHas('page_comments', ['reference_id' => $page->id]);
    }
}
