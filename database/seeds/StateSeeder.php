<?php

use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('states')->insert(
            [
                'name'=>"Inscrito",
                'candidate_visible'=>1,
            ]
        );
        DB::table('states')->insert(
            [
                'name'=>"Rejeitado",
                'candidate_visible'=>1,
            ]
        );
        DB::table('states')->insert(
            [
                'name'=>"Contratado",
                'candidate_visible'=>1,
            ]
        );
        DB::table('states')->insert(
            [
                'name'=>"Visualizado",
            ]
        );
        DB::table('states')->insert(
            [
                'name'=>"Sincronizado",
            ]
        );
        DB::table('states')->insert(
            [
                'name'=>"Selecionado",
                'sync_to_senior'=>1,
            ]
        );
        DB::table('states')->insert(
            [
                'name'=>"Contatado",
            ]
        );
        DB::table('states')->insert(
            [
                'name'=>"Agendada Entrevista",
                'candidate_visible'=>1,
            ]
        );
        DB::table('states')->insert(
            [
                'name'=>"Entrevistado",
            ]
        );
    }
}
