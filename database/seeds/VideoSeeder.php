<?php

use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('video')->insert([
            'file'=>'https://www.youtube.com/embed/Sq_GxjLaDRc',
            'title'=>'Moda',
            'title_background'=>'com significado',
            'face'=>'bg-home.jpg',
            'active'=>'1',
        ]);
    }
}
