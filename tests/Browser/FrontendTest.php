<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestDataSetup;

class FrontendTest extends DuskTestDataSetup
{
    /**
     * Test Home Page.
     *
     * @return void
     */
    public function test_home()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('My Blog')
                ->assertSee('Made with WebTheory');
        });
    }

    /**
     * Test Page View.
     *
     * @return void
     */
    public function test_pages_show()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/pages/' . $this->page->id)
                ->assertSee($this->page->title);
        });
        $this->assertDatabaseHas('views', ['content_type' => 'App\Page', 'content_id' => $this->page->id, 'browser' => 'HeadlessChrome']);
    }

    /**
     * Test Category View.
     *
     * @return void
     */
    public function test_categories_show()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/categories/' . $this->category->id)
                ->assertSee($this->category->name);
        });
        $this->assertDatabaseHas('views', ['content_type' => 'App\Category', 'content_id' => $this->category->id, 'browser' => 'HeadlessChrome']);
    }

    /**
     * Test Profile View.
     *
     * @return void
     */
    public function test_profiles_show()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/profiles/' . $this->adminUser->public_id)
                ->assertSee($this->adminUser->name)
                ->assertSee($this->adminUser->role);
        });
        $this->assertDatabaseHas('views', ['content_type' => 'App\User', 'content_id' => $this->adminUser->id, 'browser' => 'HeadlessChrome']);
    }

    /**
     * Test Sitemap.
     *
     * @return void
     */
    public function test_sitemap()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/sitemap')
                ->assertSee('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">')
                ->assertSee('<loc>' . env('APP_URL') . '</loc>');
        });
    }

    /**
     * Test Rss.
     *
     * @return void
     */
    public function test_rss()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/rss')
                ->assertSee('<rss version="2.0">')
                ->assertSee('<title>My Blog Title</title>')
                ->assertSee('<link>' . env('APP_URL') . '</link>')
                ->assertSee('<description>My Blog Description</description>');
        });
    }

    /**
     * Test Privacy.
     *
     * @return void
     */
    public function test_privacy()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/privacy')
                ->assertSee('Privacy Policy')
                ->assertSee('At "My Blog", accessible from ' . env('APP_URL') . ', one of our main priorities is the privacy of our visitors.');
        });
    }

    /**
     * Test Terms.
     *
     * @return void
     */
    public function test_terms()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/terms')
                ->assertSee('Terms of Use')
                ->assertSee('You may view and/or print pages from ' . env('APP_URL') . ' for your own personal use subject to restrictions set in these terms of service.');
        });
    }
}
