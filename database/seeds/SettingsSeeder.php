<?php

use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            array(
                'name'  =>'default_currencies',
                'value' =>'1'
            ),
            array(
                'name'  =>'type_logo',
                'value' =>''
            ),
            array(
                'name'  =>'type_name',
                'value' =>''
            ),
            array(
                'name'  =>'type_footer',
                'value' =>''
            ),
            array(
                'name'  =>'type_mail',
                'value' =>''
            ),
            array(
                'name'  =>'type_address',
                'value' =>''
            ),
            array(
                'name'  =>'type_fb',
                'value' =>''
            ),
            array(
                'name'  =>'type_tw',
                'value' =>''
            ),
            array(
                'name'  =>'type_number',
                'value' =>''
            ),
            array(
                'name'  =>'type_google',
                'value' =>''
            ),
            array(
                'name'  =>'footer_logo',
                'value' =>''
            ),
            array(
                'name'  =>'favicon_icon',
                'value' =>''
            ),
            array(
                'name'=>'seller',
                'value'=>'enable'
            ),
            array(
                'name'=>'primary_color',
                'value'=>''
            ),
            array(
                'name'=>'secondary_color',
                'value'=>''
            ),
            array(
                'name'=>'seller_mode',
                'value'=>'freedom'
            ),
            array(
                'name'=>'verification',
                'value'=>''
            ),
            array(
                'name'=>'login_modal',
                'value'=>''
            ),
            array(
                'name'=>'payment_logo',
                'value'=>''
            ),
            array(
                'name'=>'type_ios',
                'value'=>''
            ),
            array(
                'name'=>'type_appstore',
                'value'=>''
            ),
            array(
                'name'=>'type_playstore',
                'value'=>''
            ),
            array(
                'name'=>'type_android',
                'value'=>''
            ),
        ]);
    }
}
