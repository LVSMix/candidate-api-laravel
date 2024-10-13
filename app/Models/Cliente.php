<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model {

    const ESTADO_INGRESADO     = "INGRESADO";
    const ESTADO_CONCTATADO    = "CONCTATADO";
    const ESTADO_COTIZADO    = "COTIZADO";
    const ESTADO_VENTA_FINALIZADA    = "VENTA_FINALIZADA";
    const ESTADO_NUEVO_CLIENTE = "NUEVO CLIENTE";

    protected $table = 'clientes';
}
