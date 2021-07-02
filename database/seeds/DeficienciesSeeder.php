<?php

use Illuminate\Database\Seeder;

class DeficienciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('deficiencies')->insert(
            [
                'name'=>'Deficiência Visual',
            ]
        );
        DB::table('deficiencies')->insert(
            [
                'name'=>'Deficiência Física',
            ]
        );
        DB::table('deficiencies')->insert(
            [
                'name'=>'Deficiência Intelectual',
            ]
        );
        DB::table('deficiencies')->insert(
            [
                'name'=>'Deficiência Psicossocial',
            ]
        );
        DB::table('deficiencies')->insert(
            [
                'name'=>'Deficiência Múltipla',
            ]
        );
        DB::table('deficiencies')->insert(
            [
                'name'=>'Reabilitado pelo INSS',
            ]
        );
    }
}
