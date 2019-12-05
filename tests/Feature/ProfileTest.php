<?php

namespace Tests\Feature;

use Tests\TestDataSetup;
use Laravel\Passport\Passport;
use App\CategoryComment;
use App\PageComment;

class ProfileTest extends TestDataSetup
{
    /* User Comments Test */
    public function test_user_comments()
    {
        $categorycomment = factory(CategoryComment::class)->create([
            'reference_id' => $this->category->id,
            'user_id' => $this->adminUser->id,
        ]);

        $pagecomment = factory(PageComment::class)->create([
            'reference_id' => $this->page->id,
            'user_id' => $this->adminUser->id,
        ]);

        /* Authenticated user can view auth user comments */
        // Passport::actingAs($this->adminUser);
        // $response = $this->get('/api/users/comments');
        
        $response = $this->actingAs($this->adminUser)->get('/api/users/comments');
        $response->assertStatus(200)
            ->assertJsonFragment(['body' => $pagecomment->body])
            ->assertJsonStructureExact([
                'categories' => [
                    '*' => [
                        'id', 'name', 'parent_id', 'description', 'metakey', 'metadesc', 'media_id', 'user_id', 
                        'created_at', 'updated_at', 'deleted_at', 
                        'url', 'created_ago', 'updated_ago', 
                        'comments' => [
                            '*' => [
                                'id', 'parent_id', 'reference_id', 'user_id', 'body', 'likes', 'dislikes', 
                                'created_at', 'updated_at', 'deleted_at', 'created_ago', 'updated_ago' 
                            ]
                        ]
                    ]
                ], 
                'pages' => [
                    '*' => [
                        'id', 'category_id', 'user_id', 'title', 'summary', 'metakey', 'metadesc', 'media_id', 'status',
                        'created_at', 'updated_at', 'deleted_at', 
                        'url', 'created_ago', 'updated_ago', 
                        'comments' => [
                            '*' => [
                                'id', 'parent_id', 'reference_id', 'user_id', 'body', 'likes', 'dislikes', 
                                'created_at', 'updated_at', 'deleted_at', 'created_ago', 'updated_ago' 
                            ]
                        ]
                    ]
                ], 
            ]);
        $this->assertDatabaseHas('category_comments', ['user_id' => $categorycomment->user_id]);
        $this->assertDatabaseHas('page_comments', ['user_id' => $pagecomment->user_id]);
    }
}
