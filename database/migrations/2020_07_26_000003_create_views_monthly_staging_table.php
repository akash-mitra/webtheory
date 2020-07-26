<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewsMonthlyStagingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('views_monthly_staging', function (Blueprint $table) {
            $table->ipAddress('ip');
            $table->timestamp('created_at');
            $table->string('content_type', 255)->index();
            $table->unsignedBigInteger('content_id')->index();
            $table->string('platform', 255)->nullable();
            $table->string('browser', 255);
            $table->string('referrer_domain', 255)->nullable();
            $table->string('session_id');
            $table->string('country', 255)->nullable();
            $table->string('city', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('views_monthly_staging');
    }
}
