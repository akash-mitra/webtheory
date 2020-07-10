<?php

namespace Tests;

use App\Page;
use App\User;
use App\Media;
use App\Category;
use App\PageContent;
use App\Form;
use App\FormResponse;
use Tests\Support\AssertJson;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Event;

class TestDataSetup extends TestCase
{
    use AssertJson;
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        Notification::fake();
        Mail::fake();
        Queue::fake();
        Event::fake();

        $this->setUpAssertJson();

        $this->seed();

        $this->generateTestdata();

        $this->setModelAttributes();

        // COMMENTED OUT FOR 403 Restricted Access permission Test Cases
        // $this->withoutExceptionHandling();

        // https://medium.com/@brice_hartmann/testing-laravel-password-resets-858c58c16b79
        // https://medium.com/@mscherrenberg/unit-testing-your-api-in-laravel-5-6-7172bcdc593d
        // https://laracasts.com/series/build-a-laravel-app-with-tdd/episodes/2
        // https://mattstauffer.com/blog/better-integration-testing-in-laravel-5.1-powerful-integration-tests-in-a-few-lines/
    }

    private function generateTestdata()
    {
        // API TESTING DATA
        $this->adminUser = factory(User::class)->create([
            'email' => 'adminuser@example.com',
            'role' => 'admin',
        ]);
        $this->authorUser1 = factory(User::class)->create([
            'email' => 'authoruser1@example.com',
            'role' => 'author',
        ]);
        $this->authorUser2 = factory(User::class)->create([
            'email' => 'authoruser2@example.com',
            'role' => 'author',
        ]);
        $this->registeredUser = factory(User::class)->create([
            'email' => 'registereduser@example.com',
            'role' => 'registered',
        ]);
        $this->user = factory(User::class)->create(['email' => 'testuser@example.com']);

        $this->media = factory(Media::class)->create([
            'user_id' => $this->adminUser->id,
        ]);

        $this->category = factory(Category::class)->create([
            'user_id' => $this->adminUser->id,
        ]);

        $this->page = factory(Page::class)->create([
            'category_id' => $this->category->id,
            'user_id' => $this->adminUser->id,
            'status' => 'Live',
        ]);
        $this->pagecontent = factory(PageContent::class)->create([
            'page_id' => $this->page->id,
        ]);

        $this->draftPage = factory(Page::class)->create([
            'category_id' => $this->category->id,
            'user_id' => $this->adminUser->id,
            'status' => 'Draft',
        ]);
        $this->draftPagecontent = factory(PageContent::class)->create([
            'page_id' => $this->draftPage->id,
        ]);

        $this->form = factory(Form::class)->create();

        $this->formResponse = factory(FormResponse::class)->create([
            'form_id' => $this->form->id,
        ]);

    }

    private function setModelAttributes()
    {
        $this->user_attributes = [
            'id',
            'name',
            'email',
            'email_verified_at',
            'role',
            'avatar',
            'about_me',
            'gender',
            'dob',
            'preferences',
            'public_id',
            'created_at',
            'updated_at',
            'deleted_at',
            'created_ago',
            'updated_ago',
            'url',
        ];

        $this->user_attributes_store = [
            'name',
            'email',
            'role',
            'preferences',
            'public_id',
            'updated_at',
            'created_at',
            'id',
            'created_ago',
            'updated_ago',
            'url',
        ];

        $this->profile_attributes = [
            'name',
            'email',
            'email_verified_at',
            'role',
            'avatar',
            'about_me',
            'gender',
            'dob',
            'preferences',
            'created_at',
            'updated_at',
            'public_id',
            'id',
            'created_ago',
            'updated_ago',
            'url',
        ];

        $this->media_attributes = [
            'id',
            'name',
            'type',
            'size',
            'path',
            'url',
            'storage',
            'user_id',
            'created_at',
            'updated_at',
            'created_ago',
            'updated_ago',
        ];

        $this->category_attributes = [
            'id',
            'name',
            'parent_id',
            'description',
            'metakey',
            'metadesc',
            'media_id',
            'user_id',
            'created_at',
            'updated_at',
            'deleted_at',
            'url',
            'permalink',
            'created_ago',
            'updated_ago',
        ];

        $this->page_attributes = [
            'id',
            'category_id',
            'user_id',
            'title',
            'summary',
            'metakey',
            'metadesc',
            'media_id',
            'status',
            'created_at',
            'updated_at',
            'deleted_at',
            'url',
            'permalink',
            'created_ago',
            'updated_ago',
        ];

        $this->pagecontent_attributes = [
            'id',
            'page_id',
            'body_json',
            'body_html',
            'created_at',
            'updated_at',
            'editor',
        ];

        $this->category_attributes_list = array_merge($this->category_attributes, [
            'media',
            'author' => $this->user_attributes,
        ]);

        $this->category_attributes_pages = array_merge($this->category_attributes, [
            'pages' => [
                '*' => array_merge($this->page_attributes, [
                    'author' => $this->user_attributes,
                ]),
            ],
        ]);

        $this->page_attributes_list = array_merge($this->page_attributes, [
            'category' => $this->category_attributes,
            'author' => $this->user_attributes,
            'media',
        ]);

        $this->page_attributes_show = array_merge($this->page_attributes, [
            'content' => $this->pagecontent_attributes,
            'category' => $this->category_attributes,
            'author' => $this->user_attributes,
            'media',
        ]);

        $this->page_attributes_show_media = array_merge($this->page_attributes, [
            'content' => $this->pagecontent_attributes,
            'category' => $this->category_attributes,
            'author' => $this->user_attributes,
            'media' => $this->media_attributes,
        ]);

        $this->page_attributes_store = [
            'category_id',
            'user_id',
            'title',
            'summary',
            'metakey',
            'metadesc',
            'media_id',
            'status',
            'updated_at',
            'created_at',
            'id',
            'url',
            'permalink',
            'created_ago',
            'updated_ago',
            'content' => $this->pagecontent_attributes,
        ];

        $this->user_pages_attributes = array_merge($this->page_attributes, [
            'media',
            'category' => $this->category_attributes,
        ]);

        $this->comment_attributes = [
            'id',
            'parent_id',
            'reference_id',
            'user_id',
            'body',
            'likes',
            'dislikes',
            'created_at',
            'updated_at',
            'deleted_at',
            'created_ago',
            'updated_ago',
        ];

        $this->comment_attributes_store = [
            'body',
            'parent_id',
            'user_id',
            'reference_id',
            'updated_at',
            'created_at',
            'id',
            'created_ago',
            'updated_ago',
            'parent',
        ];

        $this->form_attributes = [
            'id',
            'name',
            'description',
            'status',
            'captcha',
            'fields',
            'created_at',
            'updated_at',
            'created_ago',
            'updated_ago', 
        ];

        $this->formresponse_attributes = [
            'id',
            'form_id',
            'ip',
            'responses',
            'created_at',
            'updated_at', 
        ];
    }
}
