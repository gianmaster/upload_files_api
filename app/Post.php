<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * @var string
     */
    public $table = 'posts';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'uuid', 'body'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class, 'id', 'user_id');
    }


    //protected $dateFormat = 'Ymd H:i:s'; //primer solucion. solo guarda, no lee
    //protected $dateFormat = 'Y-d-m H:i:s';
}
