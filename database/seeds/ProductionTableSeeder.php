<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->addDefaultCategory();

        $this->addDefaultPage();

        $this->addDefaultParameters();

        $this->addDefaultTemplates();
    }



    private function addDefaultCategory ()
    {
        DB::table('categories')->insert([
            'name' => 'Uncategorised',
            'parent_id' => null,
            'description' => 'All other pages which are not part of any specific topic.',
            'metakey' => 'Uncategorised',
            'metadesc' => 'Uncategorised',
            'media_id' => null,
            'user_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }



    private function addDefaultPage ()
    {
        DB::table('pages')->insert([
            'category_id' => 1,
            'user_id' => 1,
            'title' => 'Getting Started',
            'summary' => 'This is your Space and it is Fabulous Place to be there',
            'metakey' => 'Webtheory, Getting Started',
            'metadesc' => 'Getting Started with Webtheory',
            'media_id' => null,
            'status' => 'Live',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('page_contents')->insert([
            'page_id' => 1,
            'body_json' => '{"time":1588996014099,"blocks":[{"type":"header","data":{"text":"Welcome aboard!","level":3}},{"type":"paragraph","data":{"text":"We at WebTheory, have put our heart, soul and sweat to bring you the next-generation  Content Management System."}},{"type":"paragraph","data":{"text":"You now have access to highly advanced and superfast platform - integrated with powerful tools such as analytics, social integration, media management, CDN, AMP, SEO tools etc."}},{"type":"paragraph","data":{"text":"As you start writing your first article in the WebTheory platform, we wish you very best of writing time. We are always available a mail away from you but very close to the CMS."}},{"type":"paragraph","data":{"text":"Feel free to reach out when you are stuck anywhere in between."}},{"type":"paragraph","data":{"text":"Enjoy writing creating delightful and successful site using WebTheory."}},{"type":"paragraph","data":{"text":"Spread the love and word about us to the world."}},{"type":"paragraph","data":{"text":"Thank you very much for choosing us."}},{"type":"paragraph","data":{"text":"*Note: *This is a default page created and it is published on your site by us. Kindly go to Pages —&gt;  and switch it to Draft to take it down from Live."}}],"version":"2.16.1"}',
            'body_html' => '<h3>Welcome aboard!</h3><p>We at WebTheory, have put our heart, soul and sweat to bring you the next-generation  Content Management System.</p><p>You now have access to highly advanced and superfast platform - integrated with powerful tools such as analytics, social integration, media management, CDN, AMP, SEO tools etc.</p><p>As you start writing your first article in the WebTheory platform, we wish you very best of writing time. We are always available a mail away from you but very close to the CMS.</p><p>Feel free to reach out when you are stuck anywhere in between.</p><p>Enjoy writing creating delightful and successful site using WebTheory.</p><p>Spread the love and word about us to the world.</p><p>Thank you very much for choosing us.</p><p>*Note: *This is a default page created and it is published on your site by us. Kindly go to Pages —&gt;  and switch it to Draft to take it down from Live.</p>',
            'editor' => 'editorjs',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }



    private function addDefaultParameters ()
    {
        // SITE
        DB::table('parameters')->insert([
            'key' => 'siteinfo',
            'value' => '{"name": "My Blog", "title": "My Blog Title", "desc": "My Blog Description"}',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // EDITOR
        DB::table('parameters')->insert([
            'key' => 'editor',
            'value' => 'editorjs',
            'created_at' => now(),
            'updated_at' => now()
        ]);


        // SOCIAL LOGIN
        DB::table('parameters')->insert([
            'key' => 'socialprovider',
            'value' => '{"facebook": "Disabled", "twitter": "Disabled", "linkedin": "Disabled", "google": "Disabled"}',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('parameters')->insert([
            'key' => 'socialprovider_redirect_url',
            'value' => '{"facebook": "' . $this->getUrl('facebook') . '", "twitter": "' . $this->getUrl('twitter') . '", "linkedin": "' . $this->getUrl('linkedin') . '", "google": "' . $this->getUrl('google') . '"}',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('parameters')->insert([
            'key' => 'FACEBOOK_CLIENT_ID',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'FACEBOOK_CLIENT_SECRET',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'TWITTER_CLIENT_ID',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'TWITTER_CLIENT_SECRET',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'LINKEDIN_CLIENT_ID',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'LINKEDIN_CLIENT_SECRET',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'GOOGLE_CLIENT_ID',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'GOOGLE_CLIENT_SECRET',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);


        // MAIL DRIVER
        DB::table('parameters')->insert([
            'key' => 'MAIL_DRIVER',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('parameters')->insert([
            'key' => 'MAIL_FROM_ADDRESS',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'MAIL_FROM_NAME',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'MAIL_HOST',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'MAIL_PORT',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'MAIL_ENCRYPTION',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'MAIL_USERNAME',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'MAIL_PASSWORD',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'MAILGUN_DOMAIN',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'MAILGUN_SECRET',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'MAILGUN_ENDPOINT',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'POSTMARK_TOKEN',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'AWS_ACCESS_KEY_ID',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'AWS_SECRET_ACCESS_KEY',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('parameters')->insert([
            'key' => 'AWS_DEFAULT_REGION',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);

    }

    private function getUrl($provider)
    {
        return env('APP_URL') . '/app/social/login/' .$provider . '/callback';
    }


    private function addDefaultTemplates ()
    {
        $templateParameters = [
            [
                "name" => "headingFont",
                "type" => "list",
                "options" => "Verdana, Arial, Playfair Display",
                "value" => "Playfair Display"
            ],
            [
                "name" => "primaryColor",
                "type" => "list",
                "options" => "gray,red,orange,yellow,green,teal,blue,indigo,purple,pink",
                "value" => "orange"
            ],
            [
                "name" => "centerContent",
                "type" => "list",
                "options" => "yes,no",
                "value" => "yes"
            ]
        ];

        DB::table('templates')->insert([
            'name' => 'Serenity',
            'description' => 'A spotless template that provides a clean and simple user experience for the users of your blog.',
            'media_url' => 'https://source.unsplash.com/apax4M-4kFI',
            'active' => 1,
            'user_id' => 1,
            'parameters' => json_encode($templateParameters),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }


}
