<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Media;
use App\Category;
use App\Page;
use App\PageContent;
use App\CategoryComment;
use App\PageComment;

class LocalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        // Admin user
        $admin = factory(User::class)->create([
            'name' => env('ADMIN_USER_NAME', 'Administrator'),
            'email' => env('ADMIN_USER_EMAIL', 'admin@example.com'),
            'password' => Hash::make(env('ADMIN_USER_PASSWORD', 'Passw0rd')),
            'role' => 'admin',
            'avatar' => 'https://i.pravatar.cc/100?u=admin@example.com',
        ]);

        // Authors
        $authorIds = factory(User::class, mt_rand(3, 10))->create([
            'role' => 'author'
        ])->pluck('id')->all();

        // Admin & Authors
        $adminAuthorIds = $authorIds;
        array_push($adminAuthorIds, $admin->id);

        // Registered users
        $userIds = factory(User::class, mt_rand(5, 20))->create([
            'role' => 'registered'
        ])->pluck('id')->all();

        // Media
        $files = Storage::allFiles('public/media');
        Storage::delete($files);

        $mediaIds = [];
        $mediaArray = [];
        for ($i = 0; $i < mt_rand(10, 30); $i++) {
            $fileExtension = 'png';
            $filename = $faker->domainWord . '.' . $fileExtension;
            // Storage::disk('local')->put('media/file.txt', 'Contents');
            $url = 'https://i.pravatar.cc/1000?u=' . $faker->unique()->safeEmail;
            $contents = file_get_contents($url);
            Storage::put('public/media/' . $filename, $contents);

            $media = factory(Media::class)->create([
                'name' => $filename,
                'type' => $fileExtension,
                'size' => rand(10, 50),
                'path' => 'media/' . $filename,
                'url' => '/storage/media/' . $filename,
                'storage' => 'public',
                'user_id' => $faker->randomElement($adminAuthorIds),
                // 'user_id' => $adminAuthorIds[random_int(0, count($adminAuthorIds) - 1)],
            ]);
            array_push($mediaIds, $media->id);
            array_push($mediaArray, $media);
        }

        // Parent Categories
        $parentCategoryIds = [];
        for ($i = 0; $i < mt_rand(5, 10); $i++) {
            $category = factory(Category::class)->create([
                'user_id' => $faker->randomElement($adminAuthorIds),
                'media_id' => $faker->randomElement($mediaIds),
            ]);
            array_push($parentCategoryIds, $category->id);
        }

        // Child Categories
        $childCategoryIds = [];
        foreach($parentCategoryIds as $parentCategoryId) {
            for ($i = 0; $i < mt_rand(1, 5); $i++) {
                $category = factory(Category::class)->create([
                    'parent_id' => $parentCategoryId,
                    'user_id' => $faker->randomElement($adminAuthorIds),
                    'media_id' => $faker->randomElement($mediaIds),
                ]);
                array_push($childCategoryIds, $category->id);
            }
        }

        // Uncategorised, Parent & Child Categories
        $uncategorized = [1];
        $categoryIds = array_merge($uncategorized, $parentCategoryIds);
        $categoryIds = array_merge($categoryIds, $childCategoryIds);
        // Skip some Categories with No pages
        $tempcategoryIds = $categoryIds;
        shuffle($tempcategoryIds);
        $tempcategoryIds = array_slice($tempcategoryIds, 5);

        // Pages
        $pageIds = [];
        foreach ($categoryIds as $categoryId) {
            for ($i = 0; $i < mt_rand(1, 10); $i++) {
                $page = factory(Page::class)->create([
                    'category_id' => $categoryId,
                    'user_id' => $faker->randomElement($adminAuthorIds),
                    'media_id' => $faker->randomElement($mediaIds),
                ]);
                array_push($pageIds, $page->id);
                
                // Content Generation
                $body_html = '';
                $body_json = '{"blocks":[';
                
                for ($j = 0; $j < mt_rand(3, 7); $j++) {
                    // Heading1
                    $heading = $faker->realText(40);
                    $body_json .= '{"type":"header","data":{"level":1,"text":"' . str_replace('"', '\"', $heading) . '"}},';
                    $body_html .= '<h1>' . $heading . '</h1>';
                    
                    // Paragraph
                    $paragraph = $faker->realText() . '.' . $faker->realText();
                    $body_json .= '{"type":"paragraph","data":{"text":"' . str_replace('"', '\"', $paragraph) . '"}},';
                    $body_html .= '<p>' . $paragraph . '</p>';

                    // Heading2
                    for ($k = 0; $k < mt_rand(0, 2); $k++) {
                        $heading = $faker->realText(40);
                        $body_json .= '{"type":"header","data":{"level":2,"text":"' . str_replace('"', '\"', $heading) . '"}},';
                        $body_html .= '<h2>' . $heading . '</h2>';
                        
                        // Paragraph
                        $paragraph = $faker->realText() . '.' . $faker->realText();
                        $body_json .= '{"type":"paragraph","data":{"text":"' . str_replace('"', '\"', $paragraph) . '"}},';
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
                            $listitem = $faker->catchPhrase();
                            $body_json .= '"' . str_replace('"', '\"', $listitem) . '",';
                            $body_html .= '<li>' . $listitem . '</li>';
                        }
                        
                        $body_json = rtrim($body_json, ",") . ']}},';
                        if ($type == 'ordered') {
                            $body_html .= '</ol>';
                        } else {
                            $body_html .= '</ul>';
                        }
                        
                    }

                    // Code & Table
                    for ($k = 0; $k < mt_rand(0, 1); $k++) {
                        $email = $faker->safeEmail;
                        $body_json .= '{"type":"code","data":{"code":"' . str_replace('"', '\"', "SELECT * FROM users WHERE email = '" . $email . "'") . '"}},';
                        $body_html .= '<pre><code class="hljs sql">';
                        $body_html .= '<span class="hljs-keyword">SELECT</span>' . " * " . '<span class="hljs-keyword">FROM</span>' . " users " . '<span class="hljs-keyword">WHERE</span>' . " email = " . '<span class="hljs-string">' . "'" . $email . "'" . '</span>';
                        $body_html .= '</code></pre>';

                        // Table
                        /*
                        $name = $faker->name;
                        $member = $faker->randomElement($array = ['Platinum', 'Gold']);
                        $joined = $faker->date($format = 'Y-m-d', $max = 'now');

                        $json_rows = '["Name","Email","Member","Joined"],["' . str_replace('"', '\"', $name) . '","' . str_replace('"', '\"', $email) . '","' . str_replace('"', '\"', $member)  . '","'  . str_replace('"', '\"', $joined) . '"]';
                        $body_json .= '{"type":"table","data":{"content":[' . $json_rows . ']}},';

                        $body_html .= '<table class="wt-table"><tbody>';
                        $body_html .= '<tr class="wt-table-tr"><td class="wt-table-td">Name</td><td class="wt-table-td">Email</td><td class="wt-table-td">Member</td><td class="wt-table-td">Joined</td><tr>';
                        $body_html .= '<tr class="wt-table-tr"><td class="wt-table-td">' . $name . '</td><td class="wt-table-td">' . $email . '</td><td class="wt-table-td">' . $member  . '</td><td class="wt-table-td">'  . $joined . '</td><tr>';
                        $body_html .= '</tbody></table>';
                        */
                    }

                    // Paragraph
                    for ($k = 0; $k < mt_rand(1, 5); $k++) {
                        $paragraph = $faker->realText() . '.' . $faker->realText();
                        $body_json .= '{"type":"paragraph","data":{"text":"' . str_replace('"', '\"', $paragraph) . '"}},';
                        $body_html .= '<p>' . $paragraph . '</p>';

                        // Media
                        $media = $faker->randomElement($mediaArray);
                        $caption = $faker->catchPhrase;
                        $withBorder = "false";
                        $stretched = "false";
                        $withBackground = "false";

                        $body_json .= '{"type":"image","data":{"file":{"id":' . $media->id . ',"path":"' . $media->path . '","url":"' . $media->url . '"},"caption":"' . str_replace('"', '\"', $caption) . '","withBorder":' . $withBorder . ',"stretched":' . $stretched . ',"withBackground":' . $withBackground . '}},';
                        $body_html .= '<div class="my-4"><figure class="img-fig"><img src="' . $media->url . '" alt="' . $caption . '"></img><figcaption class="text-sm mt-3 img-fig-caption' . (($stretched || $withBackground) ? ' text-center' :'') . '">' . $caption . '</figcaption></figure></div>';
                    }
                }

                $body_json = rtrim($body_json, ",") . ']}';


                // Page Contents
                $pageContent = factory(PageContent::class)->create([
                    'page_id' => $page->id,
                    'body_json' => $body_json,
                    'body_html' => $body_html
                ]);
                
            }
        }
        // End of Pages

        // Category Comment
        // Skip some User from commenting
        $tempUserIds = $userIds;
        shuffle($tempUserIds);
        $tempUserIds = array_slice($tempUserIds, 3);
        foreach ($categoryIds as $categoryId) {
            foreach ($tempUserIds as $userId) {
                $categoryComments = factory(CategoryComment::class, mt_rand(0, 1))->create([
                    'reference_id' => $categoryId,
                    'user_id' => $userId,
                ]); 
            }
        }
        

        // Page Comment
        // Skip some User from commenting
        $tempUserIds = $userIds;
        shuffle($tempUserIds);
        $tempUserIds = array_slice($tempUserIds, 3);
        foreach ($pageIds as $pageId) {
            foreach ($tempUserIds as $userId) {
                $pageComments = factory(PageComment::class, mt_rand(0, 1))->create([
                    'reference_id' => $pageId,
                    'user_id' => $userId,
                ]); 
            }
        }
        
    }
}
