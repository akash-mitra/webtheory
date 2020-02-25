<?php

namespace Tests\Feature;

use Tests\TestDataSetup;
use App\Template;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TemplateTest extends TestDataSetup
{
    // check that default templates are available
    //TODO


    public function test_template_create_edit_activate_edit_delete ()
    {
        $randomName = Str::random(20);

        // create
        $this->actingAs($this->adminUser)
            ->post(route('templates.store'), [
            'name' => $randomName,
            'description' => 'some dummy descriptions',
            'type' => 'home',
            'media_url' => 'https://',
            'active' => false,
            'code' => '<html>Test Template</html>'
        ])->assertSuccessful();

        $this->assertDatabaseHas('templates', [
            'name' => $randomName
        ]);

        Storage::disk('store')->assertExists('file-000001');

        // edit for not active templates
        $this->actingAs($this->adminUser)
            ->put(route('templates.update', 1), [
                'type' => 'single',
                'code' => '<html>Single Page Template</html>'
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas('templates', [
            'name' => $randomName,
            'type' => 'single'
        ]);

        $this->assertStringEqualsFile(storage_path('app/file-000001'), '<html>Single Page Template</html>');


        // activate the template
        $this->actingAs($this->adminUser)
            ->post(route('templates.activate', 1))
            ->assertSuccessful();

        $this->assertDatabaseHas('templates', [
            'name' => $randomName,
            'type' => 'single',
            'active' => true
        ]);

        Storage::disk('template')->assertExists('single.blade.php');

        $this->assertFileEquals(storage_path('store/file-000001'), resource_path('views/templates/single.blade.php'));


        // update an already active template and check both files are reflecting changes
        $this->actingAs($this->adminUser)
            ->put(route('templates.update', 1), [
                'name' => $randomName . ' -edited',
                'code' => '<html>Single Page Template updated</html>'
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas('templates', [
            'name' => $randomName  . ' -edited',
            'type' => 'single',
            'active' => true
        ]);

        $this->assertStringEqualsFile(storage_path('app/file-000001'), '<html>Single Page Template updated</html>');

        $this->assertFileEquals(storage_path('app/file-000001'), resource_path('views/templates/single.blade.php'));

    }



}
