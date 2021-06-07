<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOurNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('our_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('number')->nullable();
            $table->datetime('active_from')->nullable();
            $table->datetime('active_to')->nullable();
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
        Schema::dropIfExists('our_numbers');
    }
}
