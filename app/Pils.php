<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pils extends Model
{
	protected $guarded = [];
	
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
