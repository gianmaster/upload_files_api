<?php
/**
 * Created by PhpStorm.
 * User: DesProjectos.002
 * Date: 08/06/2016
 * Time: 12:22
 */

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract{

    public function transform(User $user){
        return[
            'id'            => $user->uuid,
            'email'         => $user->email,
            'name'          => $user->name,
            'created_at'    => (string)$user->created_at,
            'updated_at'    => (string)$user->updated_at
        ];
    }


}