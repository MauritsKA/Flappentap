<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mutationtype extends Model
{
    public function mutations()
    {
        return $this->hasMany(Mutation::class);
    }
    
    public function versions()
    {
        return $this->hasMany(Version::class);
    }
}
