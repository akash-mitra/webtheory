<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestDataSetup;

class TemplateTest extends DuskTestDataSetup
{
    /**
     * Test App Dashboard.
     *
     * @return void
     */
    public function test_app_templates()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                ->visit('/app/templates')
                ->pause(1000)
                ->assertSee('Templates')
                ->click('#template-installed-tab')
                ->pause(1000)
                ->assertSee('Serenity')
                ->click('#template-available-tab')
                ->pause(1000)
                ->assertSee('Serenity')
                ->assertSee('Serenity Dark');
        });
    }
}
