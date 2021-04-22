<?php

use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('units')->insert(['name'=>'Comercial','address'=>'Rua Athanásio Rosa, 883','city'=>'Guaramirim','state'=>'Santa Catarina','country'=>'Brasil']);
        DB::table('units')->insert(['name'=>'Vestuário','address'=>'Rua Athanásio Rosa, 883','city'=>'Guaramirim','state'=>'Santa Catarina','country'=>'Brasil']);
        DB::table('units')->insert(['name'=>'Beneficiamento','address'=>'Rua Athanásio Rosa, 883','city'=>'Corupá','state'=>'Santa Catarina','country'=>'Brasil']);
        DB::table('units')->insert(['name'=>'Abimex','address'=>'Rua Athanásio Rosa, 883','city'=>'Jaraguá do Sul','state'=>'Santa Catarina','country'=>'Brasil']);
    }
}
