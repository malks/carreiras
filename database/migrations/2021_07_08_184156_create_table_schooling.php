<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSchooling extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schooling', function (Blueprint $table) {
            $table->id();
            $table->integer('candidate_id');
            $table->string('formation');
            $table->string('status');
            $table->string('course');
            $table->string('grade');
            $table->string('institution');
            $table->date('start');
            $table->date('end');
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
        Schema::dropIfExists('schooling');
    }
}
