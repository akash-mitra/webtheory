<?php

namespace Tests\Feature\TemplateTests;

use Illuminate\Support\Facades\Storage;

/**
 * This trait contains a collection of tests to make sure that
 * default template is always present in tne directory and activated.
 * This is to make sure that when this code is deployed, it contains
 * the relevant structures and files.
 */
trait DefaultTemplateTests {

    public $defaultTemplateName = 'Serenity';

    public $requiredTemplateFiles = [
        'home.blade.php',
        'single.blade.php',
        'category.blade.php'
    ];



    public function test_default_template_is_set_as_active()
    {
        $this->assertDatabaseHas('templates', [
            'name' => $this->defaultTemplateName,
            'active' => 1,
        ]);
    }



    public function test_active_dir_is_preloaded_with_default_template ()
    {
        array_map(function ($file) {

            $sourceFileContent = Storage::disk('templates')->get($file);

            $targetFileContent = Storage::disk('active')->get(basename($file));

            $this->assertEquals($sourceFileContent, $targetFileContent, $file . ' is missing in the active directory.');
        },
        Storage::disk('templates')->files($this->defaultTemplateName));
    }



    public function test_templates_dir_is_preloaded_with_default_template()
    {
        // check the default template directory is there
        $this->assertTrue(
            Storage::disk('templates')->exists($this->defaultTemplateName),
            'Default template directory is missing'
        );

        // and the default directory contains all the required template files
        array_map(function ($fileName) {
            $this->assertTrue(
                Storage::disk('templates')->exists($this->defaultTemplateName . '/' . $fileName),
                $fileName . ' file is missing in ' . $this->defaultTemplateName
            );
        }, $this->requiredTemplateFiles);
    }



    public function test_repo_is_preloaded_with_templates()
    {
        // check there is at least one template directory in the repo
        $templateDirectories = Storage::disk('repo')->directories('templates');
        $this->assertGreaterThanOrEqual(1, count($templateDirectories));

        // and the directories contain all the required template files
        foreach($templateDirectories as $dir)
        {
            array_map(function ($fileName) use ($dir){
                $this->assertTrue(
                    Storage::disk('repo')->exists($dir . '/' . $fileName),
                    $fileName . ' file is missing in ' . $dir
                );
            }, $this->requiredTemplateFiles);
        }
    }

}
