<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestDataSetup;

class UserStripTest extends DuskTestDataSetup
{   
    /**
     * Test User Profile.
     *
     * @return void
     */
    public function test_user_profile()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                ->visit('/')
                ->assertSee($this->adminUser->name)
                ->press('#user-strip')
                ->assertSee('Profile')
                ->press('#user-profile')
                ->assertPathIs('/profiles/' . $this->adminUser->public_id)
                ->assertSee($this->adminUser->name)
                ->assertSee($this->adminUser->role)
                ->assertSee($this->adminUser->about_me);
        });
    }

    /**
     * Test Control Panel.
     *
     * @return void
     */
    public function test_control_panel()
    {
        $this->browse(function (Browser $browser) {
            $response = $browser->loginAs($this->adminUser)
                ->visit('/')
                ->assertSee($this->adminUser->name)
                ->press('#user-strip')
                ->assertSee('Control Panel')
                ->press('#control-panel');

            $response->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());
            $browser
                // ->pause(1000)
                ->assertPathIs('/app')
                ->assertSee('WebTheory')
                ->assertSee('Pages')
                ->assertSee('Categories')
                ->assertSee('Library')
                ->assertSee('Users')
                ->assertSee('Templates')
                ->assertSee('Forms')
                ->assertSee('Settings');
        });
    }

    /**
     * Test Edit this Page.
     *
     * @return void
     */
    public function test_edit_this_page()
    {
        $this->browse(function (Browser $browser) {
            $response = $browser->loginAs($this->adminUser)
                ->visit('/pages/' . $this->page->id)
                ->assertSee($this->adminUser->name)
                ->press('#user-strip')
                ->assertSee('Edit this page')
                ->press('#edit-this-page');

            $response->driver->switchTo()->window(collect($browser->driver->getWindowHandles())->last());
            $browser
                ->pause(1000)
                ->assertPathIs('/app/pages/' . $this->page->id)
                ->assertInputValue('title', $this->page->title)
                ->assertInputValue('intro', $this->page->summary);
        });
    }

    /**
     * Test Update Profile Page.
     *
     * @return void
     */
    public function test_update_profile_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                ->visit('/profiles/' . $this->adminUser->public_id)
                ->assertSee($this->adminUser->name)
                ->press('#update-profile')
                ->assertInputValue('name', $this->adminUser->name)
                ->assertInputValue('about_me', $this->adminUser->about_me)
                ->type('name', 'Test Bot')
                ->type('about_me', 'I am Test Bot')
                ->press('Save')
                ->pause(1000)
                ->assertPathIs('/profiles/' . $this->adminUser->public_id)
                ->assertSee('Test Bot')
                ->assertSee('I am Test Bot');
        });
    }
}
