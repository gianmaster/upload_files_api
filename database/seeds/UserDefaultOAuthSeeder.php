<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UserDefaultOAuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DEVELOPER enviroment
        App\Entities\OauthClient::create([
            'id'        => 'gKDKTQsEcIU863DdWemHKuttt412XQx6tzXJjLpZ',
            'secret'    => 'dOOr0JbCDnsGJwEjW3XJ9MKbx5GvIMrQpNlOCbr9',
            'name'      => 'Rocalvi - Developer Group',
            //'path'      => 'DESARROLLO/'
            'path'      => '/'
        ]);

        //DEVELOPER enviroment
        App\Entities\OauthClient::create([
            'id'        => 'gKDKTQsEcIU877DdWemHKuttt412XQx6tzXJjLpZ',
            'secret'    => 'dOOr0JbCDnsGJ77jW3XJ9MKbx5GvIMrQpNlOCbr9',
            'name'      => 'CLIENTE SLB',
            'path'      => '/'
            //'path'      => 'SLB/'
        ]);

        //Default catalogo
        $catalog = App\Entities\Catalogo::create([
            'descripcion'        => 'TIPO DOCUMENTO',
            'estado'            => true,
            'usuario_creacion'  => 'gcercado',
            'usuario_modificacion'=> 'gcercado',
        ]);

        App\Entities\CatalogoItem::create([
            'id_catalogo'       => $catalog->id,
            'estado'            => true,
            'descripcion'       => 'Factura y/o Orden de Compra',
            'abreviatura'       => 'FOC',
            'usuario_creacion'  => 'gcercado',
            'usuario_modificacion'=> 'gcercado',
            'orden'             => 1
        ]);

        App\Entities\CatalogoItem::create([
            'id_catalogo'       => $catalog->id,
            'estado'            => true,
            'descripcion'       => 'Conocimiento de Embarque / Guía Aérea / Carta Porte',
            'abreviatura'       => 'CONEMB',
            'usuario_creacion'  => 'gcercado',
            'usuario_modificacion'=> 'gcercado',
            'orden'             => 2
        ]);

        App\Entities\CatalogoItem::create([
            'id_catalogo'       => $catalog->id,
            'estado'            => true,
            'descripcion'       => 'Packing List (cuando aplique)',
            'abreviatura'       => 'PKL',
            'usuario_creacion'  => 'gcercado',
            'usuario_modificacion'=> 'gcercado',
            'orden'             => 3
        ]);

        App\Entities\CatalogoItem::create([
            'id_catalogo'       => $catalog->id,
            'estado'            => true,
            'descripcion'       => 'Póliza de Seguro (cuando aplique)',
            'abreviatura'       => 'POLSEG',
            'usuario_creacion'  => 'gcercado',
            'usuario_modificacion'=> 'gcercado',
            'orden'             => 4
        ]);

        App\Entities\CatalogoItem::create([
            'id_catalogo'       => $catalog->id,
            'estado'            => true,
            'descripcion'       => 'Certificado de Origen (cuando aplique)',
            'abreviatura'       => 'CERTO',
            'usuario_creacion'  => 'gcercado',
            'usuario_modificacion'=> 'gcercado',
            'orden'             => 5
        ]);

        App\Entities\CatalogoItem::create([
            'id_catalogo'       => $catalog->id,
            'estado'            => true,
            'descripcion'       => 'Licencias de Importación (cuando aplique)',
            'abreviatura'       => 'LICIM',
            'usuario_creacion'  => 'gcercado',
            'usuario_modificacion'=> 'gcercado',
            'orden'             => 6
        ]);

        App\Entities\CatalogoItem::create([
            'id_catalogo'       => $catalog->id,
            'estado'            => true,
            'descripcion'       => 'Nota de Pedido (cuando aplique)',
            'abreviatura'       => 'NOTPE',
            'usuario_creacion'  => 'gcercado',
            'usuario_modificacion'=> 'gcercado',
            'orden'             => 7
        ]);

        App\Entities\CatalogoItem::create([
            'id_catalogo'       => $catalog->id,
            'estado'            => true,
            'descripcion'       => 'Solicitud de servicio vía correo electrónico (cuando aplique)',
            'abreviatura'       => 'SOLSER',
            'usuario_creacion'  => 'gcercado',
            'usuario_modificacion'=> 'gcercado',
            'orden'             => 8
        ]);

        App\Entities\CatalogoItem::create([
            'id_catalogo'       => $catalog->id,
            'estado'            => true,
            'descripcion'       => 'Cotización aprobada por cliente',
            'abreviatura'       => 'COTAP',
            'usuario_creacion'  => 'gcercado',
            'usuario_modificacion'=> 'gcercado',
            'orden'             => 9
        ]);

    }
}
