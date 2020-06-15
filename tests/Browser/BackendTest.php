<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestDataSetup;
use App\Category;
use App\Page;
use App\User;

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
                ->pause(1000)
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
                ->pause(1000)
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
                ->pause(1000)
                ->assertSee('Pages')
                ->assertSee($page->title);
        });
    }

    /**
     * Test App Users Listing.
     *
     * @return void
     */
    public function test_app_users()
    {
        $user = factory(User::class)->create([
            'role' => 'author'
        ]);

        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($this->adminUser)
                ->visit('/app/users')
                ->pause(1000)
                ->assertSee('Users')
                ->assertSee($user->name);
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
     * Test App Page Create.
     *
     * @return void
     */
    public function test_app_page_create()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                ->visit('/app/pages/create')
                ->pause(1000)
                ->press('Save')
                ->assertSee('Page has no title')
                ->press('OK')
                ->type('title', 'My Test Page')
                ->press('Save')
                ->assertSee('Provide an Introduction')
                ->press('OK')
                ->type('intro', 'My Test Page Introduction')
                ->press('Save')
                ->pause(1000)
                ->assertSee('Page Contents are Saved')
                ->visit('/app/pages')
                ->pause(1000)
                ->assertSee('My Test Page');
            $this->assertDatabaseHas('pages', ['title' => 'My Test Page']);
        });
    }

    /**
     * Test App User Create.
     *
     * @return void
     */
    public function test_app_user_create()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                ->visit('/app/users/create')
                ->pause(1000)
                ->press('Save')
                ->assertSee('User has no name')
                ->press('OK')
                ->type('#userName', 'Dummy Author')
                ->press('Save')
                ->assertSee('User has no email')
                ->press('OK')
                ->type('#userEmail', 'dummy.author@test.com')
                ->press('Save')
                ->assertSee('User must have a role')
                ->press('OK')
                ->select('#role', 'author')
                ->press('Save')
                ->pause(1000)
                ->assertSee('User Saved Successfully')
                ->visit('/app/users')
                ->pause(1000)
                ->assertSee('Dummy Author');
            $this->assertDatabaseHas('users', ['name' => 'Dummy Author']);
        });
    }
}
