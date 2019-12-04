<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        DB::table('categories')->insert([
            'id' => 0,
            'name' => 'Uncategorized',
            'parent_id' => null,
            'description' => 'Uncategorized',
            'user_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        factory(Category::class, 10)->create([
            'user_id' => 1,
        ]);
    }
}
