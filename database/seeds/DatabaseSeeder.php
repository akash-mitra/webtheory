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
        $this->call(IncrementalSeeder::class);

        if (App::Environment() === 'local') {
            $this->call(LocalTableSeeder::class);
        }

        if (App::Environment() === 'testing') {
            // 
        }
    }
}
