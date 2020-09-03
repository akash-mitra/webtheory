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
                ->pause(1000)
                ->assertSee('WebTheory')
                ->assertSee('Pages')
                ->assertSee('Categories')
                ->assertSee('Library')
                ->assertSee('Users')
                ->assertSee('Templates')
                ->assertSee('Forms')
                ->assertSee('Settings')
                ->assertSee('METRICS')
                ->assertSee('MOST POPULAR PAGES')
                ->assertSee('TOP BROWSERS')
                ->assertSee('TOP TRAFFIC SOURCES')
                ->assertSee('RECENT COMMENTS')
                ->assertSee('NEW MEMBERS')
                ;
        });
    }
}
