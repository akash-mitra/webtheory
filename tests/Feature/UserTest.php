<?php

namespace Tests\Feature;

use Tests\TestDataSetup;
use App\User;

class UserTest extends TestDataSetup
{
    private $user_attributes = [
        'id', 'name', 'email', 'email_verified_at', 'role', 'avatar', 'about_me', 'gender', 'dob', 'preferences', 
        'created_at', 'updated_at', 'deleted_at', 'public_id', 'created_ago', 'updated_ago', 'url', 
    ];
    
    // User Index
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
                '*' => $this->user_attributes
            ]);
        $this->assertDatabaseHas('users', ['name' => $user->name]);
    }

    // User Show
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

    // User Store
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
            ->assertJsonStructureExact([
                'name', 'email', 'role', 'preferences', 'public_id', 'updated_at', 'created_at', 'id', 'created_ago', 'updated_ago', 'url', 
            ]);
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
        $response = $this->actingAs($this->adminUser)->put('/api/users/' . $user->id, $user->toArray());
        $response->assertStatus(200)
            ->assertJsonFragment(['about_me' => 'Profile Modified'])
            ->assertJsonStructureExact($this->user_attributes);
        $this->assertDatabaseHas('users', ['about_me' => 'Profile Modified']);
        $this->assertDatabaseMissing('users', ['about_me' => 'Initial Profile']);
    }

    // User Remove
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
}
