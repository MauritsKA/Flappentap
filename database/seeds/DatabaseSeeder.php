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
        
        DB::table('items')->insert([
            'company_id' => 1,
            'description' => "Development",
        ]);
        
        DB::table('items')->insert([
            'company_id' => 1,
            'description' => "Marketing",
        ]);
        
        DB::table('items')->insert([
            'company_id' => 1,
            'description' => "Transportation",
        ]);
        
         DB::table('items')->insert([
            'company_id' => 2,
            'description' => "Prototyping",
        ]);
        
        DB::table('vattypes')->insert([
            'company_id' => 1,
            'fraction' => 0.21,
            'type' => "High",
        ]);
        
        DB::table('vattypes')->insert([
            'company_id' => 1,
            'fraction' => 0.06,
            'type' => "Low",
        ]);
        
        DB::table('vattypes')->insert([
            'company_id' => 1,
            'fraction' => 0,
            'type' => "International",
        ]);
        
        DB::table('vattypes')->insert([
            'company_id' => 2,
            'fraction' => 0,
            'type' => "European",
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
    }
}
