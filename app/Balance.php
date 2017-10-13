<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
   protected $guarded = [];
  
    public function getRouteKeyName(){
        return 'balance_code';
    }
    
    public function users(){
       return $this->belongsToMany(User::class);
    } 
}
