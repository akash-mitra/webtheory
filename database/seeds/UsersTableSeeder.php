<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => config('app.admin_user'),
            'email' => config('app.admin_email'),
            'email_verified_at' => now(),
            'password' => Hash::make(config('app.admin_password')),
            'role' => 'admin',
            'avatar' =>
                'https://webtheory01.sgp1.cdn.digitaloceanspaces.com/webtheory.co/assets/avatar.jpeg',
            'preferences' => '["broadcast", "database", "mail"]',
            'public_id' => Str::random(30),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
