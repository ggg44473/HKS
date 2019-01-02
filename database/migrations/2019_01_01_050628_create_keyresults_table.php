<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeyresultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keyresults', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('owner')->unsigned();
            $table->foreign('owner')->references('id')->on('objectives')->onDelete('cascade');
            $table->string('title');
            $table->tinyInteger('confidence');
            $table->float('initial');
            $table->float('target');
            $table->float('now');
            $table->tinyInteger('weight');
            $table->tinyInteger('average');
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
        Schema::dropIfExists('keyresults');
    }
}
