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
        DB::table('users')->insert([
            'name' => "Maurits Korthals Altes",
            'email' => "maurits@blulocks.com",
            'password' => bcrypt('wachtwoord'),
        ]);
        
        DB::table('users')->insert([
            'name' => "ronald",
            'email' => "ronald@blulocks.com",
            'password' => bcrypt('wachtwoord'),
        ]);
        
        DB::table('users')->insert([
            'name' => "duco",
            'email' => "duco@blulocks.com",
            'password' => bcrypt('wachtwoord'),
        ]);
        
        DB::table('users')->insert([
            'name' => "hugo",
            'email' => "hugo@blulocks.com",
            'password' => bcrypt('wachtwoord'),
        ]);
        
        DB::table('users')->insert([
            'name' => "gijs",
            'email' => "gijs@blulocks.com",
            'password' => bcrypt('wachtwoord'),
        ]);
        
        DB::table('users')->insert([
            'name' => "Alexander",
            'email' => "alexander@blulocks.com",
            'password' => bcrypt('wachtwoord'),
        ]);
        
        DB::table('balances')->insert([
            'name' => "Leeuwenstein",
            'balance_code' => "B1kJXWSEnHri",
            'user_id' => 1,
        ]);
        
        DB::table('balance_user')->insert([
            'balance_id' => 1,
            'user_id' => 1,
            'nickname' => "Noodle",
        ]);
        
        DB::table('balance_user')->insert([
            'balance_id' => 1,
            'user_id' => 2,
            'nickname' => "Yoko",
        ]);
        
        DB::table('balance_user')->insert([
            'balance_id' => 1,
            'user_id' => 3,
            'nickname' => "Molly",
        ]);
        
        DB::table('balance_user')->insert([
            'balance_id' => 1,
            'user_id' => 4,
            'nickname' => "Bert",
        ]);
        
        DB::table('balance_user')->insert([
            'balance_id' => 1,
            'user_id' => 5,
            'nickname' => "Bolus",
        ]);
        
        DB::table('balance_user')->insert([
            'balance_id' => 1,
            'user_id' => 6,
            'nickname' => "HJ",
        ]);
        $this->call('CsvTableSeeder');
    }
}
