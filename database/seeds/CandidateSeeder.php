<?php

use Illuminate\Database\Seeder;

class CandidateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('candidates')->insert(['user_id'=>'1','email'=>'osmar@nbwdigital.com.br','phone'=>'4799999999','name'=>'osmar gascho','cpf'=>'cpfzim','address'=>'rua do mal','district'=>'aguaverd','city'=>'jgua do sul','state'=>'Santa catarina','country'=>'Brasil','zip'=>'89250000','cv'=>'','dob'=>'1900-01-01']);
    }
}