<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
         array(
             'name'=>'admin',
             'slug'=>'slug',
             'email'=>'admin@mail.com',
             'user_type'=>'Admin'
         )
        ]);
    }
}
