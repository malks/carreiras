<?php

use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * 
     *       $table->integer('home_highlights')->default(0);
     *       $table->integer('home_slider')->default(0);
     * 
     */
    public function run()
    {
        DB::table('jobs')->insert(
            [
                'field_id'=>'1',
                'unit_id'=>'1',
                'name'=>'Desenvolvedor',
                'description'=>'Uma descrição \r\n com muitas \r\n linhas ',
                'activities'=>'atividadesss',
                'required'=>'requisitos',
                'desirable'=>'desejavel',
                'status'=>'1',
                'home_highlights'=>'1',
                'home_slider'=>'1',
                'period'=>'07 as 12 e 13 as 17',
                'created_at'=>'2021-06-05 01:03:04',
            ]
        );
        DB::table('jobs')->insert(
            [
                'field_id'=>'1',
                'unit_id'=>'1',
                'name'=>'Analista',
                'description'=>'Uma descrição \r\n com muitas \r\n linhas ',
                'activities'=>'atividadesss',
                'required'=>'requisitos',
                'desirable'=>'desejavel',
                'status'=>'1',
                'home_highlights'=>'1',
                'home_slider'=>'1',
                'created_at'=>'2021-06-05 01:03:04',
                'period'=>'07 as 12 e 13 as 17'
            ]
        );
        DB::table('jobs')->insert(
            [
                'field_id'=>'1',
                'unit_id'=>'1',
                'name'=>'ccccccccccc',
                'description'=>'Uma descrição \r\n com muitas \r\n linhas ',
                'activities'=>'atividadesss',
                'required'=>'requisitos',
                'desirable'=>'desejavel',
                'status'=>'1',
                'home_highlights'=>'1',
                'home_slider'=>'1',
                'created_at'=>'2021-06-05 01:03:04',
                'period'=>'07 as 12 e 13 as 17'
            ]
        );
        DB::table('jobs')->insert(
            [
                'field_id'=>'1',
                'unit_id'=>'1',
                'name'=>'yyyyyyy',
                'description'=>'Uma descrição \r\n com muitas \r\n linhas ',
                'activities'=>'atividadesss',
                'required'=>'requisitos',
                'desirable'=>'desejavel',
                'status'=>'1',
                'home_highlights'=>'1',
                'home_slider'=>'1',
                'created_at'=>'2021-06-05 01:03:04',
                'period'=>'07 as 12 e 13 as 17'
            ]
        );
        DB::table('jobs')->insert(
            [
                'field_id'=>'1',
                'unit_id'=>'1',
                'name'=>'zzzzzzz',
                'description'=>'Uma descrição \r\n com muitas \r\n linhas ',
                'activities'=>'atividadesss',
                'required'=>'requisitos',
                'desirable'=>'desejavel',
                'status'=>'1',
                'home_highlights'=>'1',
                'home_slider'=>'1',
                'created_at'=>'2021-06-05 01:03:04',
                'period'=>'07 as 12 e 13 as 17'
            ]
        );
        DB::table('jobs')->insert(
            [
                'field_id'=>'1',
                'unit_id'=>'1',
                'name'=>'xxxxxx',
                'description'=>'Uma descrição \r\n com muitas \r\n linhas ',
                'activities'=>'atividadesss',
                'required'=>'requisitos',
                'desirable'=>'desejavel',
                'status'=>'1',
                'home_highlights'=>'1',
                'home_slider'=>'1',
                'created_at'=>'2021-06-05 01:03:04',
                'period'=>'07 as 12 e 13 as 17'
            ]
        );
        DB::table('jobs')->insert(
            [
                'field_id'=>'1',
                'unit_id'=>'1',
                'name'=>'asdfasdf',
                'description'=>'Uma descrição \r\n com muitas \r\n linhas ',
                'activities'=>'atividadesss',
                'required'=>'requisitos',
                'desirable'=>'desejavel',
                'status'=>'1',
                'home_highlights'=>'1',
                'home_slider'=>'1',
                'created_at'=>'2021-06-05 01:03:04',
                'period'=>'07 as 12 e 13 as 17'
            ]
        );
        DB::table('jobs')->insert(
            [
                'field_id'=>'1',
                'unit_id'=>'1',
                'name'=>'lkjlkjlkj',
                'description'=>'Uma descrição \r\n com muitas \r\n linhas ',
                'activities'=>'atividadesss',
                'required'=>'requisitos',
                'desirable'=>'desejavel',
                'status'=>'1',
                'home_highlights'=>'1',
                'home_slider'=>'1',
                'created_at'=>'2021-06-05 01:03:04',
                'period'=>'07 as 12 e 13 as 17'
            ]
        );
    }
}
