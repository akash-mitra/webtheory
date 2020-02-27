<?php

namespace Tests\Feature;

use Tests\TestDataSetup;
use App\Template;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TemplateTest extends TestDataSetup
{


    public function setUp()
    {
        parent::setUp();

        if (Storage::disk('template')->exists('single.blade.php')) {
            Storage::disk('template')->delete('single.blade.php');
        }

        Storage::disk('template')->writeStream(
            'single.blade.php',
            Storage::disk('store')->readStream('file-000002')
        );
    }




    public function test_default_templates_are_present ()
    {
        Storage::disk('store')->assertExists('file-000001');
        Storage::disk('store')->assertExists('file-000002');
        Storage::disk('store')->assertExists('file-000003');

        Storage::disk('template')->assertExists('home.blade.php');
        Storage::disk('template')->assertExists('single.blade.php');
        Storage::disk('template')->assertExists('category.blade.php');

        $this->assertEquals(
            Storage::disk('store')->get('file-000001'),
            Storage::disk('template')->get('home.blade.php')
        );

        $this->assertEquals(
            Storage::disk('store')->get('file-000002'),
            Storage::disk('template')->get('single.blade.php')
        );

        $this->assertEquals(
            Storage::disk('store')->get('file-000003'),
            Storage::disk('template')->get('category.blade.php')
        );
    }




    public function test_template_create_edit_activate_edit_delete ()
    {
        $randomName = Str::random(20);

        $this->createTemplate('home', $randomName)->assertSuccessful();

        $this->assertDatabaseHas('templates', [
            'name' => $randomName
        ]);

        // retrieve the stored filename of this template
        $id = Template::where('name', $randomName)->first()->id;
        $templateFileName = Template::bladeFileName($id);

        // assert the template file is also created in the store
        Storage::disk('store')->assertExists($templateFileName);




        // Test update of this template (non-active)
        // we will change the template code as well as template type

        $newTemplateCode = '<html>Single Page Template</html>';
        $this->actingAs($this->adminUser)
            ->put(route('templates.update', $id), [
                'type' => 'single',
                'code' => $newTemplateCode
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas('templates', [
            'name' => $randomName,
            'type' => 'single',
        ]);

        $this->assertStringEqualsFile(storage_path('store/' . $templateFileName), $newTemplateCode);


        // Test for activation of the template
        //
        // CAUTION!!! Template activation will replace the default template from
        // views/templates directory. This must be restored later before
        // finishing the test.
        // $this->actingAs($this->adminUser)
        //     ->post(route('templates.activate', 1))
        //     ->assertSuccessful();

        // $this->assertDatabaseHas('templates', [
        //     'name' => $randomName,
        //     'type' => 'single',
        //     'active' => true
        // ]);

        // Storage::disk('template')->assertExists('single.blade.php');

        // $this->assertFileEquals(storage_path('store/file-000001'), resource_path('views/templates/single.blade.php'));


        // // update an already active template and check both files are reflecting changes
        // $this->actingAs($this->adminUser)
        //     ->put(route('templates.update', 1), [
        //         'name' => $randomName . ' -edited',
        //         'code' => '<html>Single Page Template updated</html>'
        //     ])
        //     ->assertSuccessful();

        // $this->assertDatabaseHas('templates', [
        //     'name' => $randomName  . ' -edited',
        //     'type' => 'single',
        //     'active' => true
        // ]);

        // $this->assertStringEqualsFile(storage_path('app/file-000001'), '<html>Single Page Template updated</html>');

        // $this->assertFileEquals(storage_path('app/file-000001'), resource_path('views/templates/single.blade.php'));

    }


    private function createTemplate(
        $type,
        $name,
        $code = '<html>Test Template</html>',
        $param = '[{"name":"font","type":"list","options":"Verdana, Arial","value":"Arial"}]'
    )
    {
        return $this->actingAs($this->adminUser)
            ->post(route('templates.store'), [
            'name' => $name,
            'description' => 'some dummy descriptions',
            'type' => $type,
            'media_url' => 'https://',
            'active' => false,
            'code' => $code,
            'parameters' => $param,
        ]);
    }


    protected function tearDown(): void
    {
        if (Storage::disk('template')->exists('single.blade.php')) {
            Storage::disk('template')->delete('single.blade.php');
        }

        Storage::disk('template')->writeStream(
            'single.blade.php',
            Storage::disk('store')->readStream('file-000002')
        );

        parent::tearDown();
    }
}
