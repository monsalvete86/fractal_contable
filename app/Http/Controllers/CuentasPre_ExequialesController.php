<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\CuentasPre_Exequial;


class CuentasPre_ExequialesController extends Controller
{
    public function store(Request $request){
        
        if(!$request->ajax()) return redirect('/');
        CuentasPre_Exequial::select('*')->delete();
        $usu_crea = Auth::user()->id;
        $pre_exequiales = new CuentasPre_Exequial();
        $pre_exequiales->id_cuenta1 = $request->codigo;
        $pre_exequiales->id_cuenta2 = $request->codigo2;
        $pre_exequiales->id_formato = $request->idformato;
        $pre_exequiales->usu_crea = $usu_crea;
        $pre_exequiales->save();
    }
    public function listarCuentas(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $cuentaspre = CuentasPre_Exequial::join('plan_cuentas','cuentas_la_paz.id_cuenta1','=','plan_cuentas.id')->join('plan_cuentas as plan_cuentas2','cuentas_la_paz.id_cuenta2','=','plan_cuentas2.id')->join('conf_formatos','cuentas_la_paz.id_formato','=','conf_formatos.id')->select('plan_cuentas.codigo','plan_cuentas.nombre','plan_cuentas2.codigo as codigo2','plan_cuentas2.nombre as nombre2','cuentas_la_paz.id_cuenta1','cuentas_la_paz.id_cuenta2','conf_formatos.nombre_formato','cuentas_la_paz.id_formato')->get();
        return [
            'cuentas' => $cuentaspre
        ];
    }
}
