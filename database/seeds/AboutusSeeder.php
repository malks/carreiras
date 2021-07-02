<?php

use Illuminate\Database\Seeder;

class AboutusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * 
     *             $table->string('title')->nullable();
     *       $table->string('background_title')->nullable();
     *       $table->string('testimonial')->nullable();
     *       $table->string('testimonial_author')->nullable();
     *       $table->string('testimonial_author_picture')->nullable();
     *
     * 
     */
    public function run()
    {
        DB::table('about_us')->insert([
            'title'=>'Lunelli',
            'background_title'=>'Moda com Significado',
            'testimonial'=>'Algumas palavras profundas, simples e com significado',
            'testimonial_author'=>'Dênis Luiz Lunelli',
            'testimonial_author_picture'=>'denis-novo.png',
        ]);
    }
}
