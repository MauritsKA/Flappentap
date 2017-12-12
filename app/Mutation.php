<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mutation extends Model
{
    protected $guarded = [];
    
    public function getRouteKeyName(){
        return 'mutation_count';
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function balance()
    {
        return $this->belongsTo(Balance::class);
    }
    
    public function versions()
    {
        return $this->hasMany(Version::class);
    }
    
}
