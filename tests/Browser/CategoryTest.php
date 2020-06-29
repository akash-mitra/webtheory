<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestDataSetup;
use App\Category;

class CategoryTest extends DuskTestDataSetup
{
    /**
     * Test App Categories Listing.
     *
     * @return void
     */
    public function test_app_categories()
    {
        $category = $this->category;
        $this->browse(function (Browser $browser) use($category) {
            $browser->loginAs($this->adminUser)
                ->visit('/app/categories')
                ->pause(1000)
                ->assertSee('Categories')
                ->assertSee($category->name);
        });
    }

    /**
     * Test App Category Search.
     *
     * @return void
     */
    public function test_app_category_search()
    {
        $category = $this->category;
        $this->browse(function (Browser $browser) use($category) {
            $browser->loginAs($this->adminUser)
                ->visit('/app/categories')
                ->pause(1000)
                ->assertSee('Categories')
                ->type('search', $category->name)
                ->pause(1000)
                ->assertSee($category->name);
        });
    }

    /**
     * Test App Category Show.
     *
     * @return void
     */
    public function test_app_category_show()
    {
        $category = $this->category;
        $this->browse(function (Browser $browser) use($category) {
            $browser->loginAs($this->adminUser)
                ->visit('/app/categories')
                ->pause(1000)
                ->assertSee('Categories')
                ->press('#show-category-' . $category->id)
                ->pause(1000)
                ->assertPathIs('/app/categories/' . $category->id)
                ->assertInputValue('#categoryName', $category->name);
        });
    }

    /**
     * Test App Category View.
     *
     * @return void
     */
    public function test_app_category_view()
    {
        $category = $this->category;
        $this->browse(function (Browser $browser) use($category) {
            $browser->loginAs($this->adminUser)
                ->visit('/app/categories')
                ->pause(1000)
                ->assertSee('Categories')
                ->press('#view-category-' . $category->id)
                ->pause(1000)
                ->assertPathIs('/categories/' . $category->id)
                ->assertSee($category->name);
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
                ->pause(1000)
                ->press('Save')
                ->assertSee('Category has no name')
                ->press('OK')
                ->type('#categoryName', 'My Test Category')
                ->press('Save')
                ->assertSee('Provide a description')
                ->press('OK')
                ->type('#categoryDescription', 'My Test Category Description')
                ->select('#parent_id', 'uncategorized')
                ->click('#category-meta-tab')
                ->type('#metadesc', 'My Test Category Description Dummy')
                ->click('#copyCatDesc')
                ->assertInputValue('#metadesc', 'My Test Category Description')
                ->type('#metakey', 'Test Category')
                ->press('Save')
                ->pause(1000)
                ->assertSee('Category Saved Successfully')
                ->visit('/app/categories')
                ->pause(1000)
                ->assertSee('My Test Category');
            $this->assertDatabaseHas('categories', ['name' => 'My Test Category']);
        });
    }

    /**
     * Test App Categories Update.
     *
     * @return void
     */
    public function test_app_category_update()
    {
        $category = $this->category;
        $this->browse(function (Browser $browser) use($category) {
            $browser->loginAs($this->adminUser)
                ->visit('/app/categories/' . $category->id)
                ->pause(1000)
                ->assertSee('Categories')
                ->assertSee($category->name)
                ->type('#categoryName', 'My Test Category')
                ->press('Save')
                ->pause(1000)
                ->assertSee('My Test Category');
            $this->assertDatabaseHas('categories', ['name' => 'My Test Category']);
        });
    }

    /**
     * Test App Categories Delete.
     *
     * @return void
     */
    public function test_app_category_delete()
    {
        $category = factory(Category::class)->create([
            'user_id' => $this->adminUser->id,
        ]);

        $this->browse(function (Browser $browser) use($category) {
            $browser->loginAs($this->adminUser)
                ->visit('/app/categories/' . $category->id)
                ->pause(1000)
                ->assertSee('Categories')
                ->assertSee($category->name)
                ->press('#deleteCategory')
                ->assertSee('Delete this category?')
                ->press('Confirm')
                ->pause(1000)
                ->assertDontSee($category->name);
            $this->assertSoftDeleted('categories', ['name' => $category->name]);
        });
    }
}
