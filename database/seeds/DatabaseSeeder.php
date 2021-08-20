<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(FieldSeeder::class);
        $this->call(UnitSeeder::class);
        $this->call(JobSeeder::class);
        $this->call(CandidateSeeder::class);
        $this->call(BannerSeeder::class);
        $this->call(AboutusSeeder::class);
        $this->call(OurNumbersSeeder::class);
        $this->call(OurTeamSeeder::class);
        $this->call(VideoSeeder::class);
        $this->call(TagsSeeder::class);
        $this->call(DeficienciesSeeder::class);
        $this->call(SchoolingSeeder::class);
        $this->call(ExperienceSeeder::class);
        $this->call(SubscriptionSeeder::class);
        $this->call(StateSeeder::class);
        $this->call(SeniorSyncSeeder::class);
    }
}
