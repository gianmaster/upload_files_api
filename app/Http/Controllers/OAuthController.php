<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use App\Http\Requests;
use LucaDegasperi\OAuth2Server\Authorizer;

class OAuthController extends Controller
{
    use Helpers;

    public function authorizeClient(){
        return $this->response->array(Authorizer::issueAccessToken());
    }
}
