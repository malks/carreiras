<?php

use Illuminate\Database\Seeder;

class OurTeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * 
     */
    public function run()
    {
        DB::table('our_team')->insert([
            'name'=>'Osmar Gascho',
            'job'=>'Fullstack Engineer',
            'facebook_link'=>'',
            'twitter_link'=>'',
            'linkedin_link'=>'',
            'picture'=>'eu.jpg',
            'testimonial'=>'Great place to Work!',
            'active_from'=>'1970-01-01',
            'active_to'=>'2030-01-01',
        ]);
        DB::table('our_team')->insert([
            'name'=>'Alessandro Alan Alexandre',
            'job'=>'Fullstack Engineer',
            'facebook_link'=>'',
            'twitter_link'=>'',
            'linkedin_link'=>'',
            'picture'=>'ale.jpeg',
            'testimonial'=>'Great place to Work!',
            'active_from'=>'1970-01-01',
            'active_to'=>'2030-01-01',
        ]);
        DB::table('our_team')->insert([
            'name'=>'Karl Mendes',
            'job'=>'Fullstack Engineer',
            'facebook_link'=>'',
            'twitter_link'=>'',
            'linkedin_link'=>'',
            'picture'=>'karl.jpeg',
            'testimonial'=>'Great place to Work!',
            'active_from'=>'1970-01-01',
            'active_to'=>'2030-01-01',
        ]);                
    }
}
