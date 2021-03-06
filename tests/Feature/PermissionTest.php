<?php

namespace Tests\Feature;

use Tests\TestDataSetup;
use App\Category;
use App\Page;
use App\PageContent;
use App\Asset;
use Illuminate\Http\UploadedFile;
use App\User;
use App\Parameter;
use App\Form;
use App\FormResponse;

class PermissionTest extends TestDataSetup
{
    private array $data = []; // ['dummy' => 'dummy'];

    // App Access
    public function test_app_permission()
    {
        $this->actingAs($this->adminUser)
            ->get('/app')
            ->assertStatus(200);
        $this->actingAs($this->authorUser1)
            ->get('/app')
            ->assertStatus(200);
        $this->actingAs($this->registeredUser)
            ->get('/app')
            ->assertStatus(403);
    }

    // Parameter
    public function test_parameter_permission()
    {
        $this->actingAs($this->adminUser)
            ->get('/api/parameters/' . 'test')
            ->assertStatus(200);
        $this->actingAs($this->authorUser1)
            ->get('/api/parameters/' . 'test')
            ->assertStatus(403);
        $this->actingAs($this->registeredUser)
            ->get('/api/parameters/' . 'test')
            ->assertStatus(403);

        $this->actingAs($this->adminUser)
            ->post(
                '/api/parameters/' . 'test',
                ['value' => 'test'],
                ['Accept' => 'application/json']
            )
            ->assertStatus(200);
        $this->actingAs($this->authorUser1)
            ->post(
                '/api/parameters/' . 'test',
                ['value' => 'test'],
                ['Accept' => 'application/json']
            )
            ->assertStatus(403);
        $this->actingAs($this->registeredUser)
            ->post(
                '/api/parameters/' . 'test',
                ['value' => 'test'],
                ['Accept' => 'application/json']
            )
            ->assertStatus(403);
    }

    // Category
    public function test_category_permission()
    {
        $users = [$this->adminUser, $this->authorUser1, $this->registeredUser];
        foreach ($users as $user) {
            $this->actingAs($user);
            $this->get('/api/categories')->assertStatus(200);
            $this->get('/api/categories/' . $this->category->id)->assertStatus(200);
            $this->get('/api/categories/' . $this->category->id . '/pages')->assertStatus(200);
        }

        $users = [$this->adminUser, $this->authorUser1];
        foreach ($users as $user) {
            $this->actingAs($user);
            $category = factory(Category::class)->make();
            $this->post('/api/categories', $category->toArray(), [
                'Accept' => 'application/json',
            ])->assertStatus(200);
        }
        $this->actingAs($this->registeredUser)
            ->post('/api/categories', $this->data, ['Accept' => 'application/json'])
            ->assertStatus(403);

        $users = [$this->adminUser, $this->authorUser1];
        foreach ($users as $user) {
            $category = factory(Category::class)->create();
            $this->actingAs($user);
            $this->actingAs($user)
                ->put('/api/categories/' . $category->id, $category->toArray(), [
                    'Accept' => 'application/json',
                ])
                ->assertStatus(200);
        }
        $this->actingAs($this->registeredUser)
            ->put('/api/categories/' . $this->category->id, $this->data, [
                'Accept' => 'application/json',
            ])
            ->assertStatus(403);

        $category = factory(Category::class)->create();
        $this->actingAs($this->adminUser)
            ->delete('/api/categories/' . $category->id, [], ['Accept' => 'application/json'])
            ->assertStatus(204);
        $this->actingAs($this->authorUser1)
            ->delete('/api/categories/' . $this->category->id, [], ['Accept' => 'application/json'])
            ->assertStatus(403);
        $this->actingAs($this->registeredUser)
            ->delete('/api/categories/' . $this->category->id, [], ['Accept' => 'application/json'])
            ->assertStatus(403);
    }

    // Page
    public function test_page_permission()
    {
        $users = [$this->adminUser, $this->authorUser1, $this->registeredUser];
        foreach ($users as $user) {
            $this->actingAs($user);
            $this->get('/api/pages')->assertStatus(200);
            $this->get('/api/pages/' . $this->page->id)->assertStatus(200);
        }

        $users = [$this->adminUser, $this->authorUser1];
        foreach ($users as $user) {
            $page = [
                'category_id' => $this->category->id,
                'title' => 'Test Title',
                'summary' => 'Test Summary',
                'metakey' => 'Test, Meta, Key',
                'metadesc' => 'Test Meta Description',
                'status' => 'Live',
                'access_plan' => null,
                'contents' => [
                    [
                        'body_json' => [
                            'blocks' => [
                                [
                                    'type' => 'header',
                                    'data' => ['level' => 1, 'text' => 'Test Heading.'],
                                ],
                                ['type' => 'paragraph', 'data' => ['text' => 'Test Paragraph']],
                            ],
                        ],
                        'type' => 'editorjs',
                        'display_order' => 1,
                    ],
                ],
            ];
            $this->actingAs($user);
            $this->post('/api/pages', $page, [
                'Accept' => 'application/json',
            ])->assertStatus(200);
        }
        $this->actingAs($this->registeredUser)
            ->post('/api/pages', $this->data, ['Accept' => 'application/json'])
            ->assertStatus(403);

        $users = [$this->adminUser, $this->authorUser1];
        foreach ($users as $user) {
            $page = factory(Page::class)->create([
                'category_id' => $this->category->id,
                'user_id' => $this->adminUser->id,
                'title' => 'Test Title',
                'summary' => 'Test Summary',
                'metakey' => 'Test, Meta, Key',
                'metadesc' => 'Test Meta Description',
                'status' => 'Live',
            ]);

            $pageContent = factory(PageContent::class)->create([
                'page_id' => $page->id,
                'body_json' => [
                    'blocks' => [
                        ['type' => 'header', 'data' => ['level' => 1, 'text' => 'Test Heading']],
                        ['type' => 'paragraph', 'data' => ['text' => 'Test Paragraph.']],
                    ],
                ],
                'body_html' => '<h1>Test Heading</h1><p>Test Paragraph.</p>',
                'type' => 'editorjs',
                'display_order' => 1,
            ]);

            $page->title = 'Test Title Updated';
            $page->contents = [
                [
                    'id' => $pageContent->id,
                    'body_json' => [
                        'blocks' => [
                            [
                                'type' => 'header',
                                'data' => ['level' => 1, 'text' => 'Test Heading Updated'],
                            ],
                            [
                                'type' => 'paragraph',
                                'data' => ['text' => 'Test Paragraph Updated.'],
                            ],
                        ],
                    ],
                    'type' => 'editorjs',
                    'display_order' => 1,
                ],
            ];
            $this->actingAs($user);
            $this->put('/api/pages/' . $page->id, $page->toArray(), [
                'Accept' => 'application/json',
            ])->assertStatus(200);
        }
        $this->actingAs($this->registeredUser)
            ->put('/api/pages/' . $this->page->id, $this->data, ['Accept' => 'application/json'])
            ->assertStatus(403);

        $this->actingAs($this->adminUser)
            ->put('/api/pages/' . $this->page->id . '/status', ['status' => 'Live'])
            ->assertStatus(200);
        $this->actingAs($this->authorUser1)
            ->put('/api/pages/' . $this->page->id . '/status', ['status' => 'Live'])
            ->assertStatus(200);
        $this->actingAs($this->registeredUser)
            ->put('/api/pages/' . $this->page->id . '/status', ['status' => 'Live'])
            ->assertStatus(403);

        $this->actingAs($this->adminUser)
            ->put('/api/pages/' . $this->page->id . '/owner', $page->toArray())
            ->assertStatus(200);
        $this->actingAs($this->authorUser1)
            ->put('/api/pages/' . $this->page->id . '/owner', $page->toArray())
            ->assertStatus(403);
        $this->actingAs($this->registeredUser)
            ->put('/api/pages/' . $this->page->id . '/owner', $page->toArray())
            ->assertStatus(403);

        $page = factory(Page::class)->create(['category_id' => $this->category->id]);
        $this->actingAs($this->adminUser)
            ->delete('/api/pages/' . $page->id, [], ['Accept' => 'application/json'])
            ->assertStatus(204);
        $this->actingAs($this->authorUser1)
            ->delete('/api/pages/' . $this->page->id, [], ['Accept' => 'application/json'])
            ->assertStatus(403);
        $this->actingAs($this->registeredUser)
            ->delete('/api/pages/' . $this->page->id, [], ['Accept' => 'application/json'])
            ->assertStatus(403);

        $users = [$this->adminUser, $this->authorUser1];
        foreach ($users as $user) {
            $page = factory(Page::class)->create(['category_id' => $this->category->id]);
            $pageContent = factory(PageContent::class)->create(['page_id' => $page->id]);
            $this->actingAs($user)
                ->delete(
                    '/api/pagecontent/' . $pageContent->id,
                    [],
                    ['Accept' => 'application/json']
                )
                ->assertStatus(204);
        }

        $this->actingAs($this->registeredUser)
            ->delete(
                '/api/pagecontent/' . $this->pageContent->id,
                [],
                ['Accept' => 'application/json']
            )
            ->assertStatus(403);
    }

    // Asset
    public function test_media_permission()
    {
        $users = [$this->adminUser, $this->authorUser1];
        foreach ($users as $user) {
            $this->actingAs($user);
            $this->get('/api/media')->assertStatus(200);
            $this->get('/api/media/' . $this->asset->id)->assertStatus(200);
        }
        $this->actingAs($this->registeredUser)
            ->get('/api/media')
            ->assertStatus(403);
        $this->actingAs($this->registeredUser)
            ->get('/api/media/' . $this->asset->id)
            ->assertStatus(403);

        $users = [$this->adminUser, $this->authorUser1];
        foreach ($users as $user) {
            $image = UploadedFile::fake()->image('testimage.png');
            $media = [
                'file' => $image,
            ];
            $this->actingAs($user);
            $this->post('/api/media', $media, ['Accept' => 'application/json'])->assertStatus(200);
        }
        $this->actingAs($this->registeredUser)
            ->post('/api/media', $this->data, ['Accept' => 'application/json'])
            ->assertStatus(403);

        $users = [$this->adminUser, $this->authorUser1];
        foreach ($users as $user) {
            $data = [
                // 'url' => 'https://i.pravatar.cc/100?u=test@example.com',
                'url' => 'https://source.unsplash.com/100x100?profile',
            ];
            $this->actingAs($user);
            $this->post('/api/media/fetchUrl', $data, [
                'Accept' => 'application/json',
            ])->assertStatus(200);
        }
        $this->actingAs($this->registeredUser)
            ->post('/api/media/fetchUrl', $this->data, ['Accept' => 'application/json'])
            ->assertStatus(403);

        $media = factory(Asset::class)->create(['user_id' => $this->user->id]);
        $this->actingAs($this->adminUser)
            ->delete('/api/media/' . $media->id)
            ->assertStatus(200);
        $this->actingAs($this->authorUser1)
            ->delete('/api/media/' . $this->asset->id)
            ->assertStatus(403);
        $this->actingAs($this->registeredUser)
            ->delete('/api/media/' . $this->asset->id)
            ->assertStatus(403);
    }

    // User
    public function test_user_permission()
    {
        $users = [$this->adminUser, $this->authorUser1];
        foreach ($users as $user) {
            $this->actingAs($user);
            $this->get('/api/users')->assertStatus(200);
            $this->get('/api/users/banned')->assertStatus(200);
            $this->get('/api/users/unverified')->assertStatus(200);
            $this->get('/api/users/' . $this->user->id)->assertStatus(200);
        }
        $this->actingAs($this->registeredUser)
            ->get('/api/users')
            ->assertStatus(403);
        $this->actingAs($this->registeredUser)
            ->get('/api/users/banned')
            ->assertStatus(403);
        $this->actingAs($this->registeredUser)
            ->get('/api/users/unverified')
            ->assertStatus(403);
        $this->actingAs($this->registeredUser)
            ->get('/api/users/' . $this->user->id)
            ->assertStatus(403);

        $user = factory(User::class)->make(['role' => 'author']);
        $this->actingAs($this->adminUser)
            ->post('/api/users', $user->toArray(), ['Accept' => 'application/json'])
            ->assertStatus(200);
        $this->actingAs($this->authorUser1)
            ->post('/api/users', $this->data, ['Accept' => 'application/json'])
            ->assertStatus(403);
        $this->actingAs($this->registeredUser)
            ->post('/api/users', $this->data, ['Accept' => 'application/json'])
            ->assertStatus(403);

        $user = factory(User::class)->create(['role' => 'author']);
        $this->actingAs($this->adminUser)
            ->put('/api/users/' . $user->id, $user->toArray(), ['Accept' => 'application/json'])
            ->assertStatus(200);
        $this->actingAs($this->authorUser1)
            ->put('/api/users/' . $this->user->id, $this->data, ['Accept' => 'application/json'])
            ->assertStatus(403);
        $this->actingAs($this->registeredUser)
            ->put('/api/users/' . $this->user->id, $this->data, ['Accept' => 'application/json'])
            ->assertStatus(403);

        $user = factory(User::class)->create(['role' => 'author']);
        $this->actingAs($this->adminUser)
            ->delete('/api/users/' . $user->id, [], ['Accept' => 'application/json'])
            ->assertStatus(204);
        $this->actingAs($this->authorUser1)
            ->delete('/api/users/' . $this->user->id, [], ['Accept' => 'application/json'])
            ->assertStatus(403);
        $this->actingAs($this->registeredUser)
            ->delete('/api/users/' . $this->user->id, [], ['Accept' => 'application/json'])
            ->assertStatus(403);

        $users = [$this->adminUser, $this->authorUser1, $this->registeredUser];
        foreach ($users as $user) {
            $data = [
                'current_password' => 'password',
                'new_password' => 'password1234',
                'new_password_confirmation' => 'password1234',
            ];
            $this->actingAs($user);
            $this->patch('/api/users/password', $data, [
                'Accept' => 'application/json',
            ])->assertStatus(200);
        }

        $this->actingAs($this->adminUser)
            ->get('/api/users/' . $this->user->id . '/pages')
            ->assertStatus(200);
        $this->actingAs($this->authorUser1)
            ->get('/api/users/' . $this->user->id . '/pages')
            ->assertStatus(403);
        $this->actingAs($this->registeredUser)
            ->get('/api/users/' . $this->user->id . '/pages')
            ->assertStatus(403);

        $this->actingAs($this->adminUser)
            ->get('/api/users/' . $this->user->id . '/comments')
            ->assertStatus(200);
        $this->actingAs($this->authorUser1)
            ->get('/api/users/' . $this->user->id . '/comments')
            ->assertStatus(403);
        $this->actingAs($this->registeredUser)
            ->get('/api/users/' . $this->user->id . '/comments')
            ->assertStatus(403);
    }

    // Setting
    public function test_setting_permission()
    {
        $this->actingAs($this->adminUser)
            ->get('/api/settings/social')
            ->assertStatus(200);
        $this->actingAs($this->authorUser1)
            ->get('/api/settings/social')
            ->assertStatus(403);
        $this->actingAs($this->registeredUser)
            ->get('/api/settings/social')
            ->assertStatus(403);

        $this->actingAs($this->adminUser)
            ->get('/api/settings/mail')
            ->assertStatus(200);
        $this->actingAs($this->authorUser1)
            ->get('/api/settings/mail')
            ->assertStatus(403);
        $this->actingAs($this->registeredUser)
            ->get('/api/settings/mail')
            ->assertStatus(403);

        $loginprovider = [
            'data' => [
                ['key' => 'FACEBOOK_CLIENT_ID', 'value' => 'Id1234'],
                ['key' => 'FACEBOOK_CLIENT_SECRET', 'value' => 'Secret1234'],
            ],
        ];
        $this->actingAs($this->adminUser)
            ->post('/api/settings/loginprovider', $loginprovider, ['Accept' => 'application/json'])
            ->assertStatus(200);
        $this->actingAs($this->authorUser1)
            ->post('/api/settings/loginprovider', $this->data, ['Accept' => 'application/json'])
            ->assertStatus(403);
        $this->actingAs($this->registeredUser)
            ->post('/api/settings/loginprovider', $this->data, ['Accept' => 'application/json'])
            ->assertStatus(403);

        $mailProvider = [
            'data' => [
                ['key' => 'MAIL_DRIVER', 'value' => 'smtp'],
                ['key' => 'MAIL_FROM_ADDRESS', 'value' => 'test@test.com'],
            ],
        ];
        $this->actingAs($this->adminUser)
            ->post('/api/settings/mailprovider', $mailProvider, ['Accept' => 'application/json'])
            ->assertStatus(200);
        $this->actingAs($this->authorUser1)
            ->post('/api/settings/mailprovider', $this->data, ['Accept' => 'application/json'])
            ->assertStatus(403);
        $this->actingAs($this->registeredUser)
            ->post('/api/settings/mailprovider', $this->data, ['Accept' => 'application/json'])
            ->assertStatus(403);

        Parameter::setKey('MAIL_DRIVER', 'array');
        $this->actingAs($this->adminUser)
            ->get('/api/settings/testmail')
            ->assertStatus(200);
        $this->actingAs($this->authorUser1)
            ->get('/api/settings/testmail')
            ->assertStatus(403);
        $this->actingAs($this->registeredUser)
            ->get('/api/settings/testmail')
            ->assertStatus(403);

        $this->actingAs($this->adminUser)
            ->get('/api/settings/search')
            ->assertStatus(200);
        $this->actingAs($this->authorUser1)
            ->get('/api/settings/search')
            ->assertStatus(403);
        $this->actingAs($this->registeredUser)
            ->get('/api/settings/search')
            ->assertStatus(403);

        $searchprovider = [
            'data' => [
                'ALGOLIA_APP_ID' => 'Id1234',
                'ALGOLIA_SECRET' => 'Secret1234',
            ],
        ];
        $this->actingAs($this->adminUser)
            ->post('/api/settings/searchprovider', $searchprovider, [
                'Accept' => 'application/json',
            ])
            ->assertStatus(200);
        $this->actingAs($this->authorUser1)
            ->post('/api/settings/searchprovider', $this->data, ['Accept' => 'application/json'])
            ->assertStatus(403);
        $this->actingAs($this->registeredUser)
            ->post('/api/settings/searchprovider', $this->data, ['Accept' => 'application/json'])
            ->assertStatus(403);
    }

    // Lov
    public function test_lov_permission()
    {
        $this->actingAs($this->adminUser)
            ->get('/api/lov/categories')
            ->assertStatus(200);
        $this->actingAs($this->authorUser1)
            ->get('/api/lov/categories')
            ->assertStatus(200);
        $this->actingAs($this->registeredUser)
            ->get('/api/lov/categories')
            ->assertStatus(403);

        $this->actingAs($this->adminUser)
            ->get('/api/lov/authors')
            ->assertStatus(200);
        $this->actingAs($this->authorUser1)
            ->get('/api/lov/authors')
            ->assertStatus(200);
        $this->actingAs($this->registeredUser)
            ->get('/api/lov/authors')
            ->assertStatus(403);
    }

    // Template
    public function test_template_permission()
    {
        $this->actingAs($this->authorUser1)
            ->get('/api/templates')
            ->assertStatus(403);

        $this->actingAs($this->registeredUser)
            ->get('/api/templates')
            ->assertStatus(403);

        $this->actingAs($this->authorUser1)
            ->get('/api/templates/1')
            ->assertStatus(403);

        $this->actingAs($this->registeredUser)
            ->get('/api/templates/1')
            ->assertStatus(403);

        $this->actingAs($this->authorUser1)
            ->post('/api/templates', $this->data, ['Accept' => 'application/json'])
            ->assertStatus(403);

        $this->actingAs($this->registeredUser)
            ->post('/api/templates', $this->data, ['Accept' => 'application/json'])
            ->assertStatus(403);

        $this->actingAs($this->authorUser1)
            ->post('/api/templates/1/add', $this->data, ['Accept' => 'application/json'])
            ->assertStatus(403);

        $this->actingAs($this->registeredUser)
            ->post('/api/templates/1/add', $this->data, ['Accept' => 'application/json'])
            ->assertStatus(403);

        $this->actingAs($this->authorUser1)
            ->get('/api/templates/1/get/test.test')
            ->assertStatus(403);

        $this->actingAs($this->registeredUser)
            ->get('/api/templates/1/get/test.test')
            ->assertStatus(403);

        $this->actingAs($this->authorUser1)
            ->post('/api/templates/1/activate', $this->data, ['Accept' => 'application/json'])
            ->assertStatus(403);

        $this->actingAs($this->registeredUser)
            ->post('/api/templates/1/activate', $this->data, ['Accept' => 'application/json'])
            ->assertStatus(403);

        $this->actingAs($this->authorUser1)
            ->patch('/api/templates/1', $this->data, ['Accept' => 'application/json'])
            ->assertStatus(403);

        $this->actingAs($this->registeredUser)
            ->patch('/api/templates/1', $this->data, ['Accept' => 'application/json'])
            ->assertStatus(403);

        $this->actingAs($this->authorUser1)
            ->delete('/api/templates/1', [], ['Accept' => 'application/json'])
            ->assertStatus(403);

        $this->actingAs($this->registeredUser)
            ->delete('/api/templates/1', [], ['Accept' => 'application/json'])
            ->assertStatus(403);

        $this->actingAs($this->authorUser1)
            ->post('/api/templates/1/duplicate', $this->data, ['Accept' => 'application/json'])
            ->assertStatus(403);

        $this->actingAs($this->registeredUser)
            ->post('/api/templates/1/duplicate', $this->data, ['Accept' => 'application/json'])
            ->assertStatus(403);

        $this->actingAs($this->authorUser1)
            ->post('/api/templates/import', $this->data, ['Accept' => 'application/json'])
            ->assertStatus(403);

        $this->actingAs($this->registeredUser)
            ->post('/api/templates/import', $this->data, ['Accept' => 'application/json'])
            ->assertStatus(403);
    }

    // Form
    public function test_form_permission()
    {
        $this->actingAs($this->adminUser)
            ->get('/api/forms')
            ->assertStatus(200);
        $this->actingAs($this->authorUser1)
            ->get('/api/forms')
            ->assertStatus(403);
        $this->actingAs($this->registeredUser)
            ->get('/api/forms')
            ->assertStatus(403);

        $this->actingAs($this->adminUser)
            ->get('/api/forms/' . $this->form->id)
            ->assertStatus(200);
        $this->actingAs($this->authorUser1)
            ->get('/api/forms/' . $this->form->id)
            ->assertStatus(403);
        $this->actingAs($this->registeredUser)
            ->get('/api/forms/' . $this->form->id)
            ->assertStatus(403);

        $form = factory(Form::class)->make();
        $this->actingAs($this->adminUser)
            ->post('/api/forms', $form->toArray(), ['Accept' => 'application/json'])
            ->assertStatus(200);
        $this->actingAs($this->authorUser1)
            ->post('/api/forms', $this->data, ['Accept' => 'application/json'])
            ->assertStatus(403);
        $this->actingAs($this->registeredUser)
            ->post('/api/forms', $this->data, ['Accept' => 'application/json'])
            ->assertStatus(403);

        $form = factory(Form::class)->create();
        $this->actingAs($this->adminUser)
            ->put('/api/forms/' . $form->id, $form->toArray(), ['Accept' => 'application/json'])
            ->assertStatus(200);
        $this->actingAs($this->authorUser1)
            ->put('/api/forms/1', $this->data, ['Accept' => 'application/json'])
            ->assertStatus(403);
        $this->actingAs($this->registeredUser)
            ->put('/api/forms/1', $this->data, ['Accept' => 'application/json'])
            ->assertStatus(403);

        $form = factory(Form::class)->create();
        $this->actingAs($this->adminUser)
            ->delete('/api/forms/' . $form->id, [], ['Accept' => 'application/json'])
            ->assertStatus(204);
        $this->actingAs($this->authorUser1)
            ->delete('/api/forms/1', [], ['Accept' => 'application/json'])
            ->assertStatus(403);
        $this->actingAs($this->registeredUser)
            ->delete('/api/forms/1', [], ['Accept' => 'application/json'])
            ->assertStatus(403);

        $users = [$this->adminUser, $this->authorUser1, $this->registeredUser];
        foreach ($users as $user) {
            $this->actingAs($user);
            $form = factory(Form::class)->create(['captcha' => false]);
            $formResponse = factory(FormResponse::class)->create(['form_id' => $form->id]);
            $this->post('/api/forms/' . $form->id . '/response', $formResponse->toArray(), [
                'Accept' => 'application/json',
            ])->assertSessionHas('success');
        }

        $this->actingAs($this->adminUser)
            ->get('/api/forms/1/responses')
            ->assertStatus(200);
        $this->actingAs($this->authorUser1)
            ->get('/api/forms/1/responses')
            ->assertStatus(403);
        $this->actingAs($this->registeredUser)
            ->get('/api/forms/1/responses')
            ->assertStatus(403);
    }
}
