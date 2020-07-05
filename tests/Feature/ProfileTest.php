<?php

namespace Tests\Feature;

use Tests\TestDataSetup;
use App\User;
use App\CategoryComment;
use App\Page;
use App\PageContent;
use App\PageComment;

class ProfileTest extends TestDataSetup
{
    /* User Pages */
    public function test_user_pages()
    {
        $page = factory(Page::class)->create([
            'category_id' => $this->category->id,
            'user_id' => $this->adminUser->id,
            'status' => 'Live',
        ]);
        $pagecontent = factory(PageContent::class)->create([
            'page_id' => $page->id,
        ]);

        // Unauthenticated user can view user pages listing
        $response = $this->get('/api/profiles/' . $this->adminUser->public_id . '/pages');
        $response->assertStatus(200);

        // Authenticated user can view user pages listing
        $response = $this->get('/api/profiles/' . $this->adminUser->public_id . '/pages');
        $response
            ->assertStatus(200)
            ->assertJsonFragment(['title' => $page->title])
            ->assertJsonStructureExact([
                'current_page',
                'data' => [
                    '*' => $this->user_pages_attributes,
                ],
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total',
            ]);
    }

    /* User Profile Update */
    public function test_user_update()
    {
        $user = factory(User::class)->create([
            'email' => 'dummyuser@example.com',
            'role' => 'registered',
            'about_me' => 'I am a dummy user',
        ]);

        $user->about_me = 'I am a registered user';
        $user->gender = true;

        /* Unauthenticated user cannot update profile */
        $response = $this->patch('/api/profile', $user->toArray(), [
            'Accept' => 'application/json',
        ]);
        $response->assertStatus(401)->assertJson(['message' => 'Unauthenticated.']);

        /* Authenticated user can update user */
        $response = $this->actingAs($user)->patch('/api/profile', $user->toArray());
        $response
            ->assertStatus(200)
            ->assertJsonFragment(['about_me' => 'I am a registered user'])
            ->assertJsonStructureExact($this->profile_attributes);
        $this->assertDatabaseHas('users', ['about_me' => 'I am a registered user']);
        $this->assertDatabaseMissing('users', ['about_me' => 'I am a dummy user']);
    }

    /* User Comments */
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
        $response
            ->assertStatus(200)
            ->assertJsonFragment(['body' => $pagecomment->body])
            ->assertJsonStructureExact([
                'categories' => [
                    '*' => array_merge($this->category_attributes, [
                        'comments' => [
                            '*' => $this->comment_attributes,
                        ],
                    ]),
                ],
                'pages' => [
                    '*' => array_merge($this->page_attributes, [
                        'comments' => [
                            '*' => $this->comment_attributes,
                        ],
                    ]),
                ],
            ]);
        $this->assertDatabaseHas('category_comments', ['user_id' => $categorycomment->user_id]);
        $this->assertDatabaseHas('page_comments', ['user_id' => $pagecomment->user_id]);
    }
}
