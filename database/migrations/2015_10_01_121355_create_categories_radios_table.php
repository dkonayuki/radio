<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesRadiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories_radios', function (Blueprint $table) {
            $table->increments('id');
            //$table->foreign('radio_id')->references('id')->on('radios');
            //$table->foreign('category_id')->references('id')->on('categories');
            $table->integer('radio_id');
            $table->integer('category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('categories_radios');
    }
}
