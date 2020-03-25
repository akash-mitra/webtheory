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
            $table->unsignedBigInteger('user_id')->nullable();
            $table->float('at', 4);
            $table->string('url', 500);
            $table->string('content_type', 255);
            $table->unsignedBigInteger('content_id');
            $table->string('platform', 255);
            $table->string('browser', 255);
            $table->string('version', 255);
            $table->string('referrer', 500);
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
