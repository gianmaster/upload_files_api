<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Transformers\UserTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;


class ProfileController extends Controller
{
    use Helpers;
    //
    public function index(){
        $user = app('Dingo\Api\Auth\Auth')->user();
        return $this->response->item($user, new UserTransformer());
    }
}
