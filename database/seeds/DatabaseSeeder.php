<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionsTableSeeder::class);
        
        $this->call(UsersTableSeeder::class);
        $this->call(MediaTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(PagesTableSeeder::class);
        $this->call(CategoryCommentsTableSeeder::class);
        $this->call(PageCommentsTableSeeder::class);
    }
}
