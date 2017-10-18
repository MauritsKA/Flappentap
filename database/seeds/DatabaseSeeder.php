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
        
        DB::table('updatetypes')->insert([
            'type' => "Create",
        ]);
        
        DB::table('updatetypes')->insert([
            'type' => "Update",
        ]);
        
        DB::table('updatetypes')->insert([
            'type' => "Delete",
        ]);
        
        DB::table('mutationtypes')->insert([
            'type' => "Add",
        ]);
        
        DB::table('mutationtypes')->insert([
            'type' => "From",
        ]);
        
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
        
        DB::table('users')->insert([
            'name' => "filip",
            'email' => "filip@blulocks.com",
            'password' => bcrypt('123mau..'),
        ]);
        
    }
}
