<?php

namespace Tests\Feature;

use Tests\TestDataSetup;
use App\User;
use App\CategoryComment;
use App\PageComment;

class ProfileTest extends TestDataSetup
{
    /* User Show */
    public function test_user_show()
    {
        $user = factory(User::class)->create([
            'email' => 'dummyuser@example.com',
            'role' => 'registered'
        ]);

        /* Unauthenticated user can view user profile */
        $response = $this->get('/api/users/' . $user->id);
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $user->name])
            ->assertJsonStructureExact([
                'id', 'name', 'email', 'email_verified_at', 'role', 'avatar', 'about_me', 'gender', 'dob', 'preferences', 
                'created_at', 'updated_at', 'deleted_at'
            ]);
        $this->assertDatabaseHas('users', ['name' => $user->name]);

        /* Authenticated user can view user profile */
        $response = $this->actingAs($this->adminUser)->get('/api/users/' . $user->id);
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $user->name])
            ->assertJsonStructureExact([
                'id', 'name', 'email', 'email_verified_at', 'role', 'avatar', 'about_me', 'gender', 'dob', 'preferences', 
                'created_at', 'updated_at', 'deleted_at'
            ]);
        $this->assertDatabaseHas('users', ['name' => $user->name]);
    }

    /* User Update */
    public function test_user_update()
    {
        $user = factory(User::class)->create([
            'email' => 'dummyuser@example.com',
            'role' => 'registered',
            'about_me' => 'I am a dummy user'
        ]);
        
        $user->about_me = 'I am a registered user';
        $user->gender = true;

        /* Unauthenticated user cannot update profile */
        // $response = $this->put('/api/users/' . $user->id, $user->toArray(), ['Accept' => 'application/json']);
        // $response->assertStatus(401)
        //     ->assertJson(['message' => 'Unauthenticated.']);

        /* Authenticated user can update user */
        $response = $this->actingAs($user)->put('/api/users/' . $user->id, $user->toArray());
        $response->assertStatus(200)
            ->assertJsonFragment(['about_me' => 'I am a registered user'])
            ->assertJsonStructureExact([
                'id', 'name', 'email', 'email_verified_at', 'role', 'avatar', 'about_me', 'gender', 'dob', 'preferences', 
                'created_at', 'updated_at', 'deleted_at'
            ]);
        $this->assertDatabaseHas('users', ['about_me' => 'I am a registered user']);
        $this->assertDatabaseMissing('users', ['about_me' => 'I am a dummy user']);
    }

    /* User Role Update */
    public function test_user_role_update()
    {
        $user = factory(User::class)->create([
            'email' => 'dummyuser@example.com',
            'role' => 'registered'
        ]);
        
        $user->role = 'author';

        /* Unauthenticated user cannot update profile */
        // $response = $this->put('/api/users/' . $user->id, $user->toArray(), ['Accept' => 'application/json']);
        // $response->assertStatus(401)
        //     ->assertJson(['message' => 'Unauthenticated.']);

        /* Authenticated user can update user */
        $response = $this->actingAs($this->adminUser)->put('/api/users/' . $user->id  . '/role', $user->toArray());
        $response->assertStatus(200)
            ->assertJsonFragment(['role' => 'author'])
            ->assertJsonStructureExact([
                'id', 'name', 'email', 'email_verified_at', 'role', 'avatar', 'about_me', 'gender', 'dob', 'preferences', 
                'created_at', 'updated_at', 'deleted_at'
            ]);
        $this->assertDatabaseHas('users', ['role' => 'author']);
        $this->assertDatabaseMissing('users', ['id' => $user->id, 'role' => 'registered']);
    }

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
