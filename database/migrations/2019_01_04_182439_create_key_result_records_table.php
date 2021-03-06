<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeyResultRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('key_result_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('key_results_id')->unsigned();
            $table->foreign('key_results_id')->references('id')->on('key_results')->onDelete('cascade');
            $table->float('history_value');
            $table->tinyInteger('history_confidence');
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
        Schema::dropIfExists('key_result_records');
    }
}
