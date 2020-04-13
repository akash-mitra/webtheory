<?php

namespace Tests\Feature;

use Tests\TestDataSetup;

class LoginTest extends TestDataSetup
{
    /* Login Test */
    public function test_login()
    {
        /* Correct credentials */
        $body = [
            'email' => 'adminuser@example.com',
            'password' => 'password'
        ];
        $response = $this->post('/api/login', $body, ['Accept' => 'application/json']);
        $response->assertStatus(200)
            ->assertJsonStructureExact([
                'id', 'name', 'email',
                'email_verified_at', 'role', 'avatar', 'about_me', 'gender', 'dob', 'preferences',
                'created_at', 'updated_at', 'deleted_at', 'created_ago', 'updated_ago'
            ]);
        $this->assertDatabaseHas('users', ['email' => $body['email']]);

        /* Incorrect credentials */
        $body = [
            'email' => 'adminuser@example.com',
            'password' => 'password1234'
        ];
        $response = $this->post('/api/login', $body, ['Accept' => 'application/json']);
        $response->assertStatus(401)
            ->assertJson([
                'message' => 'These credentials do not match our records.'
            ]);
    }

    /* Logout Test */
    /*
    public function test_logout()
    {
        $response = $this->actingAs($this->adminUser)->post('/api/logout', [], ['Accept' => 'application/json']);
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Successfully logged out'
            ]);
    }
    */
}
