<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestDataSetup;

class SettingTest extends DuskTestDataSetup
{
    /**
     * Test App Dashboard.
     *
     * @return void
     */
    public function test_app_settings_site()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                ->visit('/app/settings')
                ->pause(1000)
                ->assertSee('Settings')
                ->click('#settings-site-tab')
                ->pause(1000)
                ->assertInputValue('#sitename', 'My Blog')
                ->assertInputValue('#siteTitle', 'My Blog Title')
                ->assertInputValue('#sitedesc', 'My Blog Description')
                ->type('#sitename', 'My Test Blog')
                ->type('#siteTitle', 'My Test Blog Title')
                ->type('#sitedesc', 'My Test Blog Description')
                ->press('Save Configurations')
                ->pause(1000)
                ->assertSee('Site configurations are successfully saved.')
                ->press('OK')
                ->assertInputValue('#sitename', 'My Test Blog')
                ->assertInputValue('#siteTitle', 'My Test Blog Title')
                ->assertInputValue('#sitedesc', 'My Test Blog Description');
        });
    }
}
