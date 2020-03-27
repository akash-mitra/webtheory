<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestDataSetup;

class LoginTest extends DuskTestDataSetup
{
    /**
     * Test Admin Login.
     *
     * @return void
     */
    public function testAdminLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/app/login')
                    ->waitForText('WebTheory')
                    ->type('Email', $this->adminUser->email)
                    ->type('password', 'password')
                    ->press('Login Now')
                    ->pause(200)
                    ->assertPathIs('/app/pages')
                    ->assertSee('Pages')
                    ->visit('/app/topics')
                    ->assertSee('Topics')
                    ->visit('/app/templates')
                    ->assertSee('Templates');
        });
    }

    /**
     * Test Admin Logout.
     *
     * @return void
     */
    public function testAdminLogout()
    {
        $this->browse(function (Browser $browser) {
            
            $browser->visit('/app/login')
                    ->waitForText('WebTheory')
                    ->type('Email', $this->adminUser->email)
                    ->type('password', 'password')
                    ->press('Login Now')
                    ->waitForText('Pages')
                    ->pause(200)
                    ->click('#user-menu')
                    ->assertSee($this->adminUser->name)
                    ->click('#user-menu > div > div:nth-child(3)')
                    ->assertSee('Do you want to logout now?')
                    ->press('Confirm')
                    ->assertPathIs('/app/login');
        });
    }
}
