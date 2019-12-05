<?php

use Illuminate\Database\Seeder;
use App\Media;

class MediaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $media = factory(Media::class, 10)->create([
            'user_id' => 1,
        ]);
    }
}
