<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestDataSetup;

class ViewTest extends DuskTestDataSetup
{
    /**
     * Test Category Visit.
     *
     * @return void
     */
    public function testCategoryView()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/categories/' . $this->category->id)
                    ->pause(200)
                    ->waitForText('My Blog')
                    ->assertSee($this->category->name);
        });
        $this->assertDatabaseHas('views', ['content_type' => 'App\Category', 'content_id' => $this->category->id, 'browser' => 'HeadlessChrome']);
    }

    /**
     * Test Page Visit.
     *
     * @return void
     */
    public function testPageView()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/pages/' . $this->page->id)
                    ->pause(200)
                    ->waitForText('My Blog')
                    ->assertSee($this->page->title);
        });
        $this->assertDatabaseHas('views', ['content_type' => 'App\Page', 'content_id' => $this->page->id, 'browser' => 'HeadlessChrome']);
    }

    /**
     * Test Page Visit.
     *
     * @return void
     */
    public function testLatestPageView()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->pause(200)
                    ->waitForText('My Blog')
                    ->clickLink('Continue Reading...')
                    ->pause(200)
                    ->assertPathBeginsWith('/pages');
        });
        $this->assertDatabaseHas('views', ['content_type' => 'App\Page', 'browser' => 'HeadlessChrome']);
    }

    
}
