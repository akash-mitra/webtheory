<?php

namespace Tests\Feature;

use Tests\TestDataSetup;
use Laravel\Passport\Passport;

class LoginTest extends TestDataSetup
{
    // Login Test
    public function test_login()
    {
        // Correct credentials
        $body = [
            'email' => 'testuser@example.com',
            'password' => 'password'
        ];
        $response = $this->post('/api/login', $body, ['Accept' => 'application/json']);
        $response->assertStatus(200)
            ->assertJsonStructureExact([
                'id', 'name', 'email', 
                'email_verified_at', 'created_at', 'updated_at', 
                'token_type', 'access_token', 'expires_at'
            ]);
        $this->assertDatabaseHas('users', ['email' => $body['email']]);

        // Incorrect credentials
        $body = [
            'email' => 'testuser@example.com',
            'password' => 'password1234'
        ];
        $response = $this->post('/api/login', $body, ['Accept' => 'application/json']);
        $response->assertStatus(401)
            ->assertJson([
                'message' => 'These credentials do not match our records.'
            ]);
    }

    // Logout Test
    public function test_logout()
    {
        // Passport::actingAs($this->user);
        // $response = $this->post('/api/logout', [], ['Accept' => 'application/json']);
        $response = $this->actingAs($this->user)->post('/api/logout', [], ['Accept' => 'application/json']);
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Successfully logged out'
            ]);
    }
}
