<?php

namespace Tests\Feature;

use Tests\TestDataSetup;
use App\Form;
use App\FormResponse;

class FormTest extends TestDataSetup
{
    /* Form Index */
    public function test_form_index()
    {
        $form = factory(Form::class)->create();

        // Unauthenticated user cannot view forms listing
        $response = $this->get('/api/forms');
        $response->assertStatus(302);

        // Authenticated user can view forms listing
        $response = $this->actingAs($this->adminUser)->get('/api/forms');
        $response->assertOk()->assertJsonStructureExact([
            'current_page',
            'data' => [
                '*' => $this->form_attributes,
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
        $this->assertDatabaseHas('forms', ['name' => $form->name]);
    }

    /* Form Show */
    public function test_form_show()
    {
        $form = factory(Form::class)->create();

        // Unauthenticated user cannot view form
        $response = $this->get('/api/forms/' . $form->id);
        $response->assertStatus(302);

        // Authenticated user can view form
        $response = $this->actingAs($this->adminUser)->get('/api/forms/' . $form->id);
        $response
            ->assertOk()
            ->assertJsonFragment(['name' => $form->name])
            ->assertJsonStructureExact($this->form_attributes);
        $this->assertDatabaseHas('forms', ['name' => $form->name]);
    }

    /* Form Store */
    public function test_form_store()
    {
        $form = factory(Form::class)->make();

        // Unauthenticated user cannot save form
        $response = $this->post('/api/forms', $form->toArray(), ['Accept' => 'application/json']);
        $response->assertStatus(401)->assertJson(['message' => 'Unauthenticated.']);

        // Registered user cannot save form
        $response = $this->actingAs($this->registeredUser)->post('/api/forms', $form->toArray(), [
            'Accept' => 'application/json',
        ]);
        $response->assertStatus(403)->assertJson(['message' => 'Restricted Access']);

        // Authenticated user can save form
        $response = $this->actingAs($this->adminUser)->post('/api/forms', $form->toArray(), [
            'Accept' => 'application/json',
        ]);
        $response
            ->assertOk()
            ->assertJsonFragment(['name' => $form->name])
            ->assertJsonStructureExact([
                'name',
                'description',
                'status',
                'captcha',
                'fields',
                'updated_at',
                'created_at',
                'id',
                'created_ago',
                'updated_ago',
            ]);
        $this->assertDatabaseHas('forms', ['name' => $form->name]);
    }

    /* Form Update */
    public function test_form_update()
    {
        $form = factory(Form::class)->create([
            'name' => 'Test Form',
        ]);
        $form->name = 'Test Form Updated';

        // Unauthenticated user cannot update form
        $response = $this->put('/api/forms/' . $form->id, $form->toArray(), [
            'Accept' => 'application/json',
        ]);
        $response->assertStatus(401)->assertJson(['message' => 'Unauthenticated.']);

        // Registered user cannot update form
        $response = $this->actingAs($this->registeredUser)->put(
            '/api/forms/' . $form->id,
            $form->toArray(),
            ['Accept' => 'application/json']
        );
        $response->assertStatus(403)->assertJson(['message' => 'Restricted Access']);

        // Authenticated user can update form
        $response = $this->actingAs($this->adminUser)->put(
            '/api/forms/' . $form->id,
            $form->toArray(),
            ['Accept' => 'application/json']
        );
        $response
            ->assertOk()
            ->assertJsonFragment(['name' => 'Test Form Updated'])
            ->assertJsonStructureExact($this->form_attributes);
        $this->assertDatabaseHas('forms', ['name' => 'Test Form Updated']);
        $this->assertDatabaseMissing('forms', ['name' => 'Test Form']);
    }

    /* Form Destroy */
    public function test_form_destroy()
    {
        $form = factory(Form::class)->create();

        // Unauthenticated user cannot delete form
        $response = $this->delete('/api/forms/' . $form->id, [], ['Accept' => 'application/json']);
        $response->assertStatus(401)->assertJson(['message' => 'Unauthenticated.']);

        // Registered user cannot delete form
        $response = $this->actingAs($this->registeredUser)->delete(
            '/api/forms/' . $form->id,
            [],
            ['Accept' => 'application/json']
        );
        $response->assertStatus(403)->assertJson(['message' => 'Restricted Access']);

        // Authenticated user can delete form
        $response = $this->actingAs($this->adminUser)->delete(
            '/api/forms/' . $form->id,
            [],
            ['Accept' => 'application/json']
        );
        $response->assertStatus(204);
        $this->assertDatabaseMissing('forms', ['name' => $form->name]);
    }

    /* Form Responses */
    public function test_form_responses()
    {
        $form = factory(Form::class)->create();

        $formresponse = factory(FormResponse::class)->create([
            'form_id' => $form->id,
        ]);

        // Unauthenticated user cannot view form responses
        $response = $this->get('/api/forms/' . $form->id . '/responses');
        $response->assertStatus(302);

        // Authenticated user can view form pages
        $response = $this->actingAs($this->adminUser)->get(
            '/api/forms/' . $form->id . '/responses'
        );
        $response->assertOk()->assertJsonStructureExact([
            'current_page',
            'data' => [
                '*' => $this->formresponse_attributes,
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
        $this->assertDatabaseHas('forms', ['id' => $form->id]);
        $this->assertDatabaseHas('form_responses', ['id' => $formresponse->id]);
    }

    /* Form Response Store */
    public function test_form_store_response()
    {
        $form = factory(Form::class)->create();

        $formresponse = factory(FormResponse::class)->make([
            'form_id' => $form->id,
        ]);

        // Unauthenticated user can save form response
        $response = $this->post(
            '/api/forms/' . $form->id . '/response',
            $formresponse->toArray()
        )->assertSessionHas('status', 'success');

        $this->assertDatabaseHas('form_responses', ['form_id' => $form->id]);

        // Registered user can save form response
        $response = $this->actingAs($this->registeredUser)
            ->post('/api/forms/' . $form->id . '/response', $formresponse->toArray())
            ->assertSessionHas('status', 'success');

        $this->assertDatabaseHas('form_responses', ['form_id' => $form->id]);

        // Authenticated user can save form response
        $response = $this->actingAs($this->adminUser)
            ->post('/api/forms/' . $form->id . '/response', $formresponse->toArray())
            ->assertSessionHas('status', 'success');

        $this->assertDatabaseHas('form_responses', ['form_id' => $form->id]);
    }
}
