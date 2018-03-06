<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Krat extends Model
{
	protected $table = 'krat';
    protected $guarded = [];
	
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
