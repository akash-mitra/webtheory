<?php

use Illuminate\Database\Seeder;
// use Illuminate\Support\Arr;
use App\CategoryComment;

class CategoryCommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $comments1 = factory(CategoryComment::class)->create([
            'reference_id' => rand(1, 10),
            'user_id' => rand(4, 14),
        ]);

        $comments2 = factory(CategoryComment::class)->create([
            'reference_id' => rand(1, 10),
            'user_id' => rand(4, 14),
        ]);

        $comments3 = factory(CategoryComment::class)->create([
            'reference_id' => rand(1, 10),
            'user_id' => rand(4, 14),
        ]);

        $comments4 = factory(CategoryComment::class)->create([
            'reference_id' => rand(1, 10),
            'user_id' => rand(4, 14),
        ]);

        $comments5 = factory(CategoryComment::class)->create([
            'reference_id' => rand(1, 10),
            'user_id' => rand(4, 14),
        ]);
    }
}
