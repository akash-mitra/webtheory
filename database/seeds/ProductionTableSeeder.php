<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->addDefaultCategory();

        $this->addDefaultParameters();

        $this->addDefaultTemplates();

        $this->addDefaultPermissions();
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
        // SITE
        DB::table('parameters')->insert([
            'key' => 'siteinfo',
            'value' => '{"name": "My Blog", "title": "My Blog Title", "desc": ""}',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // EDITOR
        DB::table('parameters')->insert([
            'key' => 'editor',
            'value' => 'editorjs',
            'created_at' => now(),
            'updated_at' => now()
        ]);


        // SOCIAL LOGIN
        DB::table('parameters')->insert([
            'key' => 'socialprovider',
            'value' => '{"facebook": "Disabled", "twitter": "Disabled", "linkedin": "Disabled", "google": "Disabled"}',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('parameters')->insert([
            'key' => 'socialprovider_redirect_url',
            'value' => '{"facebook": "' . $this->getUrl('facebook') . '", "twitter": "' . $this->getUrl('twitter') . '", "linkedin": "' . $this->getUrl('linkedin') . '", "google": "' . $this->getUrl('google') . '"}',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('parameters')->insert([
            'key' => 'FACEBOOK_CLIENT_ID',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'FACEBOOK_CLIENT_SECRET',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'TWITTER_CLIENT_ID',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'TWITTER_CLIENT_SECRET',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'LINKEDIN_CLIENT_ID',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'LINKEDIN_CLIENT_SECRET',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'GOOGLE_CLIENT_ID',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'GOOGLE_CLIENT_SECRET',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);


        // MAIL DRIVER
        DB::table('parameters')->insert([
            'key' => 'MAIL_DRIVER',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('parameters')->insert([
            'key' => 'MAIL_FROM_ADDRESS',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'MAIL_FROM_NAME',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'MAIL_HOST',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'MAIL_PORT',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'MAIL_ENCRYPTION',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'MAIL_USERNAME',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'MAIL_PASSWORD',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'MAILGUN_DOMAIN',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'MAILGUN_SECRET',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'MAILGUN_ENDPOINT',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'POSTMARK_TOKEN',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'AWS_ACCESS_KEY_ID',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'AWS_SECRET_ACCESS_KEY',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'AWS_DEFAULT_REGION',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);

    }

    private function getUrl($provider)
    {
        return env('APP_URL') . '/app/social/login/' .$provider . '/callback';
    }


    private function addDefaultTemplates ()
    {
        $templateParameters = [
            [
                "name" => "headingFont",
                "type" => "list",
                "options" => "Verdana, Arial, Playfair Display",
                "value" => "Playfair Display"
            ],
            [
                "name" => "primaryColor",
                "type" => "list",
                "options" => "gray,red,orange,yellow,green,teal,blue,indigo,purple,pink",
                "value" => "orange"
            ],
            [
                "name" => "centerContent",
                "type" => "list",
                "options" => "yes,no",
                "value" => "yes"
            ]
        ];

        DB::table('templates')->insert([
            'name' => 'Serenity',
            'description' => 'A spotless template that provides a clean and simple user experience for the users of your blog.',
            'media_url' => 'https://source.unsplash.com/apax4M-4kFI',
            'active' => 1,
            'user_id' => 1,
            'parameters' => json_encode($templateParameters),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }


    private function addDefaultPermissions()
    {
        DB::table('permissions')->delete();

        /********************
         * APP
         *******************/
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'admin', 'action' => 'app', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'admin', 'action' => 'app', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);

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

        /********************
         * USER
         *******************/
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'users', 'action' => 'index', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'users', 'action' => 'show', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'users', 'action' => 'store', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'users', 'action' => 'update', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'users', 'action' => 'destroy', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);

        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'users', 'action' => 'index', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'users', 'action' => 'show', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);


        /********************
         * SETTING
         *******************/
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'settings', 'action' => 'social', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'settings', 'action' => 'mail', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'settings', 'action' => 'loginprovider', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'settings', 'action' => 'mailprovider', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);

    }

}
