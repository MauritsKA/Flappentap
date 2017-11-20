<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mutation extends Model
{
    protected $guarded = [];
    
    public function getRouteKeyName(){
        return 'mutation_count';
    }
    
    public function company()
    {
        return $this->belongsTo(Company::class);
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
    
    public function users(){
       return $this->belongsToMany(User::class)->withPivot('nickname');
    } 
    
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    
    public function mutationtype()
    {
        return $this->belongsTo(Mutationtype::class);
    }
    
    public function vattype()
    {
        return $this->belongsTo(Vattype::class);
    }
    
}
