<?php

use Illuminate\Database\Seeder;

class SeniorSyncSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('senior_sync')->insert(
            [
                'type'=>'import',
                'active'=>'1',
            ],
        );
        DB::table('senior_sync')->insert(
            [
                'type'=>'export',
                'active'=>'1',
            ],
        );
    }
}
