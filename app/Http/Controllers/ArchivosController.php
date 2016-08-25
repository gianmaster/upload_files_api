<?php

namespace App\Http\Controllers;

use App\Entities\Archivo;
use App\Entities\OauthClient;
use GrahamCampbell\Flysystem\FlysystemManager;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ArchivoCreateRequest;
use App\Http\Requests\ArchivoUpdateRequest;
use App\Repositories\ArchivoRepository;
use App\Validators\ArchivoValidator;


class ArchivosController extends Controller
{

    /**
     * @var ArchivoRepository
     */
    protected $repository;

    /**
     * @var ArchivoValidator
     */
    protected $validator;

    protected $flysystem;

    public function __construct(ArchivoRepository $repository, ArchivoValidator $validator, FlysystemManager $fly)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
        $this->flysystem = $fly;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $archivos = $this->repository->all();

        return response()->json($archivos);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexByReferencia($ref)
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $archivos = $this->repository->findWhere([
            'referencia'    => $ref,
            'estado'        => true
        ]);

        return response()->json($archivos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ArchivoCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {

            $ambiente = 'prod';

            $inputs = $request->all();
            $inputs['uuid'] = (string)\Uuid::generate(4);

            if($ambiente == 'dev') {
                //inicio de emulacion de parametros
                $inputs['extension'] = 'png';
                $inputs['nombre_real'] = 'imagen.png';
            }

            $cliente = OauthClient::find($inputs['client_id']);
            $path_root = $cliente->path;

            $inputs['archivo'] = $path_root . $inputs['referencia'] . '/' . $inputs['uuid'] . '.' . $inputs['extension'];

            //generar la ruta y nombre del archivo que se guarda en el servidor
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $uuidExiste = $this->validaArchivo($inputs['referencia'], $inputs['tipo'], $inputs['nombre_real'], $inputs['extension'], $inputs['content_type']);

            if($uuidExiste){
                return response()->json([
                    'error'   => true,
                    'message' => 'Ya existe un archivo con las mismas características',
                    'id'      => $uuidExiste
                ], 409);
            }

            //subida del archivo
            $this->upload( $inputs['archivo'], $inputs['archivo_binario'], true);

            $archivo = $this->repository->create($inputs);

            return response()->json($archivo);

        } catch (ValidatorException $e) {
            return response()->json([
                'error'   => true,
                'message' => $e->getMessageBag()
            ], 400);
        }catch (\Exception $e) {
            return response()->json([
                'error'   => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $archivo = $this->repository->findByField('uuid', $id);
        $data = null;
        if(count($archivo['data'])){
            $data = $archivo['data'][0];
        }

        return response()->json(array('data' => $data));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $archivo = $this->repository->find($id);

        return view('archivos.edit', compact('archivo'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  ArchivoUpdateRequest $request
     * @param  string            $uuid
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {

        try {

            $archivo = Archivo::where('uuid', $id)->first();
            $inputs = $request->all();

            $this->upload($archivo->archivo, $inputs['archivo_binario'], true);

            $archivo->nombre_asignado = $inputs['nombre_asignado'];
            $archivo->save();

            $response = [
                'message' => 'Archivo actualizado.',
                'data'    => $archivo->toArray(),
            ];

            return response()->json($response);

        } catch (ValidatorException $e) {

            return response()->json([
                'error'   => true,
                'message' => $e->getMessageBag()
            ]);

        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //$deleted = $this->repository->delete($id);
        $archivo = Archivo::where('uuid', $id)->first();
        if(!$archivo){
            return response()->json([
                'message' => 'No se encuentra el archivo en nuestros registros.',
                'deleted' => false,
            ], 401);
        }
        $path = $archivo->archivo;
        $res = $this->deleteFile($path);
        if ($res){
            $archivo->estado = false;
        }else{
            return response()->json([
                'message' => 'El archivo no se encuentra en nuestros servidores.',
                'deleted' => false,
            ], 401);
        }
        $archivo->save();

        return response()->json([
            'message' => 'Archivo borrado.',
            'deleted' => $archivo->toArray(),
        ]);
    }

    
    public function downloadTest(){
        $content = $this->download('20100100116172/4aa3d755-01d5-4a94-9e09-331e6eb47fc0.pdf');
        return response()->download($content);
    }
    
    ///////////////////////////////////////////////////////////////
    //METODOS ADICIONALES - FUNCIONALIDADES Y/O VALIDACIONES
    ///////////////////////////////////////////////////////////////
    /**
     * @param $nombre
     * @param $contentFile
     * @param bool $base64
     * @return bool
     */
    public function upload($nombre, $contentFile, $base64 = false){
        try{

            if ($base64){
                //$this->flysystem->put($nombre . '.' .$ext, file_get_contents($contentFile));
                $this->flysystem->put($nombre, base64_decode($contentFile));
            }else{
                $this->flysystem->put($nombre , $contentFile);
            }

            return true;

        }catch (Exception $e){
            var_dump($e->getMessage());
            return false;
        }

    }



    public  function download_v2($uuid){
        try{

            $archivo = $this->repository->findByField('uuid', $uuid);
            if ($archivo){
                $path = $archivo['data'][0]['archivo'];

                $ext = $archivo['data'][0]['extension'];
                $nombre = $archivo['data'][0]['nombre_asignado'] . '.' . $ext;
                $contentType = $archivo['data'][0]['content_type'];

                if ($this->flysystem->has($path)) {
                    $content = $this->flysystem->read($path);

                    header('Content-Type: ' . $contentType);
                    header("Content-Transfer-Encoding: binary");
                    header('Content-Disposition: attachment;filename="' . $nombre . '"');
                    //header('Content-disposition: inline');
                    header('Content-Length: ' . strlen($content));

                    echo $content;
                    exit;

                }else{
                    return abort(404);
                }
            }

            return abort(404);

        }catch (\Exception $e){
            var_dump($e->getMessage());
            return false;
        }
    }


    /**
     * @param $path
     * @return bool
     */
    public function deleteFile($path){
        try{

            if ($this->flysystem->has($path)) {
                $this->flysystem->delete($path);
                return true;
            }

            return false;

        }catch (\Exception $e){
            var_dump($e->getMessage());
            return false;
        }
    }


    public function validaArchivo($referencia, $tipo, $nombre, $extension, $ctype){
        /*$archivo = Archivo::where([
            'referencia'    => $referencia,
            'tipo'          => $tipo,
            'nombre_real'   => $nombre,
            'extension'     => $extension,
            'content_type'  => $ctype,
            'estado'        => true
        ])->first();*/

        $archivo = $this->repository->findWhere([
            'referencia'    => $referencia,
            'tipo'          => $tipo,
            'nombre_real'   => $nombre,
            'extension'     => $extension,
            'content_type'  => $ctype,
            'estado'        => true
        ]);

        if(count($archivo['data'])){
            return $archivo['data'][0]['id'];
        }

        return false;
    }


}
