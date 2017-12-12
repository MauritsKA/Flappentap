<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'iban'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function getRouteKeyName(){
        return 'id';
    }
    
    public function balances(){
       return $this->belongsToMany(Balance::class)->withPivot('nickname','archived','admin');
    }  
    
    public function mutations(){
       return $this->belongsToMany(Mutation::class);
    } 
    
    public function invitations(){
        return $this->hasMany(Invitation::class);
    }
    
    public function versions(){
       return $this->belongsToMany(Version::class)->withPivot('weight');;
    } 
    
    public function approvals(){
        return $this->hasMany(Invitation::class);
    }
}
