<?php

namespace Tests;

use DB;
use App\User;
use App\Category;
use App\Page;
use App\PageContent;
use App\Media;
use Notification;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DuskTestDataSetup extends DuskTestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        Notification::fake();

        $this->addDefaultCategory();
        $this->addDefaultParameters();
        $this->addDefaultTemplates();
        $this->generate_permissions();
        $this->generate_testdata();

        // COMMENTED OUT FOR 403 Restricted Access permission Test Cases
        // $this->withoutExceptionHandling();
    }

    private function addDefaultCategory ()
    {
        DB::table('categories')->insert([
            'name' => 'Uncategorised',
            'parent_id' => null,
            'description' => 'All other pages which are not part of any specific topic.',
            'metakey' => '',
            'metadesc' => '',
            'media_id' => null,
            'user_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }



    private function addDefaultParameters ()
    {
        DB::table('parameters')->insert([
            'key' => 'siteinfo',
            'value' => '{"name": "My Blog", "title": "My Blog Title", "desc": ""}',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('parameters')->insert([
            'key' => 'editor',
            'value' => 'editorjs',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }



    private function addDefaultTemplates ()
    {
        DB::table('templates')->insert([
            'name' => 'Serenity',
            'type' => 'home',
            'description' => 'A spotless template that provides a clean and simple user experience for the users of your blog.',
            'media_url' => 'https://source.unsplash.com/apax4M-4kFI',
            'active' => 1,
            'user_id' => 1,
            'parameters' => '[{"name":"headingFont","type":"list","options":"Verdana, Arial, Playfair Display","value":"Playfair Display"},{"name":"primaryColor","type":"list","options":"gray,red,orange,yellow,green,teal,blue,indigo,purple,pink","value":"orange"}]',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('templates')->insert([
            'name' => 'Serenity',
            'type' => 'single',
            'description' => 'A spotless template that provides a clean and simple user experience for the users of your blog.',
            'media_url' => 'https://source.unsplash.com/apax4M-4kFI',
            'active' => 1,
            'user_id' => 1,
            'parameters' => '[{"name":"primaryColor","type":"list","options":"gray,red,orange,yellow,green,teal,blue,indigo,purple,pink","value":"orange"},{"name":"centerContent","type":"list","options":"yes,no","value":"yes"}]',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('templates')->insert([
            'name' => 'Serenity',
            'type' => 'category',
            'description' => 'A spotless template that provides a clean and simple user experience for the users of your blog.',
            'media_url' => 'https://source.unsplash.com/apax4M-4kFI',
            'active' => 1,
            'user_id' => 1,
            'parameters' => '[{"name":"primaryColor","type":"list","options":"gray,red,orange,yellow,green,teal,blue,indigo,purple,pink","value":"orange"}]',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    private function generate_permissions()
    {
        // SETUP
        DB::table('permissions')->delete();
        /********************
         * CATEGORY
         *******************/
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'categories', 'action' => 'index', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'categories', 'action' => 'show', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'categories', 'action' => 'pages', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'categories', 'action' => 'comments', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'categories', 'action' => 'store', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'categories', 'action' => 'update', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'categories', 'action' => 'destroy', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);

        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'categories', 'action' => 'index', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'categories', 'action' => 'show', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'categories', 'action' => 'pages', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'categories', 'action' => 'comments', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'categories', 'action' => 'store', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'categories', 'action' => 'update', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);

        DB::table('permissions')->insert(['role' => 'registered', 'resource' => 'categories', 'action' => 'index', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'registered', 'resource' => 'categories', 'action' => 'show', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'registered', 'resource' => 'categories', 'action' => 'pages', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'registered', 'resource' => 'categories', 'action' => 'comments', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        
        /********************
         * PAGE
         *******************/
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'pages', 'action' => 'index', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'pages', 'action' => 'show', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'pages', 'action' => 'comments', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'pages', 'action' => 'store', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'pages', 'action' => 'update', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'pages', 'action' => 'updatestatus', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'pages', 'action' => 'updateowner', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'pages', 'action' => 'destroy', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);

        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'pages', 'action' => 'index', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'pages', 'action' => 'show', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'pages', 'action' => 'comments', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'pages', 'action' => 'store', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'pages', 'action' => 'update', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'pages', 'action' => 'updatestatus', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);

        DB::table('permissions')->insert(['role' => 'registered', 'resource' => 'pages', 'action' => 'index', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'registered', 'resource' => 'pages', 'action' => 'show', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'registered', 'resource' => 'pages', 'action' => 'comments', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        
        /********************
         * MEDIA
         *******************/
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'media', 'action' => 'index', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'media', 'action' => 'show', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'media', 'action' => 'upload', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'media', 'action' => 'remove', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);

        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'media', 'action' => 'index', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'media', 'action' => 'show', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'media', 'action' => 'upload', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
    }

    private function generate_testdata()
    {
        // API TESTING DATA
        
        $this->adminUser = factory(User::class)->create(['email' => 'adminuser@example.com', 'role' => 'admin']);
        $this->authorUser1 = factory(User::class)->create(['email' => 'authoruser1@example.com', 'role' => 'author']);
        $this->authorUser2 = factory(User::class)->create(['email' => 'authoruser2@example.com', 'role' => 'author']);
        $this->registeredUser = factory(User::class)->create(['email' => 'registereduser@example.com', 'role' => 'registered']);
        $this->user = factory(User::class)->create(['email' => 'testuser@example.com']);
        
        $this->media = factory(Media::class)->create([
            'user_id' => $this->adminUser->id,
        ]);
        
        $this->category = factory(Category::class)->create([
            'user_id' => $this->adminUser->id,
        ]);

        $this->page = factory(Page::class)->create([
            'category_id' => $this->category->id,
            'user_id' => $this->adminUser->id,
        ]);
        $this->pagecontent = factory(PageContent::class)->create([
            'page_id' => $this->page->id
        ]);
        
    }
}
