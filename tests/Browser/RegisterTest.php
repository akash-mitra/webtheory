<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestDataSetup;

class RegisterTest extends DuskTestDataSetup
{
    /**
     * Test User Registration.
     *
     * @return void
     */
    public function test_user_registration()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->press('#login-modal')
                ->assertSee('New Account?')
                ->press('#register-form')
                ->type('name', 'tester')
                ->type('email', 'tester@test.com')
                ->type('email_confirmation', 'tester@test.com')
                ->type('password', 'password')
                ->press('Sign Up')
                ->pause(1000)
                ->assertPathIs('/')
                ->assertSee('tester');
        });
    }
}
