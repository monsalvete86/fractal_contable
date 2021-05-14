<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pagoslapaz extends Model
{
    protected $table = 'pagoslapaz';
    protected $fillable = ['id_contrato','fecha_vence','valor_pago','cant_adicionales','estadoPago','fecha_pago','observacion','usu_crea','usu_edita','id_reg_cuenta'];
}
