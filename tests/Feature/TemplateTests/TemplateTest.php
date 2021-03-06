<?php

namespace Tests\Feature\TemplateTests;

use App\Template;
use Tests\TestDataSetup;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TemplateTest extends TestDataSetup
{
    use DefaultTemplateTests, InputValidationTests;

    // public function setUp(): void {
    //     parent::setUp();

    //     $this->backupActiveDirBladeViewFiles();
    // }

    // public function tearDown(): void {

    //     $this->restoreActiveDirBladeViewFiles();

    //     parent::tearDown();
    // }

    public $templateStructureJson = [
        'name',
        'description',
        'media_url',
        'parameters',
        'files' => [
            '*' => ['name', 'size', 'updated'],
        ],
    ];

    public function test_user_can_create_new_template()
    {
        $template = [
            'name' => 'My new Template by Admin',
            'description' => Str::random(),
            'active' => false,
        ];

        $this->actingAs($this->adminUser)
            ->post('/api/templates', $template)
            ->assertSuccessful();

        $this->assertDatabaseHas('templates', [
            'name' => $template['name'],
            'description' => $template['description'],
        ]);

        $this->assertTrue(
            Storage::disk('templates')->exists($template['name']),
            'Template directory does not exist.'
        );

        Storage::disk('templates')->deleteDirectory($template['name']);
    }

    public function test_a_file_can_be_added_to_a_template()
    {
        // given an existing template
        $template = $this->createNewTemplate();

        // if I send an add new file request, with new contents

        $content = Str::random();
        $this->actingAs($this->adminUser)
            ->post('/api/templates/' . $template->id . '/add', [
                'name' => 'home.blade.php',
                'code' => $content,
            ])
            ->assertSuccessful();

        // then the file will be added in the template directory
        $this->assertTrue(
            Storage::disk('templates')->exists($template->name . '/home.blade.php'),
            'Unable to add home.blade.php file in the template dir'
        );

        // and the file content will be set to the given content
        $this->assertEquals(
            $content,
            Storage::disk('templates')->get($template->name . '/' . 'home.blade.php')
        );

        Storage::disk('templates')->deleteDirectory($template->name);
    }

    public function test_a_file_can_be_deleted_from_template()
    {
        // given an existing template
        $template = $this->createNewTemplate();

        // if I send a delete file request...
        $response = $this->actingAs($this->adminUser)->post(
            '/api/templates/' . $template->id . '/remove',
            [
                'name' => base64_encode('home.blade.php'),
            ]
        );
        $response->assertSuccessful();

        // then the file will be deleted in the template directory
        $this->assertFalse(
            Storage::disk('templates')->exists($template->name . '/home.blade.php'),
            'File home.blade.php still exists under template ' .
                $template->name .
                ' in spite of deletion request.'
        );

        Storage::disk('templates')->deleteDirectory($template->name);
    }

    public function test_user_can_view_all_templates()
    {
        // We already have default template preinstalled.
        // let us create one more template and check those
        // 2 templates are returned when we visit the index page.
        $template = $this->createNewTemplate();

        // when we visit the index page,
        $response = $this->actingAs($this->adminUser)
            ->getJson('api/templates')
            ->assertSuccessful();

        // it must return 2 templates with the desired structure
        $json = $response->decodeResponseJson();

        $this->assertEquals(2, count($json['installed']));

        $response->assertJsonStructure([
            'installed' => [
                '*' => $this->templateStructureJson,
            ],
            'available' => [
                '*' => ['name', 'description', 'version', 'media_url', 'parameters'],
            ],
        ]);

        // also make sure that all the blade files are present in the response
        $response->assertJsonFragment([
            'name' => 'home.blade.php',
            'name' => 'single.blade.php',
            'name' => 'category.blade.php',
        ]);

        // cleanup
        Storage::disk('templates')->deleteDirectory($template->name);
    }

    public function test_user_can_view_a_specific_template()
    {
        $template = $this->createNewTemplate();

        // when we visit the show page,
        $response = $this->actingAs($this->adminUser)->getJson('api/templates/' . $template->id);

        // it must return the template with the desgnated structure
        $response->assertSuccessful()->assertJsonStructure($this->templateStructureJson);

        // cleanup
        Storage::disk('templates')->deleteDirectory($template->name);
    }

    public function test_user_can_retrieve_a_specific_template_file()
    {
        /*
         * we will test this by trying to retrieve the 'home.blade.php'
         * file from the default template.
         */

        $id = Template::where('name', $this->defaultTemplateName)->first()->id;

        $fileIdentity = base64_encode('home.blade.php');

        $this->actingAs($this->adminUser)
            ->get('api/templates/' . $id . '/get/' . $fileIdentity)
            ->assertSuccessful();
    }

    public function test_a_template_can_be_activated()
    {
        /*
         * Before we test template activation, we should note that
         * "active" folder already contains the default templates
         * in it. These templates must be backed up before we
         * begin the testing and must be restored at the
         * end of the testing.
         */
        $this->backupActiveDirBladeViewFiles();

        // create a new template
        $template = $this->createNewTemplate();

        // when I activate the template
        $this->actingAs($this->adminUser)
            ->post('/api/templates/' . $template->id . '/activate')
            ->assertSuccessful();

        // the template is activated in the database
        $this->assertDatabaseHas('templates', [
            'name' => $template->name,
            'active' => true,
        ]);

        // template files are copied to the active folder
        array_map(function ($file) {
            $sourceFileContent = Storage::disk('templates')->get($file);

            $targetFileContent = Storage::disk('active')->get(basename($file));

            $this->assertEquals($sourceFileContent, $targetFileContent);
        }, Storage::disk('templates')->files($template->name));

        // restore
        $this->restoreActiveDirBladeViewFiles();

        // cleanup
        Storage::disk('templates')->deleteDirectory($template->name);
    }

    public function test_user_can_edit_a_template()
    {
        // create a template
        $template = $this->createNewTemplate('Initial Template Name');

        // make a new template name and desription
        $name = Str::random();
        $description = Str::random();

        // when we edit the template with new name and description
        $this->actingAs($this->adminUser)
            ->patch('/api/templates/' . $template->id, [
                'name' => $name,
                'description' => $description,
            ])
            ->assertSuccessful();

        // make sure the name changes in database
        $this->assertDatabaseHas('templates', [
            'name' => $name,
            'description' => $description,
        ]);

        // and template folder name also changes
        $this->assertTrue(Storage::disk('templates')->exists($name));

        // and the old folder does not exist anymore
        $this->assertFalse(Storage::disk('templates')->exists($template->name));

        //clean up
        Storage::disk('templates')->deleteDirectory($name);
    }

    public function test_editing_active_template_reloads_view_files()
    {
        $this->backupActiveDirBladeViewFiles();

        // create a template
        $template = $this->createNewTemplate([
            'name' => 'My Active Template',
            'active' => true,
        ]);

        // send it new contents for the single.blde.php file
        $content = Str::random();
        $this->actingAs($this->adminUser)->post('/api/templates/' . $template->id . '/add', [
            'name' => 'single.blade.php',
            'code' => $content,
        ]);

        // check the contents have been added to the file in the templates directory
        $this->assertEquals(
            $content,
            Storage::disk('templates')->get($template->name . '/' . 'single.blade.php')
        );

        // check that the contents are also added to the 'views/active' directory
        $this->assertEquals($content, Storage::disk('active')->get('single.blade.php'));

        $this->restoreActiveDirBladeViewFiles();

        //clean up
        Storage::disk('templates')->deleteDirectory($template->name);
    }

    public function test_user_can_delete_template()
    {
        $template = $this->createNewTemplate();

        $this->actingAs($this->adminUser)
            ->delete('api/templates/' . $template->id)
            ->assertSuccessful();

        $this->assertDatabaseMissing('templates', [
            'id' => $template->id,
        ]);

        $this->assertFalse(Storage::disk('templates')->exists($template->name));

        Storage::disk('templates')->deleteDirectory($template->name);
    }

    public function test_user_can_not_delete_active_template()
    {
        $template = $this->createNewTemplate([
            'active' => true,
        ]);

        $this->actingAs($this->adminUser)
            ->delete('api/templates/' . $template->id)
            ->assertJsonValidationErrors(['active']);

        $this->assertDatabaseHas('templates', [
            'id' => $template->id,
        ]);

        Storage::disk('templates')->deleteDirectory($template->name);
    }

    public function test_a_user_can_duplicate_a_template()
    {
        $template = $this->createNewTemplate();

        $saveAs = $template->name . '_' . Str::random();

        $this->actingAs($this->adminUser)->post('api/templates/' . $template->id . '/duplicate', [
            'save_as' => $saveAs,
        ]);

        $this->assertDatabaseHas('templates', [
            'name' => $saveAs,
        ]);

        $this->assertTrue(Storage::disk('templates')->exists($saveAs));

        $this->assertEquals(
            array_map(function ($file) {
                return basename($file);
            }, Storage::disk('templates')->allFiles($template->name)),
            array_map(function ($file) {
                return basename($file);
            }, Storage::disk('templates')->allFiles($saveAs))
        );

        Storage::disk('templates')->deleteDirectory($template->name);
        Storage::disk('templates')->deleteDirectory($saveAs);
    }

    public function test_a_user_can_import_a_template_from_repo()
    {
        $random = Str::random();

        $response = $this->actingAs($this->adminUser)->post('api/templates/import', [
            'from' => $this->defaultTemplateName,
            'name' => $random,
        ]);

        $this->assertDatabaseHas('templates', [
            'name' => $random,
        ]);

        $this->assertTrue(Storage::disk('templates')->exists($random));

        array_map(function ($fileName) use ($random) {
            $this->assertTrue(
                Storage::disk('templates')->exists($random . '/' . $fileName),
                $fileName . ' file is missing in ' . $random
            );
        }, $this->preloadedTemplates[$this->defaultTemplateName]);

        Storage::disk('templates')->deleteDirectory($random);
    }

    public function test_correct_template_is_loaded_when_visiting_home()
    {
        $this->get('/')->assertViewIs('active.home');
    }

    private function createNewTemplate($name = null)
    {
        $input = is_array($name)
            ? $name
            : [
                'name' => $name ?? Str::random(),
            ];

        $template = factory('App\Template')->create($input);

        Storage::disk('templates')->makeDirectory($template->name);
        Storage::disk('templates')->put(
            $template->name . '/' . 'home.blade.php',
            '<html>Home</html>' . Str::random()
        );
        Storage::disk('templates')->put(
            $template->name . '/' . 'single.blade.php',
            '<html>Single</html>' . Str::random()
        );
        Storage::disk('templates')->put(
            $template->name . '/' . 'category.blade.php',
            '<html>Category</html>' . Str::random()
        );

        return $template;
    }

    private function backupActiveDirBladeViewFiles()
    {
        array_map(function ($file) {
            if (Str::endsWith($file, 'blade.php')) {
                Storage::disk('active')->move($file, $file . '___test_bkp');
            }
        }, Storage::disk('active')->files());
    }

    private function restoreActiveDirBladeViewFiles()
    {
        array_map(function ($file) {
            if (Str::endsWith($file, '___test_bkp')) {
                $originalFileName = Str::before($file, '___test_bkp');

                if (Storage::disk('active')->exists($originalFileName)) {
                    Storage::disk('active')->delete($originalFileName);
                }

                Storage::disk('active')->move($file, $originalFileName);
            }
        }, Storage::disk('active')->files());
    }
}
