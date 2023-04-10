<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMapPoints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('map_points', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('map_id')->unsigned();
            $table->integer('parent_id')->default(0);
            $table->string('name');
            $table->string('xcoord')->default('1');
            $table->string('ycoord')->default('1');
            $table->string('content')->nullable();
            $table->string('header')->nullable();
            $table->string('body')->nullable();
            $table->string('hint')->nullable();
            $table->foreign('map_id')->references('id')->on('maps')->onDelete('cascade');
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
        Schema::dropIfExists('map_points');
    }
}
