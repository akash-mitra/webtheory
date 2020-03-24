<?php

namespace Tests\Feature;

use Tests\TestDataSetup;
use App\Category;
use App\Page;
use App\CategoryComment;

class CategoryTest extends TestDataSetup
{
    private $category_attributes = [
        'id', 'name', 'parent_id', 'description', 'metakey', 'metadesc', 'media_id', 'user_id', 
        'created_at', 'updated_at', 'deleted_at', 
        'url', 'permalink', 'created_ago', 'updated_ago', 'media', 
        'author' => [
            'id', 'name', 'email', 'email_verified_at', 'role', 'avatar', 'about_me', 'gender', 'dob', 'preferences', 
            'created_at', 'updated_at', 'deleted_at'
        ]
    ];

    private $categorypage_attributes = [
        'id', 'name', 'parent_id', 'description', 'metakey', 'metadesc', 'media_id', 'user_id', 
        'created_at', 'updated_at', 'deleted_at', 
        'url', 'permalink', 'created_ago', 'updated_ago', 
        'pages' => [
            '*' => [
                'id', 'category_id', 'user_id', 'title', 'summary', 'metakey', 'metadesc', 'media_id', 'status',
                'created_at', 'updated_at', 'deleted_at', 
                'url', 'permalink', 'created_ago', 'updated_ago', 
                'author' => [
                    'id', 'name', 'email', 'email_verified_at', 'role', 'avatar', 'about_me', 'gender', 'dob', 'preferences', 
                    'created_at', 'updated_at', 'deleted_at'
                ]
            ]
        ]
    ];

    private $categorycomment_attributes = [
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
                ], 
                "subcomments"
            ]
        ]
    ];
    
    /* Category Index */
    public function test_category_index()
    {
        $category = factory(Category::class)->create([
            'user_id' => $this->adminUser->id,
        ]);

        /* Unauthenticated user can view categories listing */
        $response = $this->get('/api/categories');
        $response->assertStatus(200)
            ->assertJsonStructureExact([
                '*' => $this->category_attributes
            ]);
        $this->assertDatabaseHas('categories', ['name' => $category->name]);

        /* Authenticated user can view categories listing */
        $response = $this->actingAs($this->adminUser)->get('/api/categories');
        $response->assertStatus(200)
            ->assertJsonStructureExact([
                '*' => $this->category_attributes
            ]);
        $this->assertDatabaseHas('categories', ['name' => $category->name]);
    }

    /* Category Show */
    public function test_category_show()
    {
        $category = factory(Category::class)->create([
            'user_id' => $this->adminUser->id,
        ]);

        /* Unauthenticated user can view category */
        $response = $this->get('/api/categories/' . $category->id);
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $category->name])
            ->assertJsonStructureExact($this->category_attributes);
        $this->assertDatabaseHas('categories', ['name' => $category->name]);

        /* Authenticated user can view category */
        $response = $this->actingAs($this->adminUser)->get('/api/categories/' . $category->id);
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $category->name])
            ->assertJsonStructureExact($this->category_attributes);
        $this->assertDatabaseHas('categories', ['name' => $category->name]);

        /* Category with Media */
        $category = factory(Category::class)->create([
            'media_id' => $this->media->id,
            'user_id' => $this->adminUser->id,
        ]);
        
        /* Authenticated user can view category */
        $response = $this->actingAs($this->adminUser)->get('/api/categories/' . $category->id);
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $category->name])
            ->assertJsonStructureExact($this->category_attributes);
        $this->assertDatabaseHas('categories', ['name' => $category->name]);
    }

    /* Category Store */
    public function test_category_store()
    {
        $category = factory(Category::class)->make();

        /* Unauthenticated user cannot save category */
        $response = $this->post('/api/categories', $category->toArray(), ['Accept' => 'application/json']);
        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

        /* Registered user cannot save category */
        $response = $this->actingAs($this->registeredUser)->post('/api/categories', $category->toArray(), ['Accept' => 'application/json']);
        $response->assertStatus(403)
            ->assertJson(['message' => 'Restricted Access']);

        /* Authenticated user can save category */
        $response = $this->actingAs($this->adminUser)->post('/api/categories', $category->toArray());
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $category->name])
            ->assertJsonStructureExact([
                'name', 'parent_id', 'description', 'metakey', 'metadesc', 'media_id', 'user_id', 
                'updated_at', 'created_at',  
                'id', 'url', 'permalink', 'created_ago', 'updated_ago' 
            ]);
        $this->assertDatabaseHas('categories', ['name' => $category->name]);
    }

    /* Category Update */
    public function test_category_update()
    {
        $category = factory(Category::class)->create([
            'name' => 'Test Category',
            'user_id' => $this->adminUser->id,
        ]);
        $category->name = 'Test Category Updated';

        /* Unauthenticated user cannot update category */
        $response = $this->put('/api/categories/' . $category->id, $category->toArray(), ['Accept' => 'application/json']);
        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

        /* Registered user cannot update category */
        $response = $this->actingAs($this->registeredUser)->put('/api/categories/' . $category->id, $category->toArray(), ['Accept' => 'application/json']);
        $response->assertStatus(403)
            ->assertJson(['message' => 'Restricted Access']);

        /* Authenticated user can update category */
        $response = $this->actingAs($this->adminUser)->put('/api/categories/' . $category->id, $category->toArray());
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Test Category Updated'])
            ->assertJsonStructureExact([
                'id', 'name', 'parent_id', 'description', 'metakey', 'metadesc', 'media_id', 'user_id', 
                'created_at', 'updated_at', 'deleted_at', 
                'url', 'permalink', 'created_ago', 'updated_ago' 
            ]);
        $this->assertDatabaseHas('categories', ['name' => 'Test Category Updated']);
        $this->assertDatabaseMissing('categories', ['name' => 'Test Category']);
    }

    /* Category Destroy */
    public function test_category_destroy()
    {
        $category = factory(Category::class)->create([
            'user_id' => $this->adminUser->id
        ]);

        /* Unauthenticated user cannot delete category */
        $response = $this->delete('/api/categories/' . $category->id, [], ['Accept' => 'application/json']);
        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

        /* Registered user cannot delete category */
        $response = $this->actingAs($this->registeredUser)->delete('/api/categories/' . $category->id, [], ['Accept' => 'application/json']);
        $response->assertStatus(403)
            ->assertJson(['message' => 'Restricted Access']);

        /* Authenticated user can delete category */
        $response = $this->actingAs($this->adminUser)->delete('/api/categories/' . $category->id);
        $response->assertStatus(204);
        $this->assertSoftDeleted('categories', ['name' => $category->name]);
    }

    /* Category Pages */
    public function test_category_pages()
    {
        $category = factory(Category::class)->create([
            'user_id' => $this->adminUser->id,
        ]);

        $categorypage = factory(Page::class)->create([
            'category_id' => $category->id,
            'user_id' => $this->adminUser->id,
        ]);

        /* Unauthenticated user can view category pages */
        $response = $this->get('/api/categories/' . $category->id . '/pages');
        $response->assertStatus(200)
            ->assertJsonStructureExact($this->categorypage_attributes);
        $this->assertDatabaseHas('categories', ['id' => $category->id]);
        $this->assertDatabaseHas('pages', ['id' => $categorypage->id]);


        /* Authenticated user can view category pages */
        $response = $this->actingAs($this->adminUser)->get('/api/categories/' . $category->id . '/pages');
        $response->assertStatus(200)
            ->assertJsonStructureExact($this->categorypage_attributes);
        $this->assertDatabaseHas('categories', ['id' => $category->id]);
        $this->assertDatabaseHas('pages', ['id' => $categorypage->id]);
    }

    /* Category Comments */
    public function test_category_comments()
    {
        $category = factory(Category::class)->create([
            'user_id' => $this->adminUser->id,
        ]);

        $categorycomment = factory(CategoryComment::class)->create([
            'reference_id' => $category->id,
            'user_id' => $this->adminUser->id,
        ]);

        /* Unauthenticated user can view category comments */
        $response = $this->get('/api/categories/' . $category->id . '/comments');
        $response->assertStatus(200)
            ->assertJsonFragment(['body' => $categorycomment->body])
            ->assertJsonStructureExact($this->categorycomment_attributes);
        $this->assertDatabaseHas('category_comments', ['reference_id' => $category->id]);

        /* Authenticated user can view category comments */
        $response = $this->actingAs($this->adminUser)->get('/api/categories/' . $category->id . '/comments');
        $response->assertStatus(200)
            ->assertJsonFragment(['body' => $categorycomment->body])
            ->assertJsonStructureExact($this->categorycomment_attributes);
        $this->assertDatabaseHas('category_comments', ['reference_id' => $category->id]);
    }
}
