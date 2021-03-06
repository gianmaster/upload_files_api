<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class CatalogoItem extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'catalogo_items';

    protected $fillable = ['estado', 'descripcion', 'abreviatura', 'orden', 'id_catalogo', 'usuario_creacion', 'usuario_modificacion'];

}
