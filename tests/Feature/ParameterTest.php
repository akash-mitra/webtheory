<?php

namespace Tests\Feature;

use Tests\TestDataSetup;

class ParameterTest extends TestDataSetup
{
    /* Get Parameters */
    public function test_get_parameters()
    {
        /* Unauthenticated user cannot view parameters */
        $response = $this->get('/api/parameters/siteinfo');
        $response->assertStatus(302);

        /* Authenticated user can view parameters */
        $response = $this->actingAs($this->adminUser)->get('/api/parameters/siteinfo');
        $response->assertStatus(200);
        $value = $response->decodeResponseJson();
        $this->assertEquals( 
            '{"name": "My Blog", "title": "My Blog Title", "desc": ""}', 
            $value
        ); 
        $this->assertDatabaseHas('parameters', ['key' => 'siteinfo']);
    }

    /* Set Parameters */
    public function test_set_parameters()
    {
        /* Unauthenticated user cannot save parameters */
        $response = $this->get('/api/parameters/siteinfo');
        $response->assertStatus(302);

        /* Authenticated user can save parameters */
        $response = $this->actingAs($this->adminUser)->post('/api/parameters/siteinfo', 
            ['value' => '{"name": "My Test Blog", "title": "My Test Blog Title", "desc": ""}'], ['Accept' => 'application/json']);
        $response->assertStatus(200);
        $value = $response->decodeResponseJson();
        $this->assertEquals( 
            '{"name": "My Test Blog", "title": "My Test Blog Title", "desc": ""}', 
            $value
        ); 
        $this->assertDatabaseHas('parameters', ['key' => 'siteinfo']);
    }
}
