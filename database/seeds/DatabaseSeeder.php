<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ProductionTableSeeder::class);


        if (App::Environment() === 'local')
        {
            $this->call(PermissionsTableSeeder::class);
            // $this->call(UsersTableSeeder::class);
            $this->call(MediaTableSeeder::class);
            $this->call(CategoriesTableSeeder::class);
            $this->call(PagesTableSeeder::class);
            $this->call(CategoryCommentsTableSeeder::class);
            $this->call(PageCommentsTableSeeder::class);
        }
    }
}
