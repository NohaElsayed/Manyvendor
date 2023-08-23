<?php

use Illuminate\Database\Seeder;

class CurrenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currencies')->insert([
            'name' => 'Dollar',
            'code' => 'USD',
            'symbol' => '$',
            'rate' => '1',
            'is_published' => true,
            'align' => false,
            'image' =>'Flag_of_the_United_States.png'
        ]);
    }
}
