<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('view_contents', function (Blueprint $table) {
            $table->integer('month_key')->index();
            $table->string('content_type', 255)->index();
            $table->unsignedBigInteger('content_id')->index();
            $table->integer('total_views');
            $table->timestamp('created_at')->useCurrent();
            $table->unique(['month_key', 'content_type', 'content_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('view_contents');
    }
}
