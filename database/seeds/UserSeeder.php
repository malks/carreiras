<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(['name'=>'osmar','email'=>'osmar@nbwdigital.com.br','password'=>'$2y$10$dF48iufbs5V0rxczhsBP/OP4pWDVcuQwrEk1QxCSaHuQ0hq05PP5W']);
        DB::table('roles')->insert(['name'=>'admin','guard_name'=>'web']);
        DB::table('model_has_roles')->insert(['role_id'=>'1','model_type'=>'App\User','model_id'=>'1']);
        DB::table('permissions')->insert(['name'=>'access admin','guard_name'=>'web']);
        DB::table('role_has_permissions')->insert(['permission_id'=>'1','role_id'=>'1']);
    }
}
