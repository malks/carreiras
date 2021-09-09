<?php

use Illuminate\Database\Seeder;

class LanguagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('languages')->insert(
            [
                'name'=>'Espanhol',
            ]
        );
        DB::table('languages')->insert(
            [
                'name'=>'Ingles',
            ]
        );
        DB::table('languages')->insert(
            [
                'name'=>'Alemão',
            ]
        );
        DB::table('languages')->insert(
            [
                'name'=>'Castelhano',
            ]
        );

    }
}
