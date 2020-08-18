<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewsDailyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('views_daily', function (Blueprint $table) {
            $table->integer('date_key')->unique()->index();
            $table->integer('total_views');
            $table->integer('unique_visitors');
            $table->integer('bounce_rate');
            $table->integer('avg_visit_duration')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('views_daily');
    }
}
