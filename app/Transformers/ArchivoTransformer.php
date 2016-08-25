<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Archivo;

/**
 * Class ArchivoTransformer
 * @package namespace App\Transformers;
 */
class ArchivoTransformer extends TransformerAbstract
{

    /**
     * Transform the \Archivo entity
     * @param \Archivo $model
     *
     * @return array
     */
    public function transform(Archivo $model)
    {
        return [
            //'id'         => (int) $model->id,
            'id'            => $model->uuid,

            /* place your other model properties here */
            'client_id'     => $model->client_id,
            'referencia'    => $model->referencia,
            'tipo'          => $model->tipo,
            'descripcion_tipo'=> $model->descripcionTipo->descripcion,
            'nombre_real'   => $model->nombre_real,
            'nombre_asignado'=> $model->nombre_asignado,
            'extension'     => $model->extension,
            'content_type'     => $model->content_type,
            'archivo'       => $model->archivo,
            'usuario'       => $model->usuario,
            'estado'        => (boolean)$model->estado,

            'fecha_creacion' => (string)$model->created_at,
            'fecha_modificacion' => (string)$model->updated_at
        ];
    }
}
