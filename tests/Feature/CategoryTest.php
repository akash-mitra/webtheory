<?php

namespace Tests\Feature;

use Tests\TestDataSetup;
use Laravel\Passport\Passport;
use App\Category;
use App\CategoryComment;

class CategoryTest extends TestDataSetup
{
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
                '*' => [
                    'id', 'name', 'parent_id', 'description', 'metakey', 'metadesc', 'media_id', 'user_id', 
                    'created_at', 'updated_at', 'deleted_at', 
                    'url', 'created_ago', 'updated_ago', 'media', 
                    'author' => [
                        'id', 'name', 'email', 'email_verified_at', 'role', 'avatar', 'about_me', 'gender', 'dob', 'preferences', 
                        'created_at', 'updated_at', 'deleted_at'
                    ],
                ]
            ]);
        $this->assertDatabaseHas('categories', ['name' => $category->name]);

        /* Authenticated user can view categories listing */
        // Passport::actingAs($this->adminUser);
        // $response = $this->get('/api/categories');
        
        $response = $this->actingAs($this->adminUser)->get('/api/categories');
        $response->assertStatus(200)
            ->assertJsonStructureExact([
                '*' => [
                    'id', 'name', 'parent_id', 'description', 'metakey', 'metadesc', 'media_id', 'user_id', 
                    'created_at', 'updated_at', 'deleted_at', 
                    'url', 'created_ago', 'updated_ago', 'media', 
                    'author' => [
                        'id', 'name', 'email', 'email_verified_at', 'role', 'avatar', 'about_me', 'gender', 'dob', 'preferences', 
                        'created_at', 'updated_at', 'deleted_at'
                    ],
                ]
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
            ->assertJsonStructureExact([
                'id', 'name', 'parent_id', 'description', 'metakey', 'metadesc', 'media_id', 'user_id', 
                'created_at', 'updated_at', 'deleted_at', 
                'url', 'created_ago', 'updated_ago', 'media', 
                'author' => [
                    'id', 'name', 'email', 'email_verified_at', 'role', 'avatar', 'about_me', 'gender', 'dob', 'preferences', 
                    'created_at', 'updated_at', 'deleted_at'
                ],
            ]);
        $this->assertDatabaseHas('categories', ['name' => $category->name]);

        /* Authenticated user can view category */
        // Passport::actingAs($this->adminUser);
        // $response = $this->get('/api/categories/' . $category->id);
        
        $response = $this->actingAs($this->adminUser)->get('/api/categories/' . $category->id);
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $category->name])
            ->assertJsonStructureExact([
                'id', 'name', 'parent_id', 'description', 'metakey', 'metadesc', 'media_id', 'user_id', 
                'created_at', 'updated_at', 'deleted_at', 
                'url', 'created_ago', 'updated_ago', 'media', 
                'author' => [
                    'id', 'name', 'email', 'email_verified_at', 'role', 'avatar', 'about_me', 'gender', 'dob', 'preferences', 
                    'created_at', 'updated_at', 'deleted_at'
                ],
            ]);
        $this->assertDatabaseHas('categories', ['name' => $category->name]);

        /* Category with Media */
        $category = factory(Category::class)->create([
            'media_id' => $this->media->id,
            'user_id' => $this->adminUser->id,
        ]);
        
        /* Authenticated user can view category */
        // Passport::actingAs($this->adminUser);
        // $response = $this->get('/api/categories/' . $category->id);
        
        $response = $this->actingAs($this->adminUser)->get('/api/categories/' . $category->id);
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $category->name])
            ->assertJsonStructureExact([
                'id', 'name', 'parent_id', 'description', 'metakey', 'metadesc', 'media_id', 'user_id', 
                'created_at', 'updated_at', 'deleted_at', 
                'url', 'created_ago', 'updated_ago', 
                'media' => [
                    'id', 'name', 'type', 'size', 'path', 'url', 'storage', 'user_id', 
                    'created_at', 'updated_at', 
                    'created_ago', 'updated_ago' 
                ], 
                'author' => [
                    'id', 'name', 'email', 'email_verified_at', 'role', 'avatar', 'about_me', 'gender', 'dob', 'preferences', 
                    'created_at', 'updated_at', 'deleted_at'
                ]
            ]);
        $this->assertDatabaseHas('categories', ['name' => $category->name]);
    }

    /* Category Store */
    public function test_category_store()
    {
        $category = factory(Category::class)->make();

        /* Unauthenticated user cannot save category */
        // $response = $this->post('/api/categories', $category->toArray(), ['Accept' => 'application/json']);
        // $response->assertStatus(401)
        //     ->assertJson(['message' => 'Unauthenticated.']);

        /* Authenticated user can save category */
        // Passport::actingAs($this->adminUser);
        // $response = $this->post('/api/categories', $category->toArray());

        $response = $this->actingAs($this->adminUser)->post('/api/categories', $category->toArray());
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $category->name])
            ->assertJsonStructureExact([
                'name', 'parent_id', 'description', 'metakey', 'metadesc', 'media_id', 'user_id', 
                'updated_at', 'created_at',  
                'id', 'url', 'created_ago', 'updated_ago' 
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
        // $response = $this->put('/api/categories/' . $category->id, $category->toArray(), ['Accept' => 'application/json']);
        // $response->assertStatus(401)
        //     ->assertJson(['message' => 'Unauthenticated.']);

        /* Authenticated user can update category */
        // Passport::actingAs($this->adminUser);
        // $response = $this->put('/api/categories/' . $category->id, $category->toArray());

        $response = $this->actingAs($this->adminUser)->put('/api/categories/' . $category->id, $category->toArray());
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Test Category Updated'])
            ->assertJsonStructureExact([
                'id', 'name', 'parent_id', 'description', 'metakey', 'metadesc', 'media_id', 'user_id', 
                'created_at', 'updated_at', 'deleted_at', 
                'url', 'created_ago', 'updated_ago' 
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
        // $response = $this->delete('/api/categories/' . $category->id, [], ['Accept' => 'application/json']);
        // $response->assertStatus(401)
        //     ->assertJson(['message' => 'Unauthenticated.']);

        /* Authenticated user can delete category */
        // Passport::actingAs($this->adminUser);
        // $response = $this->delete('/api/categories/' . $category->id);

        $response = $this->actingAs($this->adminUser)->delete('/api/categories/' . $category->id);
        $response->assertStatus(204);
        $this->assertSoftDeleted('categories', ['name' => $category->name]);
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
            ->assertJsonStructureExact([
                'id', 'name', 'parent_id', 'description', 'metakey', 'metadesc', 'media_id', 'user_id', 
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
        $this->assertDatabaseHas('category_comments', ['reference_id' => $category->id]);

        /* Authenticated user can view category comments */
        // Passport::actingAs($this->adminUser);
        // $response = $this->get('/api/categories/' . $category->id . '/comments');
        
        $response = $this->actingAs($this->adminUser)->get('/api/categories/' . $category->id . '/comments');
        $response->assertStatus(200)
            ->assertJsonFragment(['body' => $categorycomment->body])
            ->assertJsonStructureExact([
                'id', 'name', 'parent_id', 'description', 'metakey', 'metadesc', 'media_id', 'user_id', 
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
        $this->assertDatabaseHas('category_comments', ['reference_id' => $category->id]);
    }
}
