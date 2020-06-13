<?php

namespace Tests\Feature;

use Tests\TestDataSetup;
use App\User;

class UserTest extends TestDataSetup
{
    /* User Index */
    public function test_user_index()
    {
        $user = factory(User::class)->create(['role' => 'author']);

        // Unauthenticated user cannot view user listing
        $response = $this->get('/api/users', ['Accept' => 'application/json']);
        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

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

    /* User Show */
    public function test_user_show()
    {
        $user = factory(User::class)->create(['role' => 'author']);

        // Unauthenticated user cannot view user
        $response = $this->get('/api/users/' . $user->id, ['Accept' => 'application/json']);
        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

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
        $response = $this->actingAs($this->adminUser)->delete('/api/users/' . $user->id);
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
}
