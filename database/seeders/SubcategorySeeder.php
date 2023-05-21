<?php

namespace Database\Seeders;

use App\Models\Subcategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subcategories = [
            //Para categoria: celulares y tablets
            [
                'category_id' => 1,
                'name'=>'Celulares y smartphones',
                'slug'=>Str::slug('Celulares y smartphones'),
                'color'=> true
            ],

            [
                'category_id' => 1,
                'name'=>'Accesorios para celulares',
                'slug'=>Str::slug('Accesorios para celulares'),
            ],

            [
                'category_id' => 1,
                'name'=>'Smartwaches',
                'slug'=>Str::slug('Smartwaches'),
            ],


            //Para categoria: Tv y Audio

            [
                'category_id' => 2,
                'name'=>'TV y audio',
                'slug'=>Str::slug('TV y audio'),
            ],

            [
                'category_id' => 2,
                'name'=>'Audios',
                'slug'=>Str::slug('Audios'),
            ],

            [
                'category_id' => 2,
                'name'=>'Audios para autos',
                'slug'=>Str::slug('Audio para autos'),
            ],


            //Para categoria: Consola y videojuegos

            [
                'category_id' => 3,
                'name'=>'xbox',
                'slug'=>Str::slug('xbox'),
            ],

            [
                'category_id' => 3,
                'name'=>'PS',
                'slug'=>Str::slug('PS'),
            ],

            [
                'category_id' => 3,
                'name'=>'Nintendo',
                'slug'=>Str::slug('Nintendo'),
            ],

            //Para categoria: Computación

            [
                'category_id' => 4,
                'name'=>'Portatiles',
                'slug'=>Str::slug('Portatiles'),
            ],

            [
                'category_id' => 4,
                'name'=>'PC Escritorio',
                'slug'=>Str::slug('PC Escritorio'),
            ],


            //Para categoria: Moda

            [
                'category_id' => 5,
                'name'=>'GTX',
                'slug'=>Str::slug('GTX'),
                'color'=>true,
                'size'=>true,
            ],

            [
                'category_id' => 5,
                'name'=>'RTX',
                'slug'=>Str::slug('RTX'),
                'color'=>true,
                'size'=>true,
            ],

            [
                'category_id' => 5,
                'name'=>'GX',
                'slug'=>Str::slug('GX'),
            ],

            [
                'category_id' => 5,
                'name'=>'AMD',
                'slug'=>Str::slug('AMD'),
            ],

            
        ];

        foreach ($subcategories as $subcategory){
            Subcategory::create($subcategory);
        }
    }
}
