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
                'candidate_id'=>2,
                'job_id'=>1,
            ]
        );
        DB::table('subscribed')->insert(
            [
                'candidate_id'=>3,
                'job_id'=>1,
            ]
        );
        DB::table('subscribed_has_states')->insert(
            [
                'subscribed_id'=>1,
                'state_id'=>1,
            ]
        );
        DB::table('subscribed_has_states')->insert(
            [
                'subscribed_id'=>2,
                'state_id'=>1,
            ]
        );

    }
}
