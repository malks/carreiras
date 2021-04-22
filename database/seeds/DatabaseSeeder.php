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
    }
}
