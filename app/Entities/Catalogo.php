<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Catalogo extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'catalogos';

    protected $fillable = ['descripcion', 'estado', 'usuario_creacion', 'usuario_modificacion', 'id'];

    public function items(){
        return $this->hasMany(CatalogoItem::class, 'id_catalogo', 'id');
    }

}
