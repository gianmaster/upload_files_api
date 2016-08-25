<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class ArchivoValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            //'uuid',
            'client_id'         => 'required',
            'referencia'        => 'required|min:10',
            'tipo'              => 'required',
            //'nombre_real'       => 'required|min:2',
            'nombre_asignado'   => 'required|min:2',
            'content_type'      => 'required|min:3',
            //'extension',
            //'archivo',
            'archivo_binario'   => 'required',
            'usuario'           => 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [],
   ];
}
