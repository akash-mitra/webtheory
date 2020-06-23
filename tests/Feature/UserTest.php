<?php

namespace Tests\Feature;

use Tests\TestDataSetup;
use App\User;
use App\Page;
use App\PageContent;
use App\CategoryComment;
use App\PageComment;

class UserTest extends TestDataSetup
{
    /* User Index */
    public function test_user_index()
    {
        $user = factory(User::class)->create(['role' => 'author']);

        // Unauthenticated user cannot view user listing
        $response = $this->get('/api/users');
        $response->assertStatus(302);

        /* Authenticated user can view user listing */
        $response = $this->actingAs($this->adminUser)->get('/api/users');
        $response->assertStatus(200)
            ->assertJsonStructureExact([
                'current_page',
                'data' => [
                    '*' => $this->user_attributes
                ],
                'first_page_url', 'from', 'last_page', 'last_page_url', 'next_page_url', 'path', 'per_page', 'prev_page_url', 'to', 'total', 
            ]);
        $this->assertDatabaseHas('users', ['name' => $user->name]);
    }

    /* User Banned */
    public function test_user_banned()
    {
        $user = factory(User::class)->create(['role' => 'author', 'deleted_at' => now()]);

        // Unauthenticated user cannot view banned user listing
        $response = $this->get('/api/users/banned');
        $response->assertStatus(302);

        /* Authenticated user can view banned user listing */
        $response = $this->actingAs($this->adminUser)->get('/api/users/banned');
        $response->assertStatus(200)
            ->assertJsonStructureExact([
                'current_page',
                'data' => [
                    '*' => $this->user_attributes
                ],
                'first_page_url', 'from', 'last_page', 'last_page_url', 'next_page_url', 'path', 'per_page', 'prev_page_url', 'to', 'total', 
            ]);
        $this->assertSoftDeleted('users', ['name' => $user->name]);
    }

    /* User Unverified */
    public function test_user_unverified()
    {
        $user = factory(User::class)->create(['role' => 'author', 'email_verified_at' => null]);

        // Unauthenticated user cannot view unverified user listing
        $response = $this->get('/api/users/unverified');
        $response->assertStatus(302);

        /* Authenticated user can view unverified user listing */
        $response = $this->actingAs($this->adminUser)->get('/api/users/unverified');
        $response->assertStatus(200)
            ->assertJsonStructureExact([
                'current_page',
                'data' => [
                    '*' => $this->user_attributes
                ],
                'first_page_url', 'from', 'last_page', 'last_page_url', 'next_page_url', 'path', 'per_page', 'prev_page_url', 'to', 'total', 
            ]);
        $this->assertDatabaseHas('users', ['name' => $user->name, 'email_verified_at' => null]);
    }

    /* User Show */
    public function test_user_show()
    {
        $user = factory(User::class)->create(['role' => 'author']);

        // Unauthenticated user cannot view user
        $response = $this->get('/api/users/' . $user->id);
        $response->assertStatus(302);

        /* Authenticated user can view user */
        $response = $this->actingAs($this->adminUser)->get('/api/users/' . $user->id);
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $user->name])
            ->assertJsonStructureExact($this->user_attributes);
        $this->assertDatabaseHas('users', ['name' => $user->name]);
    }

    /* User Store */
    public function test_user_store()
    {
        $user = factory(User::class)->make(['role' => 'author']);

        // Unauthenticated user cannot save user
        $response = $this->post('/api/users', $user->toArray(), ['Accept' => 'application/json']);
        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

        /* Authenticated user can save user */
        $response = $this->actingAs($this->adminUser)->post('/api/users', $user->toArray(), ['Accept' => 'application/json']);
        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $user->name])
            ->assertJsonStructureExact($this->user_attributes_store);
        $this->assertDatabaseHas('users', ['name' => $user->name]);
    }

    /* User Update */
    public function test_user_update()
    {
        $user = factory(User::class)->create(['role' => 'author', 'about_me' => 'Initial Profile']);
        $user->about_me = 'Profile Modified';

        /* Unauthenticated user cannot update user */
        $response = $this->put('/api/users/' . $user->id, $user->toArray(), ['Accept' => 'application/json']);
        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

        /* Registered user cannot update user */
        $response = $this->actingAs($this->registeredUser)->put('/api/users/' . $user->id, $user->toArray(), ['Accept' => 'application/json']);
        $response->assertStatus(403)
            ->assertJson(['message' => 'Restricted Access']);

        /* Authenticated user can update user */
        $response = $this->actingAs($this->adminUser)->put('/api/users/' . $user->id, $user->toArray(), ['Accept' => 'application/json']);
        $response->assertStatus(200)
            ->assertJsonFragment(['about_me' => 'Profile Modified'])
            ->assertJsonStructureExact($this->user_attributes);
        $this->assertDatabaseHas('users', ['about_me' => 'Profile Modified']);
        $this->assertDatabaseMissing('users', ['about_me' => 'Initial Profile']);
    }

    /* User Remove */
    public function test_user_destroy()
    {
        $user = factory(User::class)->create(['role' => 'author']);

        // Unauthenticated user cannot delete user
        $response = $this->delete('/api/users/' . $user->id, [], ['Accept' => 'application/json']);
        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

        /* Authenticated user can delete user */
        $response = $this->actingAs($this->adminUser)->delete('/api/users/' . $user->id, [], ['Accept' => 'application/json']);
        $response->assertStatus(204);
        $this->assertSoftDeleted('users', ['name' => $user->name]);
    }

    /* Auth User can change password */
    public function test_user_can_change_password()
    {
        $data = ['current_password' => 'password', 'new_password' => 'password1234', 'new_password_confirmation' => 'password1234'];

        /* Unauthenticated user cannot update password */
        $response = $this->patch('/api/users/password', $data, ['Accept' => 'application/json']);
        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

        /* Authenticated user can update password */
        $response = $this->actingAs($this->adminUser)->patch('/api/users/password', $data, ['Accept' => 'application/json']);
        $response->assertStatus(200)
            ->assertJson(['status' => 'success', 'message' => 'Account password changed.']);
    }

    /* User Pages */
    public function test_user_pages()
    {
        $page = factory(Page::class)->create([
            'category_id' => $this->category->id,
            'user_id' => $this->adminUser->id,
            'status' => 'Live',
        ]);
        $pagecontent = factory(PageContent::class)->create([
            'page_id' => $page->id
        ]);

        // Unauthenticated user cannot view user pages listing
        $response = $this->get('/api/users/' . $this->adminUser->id . '/pages');
        $response->assertStatus(302);

        // Authenticated user can view user pages listing
        $response = $this->actingAs($this->adminUser)->get('/api/users/' . $this->adminUser->id . '/pages');
        $response->assertStatus(200)
            ->assertJsonFragment(['title' => $page->title])
            ->assertJsonStructureExact([
                'current_page',
                'data' => [
                    '*' => $this->user_pages_attributes
                ],
                'first_page_url', 'from', 'last_page', 'last_page_url', 'next_page_url', 'path', 'per_page', 'prev_page_url', 'to', 'total', 
            ]);
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

        /* Unauthenticated user cannot view user comments */
        $response = $this->get('/api/users/' . $this->adminUser->id . '/comments');
        $response->assertStatus(302);

        /* Authenticated user can view user comments */
        $response = $this->actingAs($this->adminUser)->get('/api/users/' . $this->adminUser->id . '/comments');
        $response->assertStatus(200)
            ->assertJsonFragment(['body' => $pagecomment->body])
            ->assertJsonStructureExact([
                'categories' => [
                    'current_page',
                    'data' => [
                        '*' => array_merge($this->category_attributes, [
                            'comments' => [
                                '*' => $this->comment_attributes
                            ]
                        ])
                    ],
                    'first_page_url', 'from', 'last_page', 'last_page_url', 'next_page_url', 'path', 'per_page', 'prev_page_url', 'to', 'total', 
                ],
                'pages' => [
                    'current_page',
                    'data' => [
                        '*' => array_merge($this->page_attributes, [
                            'comments' => [
                                '*' => $this->comment_attributes
                            ]
                        ])
                    ],
                    'first_page_url', 'from', 'last_page', 'last_page_url', 'next_page_url', 'path', 'per_page', 'prev_page_url', 'to', 'total', 
                ],
            ]);
        $this->assertDatabaseHas('category_comments', ['user_id' => $categorycomment->user_id]);
        $this->assertDatabaseHas('page_comments', ['user_id' => $pagecomment->user_id]);
    }
}
