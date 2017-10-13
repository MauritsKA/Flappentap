<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Updatetype extends Model
{
     public function versions()
    {
        return $this-belongsTo(Version::class);
    }
}
