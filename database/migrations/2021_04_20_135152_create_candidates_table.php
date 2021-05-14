<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('name');
            $table->string('cpf')->nullable();
            $table->string('address_street')->nullable();
            $table->string('address_number')->nullable();
            $table->string('address_district')->nullable();
            $table->string('address_city')->nullable();
            $table->string('address_state')->nullable();
            $table->string('address_country')->nullable();
            $table->string('natural_city')->nullable();
            $table->string('natural_state')->nullable();
            $table->string('natural_country')->nullable();
            $table->string('civil_state')->nullable();
            $table->string('gender')->nullable();
            $table->string('weight')->nullable();
            $table->string('height')->nullable();
            $table->string('spouse_name')->nullable();
            $table->string('zip',10)->nullable();
            $table->string('cv')->nullable();
            $table->datetime('dob')->nullable();
            $table->datetime('last_seen')->nullable();
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
        Schema::dropIfExists('candidates');
    }
}
