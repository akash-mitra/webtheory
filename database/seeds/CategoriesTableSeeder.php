<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Category::class)->create([
            'name' => 'Uncategorized',
            'parent_id' => null,
            'description' => 'Uncategorized',
            'user_id' => 1,
        ]);

        factory(Category::class, 10)->create([
            'user_id' => 1,
        ]);
    }
}
