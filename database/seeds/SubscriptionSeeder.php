<?php

use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subscribed')->insert(
            [
                'candidate_id'=>1,
                'job_id'=>1,
            ]
        );
    }
}
