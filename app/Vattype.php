<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vattype extends Model
{
    public function mutations()
    {
        return $this->hasMany(Mutation::class);
    }
    
    public function versions()
    {
        return $this->hasMany(Version::class);
    }
    
     public function company()
    {
        return $this->belongsTo(Company::class);
    }
    
}
