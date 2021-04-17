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

        $this->addDefaultBatchJob();
    }

    private function addDefaultCategory()
    {
        DB::table('categories')->insert([
            'name' => 'Uncategorised',
            'parent_id' => null,
            'description' =>
                'A placeholder for all pages that are not part of any specific category.',
            'metakey' => 'Uncategorised',
            'metadesc' => 'Uncategorised',
            'media_id' => null,
            'user_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function addDefaultPage()
    {
        DB::table('pages')->insert([
            'category_id' => 1,
            'user_id' => 1,
            'title' => 'Welcome to WebTheory',
            'summary' =>
                'WebTheory is not just another CMS platform. We strive to be the web-superiority platform for the modern content creators who deserve much more from their web content platforms.',
            'metakey' => 'Webtheory, Getting Started',
            'metadesc' => 'Getting Started with Webtheory',
            'media_id' => null,
            'status' => 'Live',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('page_contents')->insert([
            'page_id' => 1,
            'body_json' =>
                '{"time":1597942805577,"blocks":[{"type":"header","data":{"text":"Welcome aboard!","level":3}},{"type":"paragraph","data":{"text":"To be a successful content creator, you need so much more than just the ability to create blog posts. For example, you need to actively build your audiences, manage social media accounts, run newsletters, syndicate feeds, optimize search engine performance and do so much more."}},{"type":"paragraph","data":{"text":"<b><i>At WebTheory, we have taken it on to ourselves to make this journey super easy for you.<\/i><\/b>"}},{"type":"paragraph","data":{"text":"We bring to you a web-superiority platform that is way advanced from other CMSes - with support for integrated and powerful modules, analytics, social integration, media management, CDN, AMP, SEO and many more."}},{"type":"header","data":{"text":"Thank you for helping us with beta testing","level":3}},{"type":"paragraph","data":{"text":"We are truly indebted to you for helping us out on the beta testing of our product. In this phase, we will churn out new updates quite often that will contain both bug fixes and new features. Feel free to reach out to us when you need any help or you are stuck anywhere.<br>"}},{"type":"paragraph","data":{"text":"Finally, enjoy building delightful contents and successful site using WebTheory."}},{"type":"paragraph","data":{"text":"<b>- From WebTheory Team<\/b><br>"}},{"type":"paragraph","data":{"text":"<b>PS:&nbsp; <\/b><i><mark class=\"cdx-marker\">Spread the love and word about us to the world!<\/mark><\/i>"}},{"type":"header","data":{"text":"Note:","level":3}},{"type":"paragraph","data":{"text":"This is a default page created and published on your site by us. To unpublish this page, go to Pages menu in control panel, find this page and switch it to Draft mode.<br>"}}],"version":"2.18.0"}',
            'body_html' =>
                '<h3>Welcome aboard!</h3><p>To be a successful content creator, you need so much more than just the ability to create blog posts. For example, you need to actively build your audiences, manage social media accounts, run newsletters, syndicate feeds, optimize search engine performance and do so much more.</p><p><b><i>At WebTheory, we have taken it on to ourselves to make this journey super easy for you.</i></b></p><p>We bring to you a web-superiority platform that is way advanced from other CMSes - with support for integrated and powerful modules, analytics, social integration, media management, CDN, AMP, SEO and many more.</p><h3>Thank you for helping us with beta testing</h3><p>We are truly indebted to you for helping us out on the beta testing of our product. In this phase, we will churn out new updates quite often that will contain both bug fixes and new features. Feel free to reach out to us when you need any help or you are stuck anywhere.<br></p><p>Finally, enjoy building delightful contents and successful site using WebTheory.</p><p><b>- From WebTheory Team</b><br></p><p><b>PS:&nbsp; </b><i><mark class="cdx-marker">Spread the love and word about us to the world!</mark></i></p><h3>Note:</h3><p>This is a default page created and published on your site by us. To unpublish this page, go to Pages menu in control panel, find this page and switch it to Draft mode.<br></p>',
            'type' => 'editorjs',
            'display_order' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function addDefaultParameters()
    {
        // SITE
        DB::table('parameters')->insert([
            'key' => 'siteinfo',
            'value' =>
                '{"name": "My Blog", "title": "My Blog Title", "desc": "My Blog Description"}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // EDITOR
        DB::table('parameters')->insert([
            'key' => 'editor',
            'value' => 'editorjs',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // SOCIAL LOGIN
        DB::table('parameters')->insert([
            'key' => 'socialprovider',
            'value' => '{"webtheory": "On", "facebook": "Off", "twitter": "Off", "linkedin": "Off", "google": "Off"}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('parameters')->insert([
            'key' => 'socialprovider_redirect_url',
            'value' =>
                '{"facebook": "' .
                $this->getUrl('facebook') .
                '", "twitter": "' .
                $this->getUrl('twitter') .
                '", "linkedin": "' .
                $this->getUrl('linkedin') .
                '", "google": "' .
                $this->getUrl('google') .
                '"}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('parameters')->insert([
            'key' => 'FACEBOOK_CLIENT_ID',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parameters')->insert([
            'key' => 'FACEBOOK_CLIENT_SECRET',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parameters')->insert([
            'key' => 'TWITTER_CLIENT_ID',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parameters')->insert([
            'key' => 'TWITTER_CLIENT_SECRET',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parameters')->insert([
            'key' => 'LINKEDIN_CLIENT_ID',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parameters')->insert([
            'key' => 'LINKEDIN_CLIENT_SECRET',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parameters')->insert([
            'key' => 'GOOGLE_CLIENT_ID',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parameters')->insert([
            'key' => 'GOOGLE_CLIENT_SECRET',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // MAIL DRIVER
        DB::table('parameters')->insert([
            'key' => 'MAIL_DRIVER',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('parameters')->insert([
            'key' => 'MAIL_FROM_ADDRESS',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parameters')->insert([
            'key' => 'MAIL_FROM_NAME',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parameters')->insert([
            'key' => 'MAIL_HOST',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parameters')->insert([
            'key' => 'MAIL_PORT',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parameters')->insert([
            'key' => 'MAIL_ENCRYPTION',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parameters')->insert([
            'key' => 'MAIL_USERNAME',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parameters')->insert([
            'key' => 'MAIL_PASSWORD',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parameters')->insert([
            'key' => 'MAILGUN_DOMAIN',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parameters')->insert([
            'key' => 'MAILGUN_SECRET',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parameters')->insert([
            'key' => 'MAILGUN_ENDPOINT',
            'value' => 'api.mailgun.net',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parameters')->insert([
            'key' => 'POSTMARK_TOKEN',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parameters')->insert([
            'key' => 'AWS_ACCESS_KEY_ID',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parameters')->insert([
            'key' => 'AWS_SECRET_ACCESS_KEY',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parameters')->insert([
            'key' => 'AWS_DEFAULT_REGION',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ALGOLIA SEARCH
        DB::table('parameters')->insert([
            'key' => 'SEARCHABLE',
            'value' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parameters')->insert([
            'key' => 'ALGOLIA_COMMUNITY_PLAN',
            'value' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parameters')->insert([
            'key' => 'ALGOLIA_APP_ID',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('parameters')->insert([
            'key' => 'ALGOLIA_SECRET',
            'value' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function getUrl($provider)
    {
        return config('app.url') . '/social/login/' . $provider . '/callback';
    }

    private function addDefaultTemplates()
    {
        $templateParameters = [
            [
                'name' => 'headingFont',
                'type' => 'list',
                'options' => 'Verdana, Arial, Playfair Display',
                'value' => 'Playfair Display',
            ],
            [
                'name' => 'primaryColor',
                'type' => 'list',
                'options' => 'gray,red,orange,yellow,green,teal,blue,indigo,purple,pink',
                'value' => 'orange',
            ],
            [
                'name' => 'centerContent',
                'type' => 'list',
                'options' => 'yes,no',
                'value' => 'yes',
            ],
        ];

        DB::table('templates')->insert([
            'name' => 'Serenity',
            'description' =>
                'A spotless template that provides a clean and simple user experience for the users of your blog.',
            'media_url' => 'https://source.unsplash.com/nDd3dIkkOLo',
            'active' => 1,
            'user_id' => 1,
            'parameters' => json_encode($templateParameters),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function addDefaultBatchJob()
    {
        DB::table('batch_jobs')->insert([
            'batch_date' => '2000-01-01 00:00:00',
            'batch_name' => 'process_views_analytics_table',
            'start_datetime' => '2000-02-02 00:00:00',
            'end_datetime' => '2000-02-02  00:00:00',
            'start_view_id' => 0,
            'end_view_id' => 0,
            'status' => 'success',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
