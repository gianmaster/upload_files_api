<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
header('Access-Control-Allow-Origin: *');
header( 'Access-Control-Allow-Headers: Authorization, Content-Type' );
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function(){
    return \Webpatser\Uuid\Uuid::generate(4);
});

Route::get('/usuarios', function(){
    return App\User::all();
});

Route::get('/test_upload/{referencia}/{token}/{client_id}/{username}', function($referencia, $token, $client_id, $username){
    header("Access-Control-Allow-Origin: *");
    $cliente = \App\Entities\OauthClient::find($client_id);
    if (!$cliente) {
        return '<h1 style="color: #8d0000;">El "client_id" no es correcto</h1>';
    }

    return view('upload_file_api', array('token' => $token, 'referencia' => $referencia, 'client_id' => $client_id, 'username' => $username));
});

Route::post('/upload', 'FileStorageController@uploadRemote');


Route::post('oauth/access_token', function() {
    return Response::json(Authorizer::issueAccessToken());
});

Route::get('archivos/{uuid}/descarga', 'ArchivosController@download_v2');


//Route::resource('catalogos', 'CatalogosController');
//Route::get('catalogos/{catalogo}/items', 'CatalogosController@getItems');
//Route::resource('catalogos.item', 'CatalogoItemsController');

/**
 * Rutas del API - Dingo Implementation
 */
$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function($api) {

    //$api->group(['namespace' => 'App\Http\Controllers', 'middleware' => 'testing'],
    $api->group(['namespace' => 'App\Http\Controllers'], function ($api) {
        $api->post('/auth/authorize-client', 'Auth\OAuthController@authorizeClient');
        $api->post('/auth/authorize-password', 'Auth\OAuthController@authorizePassword');

        $api->group(['middleware' => 'cors'], function($api){

            $api->group(['middleware' => 'api.auth'], function ($api) {

                $api->resource('users', 'UsersController');
                $api->resource('me', 'ProfileController');

                $api->resource('catalogos', 'CatalogosController');
                $api->get('catalogos/{catalogo}/items', 'CatalogosController@getItems');
                //$api->resource('catalogos.item', 'CatalogosController');

                $api->resource('archivos', 'ArchivosController');
                $api->get('archivos/{ref}/referencia', 'ArchivosController@indexByReferencia');
                $api->get('archivos/{uuid}/download', 'ArchivosController@download_v2');


            });
        });



    });

});
