<?php

use Illuminate\Database\Seeder;

class ExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * @return void
     */
    public function run()
    {
        DB::table('experience')->insert(
            [
                'candidate_id'=>'1',
                'business'=>'empresa anterior',
                'job'=>'trabalhador',
                'activities'=>'coisas de trabalho',
                'admission'=>'2021-01-01',
                'demission'=>'2021-06-01',
            ],
        );
        DB::table('experience')->insert(
            [
                'candidate_id'=>'2',
                'business'=>'empresa anterior',
                'job'=>'trabalhador',
                'activities'=>'coisas de trabalho',
                'admission'=>'2021-01-01',
                'demission'=>'2021-06-01',
            ],
        );
    }
}
