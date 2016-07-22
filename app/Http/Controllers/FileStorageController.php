<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Storage;
use Mockery\CountValidator\Exception;

class FileStorageController extends Controller
{
    //
    /**
     * @param Request $request
     */
    public function uploadFile(Request $request){
        try{
            $file = $request->file('archivo');
            //dd($disk);
            $exists = Storage::disk('ftp')->exists('file.jpg');
            return back()->with('success', 'Archivo subido correctamente!');
        }catch (Exception $e){
            return response()->json(array('message' => 'se presento un error'));
        }

    }
}
