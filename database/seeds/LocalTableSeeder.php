<?php

use Faker\Generator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Asset;
use App\Category;
use App\Page;
use App\PageContent;
use App\CategoryComment;
use App\PageComment;
use App\Form;
use App\FormResponse;
use App\View;

class LocalTableSeeder extends Seeder
{
    const SOURCE_UNSPLASH_1000_X_1000 = 'https://source.unsplash.com/1000x1000?travel';
    const SOURCE_UNSPLASH_ADMIN_PROFILE_PIC = 'https://source.unsplash.com/9UVmlIb0wJU/100x100';

    private Generator $faker;
    private array $views = [];
    private array $adminAuthorIds = [];
    private array $mediaIds = [];


    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $this->faker = Faker\Factory::create();

        $this->createViews(150);

        $admin = $this->createAdminUser();

        // Authors
        $authors = $this->createAuthors(3, 10);
        $authorIds = $authors->pluck('id')->all();

        // Admin & Authors
        $this->adminAuthorIds = $authorIds;
        array_push($this->adminAuthorIds, $admin->id);

        // Registered users
        $registeredUsers = $this->createRegisteredUsers(5, 15);
        $registeredUserIds = $registeredUsers->pluck('id')->all();

        // create unverified users
        $this->createRegisteredUsers(2, 5, true);

        // create banned users
        $this->createRegisteredUsers(2, 5, false, true);

        // Asset - clean up
        $files = Storage::allFiles('public/media');
        Storage::delete($files);

        $mediaArray = $this->createMedia(10, 25);
        $this->mediaIds = $mediaArray->pluck('id')->all();

        // Parent Categories
        $parentCategories = $this->createCategories(5, 10);
        $parentCategoryIds = $parentCategories->pluck('id')->all();

        // Child Categories
        $childCategoryIds = [];
        foreach ($parentCategoryIds as $parentCategoryId) {
            for ($i = 0; $i < mt_rand(1, 5); $i++) {
                $category = factory(Category::class)->create([
                    'parent_id' => $parentCategoryId,
                    'user_id' => $this->faker->randomElement($this->adminAuthorIds),
                    'media_id' => $this->faker->randomElement($this->mediaIds
                    ),
                ]);
                array_push($childCategoryIds, $category->id);
            }
        }

        // Uncategorized, Parent & Child Categories
        $uncategorized = [1];
        $categoryIds = array_merge($uncategorized, $parentCategoryIds);
        $categoryIds = array_merge($categoryIds, $childCategoryIds);

        // Skip some Categories with No pages
        $tempCategoryIds = $categoryIds;
        shuffle($tempCategoryIds);
        $tempCategoryIds = array_slice($tempCategoryIds, 5);

        // Pages
        $pageIds = [];
        foreach ($categoryIds as $categoryId) {
            for ($i = 0; $i < mt_rand(1, 10); $i++) {
                $page = factory(Page::class)->create([
                    'category_id' => $categoryId,
                    'user_id' => $this->faker->randomElement($this->adminAuthorIds),
                    'media_id' => $this->faker->randomElement($this->mediaIds),
                ]);
                array_push($pageIds, $page->id);

                // Content Generation
                list($body_html, $body_json) = $this->createDummyPageContent($mediaArray);

                // Page Contents
                factory(PageContent::class)->create([
                    'page_id' => $page->id,
                    'body_json' => json_decode($body_json),
                    'body_html' => $body_html,
                ]);
            }
        }
        // End of Pages

        // Category Comment
        $this->createCategoryComments($registeredUserIds, $categoryIds);

        // Page Comment
        $this->createPageComments($registeredUserIds, $pageIds, 3);

        // Days Loop
        for (
            $view_date = now()
                ->subDays(70)
                ->startOfDay();
            $view_date <= now();
            $view_date->addDay()
        ) {
            // User Loop
            for ($i = 0; $i < mt_rand(10, 20); $i++) {
                $view = $this->faker->randomElement($this->views);

                // Skip some Pages
                shuffle($pageIds);
                $pages = array_slice($pageIds, count($pageIds) - mt_rand(1, 5));

                // Pages Loop
                foreach ($pages as $page) {
                    $viewed_at = $view_date->addSeconds(mt_rand(0, 120));
                    factory(View::class)->create([
                        'ip' => $view->ip,
                        'at' => $viewed_at,
                        'date_key' => $viewed_at->format('Ymd'),
                        'url' => '/pages/' . $page,
                        'content_type' => 'App\Page',
                        'content_id' => $page,
                        'platform' => $view->platform,
                        'browser' => $view->browser,
                        'version' => $view->version,
                        'referrer' => $view->referrer,
                        'referrer_domain' => str_ireplace(
                            'www.',
                            '',
                            parse_url($view->referrer, PHP_URL_HOST)
                        ),
                        'session_id' => mt_rand(0, 5),
                        'country' => $view->country,
                        'city' => $view->city,
                        'latitude' => $view->latitude,
                        'longitude' => $view->longitude,
                    ]);
                }
            }
        }

        // Form
        $form = factory(Form::class)->create([
            'name' => 'Contact Us',
            'description' => 'Feel free to reach us',
            'captcha' => 1,
            'status' => 'Live',
        ]);

        // Form Response
        factory(FormResponse::class, mt_rand(10, 30))->create([
            'form_id' => $form->id,
        ]);
    }

    /**
     * @param int $noOfViews
     */
    private function createViews(int $noOfViews)
    {
        for ($i = 0; $i < $noOfViews; $i++) {
            $view = factory(View::class)->make([
                'country' => $this->faker->randomElement([
                    'Russia',
                    'Canada',
                    'China',
                    'United States',
                    'Brazil',
                    'France',
                    'Germany',
                    'United Kingdom',
                    'Australia',
                    'India',
                    'Argentina',
                    'Singapore',
                    'Malaysia',
                    'Japan',
                    'United Arab Emirates',
                ]),
            ]);

            array_push($this->views, $view);
        }
    }

    /**
     * @return Collection|Model|mixed
     */
    private function createAdminUser()
    {
        return factory(User::class)->create([
            'name' => env('ADMIN_USER_NAME', 'Administrator'),
            'email' => env('ADMIN_USER_EMAIL', 'admin@example.com'),
            'password' => Hash::make(env('ADMIN_USER_PASSWORD', 'Passw0rd')),
            'role' => 'admin',
            'email_verified_at' => now(),
            'avatar' => self::SOURCE_UNSPLASH_ADMIN_PROFILE_PIC,
        ]);
    }

    /**
     * @param int $min
     * @param int $max
     * @return Collection
     */
    private function createAuthors(int $min, int $max): Collection
    {
        return factory(User::class, mt_rand($min, $max))
            ->create(['role' => 'author',]);
    }

    /**
     * @param int $min
     * @param int $max
     * @param bool $unverified
     * @param bool $banned
     * @return Collection
     */
    private function createRegisteredUsers(int $min, int $max, bool $unverified = false, bool $banned = false): Collection
    {
        return factory(User::class, mt_rand($min, $max))
            ->create([
                'role' => 'author',
                'email_verified_at' => $unverified ? null : now(),
                'deleted_at' => $banned ? now() : null,
            ]);
    }

    /**
     * @param int $min
     * @param int $max
     * @return Collection
     */
    private function createMedia(int $min, int $max): Collection
    {
        $mediaArray = collect();

        for ($i = 0; $i < mt_rand($min, $max); $i++) {

            $filename = $this->faker->domainWord . '.png';
            $contents = file_get_contents(self::SOURCE_UNSPLASH_1000_X_1000);
            Storage::put('public/media/' . $filename, $contents);

            $media = factory(Asset::class)->create([
                'name' => $filename,
                'type' => 'image',
                'size' => rand(10, 50),
                'path' => 'media/' . $filename,
                'url' => '/storage/media/' . $filename,
                'storage' => 'public',
                'user_id' => $this->faker->randomElement($this->adminAuthorIds),
            ]);

            $mediaArray->add($media);
        }

        return $mediaArray;
    }


    /**
     * @param int $min
     * @param int $max
     * @return Collection
     */
    private function createCategories(int $min, int $max): Collection
    {
        $categories = collect();

        for ($i = 0; $i < mt_rand($min, $max); $i++) {
            $category = factory(Category::class)->create([
                'user_id' => $this->faker->randomElement($this->adminAuthorIds),
                'media_id' => $this->faker->randomElement($this->mediaIds),
            ]);
            $categories->add($category);
        }

        return $categories;
    }

    /**
     * @param Collection $mediaArray
     * @return string[]
     * @throws Exception
     */
    private function createDummyPageContent(Collection $mediaArray): array
    {
        $body_html = '';
        $body_json = '{"time":' . $this->faker->unixTime($max = 'now') . ',"blocks":[';

        for ($j = 0; $j < mt_rand(3, 7); $j++) {
            // Heading1
            $heading = $this->faker->realText(40);
            $body_json .=
                '{"type":"header","data":{"level":1,"text":"' .
                str_replace('"', '\"', $heading) .
                '"}},';
            $body_html .= '<h1>' . $heading . '</h1>';

            // Paragraph
            $paragraph = $this->faker->realText() . '.' . $this->faker->realText();
            $body_json .=
                '{"type":"paragraph","data":{"text":"' .
                str_replace('"', '\"', $paragraph) .
                '"}},';
            $body_html .= '<p>' . $paragraph . '</p>';

            // Heading2
            for ($k = 0; $k < mt_rand(0, 2); $k++) {
                $heading = $this->faker->realText(40);
                $body_json .=
                    '{"type":"header","data":{"level":2,"text":"' .
                    str_replace('"', '\"', $heading) .
                    '"}},';
                $body_html .= '<h2>' . $heading . '</h2>';

                // Paragraph
                $paragraph = $this->faker->realText() . '.' . $this->faker->realText();
                $body_json .=
                    '{"type":"paragraph","data":{"text":"' .
                    str_replace('"', '\"', $paragraph) .
                    '"}},';
                $body_html .= '<p>' . $paragraph . '</p>';
            }

            // List
            for ($k = 0; $k < mt_rand(0, 1); $k++) {
                $type = random_int(1, 3) != 3 ? 'ordered' : 'unordered';
                if ($type == 'ordered') {
                    $body_html .= '<ol>';
                    $body_json .= '{"type":"list","data":{"style":"ordered", "items":[';
                } else {
                    $body_html .= '<ul>';
                    $body_json .= '{"type":"list","data":{"style":"unordered", "items":[';
                }

                for ($l = 0; $l < mt_rand(2, 7); $l++) {
                    $listItem = $this->faker->catchPhrase();
                    $body_json .= '"' . str_replace('"', '\"', $listItem) . '",';
                    $body_html .= '<li>' . $listItem . '</li>';
                }

                $body_json = rtrim($body_json, ',') . ']}},';
                if ($type == 'ordered') {
                    $body_html .= '</ol>';
                } else {
                    $body_html .= '</ul>';
                }
            }

            // Code & Table
            for ($k = 0; $k < mt_rand(0, 1); $k++) {
                $email = $this->faker->safeEmail;
                $body_json .=
                    '{"type":"code","data":{"code":"' .
                    str_replace(
                        '"',
                        '\"',
                        "SELECT * FROM users WHERE email = '" . $email . "'"
                    ) .
                    '"}},';
                $body_html .= '<pre><code class="hljs sql">';
                $body_html .=
                    '<span class="hljs-keyword">SELECT</span>' .
                    ' * ' .
                    '<span class="hljs-keyword">FROM</span>' .
                    ' users ' .
                    '<span class="hljs-keyword">WHERE</span>' .
                    ' email = ' .
                    '<span class="hljs-string">' .
                    "'" .
                    $email .
                    "'" .
                    '</span>';
                $body_html .= '</code></pre>';

                // Table
                $name = $this->faker->name;
                $member = $this->faker->randomElement($array = ['Platinum', 'Gold']);
                $joined = $this->faker->date($format = 'Y-m-d', $max = 'now');

                $json_rows =
                    '["Name","Email","Member","Joined"],["' .
                    str_replace('"', '\"', $name) .
                    '","' .
                    str_replace('"', '\"', $email) .
                    '","' .
                    str_replace('"', '\"', $member) .
                    '","' .
                    str_replace('"', '\"', $joined) .
                    '"]';
                $body_json .= '{"type":"table","data":{"content":[' . $json_rows . ']}},';

                $body_html .= '<table class="wt-table"><tbody>';
                $body_html .=
                    '<tr class="wt-table-tr"><td class="wt-table-td">Name</td><td class="wt-table-td">Email</td><td class="wt-table-td">Member</td><td class="wt-table-td">Joined</td><tr>';
                $body_html .=
                    '<tr class="wt-table-tr"><td class="wt-table-td">' .
                    $name .
                    '</td><td class="wt-table-td">' .
                    $email .
                    '</td><td class="wt-table-td">' .
                    $member .
                    '</td><td class="wt-table-td">' .
                    $joined .
                    '</td><tr>';
                $body_html .= '</tbody></table>';
            }

            // Paragraph
            for ($k = 0; $k < mt_rand(1, 5); $k++) {
                $paragraph = $this->faker->realText() . '.' . $this->faker->realText();
                $body_json .=
                    '{"type":"paragraph","data":{"text":"' .
                    str_replace('"', '\"', $paragraph) .
                    '"}},';
                $body_html .= '<p>' . $paragraph . '</p>';

                // Asset
                $media = $this->faker->randomElement($mediaArray);
                $caption = $this->faker->catchPhrase;
                $withBorder = 'false';
                $stretched = 'false';
                $withBackground = 'false';

                $body_json .=
                    '{"type":"image","data":{"file":{"id":' .
                    $media->id .
                    ',"path":"' .
                    $media->path .
                    '","url":"' .
                    $media->url .
                    '"},"caption":"' .
                    str_replace('"', '\"', $caption) .
                    '","withBorder":' .
                    $withBorder .
                    ',"stretched":' .
                    $stretched .
                    ',"withBackground":' .
                    $withBackground .
                    '}},';
                $body_html .=
                    '<div class="my-4"><figure class="img-fig"><img src="' .
                    $media->url .
                    '" alt="' .
                    $caption .
                    '"/><figcaption class="text-sm mt-3 img-fig-caption' .
                    ($stretched || $withBackground ? ' text-center' : '') .
                    '">' .
                    $caption .
                    '</figcaption></figure></div>';
            }
        }

        $body_json = rtrim($body_json, ',') . '],"version":"2.18.0"}';
        return array($body_html, $body_json);
    }

    /**
     * @param array $registeredUserIds
     * @param array $categoryIds
     * @param int $maxCommentsPerCategory
     */
    private function createCategoryComments(array $registeredUserIds, array $categoryIds, int $maxCommentsPerCategory = 1)
    {
        $tempUserIds = $registeredUserIds;
        shuffle($tempUserIds);
        $tempUserIds = array_slice($tempUserIds, 3);
        foreach ($categoryIds as $categoryId) {
            foreach ($tempUserIds as $userId) {
                factory(CategoryComment::class, mt_rand(0, $maxCommentsPerCategory))->create([
                    'reference_id' => $categoryId,
                    'user_id' => $userId,
                ]);
            }
        }
    }

    /**
     * @param array $registeredUserIds
     * @param array $pageIds
     * @param int $maxCommentsPerPage
     */
    private function createPageComments(array $registeredUserIds, array $pageIds, int $maxCommentsPerPage = 5)
    {
        $tempUserIds = $registeredUserIds;
        shuffle($tempUserIds);
        $tempUserIds = array_slice($tempUserIds, 3);
        foreach ($pageIds as $pageId) {
            foreach ($tempUserIds as $userId) {
                factory(PageComment::class, mt_rand(0, $maxCommentsPerPage))->create([
                    'reference_id' => $pageId,
                    'user_id' => $userId,
                ]);
            }
        }

    }
}
