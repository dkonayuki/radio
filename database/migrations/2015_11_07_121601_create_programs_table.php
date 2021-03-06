<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('radio_id')->unsigned();
            $table->foreign('radio_id')->references('id')->on('radios')->onDelete('cascade');
            $table->string('title');
            $table->text('desc');
            $table->string('media_url');
            $table->datetime('start_time');
            $table->datetime('end_time');
            $table->timestamps();
            $table->integer('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('programs');
    }
}
