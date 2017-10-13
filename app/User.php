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
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
 
    public function companies(){
       return $this->belongsToMany(Company::class);
    } 
    
    public function balances(){
       return $this->belongsToMany(Balance::class);
    }  
    
    
    public function mutations(){
       return $this->belongsToMany(Mutation::class);
    } 
    
    public function versions(){
       return $this->belongsToMany(Version::class);
    } 
}
