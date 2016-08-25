<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Reusables\MyFileTrait;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Adapter\Ftp;
use League\Flysystem\Config;
use Mockery\CountValidator\Exception;

use GrahamCampbell\Flysystem\FlysystemManager;
use Illuminate\Support\Facades\App;
//use SSH;


class FileStorageController extends Controller
{
    use MyFileTrait;

    protected $flysystem;

    public function __construct(FlysystemManager $flysystem){
        $this->flysystem = $flysystem;
    }


    public function uploadRemote(Request $request){
        try{

            $file = $request->file('archivo');
            $nombreArchivo = $request->comentario;
            $this->flysystem->put($nombreArchivo . '.' .$file->getClientOriginalExtension(), file_get_contents($file->getRealPath()));

            return back()->with('success', 'Archivo subido correctamente!');

        }catch (Exception $e){
            return response()->json(array('message' => 'se presento un error'));
        }

    }


    public function upload($nombre, $ext, $contentFile){
        try{

            $this->flysystem->put($nombre . '.' .$ext, file_get_contents($contentFile));
            return true;

        }catch (Exception $e){
            var_dump($e->getMessage());
            return false;
        }

    }


    public function download($path){
        try{

            if ($this->flysystem->has($path)) {
                $content = $this->flysystem->read($path);
                return $content;
            }

            return false;

        }catch (Exception $e){
            var_dump($e->getMessage());
            return false;
        }
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function uploadFile(Request $request){
        try{
            $tipo_storage = env('STORAGE_FILES', 'local');
            $file = $request->file('archivo');
            $nombreArchivo = $request->comentario;
            $rootPath = $tipo_storage == 'remote' ? env('STORAGE_REMOTE_PATH') : env('STORAGE_LOCAL_PATH');
            $archivo = $rootPath . '/' . $nombreArchivo . '.' .$file->getClientOriginalExtension();
            
            //subida del archivo
            if($tipo_storage == 'remote'){
                $this->uploadByRemote($file->getRealPath(), $archivo);
            }else{
                Storage::put($archivo, file_get_contents($file->getRealPath()));
            }

            return back()->with('success', 'Archivo subido correctamente!');
        }catch (Exception $e){
            return response()->json(array('message' => 'se presento un error'));
        }
    }
}
