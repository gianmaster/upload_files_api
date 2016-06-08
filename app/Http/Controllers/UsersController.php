<?php

namespace App\Http\Controllers;

use App\Transformers\UserTransformer;
use App\User;
use Illuminate\Http\Request;

use Dingo\Api\Routing\Helpers;

use App\Http\Requests;
use Webpatser\Uuid\Uuid;

class UsersController extends Controller
{
    use Helpers;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return User::all();

        //convierte la respuesta nativamente en json
        //return $this->response->array(['id' => 1]); // esto con los helpers de dingo

        //hace uso del helper de dingo, con el metodo collection paso como parametro al modelo y el transformer. El transformer de Fractal
        //return $this->response->collection(User::all(), new UserTransformer());

        //retorno de los datos con pagineo
        return $this->response->paginator(User::paginate(10), new UserTransformer());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\CreateUserRequest $request)
    {
        //el proceso de creacion deberia estar en un comander - investigar
        $data = $request->except('password_confirmation');
        $data['password'] = bcrypt($data['password']);
        //generacion del Uuid con laravel UUid
        $data['uuid'] = Uuid::generate(4)->string;//conversion a string
        $user = User::create($data);
        return $this->response->item($user, new UserTransformer());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
