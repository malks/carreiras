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
        DB::table('candidates')->insert(['user_id'=>'1','email'=>'osmar@nbwdigital.com.br','phone'=>'4799999999','name'=>'osmar gascho','cpf'=>'cpfzim','address_street'=>'rua do mal','address_district'=>'aguaverd','address_city'=>'jgua do sul','address_state'=>'Santa catarina','address_country'=>'Brasil','zip'=>'89250000','cv'=>'','dob'=>'1900-01-01']);
        DB::table('candidates')->insert(['user_id'=>'2','email'=>'karl.mendes@nbwdigital.com.br','phone'=>'4799999999','name'=>'karlmendes','cpf'=>'cpfzim','address_street'=>'rua do mal','address_district'=>'aguaverd','address_city'=>'jgua do sul','address_state'=>'Santa catarina','address_country'=>'Brasil','zip'=>'89250000','cv'=>'','dob'=>'1900-01-01']);
        DB::table('candidates')->insert(['user_id'=>'2','email'=>'aleale@lunelli.com.br','phone'=>'4799999999','name'=>'alealalale','cpf'=>'cpfzim','address_street'=>'rua do mal','address_district'=>'aguaverd','address_city'=>'jgua do sul','address_state'=>'Santa catarina','address_country'=>'Brasil','zip'=>'89250000','cv'=>'','dob'=>'1900-01-01']);
    }
}