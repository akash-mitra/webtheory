<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('category_id')->nullable()->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('title', 100);
            $table->string('summary', 1048)->nullable();
            $table->string('metakey')->nullable();
            $table->string('metadesc')->nullable();
            $table->unsignedInteger('media_id')->nullable()->index();
            $table->string('status', 30)->default('Draft')->index();
            $table->string('access_plan')->nullable()->index();
            $table->string('options', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
