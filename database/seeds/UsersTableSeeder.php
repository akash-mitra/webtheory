<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create a system admin user
        factory(User::class)->create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            // 'password' => Hash::make(str_random(8)),
            // 'type' => 'admin',
            // 'role' => 'admin',
        ]);
    }
}
