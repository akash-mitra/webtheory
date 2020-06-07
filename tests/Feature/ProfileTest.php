<?php

namespace Tests\Feature;

use Tests\TestDataSetup;
use App\User;
use App\CategoryComment;
use App\PageComment;

class ProfileTest extends TestDataSetup
{
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
        $response = $this->patch('/api/profile', $user->toArray(), ['Accept' => 'application/json']);
        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

        /* Authenticated user can update user */
        $response = $this->actingAs($user)->patch('/api/profile', $user->toArray());
        $response->assertStatus(200)
            ->assertJsonFragment(['about_me' => 'I am a registered user'])
            ->assertJsonStructureExact($this->profile_attributes);
        $this->assertDatabaseHas('users', ['about_me' => 'I am a registered user']);
        $this->assertDatabaseMissing('users', ['about_me' => 'I am a dummy user']);
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
        $response = $this->actingAs($this->adminUser)->get('/api/profile/comments');
        $response->assertStatus(200)
            ->assertJsonFragment(['body' => $pagecomment->body])
            ->assertJsonStructureExact([
                'categories' => [
                    '*' => array_merge($this->category_attributes, [
                        'comments' => [
                            '*' => $this->comment_attributes
                        ]
                    ])
                ],
                'pages' => [
                    '*' => array_merge($this->page_attributes, [
                        'comments' => [
                            '*' => $this->comment_attributes
                        ]
                    ])
                ],
            ]);
        $this->assertDatabaseHas('category_comments', ['user_id' => $categorycomment->user_id]);
        $this->assertDatabaseHas('page_comments', ['user_id' => $pagecomment->user_id]);
    }
}
