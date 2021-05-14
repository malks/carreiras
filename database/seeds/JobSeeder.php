<?php

use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jobs')->insert(['field_id'=>'1','unit_id'=>'1','name'=>'Desenvolvedor','description'=>'Uma descrição \r\n com muitas \r\n linhas ','activities'=>'atividadesss','required'=>'requisitos','desirable'=>'desejavel','status'=>'0','period'=>'07 as 12 e 13 as 17']);
    }
}
