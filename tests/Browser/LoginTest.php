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

    /**
     * Test User Logout.
     *
     * @return void
     */
    public function test_user_logout()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                ->visit('/')
                ->assertSee($this->adminUser->name)
                ->press('#user-strip')
                ->assertSee('Logout')
                ->press('Logout')
                ->assertPathIs('/')
                ->assertDontSee($this->adminUser->name);
        });
    }
}
