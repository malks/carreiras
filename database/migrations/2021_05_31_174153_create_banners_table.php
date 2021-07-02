<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('title_big')->nullable();
            $table->string('title_big_color')->nullable();
            $table->string('title_big_outline')->default('');
            $table->string('title_small')->nullable();
            $table->string('title_small_color')->nullable();
            $table->string('title_small_outline')->default('');
            $table->string('cta')->nullable();
            $table->string('background')->nullable();
            $table->datetime('active_from')->nullable();
            $table->datetime('active_to')->nullable();
            $table->integer('order')->nullable();
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
        Schema::dropIfExists('banners');
    }
}
