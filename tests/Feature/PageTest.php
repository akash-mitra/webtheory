<?php

namespace Tests\Feature;

use Tests\TestDataSetup;
use App\Page;
use App\PageContent;
use App\PageComment;

class PageTest extends TestDataSetup
{
    private $page_attributes = [
        'id', 'category_id', 'user_id', 'title', 'summary', 'metakey', 'metadesc', 'media_id', 'status',
        'created_at', 'updated_at', 'deleted_at',
        'url', 'permalink', 'created_ago', 'updated_ago',
        'category' => [
            'id', 'name', 'parent_id', 'description', 'metakey', 'metadesc', 'media_id', 'user_id',
            'created_at', 'updated_at', 'deleted_at',
            'url', 'permalink', 'created_ago', 'updated_ago'
        ],
        'author' => [
            'id', 'name', 'email', 'email_verified_at', 'role', 'avatar', 'about_me', 'gender', 'dob', 'preferences',
            'created_at', 'updated_at', 'deleted_at', 'public_id', 'created_ago', 'updated_ago', 'url', 
        ],
        'media'
    ];

    private $pagecontent_attributes = [
        'id', 'category_id', 'user_id', 'title', 'summary', 'metakey', 'metadesc', 'media_id', 'status',
        'created_at', 'updated_at', 'deleted_at',
        'url', 'permalink', 'created_ago', 'updated_ago',
        'content' => [
            'id', 'page_id', 'body_json', 'body_html',
            'created_at', 'updated_at', 'editor'
        ],
        'category' => [
            'id', 'name', 'parent_id', 'description', 'metakey', 'metadesc', 'media_id', 'user_id',
            'created_at', 'updated_at', 'deleted_at',
            'url', 'permalink', 'created_ago', 'updated_ago'
        ],
        'author' => [
            'id', 'name', 'email', 'email_verified_at', 'role', 'avatar', 'about_me', 'gender', 'dob', 'preferences',
            'created_at', 'updated_at', 'deleted_at', 'public_id', 'created_ago', 'updated_ago', 'url',
        ],
        'media'
    ];

    private $pagemedia_attributes = [
        'id', 'category_id', 'user_id', 'title', 'summary', 'metakey', 'metadesc', 'media_id', 'status',
        'created_at', 'updated_at', 'deleted_at',
        'url', 'permalink', 'created_ago', 'updated_ago',
        'content' => [
            'id', 'page_id', 'body_json', 'body_html',
            'created_at', 'updated_at', 'editor'
        ],
        'category' => [
            'id', 'name', 'parent_id', 'description', 'metakey', 'metadesc', 'media_id', 'user_id',
            'created_at', 'updated_at', 'deleted_at',
            'url', 'permalink', 'created_ago', 'updated_ago'
        ],
        'author' => [
            'id', 'name', 'email', 'email_verified_at', 'role', 'avatar', 'about_me', 'gender', 'dob', 'preferences',
            'created_at', 'updated_at', 'deleted_at', 'public_id', 'created_ago', 'updated_ago', 'url', 
        ],
        'media' => [
            'id', 'name', 'type', 'size', 'path', 'url', 'storage', 'user_id',
            'created_at', 'updated_at',
            'created_ago', 'updated_ago'
        ]
    ];

    private $pageupdate_attributes = [
        'id', 'category_id', 'user_id', 'title', 'summary', 'metakey', 'metadesc', 'media_id', 'status',
        'created_at', 'updated_at', 'deleted_at',
        'url', 'permalink', 'created_ago', 'updated_ago'
    ];

    private $pagecomment_attributes = [
        'id', 'category_id', 'user_id', 'title', 'summary', 'metakey', 'metadesc', 'media_id', 'status',
        'created_at', 'updated_at', 'deleted_at',
        'url', 'permalink', 'created_ago', 'updated_ago',
        'comments' => [
            '*' => [
                'id', 'parent_id', 'reference_id', 'user_id', 'body', 'likes', 'dislikes',
                'created_at', 'updated_at', 'deleted_at', 'created_ago', 'updated_ago',
                'user' => [
                    'id', 'name', 'email', 'email_verified_at', 'role', 'avatar', 'about_me', 'gender', 'dob', 'preferences',
                    'created_at', 'updated_at', 'deleted_at', 'created_ago', 'updated_ago'
                ],
                "replies"
            ]
        ]
    ];

    /* Page Index */
    public function test_page_index()
    {
        $page = factory(Page::class)->create([
            'category_id' => $this->category->id,
            'user_id' => $this->adminUser->id,
        ]);

        /* Unauthenticated user cannot view pages listing */
        $response = $this->get('/api/pages');
        $response->assertStatus(302);

        /* Authenticated user can view pages listing */
        $response = $this->actingAs($this->adminUser)->get('/api/pages');
        $response->assertStatus(200)
            ->assertJsonStructureExact([
                '*' => $this->page_attributes
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

        /* Unauthenticated user cannot view page */
        $response = $this->get('/api/pages/' . $page->id);
        $response->assertStatus(302);

        /* Authenticated user can view page */
        $response = $this->actingAs($this->adminUser)->get('/api/pages/' . $page->id);
        $response->assertStatus(200)
            ->assertJsonFragment(['title' => $page->title])
            ->assertJsonStructure($this->pagecontent_attributes);
        $this->assertDatabaseHas('pages', ['title' => $page->title]);

        /* Page with media */
        $page = factory(Page::class)->create([
            'category_id' => $this->category->id,
            'user_id' => $this->adminUser->id,
            'media_id' => $this->media->id
        ]);
        $pagecontent = factory(PageContent::class)->create(['page_id' => $page->id]);

        /* Authenticated user can view page */
        $response = $this->actingAs($this->adminUser)->get('/api/pages/' . $page->id);
        $response->assertStatus(200)
            ->assertJsonFragment(['title' => $page->title])
            ->assertJsonStructure($this->pagemedia_attributes);
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
            'body_json' => '{"blocks":[{"type":"header","data":{"level":1,"text":"Test Heading."}},{"type":"paragraph","data":{"text":"Test Paragraph"}}]}',
            'status' => 'Live',
            'editor' => 'editorjs',
        ];

        /* Unauthenticated user cannot save page */
        $response = $this->post('/api/pages', $page, ['Accept' => 'application/json']);
        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

        /* Authenticated user can save page */
        $response = $this->actingAs($this->adminUser)->post('/api/pages', $page, ['Accept' => 'application/json']);
        $response->assertStatus(200)
            ->assertJsonFragment(['title' => $page['title']])
            ->assertJsonStructure([
                'category_id', 'user_id', 'title', 'summary', 'metakey', 'metadesc', 'media_id', 'status',
                'updated_at', 'created_at',
                'id', 'url', 'permalink', 'created_ago', 'updated_ago',
                'content' => [
                    'id', 'page_id', 'body_json', 'body_html',
                    'created_at', 'updated_at', 'editor'
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
            'status' => 'Live',
        ]);

        factory(PageContent::class)->create([
            'page_id' => $page->id,
            'body_json' => '{"blocks":[{"type":"header","data":{"level":1,"text":"Test Heading."}},{"type":"paragraph","data":{"text":"Test Paragraph"}}]}',
            'editor' => 'editorjs',
        ]);

        $page->title = 'Test Title Updated';
        $page->body_json = '{"blocks":[{"type":"header","data":{"level":1,"text":"Test Heading Updated."}},{"type":"paragraph","data":{"text":"Test Paragraph Updated"}}]}';
        $updateRequestInfo = array_merge($page->toArray(), ['editor' => 'editorjs']);

        /* Unauthenticated user cannot update page */
        $response = $this->put('/api/pages/' . $page->id, $updateRequestInfo);
        $response->assertStatus(302);


        /* Authenticated user can update page */
        $response = $this->actingAs($this->adminUser)
                ->put('/api/pages/' . $page->id, $updateRequestInfo);

        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'Test Title Updated'])
            ->assertJsonStructure([
                'id', 'category_id', 'user_id', 'title', 'summary', 'metakey', 'metadesc', 'media_id', 'status',
                'created_at', 'updated_at', 'deleted_at',
                'url', 'permalink', 'created_ago', 'updated_ago',
                'content' => [
                    'id', 'page_id', 'body_json', 'body_html',
                    'created_at', 'updated_at', 'editor'
                ]
            ]);
        $this->assertDatabaseHas('pages', ['title' => 'Test Title Updated']);
        $this->assertDatabaseMissing('pages', ['title' => 'Test Title']);
    }

    /* Page Status Update */
    public function test_page_status_update()
    {
        $page = factory(Page::class)->create([
            'category_id' => $this->category->id,
            'user_id' => $this->authorUser1->id,
            'status' => 'Draft',
        ]);

        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'status' => 'Draft'
        ]);

        /* unauthenticated users cannot update page status */
        $response = $this->put('/api/pages/' . $page->id . '/status', [
            'status' => 'Live'
        ]);
        $response->assertStatus(302);


        /* Authenticated user can update page status */
        $response = $this->actingAs($this->adminUser)
            ->put('/api/pages/' . $page->id . '/status', [
                'status' => 'Live'
            ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['status' => 'Live'])
            ->assertJsonStructureExact($this->pageupdate_attributes);

        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'status' => 'Live'
        ]);
    }

    /* Page Owner Update */
    public function test_page_owner_update()
    {
        $page = factory(Page::class)->create([
            'category_id' => $this->category->id,
            'user_id' => $this->authorUser1->id
        ]);
        $pagecontent = factory(PageContent::class)->create([
            'page_id' => $page->id
        ]);

        $page->user_id = $this->authorUser2->id;

        /* Unauthenticated user cannot update page owner */
        $response = $this->put('/api/pages/' . $page->id . '/owner', $page->toArray(), ['Accept' => 'application/json']);
        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

        /* Authenticated user can update page owner */
        $response = $this->actingAs($this->adminUser)->put('/api/pages/' . $page->id . '/owner', $page->toArray());
        $response->assertStatus(200)
            ->assertJsonFragment(['user_id' => $this->authorUser2->id])
            ->assertJsonStructureExact($this->pageupdate_attributes);
        $this->assertDatabaseHas('pages', ['user_id' => $this->authorUser2->id]);
        $this->assertDatabaseMissing('pages', ['id' => $page->id, 'user_id' => $this->authorUser1->id]);
    }

    /* Page Destroy */
    public function test_page_destroy()
    {
        $page = factory(Page::class)->create([
            'category_id' => $this->category->id,
            'user_id' => $this->adminUser->id
        ]);

        /* Unauthenticated user cannot delete page */
        $response = $this->delete('/api/pages/' . $page->id, [], ['Accept' => 'application/json']);
        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

        /* Authenticated user can delete page */
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
                'current_page',
                'data' => [
                    '*' => [
                        'id', 'parent_id', 'reference_id', 'user_id', 'body', 'likes', 'dislikes',
                        'created_at', 'updated_at', 'deleted_at', 'created_ago', 'updated_ago',
                        'user' => [
                            'id', 'name', 'email', 'email_verified_at', 'role', 'avatar', 'about_me', 'gender', 'dob', 'preferences',
                            'created_at', 'updated_at', 'deleted_at', 'public_id', 'created_ago', 'updated_ago', 'url', 
                        ],
                        "replies"
                    ]
                ],
                'first_page_url', 'from', 'last_page', 'last_page_url', 'next_page_url', 'path', 'per_page', 'prev_page_url', 'to', 'total', 
            ]);
        $this->assertDatabaseHas('page_comments', ['reference_id' => $page->id]);

        /* Authenticated user can view page comments */
        $response = $this->actingAs($this->adminUser)->get('/api/pages/' . $page->id . '/comments');
        $response->assertStatus(200)
            ->assertJsonFragment(['body' => $pagecomment->body])
            ->assertJsonStructureExact([
                'current_page',
                'data' => [
                    '*' => [
                        'id', 'parent_id', 'reference_id', 'user_id', 'body', 'likes', 'dislikes',
                        'created_at', 'updated_at', 'deleted_at', 'created_ago', 'updated_ago',
                        'user' => [
                            'id', 'name', 'email', 'email_verified_at', 'role', 'avatar', 'about_me', 'gender', 'dob', 'preferences',
                            'created_at', 'updated_at', 'deleted_at', 'public_id', 'created_ago', 'updated_ago', 'url', 
                        ],
                        "replies"
                    ]
                ],
                'first_page_url', 'from', 'last_page', 'last_page_url', 'next_page_url', 'path', 'per_page', 'prev_page_url', 'to', 'total', 
            ]);
        $this->assertDatabaseHas('page_comments', ['reference_id' => $page->id]);
    }
}
