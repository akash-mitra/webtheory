<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestDataSetup;

class CategoryTest extends DuskTestDataSetup
{
    /**
     * Test Category Create.
     *
     * @return void
     */
    public function testCategoryCreate()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/app/login')
                    ->waitForText('WebTheory')
                    ->type('Email', $this->adminUser->email)
                    ->type('password', 'password')
                    ->press('Login Now')
                    ->pause(200)
                    ->visit('/app/categories/create')
                    ->type('#categoryName', 'Test Category')
                    ->type('#categoryDescription', 'Test Category Description')
                    ->press('Save')
                    ->pause(200)
                    ->assertSee('Category Saved Successfully')
                    ->visit('/app/categories')
                    ->waitForText('categories')
                    ->assertSee('Test Category');
            $this->assertDatabaseHas('categories', ['name' => 'Test Category']);
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
