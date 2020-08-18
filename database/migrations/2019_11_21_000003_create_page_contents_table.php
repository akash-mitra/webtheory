<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_contents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('page_id')->index();
            $table->longText('body_json')->nullable();
            $table->longText('body_html');
            $table->string('type')->nullable();
            $table->integer('display_order');
            $table->timestamps();
            // $table->unique(['page_id', 'display_order']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_contents');
    }
}
