<?php

namespace Tests\Feature;

use Tests\TestDataSetup;
use Laravel\Passport\Passport;
use App\Page;
use App\PageContent;

class PageTest extends TestDataSetup
{
    // Page Index
    public function test_page_index()
    {
        $page = factory(Page::class)->create([
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
        ]);

        // Unauthenticated user can view pages listing
        $response = $this->get('/api/pages');
        $response->assertStatus(200)
            ->assertJsonStructureExact([
                '*' => [
                    'id', 'category_id', 'user_id', 'title', 'summary', 'metakey', 'metadesc', 'status',
                    'created_at', 'updated_at', 'deleted_at', 
                    'url', 'created_ago', 'updated_ago',
                    'category' => [
                        'id', 'name', 'parent_id', 'description', 
                        'created_at', 'updated_at', 'deleted_at', 
                        'url', 'created_ago', 'updated_ago'
                    ],
                    'author' => [
                        'id', 'name', 'email', 'email_verified_at', 'role', 'avatar', 'about_me', 'gender', 'dob', 'preferences', 
                        'created_at', 'updated_at', 'deleted_at'
                    ]
                ]
            ]);
        $this->assertDatabaseHas('pages', ['title' => $page['title']]);

        // Authenticated user can view pages listing
        // Passport::actingAs($this->user);
        $response = $this->get('/api/pages');
        $response->assertStatus(200)
            ->assertJsonStructureExact([
                '*' => [
                    'id', 'category_id', 'user_id', 'title', 'summary', 'metakey', 'metadesc', 'status',
                    'created_at', 'updated_at', 'deleted_at', 
                    'url', 'created_ago', 'updated_ago',
                    'category' => [
                        'id', 'name', 'parent_id', 'description', 
                        'created_at', 'updated_at', 'deleted_at', 
                        'url', 'created_ago', 'updated_ago'
                    ],
                    'author' => [
                        'id', 'name', 'email', 'email_verified_at', 'role', 'avatar', 'about_me', 'gender', 'dob', 'preferences', 
                        'created_at', 'updated_at', 'deleted_at'
                    ]
                ]
            ]);
        $this->assertDatabaseHas('pages', ['title' => $page['title']]);
    }

    // Page Show
    public function test_page_show()
    {
        $page = factory(Page::class)->create([
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
        ]);
        $pagecontent = factory(PageContent::class)->create(['page_id' => $page->id]);

        // Unauthenticated user can view page
        $response = $this->get('/api/pages/' . $page->id);
        $response->assertStatus(200)
            ->assertJsonFragment(['title' => $page->title])
            ->assertJsonStructureExact([
                'id', 'category_id', 'user_id', 'title', 'summary', 'metakey', 'metadesc', 'status',
                'created_at', 'updated_at', 'deleted_at', 
                'url', 'created_ago', 'updated_ago',
                'content' => [
                    'id', 'page_id', 'body_json', 'body_html', 
                    'created_at', 'updated_at'
                ],
                'category' => [
                    'id', 'name', 'parent_id', 'description', 
                    'created_at', 'updated_at', 'deleted_at', 
                    'url', 'created_ago', 'updated_ago'
                ],
                'author' => [
                    'id', 'name', 'email', 'email_verified_at', 'role', 'avatar', 'about_me', 'gender', 'dob', 'preferences', 
                    'created_at', 'updated_at', 'deleted_at'
                ]
            ]);
        $this->assertDatabaseHas('pages', ['title' => $page->title]);

        // Authenticated user can view page
        // Passport::actingAs($this->user);
        $response = $this->get('/api/pages/' . $page->id);
        $response->assertStatus(200)
            ->assertJsonFragment(['title' => $page->title])
            ->assertJsonStructureExact([
                'id', 'category_id', 'user_id', 'title', 'summary', 'metakey', 'metadesc', 'status',
                'created_at', 'updated_at', 'deleted_at', 
                'url', 'created_ago', 'updated_ago',
                'content' => [
                    'id', 'page_id', 'body_json', 'body_html', 
                    'created_at', 'updated_at'
                ],
                'category' => [
                    'id', 'name', 'parent_id', 'description', 
                    'created_at', 'updated_at', 'deleted_at', 
                    'url', 'created_ago', 'updated_ago'
                ],
                'author' => [
                    'id', 'name', 'email', 'email_verified_at', 'role', 'avatar', 'about_me', 'gender', 'dob', 'preferences', 
                    'created_at', 'updated_at', 'deleted_at'
                ]
            ]);
        $this->assertDatabaseHas('pages', ['title' => $page->title]);
    }

    // Page Store
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

        // Unauthenticated user cannot save page
        // $response = $this->post('/api/pages', $page, ['Accept' => 'application/json']);
        // $response->assertStatus(401)
        //     ->assertJson(['message' => 'Unauthenticated.']);

        // Authenticated user can save page
        // Passport::actingAs($this->user);
        // $response = $this->post('/api/pages', $page);
        $response = $this->actingAs($this->user)->post('/api/pages', $page, ['Accept' => 'application/json']);
        $response->assertStatus(200)
            ->assertJsonFragment(['title' => $page['title']])
            ->assertJsonStructureExact([
                'category_id', 'user_id', 'title', 'summary', 'metakey', 'metadesc', 'status',
                'updated_at', 'created_at', 
                'id', 'url', 'created_ago', 'updated_ago',
                'content' => [
                    'id', 'page_id', 'body_json', 'body_html', 
                    'created_at', 'updated_at'
                ],
                'category' => [
                    'id', 'name', 'parent_id', 'description', 
                    'created_at', 'updated_at', 'deleted_at', 
                    'url', 'created_ago', 'updated_ago'
                ],
                'author' => [
                    'id', 'name', 'email', 'email_verified_at', 'role', 'avatar', 'about_me', 'gender', 'dob', 'preferences', 
                    'created_at', 'updated_at', 'deleted_at'
                ]
            ]);
        $this->assertDatabaseHas('pages', ['title' => $page['title']]);
    }

    // Page Update
    public function test_page_update()
    {
        $page = factory(Page::class)->create([
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
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

        // Unauthenticated user cannot update page
        // $response = $this->put('/api/pages/' . $page->id, $page->toArray(), ['Accept' => 'application/json']);
        // $response->assertStatus(401)
        //     ->assertJson(['message' => 'Unauthenticated.']);

        // Authenticated user can update page
        // Passport::actingAs($this->user);
        $response = $this->put('/api/pages/' . $page->id, $page->toArray());
        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'Test Title Updated'])
            ->assertJsonStructureExact([
                'id', 'category_id', 'user_id', 'title', 'summary', 'metakey', 'metadesc', 'status',
                'created_at', 'updated_at', 'deleted_at', 
                'url', 'created_ago', 'updated_ago',
                'content' => [
                    'id', 'page_id', 'body_json', 'body_html',
                    'created_at', 'updated_at'
                ],
                'category' => [
                    'id', 'name', 'parent_id', 'description', 
                    'created_at', 'updated_at', 'deleted_at', 
                    'url', 'created_ago', 'updated_ago'
                ],
                'author' => [
                    'id', 'name', 'email', 'email_verified_at', 'role', 'avatar', 'about_me', 'gender', 'dob', 'preferences', 
                    'created_at', 'updated_at', 'deleted_at'
                ]
            ]);
        $this->assertDatabaseHas('pages', ['title' => 'Test Title Updated']);
        $this->assertDatabaseMissing('pages', ['title' => 'Test Title']);
    }

    // Page Destroy
    public function test_page_destroy()
    {
        $page = factory(Page::class)->create([
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
            'title' => 'Test Title',
            'summary' => 'Test Summary',
            'metakey' => 'Test, Meta, Key',
            'metadesc' => 'Test Meta Description',
        ]);

        // Unauthenticated user cannot delete page
        // $response = $this->delete('/api/pages/' . $page->id, [], ['Accept' => 'application/json']);
        // $response->assertStatus(401)
        //     ->assertJson(['message' => 'Unauthenticated.']);

        // Authenticated user can delete page
        // Passport::actingAs($this->user);
        $response = $this->delete('/api/pages/' . $page->id);
        $response->assertStatus(204);
        $this->assertSoftDeleted('pages', ['title' => $page->title]);
    }
}
