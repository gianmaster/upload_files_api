<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Catalogo;

/**
 * Class CatalogoTransformer
 * @package namespace App\Transformers;
 */
class CatalogoTransformer extends TransformerAbstract
{

    /**
     * Transform the \Catalogo entity
     * @param \Catalogo $model
     *
     * @return array
     */
    public function transform(Catalogo $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */
            'descripcion'   => $model->descripcion,
            'estado'        => $model->estado,
            'items'         => $model->items,

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
