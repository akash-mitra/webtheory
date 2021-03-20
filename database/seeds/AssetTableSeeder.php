<?php

use Illuminate\Database\Seeder;
use App\Asset;

class AssetTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Asset::class, 10)->create([
            'user_id' => 1,
        ]);
    }
}
