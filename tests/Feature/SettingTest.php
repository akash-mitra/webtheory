<?php

namespace Tests\Feature;

use Tests\TestDataSetup;

class SettingTest extends TestDataSetup
{
    /* Get Social Settings */
    public function test_social_setting()
    {
        /* Unauthenticated user cannot view social listing */
        $response = $this->get('/api/settings/social');
        $response->assertStatus(302);

        /* Authenticated user can view social listing */
        $response = $this->actingAs($this->adminUser)->get('/api/settings/social');
        $response->assertStatus(200)
            ->assertJsonStructureExact([
                'FACEBOOK_CLIENT_ID', 'FACEBOOK_CLIENT_SECRET', 
                'TWITTER_CLIENT_ID', 'TWITTER_CLIENT_SECRET', 
                'LINKEDIN_CLIENT_ID', 'LINKEDIN_CLIENT_SECRET',
                'GOOGLE_CLIENT_ID', 'GOOGLE_CLIENT_SECRET',
            ]);
        $this->assertDatabaseHas('parameters', ['key' => 'FACEBOOK_CLIENT_ID']);
    }

    /* Get Mail Settings */
    public function test_mail_setting()
    {
        /* Unauthenticated user cannot view mail listing */
        $response = $this->get('/api/settings/mail');
        $response->assertStatus(302);

        /* Authenticated user can view mail listing */
        $response = $this->actingAs($this->adminUser)->get('/api/settings/mail');
        $response->assertStatus(200)
            ->assertJsonStructureExact([
                'MAIL_DRIVER', 'MAIL_FROM_ADDRESS', 'MAIL_FROM_NAME',
                'MAIL_HOST', 'MAIL_PORT', 'MAIL_ENCRYPTION', 'MAIL_USERNAME', 'MAIL_PASSWORD',
                'MAILGUN_DOMAIN', 'MAILGUN_SECRET', 'MAILGUN_ENDPOINT',
                'POSTMARK_TOKEN',
                'AWS_ACCESS_KEY_ID', 'AWS_SECRET_ACCESS_KEY', 'AWS_DEFAULT_REGION'
            ]);
        $this->assertDatabaseHas('parameters', ['key' => 'MAIL_DRIVER']);
    }
}
