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
            'id' => 0,
            'name' => 'Uncategorized',
            'parent_id' => null,
            'description' => 'Uncategorized',
        ]);

        factory(Category::class, 10)->create();
    }
}
