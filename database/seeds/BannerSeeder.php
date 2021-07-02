<?php

use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * 
     */
    public function run()
    {
        DB::table('banners')->insert([
            'name'=>'Banner Default',
            'title_big'=>'Lunelli Carreiras',
            'title_big_color'=>'#fff',
            'title_big_outline'=>'outline-dark-grey',
            'title_small'=>'HÁ 40 ANOS CRIANDO MODA COM SIGNIFICADO',
            'title_small_color'=>'',
            'title_small_outline'=>'outline-dark-grey',
            'cta'=>'Confira',
            'background'=>'lunelli-carreiras-banner.png',
            'active_from'=>'1970-01-01',
            'active_to'=>'2030-01-01',
            'order'=>'1',
        ]);
        DB::table('banners')->insert([
            'name'=>'Banner 2',
            'title_big'=>'SEGUNDA PAGINA',
            'title_big_color'=>'#fff',
            'title_big_outline'=>'outline-dark-grey',
            'title_small'=>'aqui vai mais info',
            'title_small_color'=>'',
            'title_small_outline'=>'outline-dark-grey',
            'cta'=>'Confira',
            'background'=>'lunelli-carreiras-banner.png',
            'active_from'=>'1970-01-01',
            'active_to'=>'2030-01-01',
            'order'=>'2',
        ]);
        DB::table('banners')->insert([
            'name'=>'Banner 3',
            'title_big'=>'TERCERAA',
            'title_big_color'=>'#fff',
            'title_big_outline'=>'outline-dark-grey',
            'title_small'=>'aqui vai mais info',
            'title_small_color'=>'',
            'title_small_outline'=>'outline-dark-grey',
            'cta'=>'Confira',
            'background'=>'lunelli-carreiras-banner.png',
            'active_from'=>'1970-01-01',
            'active_to'=>'2030-01-01',
            'order'=>'3',
        ]);
    }
}
