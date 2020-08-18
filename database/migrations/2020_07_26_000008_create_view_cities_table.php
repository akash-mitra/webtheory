<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('view_cities', function (Blueprint $table) {
            $table->integer('month_key')->index();
            $table->string('city', 255)->nullable()->index();
            $table->integer('total_views');
            $table->timestamp('created_at')->useCurrent();
            $table->unique(['month_key', 'city']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('view_cities');
    }
}
