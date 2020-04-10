<?php

namespace Tests\Feature\TemplateTests;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

/**
 * This trait contains a collection of tests to make sure that
 * all the input data are validated properly.
 */
trait InputValidationTests {

    public function test_template_names_can_not_contain_invalid_char()
    {
        $template = [
            'name' => 'Invalid/template/name',
            'description' => Str::random(),
            'active' => 0
        ];

        $this->actingAs($this->adminUser)
            ->post('/api/templates', $template)
            ->assertRedirect()
            ->assertSessionHasErrors([
                'name'
            ]);
    }
}
