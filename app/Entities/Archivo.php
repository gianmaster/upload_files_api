<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Archivo extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'archivos';
    
    protected $fillable = [
        'id',
        'uuid',
        'client_id',
        'referencia',
        'tipo',
        'nombre_real',
        'nombre_asignado',
        'content_type',
        'extension',
        'archivo',
        'usuario',
        'estado',
        'created_at',
        'updated_at',
    ];


    public function descripcionTipo(){
        return $this->hasOne(CatalogoItem::class, 'abreviatura', 'tipo')
            ->where('id_catalogo', 1);
    }

}
