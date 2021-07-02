<?php

use Illuminate\Database\Seeder;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert([
            'name'=>'programação',
        ]);
        DB::table('tags')->insert([
            'name'=>'moda',
        ]);
        DB::table('tags')->insert([
            'name'=>'costura',
        ]);
        DB::table('tags')->insert([
            'name'=>'vendas',
        ]);
        DB::table('tags')->insert([
            'name'=>'finanças',
        ]);
        DB::table('tags')->insert([
            'name'=>'gestão',
        ]);
        DB::table('tags')->insert([
            'name'=>'sistemas',
        ]);
        DB::table('jobs_tags')->insert([
            'job_id'=>'1',
            'tag_id'=>'1',
        ]);
        DB::table('jobs_tags')->insert([
            'job_id'=>'1',
            'tag_id'=>'7',
        ]);
        DB::table('jobs_tags')->insert([
            'job_id'=>'2',
            'tag_id'=>'1',
        ]);
        DB::table('jobs_tags')->insert([
            'job_id'=>'2',
            'tag_id'=>'7',
        ]);
        DB::table('jobs_tags')->insert([
            'job_id'=>'3',
            'tag_id'=>'4',
        ]);
        DB::table('jobs_tags')->insert([
            'job_id'=>'3',
            'tag_id'=>'5',
        ]);        
    }
}
