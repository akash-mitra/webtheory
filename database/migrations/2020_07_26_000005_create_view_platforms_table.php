<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewPlatformsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('view_platforms', function (Blueprint $table) {
            $table->integer('month_key')->index();
            $table->string('platform', 255)->index();
            $table->integer('total_views');
            $table->timestamp('created_at')->useCurrent();
            $table->unique(['month_key', 'platform']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('view_platforms');
    }
}
