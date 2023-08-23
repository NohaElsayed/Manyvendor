<?php

use Illuminate\Database\Seeder;

class SectionSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('section_settings')->insert([
            array(
                'active'=>'1',
                'sort'=>'1',
                'name'=>'Main banner section with menu',
                'blade_name'=>'main-banner',
                'image'=>'images/section/main-banner.png'
            ),
            array(
                'active'=>'1',
                'sort'=>'2',
                'name'=>'Search trending section',
                'blade_name'=>'search-trending',
                'image'=>'images/section/search-trending.png'
            ),
            array(
                'active'=>'1',
                'sort'=>'3',
                'name'=>'Deal of day',
                'blade_name'=>'deal-day',
                'image'=>'images/section/deal-day.png'
            ),
            array(
                'active'=>'1',
                'sort'=>'4',
                'name'=>'Shop brand section',
                'blade_name'=>'shop-brand',
                'image'=>'images/section/shop-brand.png'
            ),
            array(
                'active'=>'1',
                'sort'=>'5',
                'name'=>'Shop store section',
                'blade_name'=>'shop-store',
                'image'=>'images/section/shop-store.png'
            ),
            array(
                'active'=>'1',
                'sort'=>'6',
                'name'=>'Promotional banner section',
                'blade_name'=>'promotional-banner',
                'image'=>'images/section/promotional-banner.png'
            ),
            array(
                'active'=>'1',
                'sort'=>'7',
                'name'=>'Top-categories section',
                'blade_name'=>'top-categories',
                'image'=>'images/section/top-categories.png'
            ),
            array(
                'active'=>'1',
                'sort'=>'8',
                'name'=>'Category promotional section',
                'blade_name'=>'category-promotional',
                'image'=>'images/section/category-promotional.png'
            ),
        ]);

    }
}
