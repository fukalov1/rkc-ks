<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailforms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mailforms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('sender');
            $table->string('sender_name')->default('');
            $table->text('signature')->nullable();
            $table->integer('page_id')->unsigned();
            $table->integer('page_block_id')->unsigned();
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
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
        Schema::dropIfExists('mailforms');
    }
}
