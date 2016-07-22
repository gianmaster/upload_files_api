<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Dingo\Api\Routing\Helpers;
use App\Http\Requests;
use Authorizer;

/**
 * Class OAuthController
 * @package App\Http\Controllers\Auth
 */
class OAuthController extends Controller
{
    use Helpers;

    /**
     * @return mixed
     */
    public function authorizeClient(){
        return $this->response->array(Authorizer::issueAccessToken());
    }


    /**
     * @param $username
     * @param $password
     * @return mixed
     */
    public function authorizePassword($username, $password){
        $credentials = [
            'email'     => $username,
            'password'  => $password,
        ];

        if(Auth::once($credentials)){
            return Auth::user()->id;
        }

        return false;
    }
}
