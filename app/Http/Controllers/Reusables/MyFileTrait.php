<?php

namespace App\Http\Controllers\Reusables;

use SSH;

trait MyFileTrait
{

    /**
     * @param $archivo
     * @param $archivo_destino
     */
    public function uploadByRemote($archivo, $archivo_destino)
    {
        SSH::put($archivo, $archivo_destino);
    }


    /**
     * @param $path
     */
    public function createPath($path)
    {
        SSH::run([
            'mkdir ' . $path,
        ]);
    }

    public function existPath($path){
        SSH::run([
            "if [ -d $path]; then",
            "echo 'true'"
        ]);
    }

}
