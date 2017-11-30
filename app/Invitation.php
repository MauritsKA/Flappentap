<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $guarded = [];
    
    public function getRouteKeyName(){
        return 'token';
    }
    
    public function balance()
    {
        return $this->belongsTo(Balance::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
