<?php

namespace Tests\Feature;

use Tests\TestDataSetup;
use Laravel\Passport\Passport;
use App\Category;

class CategoryTest extends TestDataSetup
{
    // Category Index
    public function test_category_index()
    {
        $category = factory(Category::class)->create();

        // Unauthenticated user can view categories listing
        $response = $this->get('/api/categories');
        $response->assertStatus(200)
            ->assertJsonStructureExact([
                '*' => [
                    'id', 'name', 'parent_id', 'description', 
                    'created_at', 'updated_at', 
                    'url', 'created_ago', 'updated_ago'
                ]
            ]);
        $this->assertDatabaseHas('categories', ['name' => $category->name]);

        // Authenticated user can view categories listing
        Passport::actingAs($this->user);
        $response = $this->get('/api/categories');
        $response->assertStatus(200)
            ->assertJsonStructureExact([
                '*' => [
                    'id', 'name', 'parent_id', 'description', 
                    'created_at', 'updated_at', 
                    'url', 'created_ago', 'updated_ago'
                ]
            ]);
        $this->assertDatabaseHas('categories', ['name' => $category->name]);
    }

    // Category Show
    public function test_category_show()
    {
        $category = factory(Category::class)->create();

        // Unauthenticated user can view category
        $response = $this->get('/api/categories/' . $category->id);
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $category->name])
            ->assertJsonStructureExact([
                'id', 'name', 'parent_id', 'description', 
                'created_at', 'updated_at', 
                'url', 'created_ago', 'updated_ago'
            ]);
        $this->assertDatabaseHas('categories', ['name' => $category->name]);

        // Authenticated user can view category
        Passport::actingAs($this->user);
        $response = $this->get('/api/categories/' . $category->id);
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $category->name])
            ->assertJsonStructureExact([
                'id', 'name', 'parent_id', 'description', 
                'created_at', 'updated_at', 
                'url', 'created_ago', 'updated_ago'
            ]);
        $this->assertDatabaseHas('categories', ['name' => $category->name]);
    }

    // Category Store
    public function test_category_store()
    {
        $category = factory(Category::class)->make();

        // Unauthenticated user cannot save category
        $response = $this->post('/api/categories', $category->toArray(), ['Accept' => 'application/json']);
        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

        // Authenticated user can save category
        Passport::actingAs($this->user);
        $response = $this->post('/api/categories', $category->toArray());
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $category->name])
            ->assertJsonStructureExact([
                'name', 'parent_id', 'description', 
                'updated_at', 'created_at', 
                'id', 'url', 'created_ago', 'updated_ago'
            ]);
        $this->assertDatabaseHas('categories', ['name' => $category->name]);
    }

    // Category Update
    public function test_category_update()
    {
        $category = factory(Category::class)->create([
            'name' => 'Test Category'
        ]);
        $category->name = 'Test Category Updated';

        // Unauthenticated user cannot update category
        $response = $this->put('/api/categories/' . $category->id, $category->toArray(), ['Accept' => 'application/json']);
        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

        // Authenticated user can update category
        Passport::actingAs($this->user);
        $response = $this->put('/api/categories/' . $category->id, $category->toArray());
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Test Category Updated'])
            ->assertJsonStructureExact([
                'id', 'name', 'parent_id', 'description', 
                'created_at', 'updated_at', 
                'url', 'created_ago', 'updated_ago'
            ]);
        $this->assertDatabaseHas('categories', ['name' => 'Test Category Updated']);
        $this->assertDatabaseMissing('categories', ['name' => 'Test Category']);
    }

    // Category Destroy
    public function test_category_destroy()
    {
        $category = factory(Category::class)->create();

        // Unauthenticated user cannot delete category
        $response = $this->delete('/api/categories/' . $category->id, [], ['Accept' => 'application/json']);
        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

        // Authenticated user can delete category
        Passport::actingAs($this->user);
        $response = $this->delete('/api/categories/' . $category->id);
        $response->assertStatus(204);
        $this->assertDatabaseMissing('categories', ['name' => $category->name]);
    }
}
