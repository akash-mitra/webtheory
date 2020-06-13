<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestDataSetup;

class BackendTest extends DuskTestDataSetup
{
    /**
     * Test App Dashboard.
     *
     * @return void
     */
    public function test_app_dashboard()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                ->visit('/app')
                ->pause(200)
                ->assertSee('WebTheory')
                ->assertSee('Pages')
                ->assertSee('Categories')
                ->assertSee('Gallery')
                ->assertSee('Users')
                ->assertSee('Templates')
                ->assertSee('Settings')
                ->assertSee('Dashboard');
        });
    }

    /**
     * Test App Categories Listing.
     *
     * @return void
     */
    public function test_app_categories()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                ->visit('/app/categories')
                ->pause(200)
                ->assertSee('Categories')
                ->assertSee('Uncategorised');
        });
    }
}
