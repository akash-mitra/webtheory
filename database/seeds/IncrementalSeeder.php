<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class IncrementalSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionsTableSeeder::class);
    }
}
