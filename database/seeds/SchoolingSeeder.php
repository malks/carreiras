<?php

use Illuminate\Database\Seeder;

class SchoolingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('schooling')->insert(
            [
                'candidate_id'=>'1',
                'formation'=>'superior',
                'status'=>'complete',
                'course'=>'Tecnologia em Redes de Computadores',
                'grade'=>'graduation',
                'institution'=>'Senai Joinville',
                'start'=>'2008-01-01',
                'end'=>'2011-04-01'
            ],

        );
        DB::table('schooling')->insert(
            [
                'candidate_id'=>'2',
                'formation'=>'superior',
                'status'=>'coursing',
                'course'=>'Bacharelado em Ciência da Computação',
                'grade'=>'graduation',
                'institution'=>'Católica',
                'start'=>'2012-01-01',
                'end'=>'2013-01-01'
            ]
        );
    }
}
