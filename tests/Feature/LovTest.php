<?php

namespace Tests\Feature;

use Tests\TestDataSetup;
use Laravel\Passport\Passport;
use App\Category;
use App\User;

class LovTest extends TestDataSetup
{
    /* Categories Lov Test */
    public function test_categories_lov()
    {
        $category = factory(Category::class)->create([
            'user_id' => $this->adminUser->id,
        ]);

        /* Unauthenticated user can view categories lov listing */
        $response = $this->get('/api/lov/categories');
        $response->assertStatus(200)
            ->assertJsonStructureExact([
                '*' => [
                    'key', 'value', 'trashed'
                ]
            ]);
        $this->assertDatabaseHas('categories', ['name' => $category->name]);

        /* Authenticated user can view categories lov listing */
        // Passport::actingAs($this->adminUser);
        // $response = $this->get('/api/lov/categories');
        
        $response = $this->actingAs($this->adminUser)->get('/api/lov/categories');
        $response->assertStatus(200)
            ->assertJsonStructureExact([
                '*' => [
                    'key', 'value', 'trashed'
                ]
            ]);
        $this->assertDatabaseHas('categories', ['name' => $category->name]);
    }

    /* Authors Lov Test */
    public function test_authors_lov()
    {
        /* Unauthenticated user can view authors lov listing */
        $response = $this->get('/api/lov/authors');
        $response->assertStatus(200)
            ->assertJsonStructureExact([
                '*' => [
                    'key', 'value', 'trashed'
                ]
            ]);
        
        /* Authenticated user can view authors lov listing */
        // Passport::actingAs($this->adminUser);
        // $response = $this->get('/api/lov/authors');
        
        $response = $this->actingAs($this->adminUser)->get('/api/lov/authors');
        $response->assertStatus(200)
            ->assertJsonStructureExact([
                '*' => [
                    'key', 'value', 'trashed'
                ]
            ]);
    }
}
