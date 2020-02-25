<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProductionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->addAdminUser();

        $this->addDefaultCategory();

        $this->addDefaultParameters();

        $this->addDefaultTemplates();
    }


    private function addAdminUser ()
    {
        factory(User::class)->create([
            'name' => env('ADMIN_USER_NAME'),
            'email' => env('ADMIN_USER_EMAIL'),
            'email_verified_at' => now(),
            'password' => Hash::make(env('ADMIN_USER_PASSWORD')),
            'role' => 'admin',
        ]);
    }



    private function addDefaultCategory ()
    {
        DB::table('categories')->insert([
            'name' => 'Uncategorised',
            'parent_id' => null,
            'description' => 'All other pages which are not part of any specific topic.',
            'metakey' => '',
            'metadesc' => '',
            'media_id' => null,
            'user_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }



    private function addDefaultParameters ()
    {
        DB::table('parameters')->insert([
            'key' => 'siteinfo',
            'value' => '{"name":"","title":"","desc":""}',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }



    private function addDefaultTemplates ()
    {
        DB::table('templates')->insert([
            'name' => 'Serenity',
            'type' => 'home',
            'description' => 'A spotless template that provides a clean and simple user experience for the users of your blog.',
            'media_url' => 'https://source.unsplash.com/apax4M-4kFI',
            'active' => 1,
            'user_id' => 1,
            'parameters' => '[{"name":"headingFont","type":"list","options":"Verdana, Arial, Playfair Display","value":"Playfair Display"},{"name":"primaryColor","type":"list","options":"gray,red,orange,yellow,green,teal,blue,indigo,purple,pink","value":"orange"}]',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('templates')->insert([
            'name' => 'Serenity',
            'type' => 'single',
            'description' => 'A spotless template that provides a clean and simple user experience for the users of your blog.',
            'media_url' => 'https://source.unsplash.com/apax4M-4kFI',
            'active' => 1,
            'user_id' => 1,
            'parameters' => '[{"name":"primaryColor","type":"list","options":"gray,red,orange,yellow,green,teal,blue,indigo,purple,pink","value":"orange"},{"name":"centerContent","type":"list","options":"yes,no","value":"yes"}]',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('templates')->insert([
            'name' => 'Serenity',
            'type' => 'category',
            'description' => 'A spotless template that provides a clean and simple user experience for the users of your blog.',
            'media_url' => 'https://source.unsplash.com/apax4M-4kFI',
            'active' => 1,
            'user_id' => 1,
            'parameters' => '[{"name":"primaryColor","type":"list","options":"gray,red,orange,yellow,green,teal,blue,indigo,purple,pink","value":"orange"}]',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

}
