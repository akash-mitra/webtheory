<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('alias')->nullable();
            $table->unsignedInteger('parent_id')->nullable();
            $table->unsignedInteger('sequence_num');
            $table->unsignedBigInteger('menuable_id');
            $table->string('menuable_type');
            $table->boolean('home')->default(false)->index();
            $table->timestamps();
            $table->unique(['parent_id', 'sequence_num']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
