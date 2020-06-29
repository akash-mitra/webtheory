<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestDataSetup;
use App\Page;
use Illuminate\Support\Str;

class PageTest extends DuskTestDataSetup
{
    /**
     * Test App Pages Listing.
     *
     * @return void
     */
    public function test_app_pages()
    {
        $page = $this->page;
        $this->browse(function (Browser $browser) use($page) {
            $browser->loginAs($this->adminUser)
                ->visit('/app/pages')
                ->pause(1000)
                ->assertSee('Pages')
                ->assertSee($page->title);
        });
    }

    /**
     * Test App Pages Listing Draft.
     *
     * @return void
     */
    public function test_app_pages_draft()
    {
        $page = $this->draftPage;
        $this->browse(function (Browser $browser) use($page) {
            $browser->loginAs($this->adminUser)
                ->visit('/app/pages')
                ->pause(1000)
                ->assertSee('Pages')
                ->click('#draft-tab')
                ->assertSee($page->title);
        });
    }

    /**
     * Test App Page Search.
     *
     * @return void
     */
    public function test_app_page_search()
    {
        $page = $this->draftPage;
        $this->browse(function (Browser $browser) use($page) {
            $browser->loginAs($this->adminUser)
                ->visit('/app/pages')
                ->pause(1000)
                ->assertSee('Pages')
                ->type('search', $page->title)
                ->pause(1000)
                ->assertSee($page->title)
                ->click('#draft-tab')
                ->assertSee($page->title);
        });
    }

    /**
     * Test App Page Show.
     *
     * @return void
     */
    public function test_app_page_show()
    {
        $page = $this->page;
        $this->browse(function (Browser $browser) use($page) {
            $browser->loginAs($this->adminUser)
                ->visit('/app/pages')
                ->pause(1000)
                ->assertSee('Pages')
                ->press('#show-page-' . $page->id)
                ->pause(1000)
                ->assertPathIs('/app/pages/' . $page->id)
                ->assertInputValue('title', $page->title);
        });
    }

    /**
     * Test App Page View.
     *
     * @return void
     */
    public function test_app_page_view()
    {
        $page = $this->page;
        $this->browse(function (Browser $browser) use($page) {
            $response = $browser->loginAs($this->adminUser)
                ->visit('/app/pages')
                ->pause(1000)
                ->assertSee('Pages')
                ->press('#view-page-' . $page->id);
            
            $response->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());
            $browser
                ->pause(1000)
                ->assertPathIs('/pages/' . $page->id . '/' . Str::slug($page->title))
                ->assertSee($page->title);
        });
    }

    /**
     * Test App Page Change Status.
     *
     * @return void
     */
    // public function test_app_page_change_status()
    // {
    //     $page = $this->draftPage;
    //     $this->browse(function (Browser $browser) use($page) {
    //         $response = $browser->loginAs($this->adminUser)
    //             ->visit('/app/pages')
    //             ->pause(1000)
    //             ->assertSee('Pages')
    //             ->click('#draft-tab')
    //             ->assertSee($page->title)
    //             ->press('#change-status-page-' . $page->id)
    //             ->pause(1000)
    //             // ->assertSee('Status Updated Page in Live mode now')
    //             ->click('#all-tab')
    //             ->assertSee($page->title);
    //     });
    // }

    /**
     * Test App Page Create.
     *
     * @return void
     */
    // public function test_app_page_create()
    // {
    //     $this->browse(function (Browser $browser) {
    //         $browser->loginAs($this->adminUser)
    //             ->visit('/app/pages/create')
    //             ->pause(1000)
    //             ->press('Save')
    //             ->assertSee('Page has no title')
    //             ->press('OK')
    //             ->type('title', 'My Test Page')
    //             ->press('Save')
    //             ->assertSee('Provide an Introduction')
    //             ->press('OK')
    //             ->type('intro', 'My Test Page Introduction')
    //             // ->keys('intro', ['{tab}'])
    //             ->press('Save')
    //             ->pause(1000)
    //             ->assertSee('Page Contents are Saved')
    //             ->visit('/app/pages')
    //             ->pause(1000)
    //             ->assertSee('My Test Page');
    //         $this->assertDatabaseHas('pages', ['title' => 'My Test Page']);
    //     });
    // }
}
