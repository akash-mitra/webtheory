<?php

namespace Tests;

use App\User;
use App\Category;
use App\Page;
use App\PageContent;
use App\Media;
use Notification;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\Support\AssertJson;

class TestDataSetup extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;
    // use RefreshDatabase;
    // use WithoutMiddleware;
    use AssertJson;

    public function setUp(): void
    {
        parent::setUp();
        Notification::fake();
        \Artisan::call('passport:install');

        $this->setUpAssertJson();
        $this->generate_testdata();

        // COMMENTED OUT FOR 403 Restricted Access permission Test Cases
        // $this->withoutExceptionHandling();


        // https://medium.com/@brice_hartmann/testing-laravel-password-resets-858c58c16b79
        // https://medium.com/@mscherrenberg/unit-testing-your-api-in-laravel-5-6-7172bcdc593d
        // https://laracasts.com/series/build-a-laravel-app-with-tdd/episodes/2
        // https://mattstauffer.com/blog/better-integration-testing-in-laravel-5.1-powerful-integration-tests-in-a-few-lines/
    }

    private function generate_testdata()
    {
        // API TESTING DATA
        
        $this->user = factory(User::class)->create(['email' => 'testuser@example.com']);

        $this->category = factory(Category::class)->create();

        $this->page = factory(Page::class)->create([
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
        ])->each(function ($page) {
            $page->content()->save(factory(PageContent::class)->make());
        });
        
        $this->media = factory(Media::class)->create([
            'user_id' => $this->user->id,
        ]);
    }
}
