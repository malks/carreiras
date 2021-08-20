<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->integer('field_id');
            $table->integer('unit_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->text('activities')->nullable();
            $table->text('required')->nullable();
            $table->text('desirable')->nullable();
            $table->integer('status');
            $table->string('period')->nullable();
            $table->string('picture')->nullable();
            $table->integer('home_highlights')->default(0);
            $table->integer('home_slider')->default(0);
            $table->integer('cod_senior')->nullable();
            $table->date('start')->nullable();
            $table->date('end')->nullable();
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
        Schema::dropIfExists('jobs');
    }
}
