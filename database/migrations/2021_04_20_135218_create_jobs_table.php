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
            $table->integer('status')->default(0);
            $table->string('period')->nullable();
            $table->string('picture')->nullable()->default('/img/gallery.png');
            $table->integer('home_highlights')->default(1);
            $table->integer('home_slider')->default(1);
            $table->string('cod_senior')->nullable();
            $table->string('cod_rqu_senior')->nullable();
            $table->string('cod_est_senior')->nullable();
            $table->string('cod_hie_senior')->nullable();
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->timestamps();
            $table->unique(['cod_senior', 'cod_rqu_senior','cod_est_senior','cod_hie_senior'],'senior_keys');
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
