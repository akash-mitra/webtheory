<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewBrowsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('view_browsers', function (Blueprint $table) {
            $table->integer('month_key')->index();
            $table->string('browser', 255)->index();
            $table->integer('total_views');
            $table->timestamp('created_at')->useCurrent();
            $table->unique(['month_key', 'browser']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('view_browsers');
    }
}
