<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeyResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('key_results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('objective_id')->unsigned();
            $table->foreign('objective_id')->references('id')->on('objectives')->onDelete('cascade');
            $table->string('title');
            $table->tinyInteger('confidence');
            $table->float('initial_value');
            $table->float('target_value');
            $table->float('current_value');
            $table->tinyInteger('weight');
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
        Schema::dropIfExists('key_results');
    }
}
