<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestDataSetup;
use App\User;

class UserTest extends DuskTestDataSetup
{
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
     * Test App User Search.
     *
     * @return void
     */
    public function test_app_user_search()
    {
        $user = factory(User::class)->create([
            'role' => 'author',
            'email_verified_at' => null,
        ]);

        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($this->adminUser)
                ->visit('/app/users')
                ->pause(1000)
                ->assertSee('Users')
                ->type('search', $user->name)
                ->pause(1000)
                ->assertSee($user->name)
                ->click('#user-unverified-tab')
                ->assertSee($user->name);
        });
    }

    /**
     * Test App User Show.
     *
     * @return void
     */
    public function test_app_user_show()
    {
        $user = factory(User::class)->create([
            'role' => 'author',
            'email_verified_at' => null,
        ]);

        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($this->adminUser)
                ->visit('/app/users')
                ->pause(1000)
                ->assertSee('Users')
                ->press('#show-user-' . $user->id)
                ->pause(1000)
                ->assertPathIs('/app/users/' . $user->id)
                ->assertInputValue('#userName', $user->name);
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

    /**
     * Test App User Update.
     *
     * @return void
     */
    // public function test_app_user_update()
    // {
    // }

    /**
     * Test App User Ban.
     *
     * @return void
     */
    public function test_app_user_ban()
    {
        $user = factory(User::class)->create([
            'role' => 'author',
        ]);

        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($this->adminUser)
                ->visit('/app/users')
                ->pause(1000)
                ->assertSee('Users')
                ->assertSee($user->name)
                ->press('#ban-user-' . $user->id)
                ->assertSee('Ban this user?')
                ->press('Confirm')
                ->pause(1000)
                ->assertSee('User Banned')
                ->press('OK')
                ->click('#user-banned-tab')
                ->assertSee($user->name);
        });
    }

    /**
     * Test App User Unban.
     *
     * @return void
     */
    // public function test_app_user_unban()
    // {
    // }
}
