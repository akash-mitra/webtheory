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
}
