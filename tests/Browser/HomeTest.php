<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestDataSetup;

class HomeTest extends DuskTestDataSetup
{
    /**
     * Test Home Page.
     *
     * @return void
     */
    public function testRoot()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('My Blog');
        });
    }
}
