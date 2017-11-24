<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    protected $guarded = [];
    
    public function mutation()
    {
        return $this->belongsTo(Mutation::class);
    }
    
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    
    public function mutationtype()
    {
        return $this->belongsTo(Mutationtype::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function users(){
       return $this->belongsToMany(User::class)->withPivot('weight');
    } 
    
     public function editor()
    {
        return $this->belongsTo(User::class);
    }
    
    public function vattype()
    {
        return $this->belongsTo(Vattype::class);
    }
}
