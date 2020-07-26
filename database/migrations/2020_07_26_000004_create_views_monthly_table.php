<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewsMonthlyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('views_monthly', function (Blueprint $table) {
            $table->integer('month_key')->index();
            $table->integer('total_views');
            $table->integer('unique_vistors');
            $table->string('content_type', 255)->index();
            $table->unsignedBigInteger('content_id')->index();
            $table->string('platform', 255)->nullable()->index();
            $table->string('browser', 255)->index();
            $table->string('referrer_domain', 255)->nullable();
            $table->string('country', 255)->nullable()->index();
            $table->string('city', 255)->nullable();
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
        Schema::dropIfExists('views_monthly');
    }
}
