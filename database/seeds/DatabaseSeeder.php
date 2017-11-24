<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('balance_user')->insert([
            'balance_id' => 1,
            'user_id' => 1,
            'nickname' => "noodle",
        ]);
        
        DB::table('balance_user')->insert([
            'balance_id' => 1,
            'user_id' => 2,
            'nickname' => "Puk",
        ]);
        
        DB::table('balance_user')->insert([
            'balance_id' => 1,
            'user_id' => 3,
            'nickname' => "bolus",
        ]);
        
        DB::table('balance_user')->insert([
            'balance_id' => 1,
            'user_id' => 4,
            'nickname' => "bert",
        ]);
        
        DB::table('balance_user')->insert([
            'balance_id' => 1,
            'user_id' => 5,
            'nickname' => "mol",
        ]);
        
        DB::table('balance_user')->insert([
            'balance_id' => 1,
            'user_id' => 6,
            'nickname' => "yoko",
        ]);
        
//         DB::table('balance_user')->insert([
//            'balance_id' => 1,
//            'user_id' => 7,
//            'nickname' => "poef",
//        ]);
//        
//         DB::table('balance_user')->insert([
//            'balance_id' => 1,
//            'user_id' => 8,
//            'nickname' => "guus",
//        ]);
//        
//         DB::table('balance_user')->insert([
//            'balance_id' => 1,
//            'user_id' => 9,
//            'nickname' => "gert",
//        ]);
//        
//         DB::table('balance_user')->insert([
//            'balance_id' => 1,
//            'user_id' => 10,
//            'nickname' => "lars",
//        ]);
//        
//         DB::table('balance_user')->insert([
//            'balance_id' => 1,
//            'user_id' => 11,
//            'nickname' => "kokkie",
//        ]);
//        
//         DB::table('balance_user')->insert([
//            'balance_id' => 1,
//            'user_id' => 12,
//            'nickname' => "ketamien",
//        ]);
                
        DB::table('users')->insert([
            'name' => "Maurits Korthals Altes",
            'email' => "maurits@blulocks.com",
            'password' => bcrypt('123mau..'),
        ]);
        
         DB::table('users')->insert([
            'name' => "Alexander",
            'email' => "alexander@blulocks.com",
            'password' => bcrypt('123mau..'),
        ]);
        
         DB::table('users')->insert([
            'name' => "gijs",
            'email' => "gijs@blulocks.com",
            'password' => bcrypt('123mau..'),
        ]);
        
         DB::table('users')->insert([
            'name' => "hugo",
            'email' => "hugo@blulocks.com",
            'password' => bcrypt('123mau..'),
        ]);
        
        DB::table('users')->insert([
            'name' => "duco",
            'email' => "duco@blulocks.com",
            'password' => bcrypt('123mau..'),
        ]);
        
        DB::table('users')->insert([
            'name' => "ronald",
            'email' => "ronald@blulocks.com",
            'password' => bcrypt('123mau..'),
        ]);
        
//        DB::table('users')->insert([
//            'name' => "michiel",
//            'email' => "michiel@blulocks.com",
//            'password' => bcrypt('123mau..'),
//        ]);
//        
//        DB::table('users')->insert([
//            'name' => "aernout",
//            'email' => "aernout@blulocks.com",
//            'password' => bcrypt('123mau..'),
//        ]);
//        
//        DB::table('users')->insert([
//            'name' => "tjeerd",
//            'email' => "tjeerd@blulocks.com",
//            'password' => bcrypt('123mau..'),
//        ]);
//        
//        DB::table('users')->insert([
//            'name' => "ludo",
//            'email' => "ludo@blulocks.com",
//            'password' => bcrypt('123mau..'),
//        ]);
//        
//        DB::table('users')->insert([
//            'name' => "matthijs",
//            'email' => "matthijs@blulocks.com",
//            'password' => bcrypt('123mau..'),
//        ]);
//        
//        DB::table('users')->insert([
//            'name' => "rik",
//            'email' => "rik@blulocks.com",
//            'password' => bcrypt('123mau..'),
//        ]);
//        
//        DB::table('users')->insert([
//            'name' => "filip",
//            'email' => "filip@blulocks.com",
//            'password' => bcrypt('123mau..'),
//        ]);
        
        
        
    }
}
