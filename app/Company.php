<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\User;

class Company extends Model
{
    
    protected $guarded = [];
  
    public function getRouteKeyName(){
        return 'company_code';
    }
    
    public function users(){
       return $this->belongsToMany(User::class);
    }    
    
    public function mutations()
    {
        return $this->hasMany(Mutation::class);
    }
    
    public function items()
    {
        return $this->hasMany(Item::class);
    }
    
    public function vattypes()
    {
        return $this->hasMany(Vattype::class);
    }
}


 
    