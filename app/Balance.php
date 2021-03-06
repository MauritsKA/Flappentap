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
       return $this->belongsToMany(User::class)->withPivot('nickname','archived','admin');
    } 
    
    public function mutations(){
        return $this->hasMany(Mutation::class);
    }
    
    public function invitations(){
        return $this->hasMany(Invitation::class);
    }
    
     public function approvals(){
        return $this->hasMany(Invitation::class);
    }
}
