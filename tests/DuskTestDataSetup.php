<?php

namespace Tests;

use App\Page;
use App\User;
use App\Media;
use App\Category;
use App\PageContent;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Event;

class DuskTestDataSetup extends DuskTestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        Notification::fake();
        Mail::fake();
        Queue::fake();
        Event::fake();

        $this->seed();

        $this->generateTestdata();

        // COMMENTED OUT FOR 403 Restricted Access permission Test Cases
        // $this->withoutExceptionHandling();
    }

    private function generateTestdata()
    {
        // API TESTING DATA
        $this->adminUser = factory(User::class)->create(['email' => 'adminuser@example.com', 'role' => 'admin']);
        $this->authorUser1 = factory(User::class)->create(['email' => 'authoruser1@example.com', 'role' => 'author']);
        $this->authorUser2 = factory(User::class)->create(['email' => 'authoruser2@example.com', 'role' => 'author']);
        $this->registeredUser = factory(User::class)->create(['email' => 'registereduser@example.com', 'role' => 'registered']);
        $this->user = factory(User::class)->create(['email' => 'testuser@example.com']);

        $this->media = factory(Media::class)->create([
            'user_id' => $this->adminUser->id,
        ]);

        $this->category = factory(Category::class)->create([
            'user_id' => $this->adminUser->id,
        ]);

        $this->page = factory(Page::class)->create([
            'category_id' => $this->category->id,
            'user_id' => $this->adminUser->id,
            'status' => 'Live',
        ]);
        $this->pagecontent = factory(PageContent::class)->create([
            'page_id' => $this->page->id
        ]);
    }
}
