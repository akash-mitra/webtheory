<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batch_jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('batch_date')->index();
            $table->string('batch_name', 60)->index();
            $table->timestamp('start_datetime')->useCurrent();
            $table->timestamp('end_datetime')->nullable();
            $table->integer('start_view_id');
            $table->integer('end_view_id')->nullable();
            $table->string('status', 10)->index();
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
        Schema::dropIfExists('batch_jobs');
    }
}
