<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class OauthClient extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'oauth_clients';

    protected $fillable = ['id', 'secret', 'created_at', 'updated_at', 'name', 'path'];

}
