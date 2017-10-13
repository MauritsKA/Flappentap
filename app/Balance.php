<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class List extends Model
{
   protected $guarded = [];
  
    public function getRouteKeyName(){
        return 'list_code';
    }
    
    public function users(){
       return $this->belongsToMany(User::class);
    } 
}
