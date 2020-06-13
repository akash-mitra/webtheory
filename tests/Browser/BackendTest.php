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
                ->assertSee('WebTheory')
                ->pause(200)
                ->assertSee('Dashboard');
        });
    }

    /**
     * Test App Categories Listing.
     *
     * @return void
     */
    public function test_app_categories()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                ->visit('/app/categories')
                ->assertSee('WebTheory')
                ->pause(200)
                ->assertSee('Uncategorised');
        });
    }

    /**
     * Test App Category Create.
     *
     * @return void
     */
    public function test_app_category_create()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                ->visit('/app/login')
                ->visit('/app/categories/create')
                ->press('Save')
                ->assertSee('Category has no name')
                ->press('OK')
                ->type('#categoryName', 'My Test Category')
                ->press('Save')
                ->assertSee('Provide a description')
                ->press('OK')
                ->type('#categoryDescription', 'My Test Category Description')
                ->press('Save')
                ->pause(200)
                ->assertSee('Category Saved Successfully')
                ->visit('/app/categories')
                ->pause(200)
                // ->waitForText('categories')
                ->assertSee('My Test Category');
            $this->assertDatabaseHas('categories', ['name' => 'My Test Category']);
        });
    }
}
