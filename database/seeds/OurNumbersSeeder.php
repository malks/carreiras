<?php

use Illuminate\Database\Seeder;

class OurNumbersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * 
     *           $table->string('title')->nullable();
     *   $table->string('number')->nullable();
     *     $table->datetime('active_from')->nullable();
     *      $table->datetime('active_to')->nullable();
     *
     * 
     */
    public function run()
    {
        DB::table('our_numbers')->insert([
            'title'=>'Colaboradores',
            'number'=>'7701',
            'active_from'=>'1970-01-01',
            'active_to'=>'2030-01-01',
        ]);
        DB::table('our_numbers')->insert([
            'title'=>'Vagas Novas Nesse Ano',
            'number'=>'200',
            'active_from'=>'1970-01-01',
            'active_to'=>'2030-01-01',
        ]);
        DB::table('our_numbers')->insert([
            'title'=>'Vagas em Aberto',
            'number'=>'30',
            'active_from'=>'1970-01-01',
            'active_to'=>'2030-01-01',
        ]);        
    }
}
