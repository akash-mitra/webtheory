<?php

namespace Tests\Feature;

use Tests\TestDataSetup;
use App\Menu;

class MenuTest extends TestDataSetup
{
    /* Menu Index */
    public function test_menu_index()
    {
        $menu = factory(Menu::class)->create([
            'menuable_id' => $this->category->id,
            'menuable_type' => 'App\Category',
            'sequence_num' => 1,
        ]);

        // Unauthenticated user cannot view menus listing
        $response = $this->get('/api/menus');
        $response->assertStatus(302);

        // Authenticated user can view menus listing
        $response = $this->actingAs($this->adminUser)->get('/api/menus');
        $response->assertStatus(200)->assertJsonStructureExact([
            '*' => $this->menu_attributes_list,
        ]);
        $this->assertDatabaseHas('menus', ['title' => $menu->title]);
    }

    /* Menu Show */
    public function test_menu_show()
    {
        $menu = factory(Menu::class)->create([
            'menuable_id' => $this->category->id,
            'menuable_type' => 'App\Category',
            'sequence_num' => 1,
        ]);

        // Unauthenticated user cannot view menu
        $response = $this->get('/api/menus/' . $menu->id);
        $response->assertStatus(302);

        // Authenticated user can view menu
        $response = $this->actingAs($this->adminUser)->get('/api/menus/' . $menu->id);
        $response
            ->assertStatus(200)
            ->assertJsonFragment(['title' => $menu->title])
            ->assertJsonStructureExact($this->menu_attributes_list);
        $this->assertDatabaseHas('menus', ['title' => $menu->title]);
    }

//    /* Menu Store */
//    public function test_menu_store()
//    {
//        $menu = factory(Menu::class)->make([
//            'menuable_id' => $this->category->id,
//            'menuable_type' => 'App\Category',
//            'sequence_num' => 1,
//        ]);
//
//        // Unauthenticated user cannot save menu
//        $response = $this->post('/api/menus', $menu->toArray(), [
//            'Accept' => 'application/json',
//        ]);
//        $response->assertStatus(401)->assertJson(['message' => 'Unauthenticated.']);
//
//        // Registered user cannot save menu
//        $response = $this->actingAs($this->registeredUser)->post(
//            '/api/menus',
//            $menu->toArray(),
//            ['Accept' => 'application/json']
//        );
//        $response->assertStatus(403)->assertJson(['message' => 'Restricted Access']);
//
//        // Authenticated user can save menu
//        $response = $this->actingAs($this->adminUser)->post(
//            '/api/menus',
//            $menu->toArray(),
//            ['Accept' => 'application/json']
//        );
//        $response
//            ->assertStatus(200)
//            ->assertJsonFragment(['title' => $menu->title])
//            ->assertJsonStructureExact([
//                'title',
//                'alias',
//                'parent_id',
//                'sequence_num',
//                'menuable_id',
//                'menuable_type',
//                'home',
//                'updated_at',
//                'created_at',
//                'id',
//            ]);
//        $this->assertDatabaseHas('menus', ['title' => $menu->title]);
//    }

    /* Menu Update */
//    public function test_menu_update()
//    {
//        $menu = factory(Menu::class)->create([
//            'title' => 'Test Menu',
//            'menuable_id' => $this->category->id,
//            'menuable_type' => 'App\Category',
//            'sequence_num' => 1,
//        ]);
//        $menu->title = 'Test Menu Updated';
//
//        // Unauthenticated user cannot update menu
//        $response = $this->put('/api/menus/' . $menu->id, $menu->toArray(), [
//            'Accept' => 'application/json',
//        ]);
//        $response->assertStatus(401)->assertJson(['message' => 'Unauthenticated.']);
//
//        // Registered user cannot update menu
//        $response = $this->actingAs($this->registeredUser)->put(
//            '/api/menus/' . $menu->id,
//            $menu->toArray(),
//            ['Accept' => 'application/json']
//        );
//        $response->assertStatus(403)->assertJson(['message' => 'Restricted Access']);
//
//        // Authenticated user can update menu
//        $response = $this->actingAs($this->adminUser)->put(
//            '/api/menus/' . $menu->id,
//            $menu->toArray(),
//            ['Accept' => 'application/json']
//        );
//        $response
//            ->assertStatus(200)
//            ->assertJsonFragment(['title' => 'Test Menu Updated'])
//            ->assertJsonStructureExact([
//                'id',
//                'title',
//                'alias',
//                'parent_id',
//                'sequence_num',
//                'menuable_id',
//                'menuable_type',
//                'home',
//                'created_at',
//                'updated_at',
//            ]);
//        $this->assertDatabaseHas('menus', ['title' => 'Test Menu Updated']);
//        $this->assertDatabaseMissing('menus', ['title' => 'Test Menu']);
//    }

    /* Menu Upsert */
    public function test_menu_upsert1()
    {
        $menus = [];
        $menu1 = factory(Menu::class)->make([
            'menuable_id' => $this->category->id,
            'menuable_type' => 'App\Category',
            'sequence_num' => 1,
        ]);
        array_push($menus, $menu1->toArray());

        $menu2 = factory(Menu::class)->make([
            'menuable_id' => $this->page->id,
            'menuable_type' => 'App\Page',
            'sequence_num' => 2,
        ]);
        array_push($menus, $menu2->toArray());

        $menu = ['menus' => $menus];

        // Unauthenticated user cannot save menu
        $response = $this->post('/api/menus', $menu, [
            'Accept' => 'application/json',
        ]);
        $response->assertStatus(401)->assertJson(['message' => 'Unauthenticated.']);

        // Registered user cannot save menu
        $response = $this->actingAs($this->registeredUser)->post(
            '/api/menus',
            $menu,
            ['Accept' => 'application/json']
        );
        $response->assertStatus(403)->assertJson(['message' => 'Restricted Access']);

        // Authenticated user can save menu
        $response = $this->actingAs($this->adminUser)->post(
            '/api/menus',
            $menu,
            ['Accept' => 'application/json']
        );

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'menus' => [
                    '*' => [
                        'id',
                        'title',
                        'alias',
                        'parent_id',
                        'sequence_num',
                        'menuable_id',
                        'menuable_type',
                        'home',
                        'created_at',
                        'updated_at',
                    ]
                ]
            ]);
        $this->assertDatabaseHas('menus', ['title' => $menu1->title]);
    }

    public function test_menu_upsert2()
    {
        $menus = [];
        $menu1 = factory(Menu::class)->create([
            'title' => 'Test Menu',
            'menuable_id' => $this->category->id,
            'menuable_type' => 'App\Category',
            'sequence_num' => 1,
        ]);
        $menu1->title = 'Test Menu Updated';
        array_push($menus, $menu1->toArray());

        $menu2 = factory(Menu::class)->make([
            'menuable_id' => $this->page->id,
            'menuable_type' => 'App\Page',
            'sequence_num' => 2,
        ]);
        array_push($menus, $menu2->toArray());

        $menu = ['menus' => $menus];

        $response = $this->actingAs($this->adminUser)->post(
            '/api/menus',
            $menu,
            ['Accept' => 'application/json']
        );

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'menus' => [
                    '*' => [
                        'id',
                        'title',
                        'alias',
                        'parent_id',
                        'sequence_num',
                        'menuable_id',
                        'menuable_type',
                        'home',
                        'created_at',
                        'updated_at',
                    ]
                ]
            ]);

        $this->assertDatabaseHas('menus', ['title' => 'Test Menu Updated']);
        $this->assertDatabaseMissing('menus', ['title' => 'Test Menu']);
        $this->assertDatabaseHas('menus', ['title' => $menu2->title]);
    }

    /* Menu Destroy */
    public function test_menu_destroy()
    {
        $menu = factory(Menu::class)->create([
            'menuable_id' => $this->category->id,
            'menuable_type' => 'App\Category',
            'sequence_num' => 1,
        ]);

        // Unauthenticated user cannot delete menu
        $response = $this->delete(
            '/api/menus/' . $menu->id,
            [],
            ['Accept' => 'application/json']
        );
        $response->assertStatus(401)->assertJson(['message' => 'Unauthenticated.']);

        // Registered user cannot delete menu
        $response = $this->actingAs($this->registeredUser)->delete(
            '/api/menus/' . $menu->id,
            [],
            ['Accept' => 'application/json']
        );
        $response->assertStatus(403)->assertJson(['message' => 'Restricted Access']);

        // Authenticated user can delete menu
        $response = $this->actingAs($this->adminUser)->delete(
            '/api/menus/' . $menu->id,
            [],
            ['Accept' => 'application/json']
        );
        $response->assertStatus(204);
        $this->assertDatabaseMissing('menus', ['title' => $menu->title]);
    }
}
