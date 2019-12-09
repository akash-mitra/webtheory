<?php

use Illuminate\Database\Seeder;
use App\Permission;

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
        /********************
         * CATEGORY
         *******************/
        factory(Permission::class)->create(['role' => 'admin', 'resource' => 'categories', 'action' => 'index', 'permission' => true]);
        factory(Permission::class)->create(['role' => 'admin', 'resource' => 'categories', 'action' => 'show', 'permission' => true]);
        factory(Permission::class)->create(['role' => 'admin', 'resource' => 'categories', 'action' => 'comments', 'permission' => true]);
        factory(Permission::class)->create(['role' => 'admin', 'resource' => 'categories', 'action' => 'store', 'permission' => true]);
        factory(Permission::class)->create(['role' => 'admin', 'resource' => 'categories', 'action' => 'update', 'permission' => true]);
        factory(Permission::class)->create(['role' => 'admin', 'resource' => 'categories', 'action' => 'destroy', 'permission' => true]);

        factory(Permission::class)->create(['role' => 'author', 'resource' => 'categories', 'action' => 'index', 'permission' => true]);
        factory(Permission::class)->create(['role' => 'author', 'resource' => 'categories', 'action' => 'show', 'permission' => true]);
        factory(Permission::class)->create(['role' => 'author', 'resource' => 'categories', 'action' => 'comments', 'permission' => true]);
        factory(Permission::class)->create(['role' => 'author', 'resource' => 'categories', 'action' => 'store', 'permission' => true]);
        factory(Permission::class)->create(['role' => 'author', 'resource' => 'categories', 'action' => 'update', 'permission' => true]);

        // factory(Permission::class)->create(['role' => 'registered', 'resource' => 'categories', 'action' => 'index', 'permission' => true]);
        // factory(Permission::class)->create(['role' => 'registered', 'resource' => 'categories', 'action' => 'show', 'permission' => true]);
        // factory(Permission::class)->create(['role' => 'registered', 'resource' => 'categories', 'action' => 'comments', 'permission' => true]);
        // factory(Permission::class)->create(['role' => 'guest', 'resource' => 'categories', 'action' => 'index', 'permission' => true]);
        // factory(Permission::class)->create(['role' => 'guest', 'resource' => 'categories', 'action' => 'show', 'permission' => true]);
        // factory(Permission::class)->create(['role' => 'guest', 'resource' => 'categories', 'action' => 'comments', 'permission' => true]);

        /********************
         * PAGE
         *******************/
        factory(Permission::class)->create(['role' => 'admin', 'resource' => 'pages', 'action' => 'index', 'permission' => true]);
        factory(Permission::class)->create(['role' => 'admin', 'resource' => 'pages', 'action' => 'show', 'permission' => true]);
        factory(Permission::class)->create(['role' => 'admin', 'resource' => 'pages', 'action' => 'comments', 'permission' => true]);
        factory(Permission::class)->create(['role' => 'admin', 'resource' => 'pages', 'action' => 'store', 'permission' => true]);
        factory(Permission::class)->create(['role' => 'admin', 'resource' => 'pages', 'action' => 'update', 'permission' => true]);
        factory(Permission::class)->create(['role' => 'admin', 'resource' => 'pages', 'action' => 'updatestatus', 'permission' => true]);
        factory(Permission::class)->create(['role' => 'admin', 'resource' => 'pages', 'action' => 'updateowner', 'permission' => true]);
        factory(Permission::class)->create(['role' => 'admin', 'resource' => 'pages', 'action' => 'destroy', 'permission' => true]);

        factory(Permission::class)->create(['role' => 'author', 'resource' => 'pages', 'action' => 'index', 'permission' => true]);
        factory(Permission::class)->create(['role' => 'author', 'resource' => 'pages', 'action' => 'show', 'permission' => true]);
        factory(Permission::class)->create(['role' => 'author', 'resource' => 'pages', 'action' => 'comments', 'permission' => true]);
        factory(Permission::class)->create(['role' => 'author', 'resource' => 'pages', 'action' => 'store', 'permission' => true]);
        factory(Permission::class)->create(['role' => 'author', 'resource' => 'pages', 'action' => 'update', 'permission' => true]);
        factory(Permission::class)->create(['role' => 'author', 'resource' => 'pages', 'action' => 'updatestatus', 'permission' => true]);

        // factory(Permission::class)->create(['role' => 'registered', 'resource' => 'pages', 'action' => 'index', 'permission' => true]);
        // factory(Permission::class)->create(['role' => 'registered', 'resource' => 'pages', 'action' => 'show', 'permission' => true]);
        // factory(Permission::class)->create(['role' => 'registered', 'resource' => 'pages', 'action' => 'comments', 'permission' => true]);
        // factory(Permission::class)->create(['role' => 'guest', 'resource' => 'pages', 'action' => 'index', 'permission' => true]);
        // factory(Permission::class)->create(['role' => 'guest', 'resource' => 'pages', 'action' => 'show', 'permission' => true]);
        // factory(Permission::class)->create(['role' => 'guest', 'resource' => 'pages', 'action' => 'comments', 'permission' => true]);

        /********************
         * MEDIA
         *******************/
        factory(Permission::class)->create(['role' => 'admin', 'resource' => 'media', 'action' => 'index', 'permission' => true]);
        factory(Permission::class)->create(['role' => 'admin', 'resource' => 'media', 'action' => 'show', 'permission' => true]);
        factory(Permission::class)->create(['role' => 'admin', 'resource' => 'media', 'action' => 'upload', 'permission' => true]);
        factory(Permission::class)->create(['role' => 'admin', 'resource' => 'media', 'action' => 'remove', 'permission' => true]);

        factory(Permission::class)->create(['role' => 'author', 'resource' => 'media', 'action' => 'index', 'permission' => true]);
        factory(Permission::class)->create(['role' => 'author', 'resource' => 'media', 'action' => 'show', 'permission' => true]);
        factory(Permission::class)->create(['role' => 'author', 'resource' => 'media', 'action' => 'comments', 'permission' => true]);
        factory(Permission::class)->create(['role' => 'author', 'resource' => 'media', 'action' => 'upload', 'permission' => true]);

        // factory(Permission::class)->create(['role' => 'registered', 'resource' => 'media', 'action' => 'index', 'permission' => true]);
        // factory(Permission::class)->create(['role' => 'registered', 'resource' => 'media', 'action' => 'show', 'permission' => true]);
        // factory(Permission::class)->create(['role' => 'guest', 'resource' => 'media', 'action' => 'index', 'permission' => true]);
        // factory(Permission::class)->create(['role' => 'guest', 'resource' => 'media', 'action' => 'show', 'permission' => true]);
    }
}
