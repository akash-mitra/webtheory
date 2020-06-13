<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestDataSetup;
use App\Category;
use App\Page;

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
                ->pause(200)
                ->assertSee('WebTheory')
                ->assertSee('Pages')
                ->assertSee('Categories')
                ->assertSee('Gallery')
                ->assertSee('Users')
                ->assertSee('Templates')
                ->assertSee('Settings')
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
        $category = factory(Category::class)->create([
            'user_id' => $this->adminUser->id,
        ]);

        $this->browse(function (Browser $browser) use($category) {
            $browser->loginAs($this->adminUser)
                ->visit('/app/categories')
                ->pause(200)
                ->assertSee('Categories')
                ->assertSee($category->name);
        });
    }

    /**
     * Test App Pages Listing.
     *
     * @return void
     */
    public function test_app_pages()
    {
        $page = factory(Page::class)->create([
            'category_id' => $this->category->id,
            'user_id' => $this->adminUser->id,
            'status' => 'Live',
        ]);

        $this->browse(function (Browser $browser) use($page) {
            $browser->loginAs($this->adminUser)
                ->visit('/app/pages')
                ->pause(200)
                ->assertSee('Pages')
                ->assertSee($page->title);
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
                ->visit('/app/categories/create')
                ->pause(200)
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
                ->assertSee('My Test Category');
            $this->assertDatabaseHas('categories', ['name' => 'My Test Category']);
        });
    }


}
