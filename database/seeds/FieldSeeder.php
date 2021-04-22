<?php

use Illuminate\Database\Seeder;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fields')->insert(['name'=>'Comercial','description'=>'desc']);
        DB::table('fields')->insert(['name'=>'Produção','description'=>'desc']);
        DB::table('fields')->insert(['name'=>'Financeiro','description'=>'desc']);
        DB::table('fields')->insert(['name'=>'Infraestrutura','description'=>'desc']);
        DB::table('fields')->insert(['name'=>'Sistemas','description'=>'desc']);
        DB::table('fields')->insert(['name'=>'Marketing','description'=>'desc']);
        DB::table('fields')->insert(['name'=>'Vendas','description'=>'desc']);
        DB::table('fields')->insert(['name'=>'Expedição','description'=>'desc']);
        DB::table('fields')->insert(['name'=>'Atendimento ao Cliente','description'=>'desc']);
        DB::table('fields')->insert(['name'=>'Zeladoria','description'=>'desc']);
        DB::table('fields')->insert(['name'=>'Criação','description'=>'desc']);
    }
}
