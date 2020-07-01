<?php

namespace Tests\Feature;

use Tests\TestDataSetup;
use App\Parameter;
use Illuminate\Support\Facades\Queue;
use App\Jobs\UpdateSite;
use App\Jobs\SendEmail;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;

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

    /* Set Login Providers */
    public function test_login_provider_setting()
    {
        $loginprovider = [ 'data' => [
            ['key' => 'FACEBOOK_CLIENT_ID', 'value' => 'Id1234'],
            ['key' => 'FACEBOOK_CLIENT_SECRET', 'value' => 'Secret1234']
        ]];

        /* Unauthenticated user cannot set login provider */
        $response = $this->post('/api/settings/loginprovider', $loginprovider, ['Accept' => 'application/json']);
        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

        /* Authenticated user can set login provider */
        $response = $this->actingAs($this->adminUser)->post('/api/settings/loginprovider', $loginprovider, ['Accept' => 'application/json']);
        $response->assertStatus(200);
        $this->assertDatabaseHas('parameters', ['key' => 'FACEBOOK_CLIENT_ID', 'value' => 'Id1234']);
        $this->assertDatabaseHas('parameters', ['key' => 'FACEBOOK_CLIENT_SECRET', 'value' => 'Secret1234']);
    }

    /* Set Mail Providers */
    public function test_mail_provider_setting()
    {
        $mailprovider = [ 'data' => [
            ['key' => 'MAIL_DRIVER', 'value' => 'smtp'],
            ['key' => 'MAIL_FROM_ADDRESS', 'value' => 'test@test.com']
        ]];

        /* Unauthenticated user cannot set mail provider */
        $response = $this->post('/api/settings/mailprovider', $mailprovider, ['Accept' => 'application/json']);
        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

        /* Authenticated user can set mail provider */
        $response = $this->actingAs($this->adminUser)->post('/api/settings/mailprovider', $mailprovider, ['Accept' => 'application/json']);
        $response->assertStatus(200);
        $this->assertDatabaseHas('parameters', ['key' => 'MAIL_DRIVER', 'value' => 'smtp']);
        $this->assertDatabaseHas('parameters', ['key' => 'MAIL_FROM_ADDRESS', 'value' => 'test@test.com']);
    }

    public function test_email_success_setting()
    {
        Parameter::setKey('MAIL_DRIVER', 'array');

        /* Unauthenticated user cannot test email setup */
        $response = $this->get('/api/settings/testmail');
        $response->assertStatus(302);

        /* Authenticated user can set email setup */
        $response = $this->actingAs($this->adminUser)->get('/api/settings/testmail');
        $response->assertStatus(200)
            ->assertSee('Mail Sent. Please check your email inbox');

        Queue::assertPushed(SendEmail::class);
        // Mail::assertSent(TestMail::class);
    }

    public function test_site_update_setting()
    {
        $this->assertTrue(true);

        // DO NOT RUN - it will STASH existing uncommited code & refresh local site
        /*
        // Unauthenticated user cannot update site
        $response = $this->post('/api/settings/update', [], ['Accept' => 'application/json']);
        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

        // Authenticated user can update site
        $response = $this->actingAs($this->adminUser)->post('/api/settings/update', [], ['Accept' => 'application/json']);
        $response->assertStatus(200)
            ->assertSee('Site update is in progress');

        // Queue::assertPushed(UpdateSite::class);

        // Test Site-Update Artisan Command
        $this->artisan('update:site')
            ->assertExitCode(0);
        */
    }

    /* Get Search Settings */
    public function test_search_setting()
    {
        /* Unauthenticated user cannot view search listing */
        $response = $this->get('/api/settings/search');
        $response->assertStatus(302);

        /* Authenticated user can view search listing */
        $response = $this->actingAs($this->adminUser)->get('/api/settings/search');
        $response->assertStatus(200)
            ->assertJsonStructureExact([
                'SEARCHABLE', 'ALGOLIA_COMMUNITY_PLAN',
                'ALGOLIA_APP_ID', 'ALGOLIA_SECRET',
            ]);
        $this->assertDatabaseHas('parameters', ['key' => 'SEARCHABLE']);
    }

    /* Set Search Providers */
    public function test_search_provider_setting()
    {
        $searchprovider = [ 'data' => [
            'SEARCHABLE' => '1',
            'ALGOLIA_COMMUNITY_PLAN' => '0',
            'ALGOLIA_APP_ID' => 'Id1234',
            'ALGOLIA_SECRET' => 'Secret1234'
        ]];

        /* Unauthenticated user cannot set search provider */
        $response = $this->post('/api/settings/searchprovider', $searchprovider, ['Accept' => 'application/json']);
        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

        /* Authenticated user can set search provider */
        $response = $this->actingAs($this->adminUser)->post('/api/settings/searchprovider', $searchprovider, ['Accept' => 'application/json']);
        $response->assertStatus(200);
        $this->assertDatabaseHas('parameters', ['key' => 'SEARCHABLE', 'value' => '1']);
        $this->assertDatabaseHas('parameters', ['key' => 'ALGOLIA_APP_ID', 'value' => 'Id1234']);
    }
}
