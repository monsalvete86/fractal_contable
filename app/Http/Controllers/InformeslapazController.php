<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contrato;

class InformeslapazController extends Controller
{
    public function index(Request $request)
    {
        $n_contrato = $request->Bn_contrato;
        $cliente = $request->Bcliente;
        $desde = $request->Bdesde;
        $hasta = $request->Bhasta;
        $informes = Contrato::join('personas','contratos.id_tercero','=','personas.id')->join('pagoslapaz','contratos.id','=','pagoslapaz.id_contrato')
        ->select('personas.id as idpersona','personas.nombre1','personas.nombre2','personas.apellido1','personas.apellido2','personas.tipo_documento','personas.num_documento','personas.direccion','personas.telefono','personas.email','contratos.id as idcontrato','contratos.n_contrato','contratos.id_tercero','contratos.lugar_cedula','contratos.barrio','contratos.tel','contratos.cel','pagoslapaz.fecha_pago','pagoslapaz.valor_pago');
        
        if($n_contrato!='' && $n_contrato!=null)
        {
            $informes = $informes->where('contratos.n_contrato','like','%'.$n_contrato.'%');
        }
        if($cliente!='' && $cliente!=null)
        {
            $informes = $informes->where('personas.nombre1','like','%'.$cliente.'%');
        }
        if($desde!='' && $hasta!=null)
        {
            $informes = $informes->whereBetween('pagoslapaz.fecha_pago', [$desde,$hasta]);
        }
        
        
        $informes = $informes->orderBy('personas.nombre1','asc')->get();
        return [
            'informes' =>$informes
        ];
    }
}

