<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CuentasPre_Exequial extends Model
{
    protected $table = 'cuentas_la_paz';
    protected $fillable = ['id_cuenta1','id_cuenta2','id_formato','usu_crea'];
}
