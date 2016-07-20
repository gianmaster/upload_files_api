<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'uuid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts(){
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    //protected $dateFormat = 'Ymd H:i:s'; //primer solucion. solo guarda, no lee
    //protected $dateFormat = 'Y-d-m H:i:s';
    //protected $dateFormat = 'Y-m-d H:i:u';

}
