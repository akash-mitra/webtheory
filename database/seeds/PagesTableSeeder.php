<?php

use Illuminate\Database\Seeder;
// use Illuminate\Support\Arr;
use App\Page;
use App\PageContent;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages1 = factory(Page::class, 3)->create([
            'category_id' => null,
            'user_id' => 1,
        ])->each(function ($page) {
            $page->content()->save(factory(PageContent::class)->make());
        });

        $pages2 = factory(Page::class, 5)->create([
            'category_id' => rand(1, 5),
            'user_id' => 1,
        ])->each(function ($page) {
            $page->content()->save(factory(PageContent::class)->make());
        });

        $pages3 = factory(Page::class, 5)->create([
            'category_id' => rand(1, 5),
            'user_id' => 1,
        ])->each(function ($page) {
            $page->content()->save(factory(PageContent::class)->make());
        });

    }
}
