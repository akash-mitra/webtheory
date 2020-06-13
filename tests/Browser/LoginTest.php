<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestDataSetup;

class LoginTest extends DuskTestDataSetup
{   
    /**
     * Test User Login.
     *
     * @return void
     */
    public function test_user_login()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->press('#login-modal')
                ->type('email', $this->adminUser->email)
                ->type('password', 'password1')
                ->press('Log in')
                ->assertSee('These credentials do not match our records.')
                ->type('password', 'password')
                ->press('Log in')
                ->assertPathIs('/')
                ->assertSee($this->adminUser->name);
        });
    }
}
