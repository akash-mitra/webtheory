<?php


use Illuminate\Database\Seeder;


class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /*
         * Need to seed this file explicitly during each code pull
         *
         * php artisan db:seed --class=PermissionsTableSeeder --force
         *
         */


        // SETUP
        DB::table('permissions')->delete();

        /********************
         * APP
         *******************/
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'admin', 'action' => 'app', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'admin', 'action' => 'app', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);


        /********************
         * PARAMETER
         *******************/
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'parameters', 'action' => 'get', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'parameters', 'action' => 'set', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);


        /********************
         * CATEGORY
         *******************/
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'categories', 'action' => 'index', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'categories', 'action' => 'show', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'categories', 'action' => 'pages', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'categories', 'action' => 'store', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'categories', 'action' => 'update', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'categories', 'action' => 'destroy', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);

        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'categories', 'action' => 'index', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'categories', 'action' => 'show', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'categories', 'action' => 'pages', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'categories', 'action' => 'store', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'categories', 'action' => 'update', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);

        DB::table('permissions')->insert(['role' => 'registered', 'resource' => 'categories', 'action' => 'index', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'registered', 'resource' => 'categories', 'action' => 'show', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'registered', 'resource' => 'categories', 'action' => 'pages', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);


        /********************
         * PAGE
         *******************/
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'pages', 'action' => 'index', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'pages', 'action' => 'show', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'pages', 'action' => 'store', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'pages', 'action' => 'update', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'pages', 'action' => 'updatestatus', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'pages', 'action' => 'updateowner', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'pages', 'action' => 'destroy', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);

        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'pages', 'action' => 'index', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'pages', 'action' => 'show', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'pages', 'action' => 'store', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'pages', 'action' => 'update', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'pages', 'action' => 'updatestatus', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);

        DB::table('permissions')->insert(['role' => 'registered', 'resource' => 'pages', 'action' => 'index', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'registered', 'resource' => 'pages', 'action' => 'show', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);


        /********************
         * MEDIA
         *******************/
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'media', 'action' => 'index', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'media', 'action' => 'show', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'media', 'action' => 'upload', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'media', 'action' => 'uploadurl', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'media', 'action' => 'remove', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);

        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'media', 'action' => 'index', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'media', 'action' => 'show', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'media', 'action' => 'upload', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'media', 'action' => 'uploadurl', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);


        /********************
         * USER
         *******************/
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'users', 'action' => 'index', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'users', 'action' => 'banned', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'users', 'action' => 'unverified', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'users', 'action' => 'show', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'users', 'action' => 'store', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'users', 'action' => 'update', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'users', 'action' => 'destroy', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'users', 'action' => 'changepassword', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'users', 'action' => 'pages', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'users', 'action' => 'comments', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);

        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'users', 'action' => 'index', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'users', 'action' => 'banned', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'users', 'action' => 'unverified', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'users', 'action' => 'show', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'users', 'action' => 'changepassword', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);

        DB::table('permissions')->insert(['role' => 'registered', 'resource' => 'users', 'action' => 'changepassword', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);


        /********************
         * SETTING
         *******************/
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'settings', 'action' => 'social', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'settings', 'action' => 'mail', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'settings', 'action' => 'loginprovider', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'settings', 'action' => 'mailprovider', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'settings', 'action' => 'testmail', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'settings', 'action' => 'update', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'settings', 'action' => 'search', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'settings', 'action' => 'searchprovider', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);


        /********************
         * LOV
         *******************/
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'lov', 'action' => 'categories', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'lov', 'action' => 'authors', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'lov', 'action' => 'categories', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'lov', 'action' => 'authors', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);


        /********************
         * TEMPLATE
         *******************/
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'templates', 'action' => 'index', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'templates', 'action' => 'show', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'templates', 'action' => 'store', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'templates', 'action' => 'add', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'templates', 'action' => 'remove', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'templates', 'action' => 'get', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'templates', 'action' => 'activate', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'templates', 'action' => 'update', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'templates', 'action' => 'destroy', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'templates', 'action' => 'duplicate', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'templates', 'action' => 'import', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'templates', 'action' => 'download', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'templates', 'action' => 'upload', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);


        /********************
         * FORM
         *******************/
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'forms', 'action' => 'index', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'forms', 'action' => 'show', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'forms', 'action' => 'store', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'forms', 'action' => 'update', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'forms', 'action' => 'destroy', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'forms', 'action' => 'responses', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'forms', 'action' => 'response', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'forms', 'action' => 'responsesdownload', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);


        /********************
         * DASHBOARD
         *******************/
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'dashboard', 'action' => 'topcomments', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'dashboard', 'action' => 'topcomments', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'admin', 'resource' => 'dashboard', 'action' => 'clearcache', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('permissions')->insert(['role' => 'author', 'resource' => 'dashboard', 'action' => 'clearcache', 'permission' => true, 'created_at' => now(), 'updated_at' => now()]);


    }
}
