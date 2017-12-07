<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Approval extends Model
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
    
    public function editor()
    {
        return $this->belongsTo(User::class);
    }
}
