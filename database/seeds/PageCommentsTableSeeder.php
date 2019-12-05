<?php

use Illuminate\Database\Seeder;
// use Illuminate\Support\Arr;
use App\PageComment;

class PageCommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $comments1 = factory(PageComment::class)->create([
            'reference_id' => rand(1, 13),
            'user_id' => rand(4, 14),
        ]);

        $comments2 = factory(PageComment::class)->create([
            'reference_id' => rand(1, 13),
            'user_id' => rand(4, 14),
        ]);

        $comments3 = factory(PageComment::class)->create([
            'reference_id' => rand(1, 13),
            'user_id' => rand(4, 14),
        ]);

        $comments4 = factory(PageComment::class)->create([
            'reference_id' => rand(1, 13),
            'user_id' => rand(4, 14),
        ]);

        $comments5 = factory(PageComment::class)->create([
            'reference_id' => rand(1, 13),
            'user_id' => rand(4, 14),
        ]);
    }
}
