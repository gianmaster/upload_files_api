<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\CatalogoItem;

/**
 * Class CatalogoItemTransformer
 * @package namespace App\Transformers;
 */
class CatalogoItemTransformer extends TransformerAbstract
{

    /**
     * Transform the \CatalogoItem entity
     * @param \CatalogoItem $model
     *
     * @return array
     */
    public function transform(CatalogoItem $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */
            'estado'    => $model->estado,
            'descripcion'   => $model->descripcion,
            'abreviatura'   => $model->abreviatura,
            'orden'         => (int)$model->orden,
            'id_catalogo'   => (int)$model->id_catalogo,
            'usuario_creacion'=> $model->usuario_creacion,
            'usuario_modificacion'=> $model->usuario->modificacion,

            'created_at' => (string)$model->created_at,
            'updated_at' => (string)$model->updated_at
        ];
    }
}
