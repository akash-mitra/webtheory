<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUserAddSlug extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // add a new column
        Schema::table('users', function (Blueprint $table) {
            $table->string('public_id', 30)->default('0');
        });

        // update the data of this new column
        $users = DB::table('users')->where('public_id', '0')->get();
        foreach($users as $user)
        {
            DB::table('users')
            ->where('id', $user->id)
            ->update([
                "public_id" => Str::random(30)
            ]);
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn('public_id');

        });
    }
}
