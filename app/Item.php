<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public function mutations()
    {
        return $this-belongsTo(Mutation::class);
    }
    
    public function versions()
    {
        return $this-belongsTo(Version::class);
    }
    
    public function company()
    {
        return $this-belongsTo(Company::class);
    }
}
