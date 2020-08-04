<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewsIpStagingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('views_ip_staging', function (Blueprint $table) {
            $table->integer('month_key')->index();
            $table->ipAddress('ip');
            $table->bigInteger('batch_id');
            $table->timestamp('created_at')->useCurrent();
            $table->unique(['month_key', 'ip']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('views_ip_staging');
    }
}
