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
            $this->call(LocalTableSeeder::class);
            $this->call(PermissionsTableSeeder::class);
        }

        if (App::Environment() === 'testing')
        {
            $this->call(PermissionsTableSeeder::class);
        }
    }
}
