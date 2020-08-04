<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('views', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->ipAddress('ip');
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->dateTime('at');
            $table->integer('date_key');
            $table->string('url', 500);
            $table->string('content_type', 255)->index();
            $table->unsignedBigInteger('content_id')->index();
            $table->string('platform', 255)->nullable();
            $table->string('browser', 255);
            $table->string('version', 255);
            $table->string('referrer', 500)->nullable();
            $table->string('referrer_domain', 255)->nullable();
            $table->string('session_id');
            $table->string('country', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('views');
    }
}
