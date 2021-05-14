<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\conf_formatos;

class Conf_formatosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if ($buscar==''){
            $conf_formatos = conf_formatos::orderBy('nombre_formato', 'asc')->paginate(10);
        }
        else{
            $conf_formatos = conf_formatos::where($criterio, 'like', '%'. $buscar . '%')->orderBy('codigo', 'asc')->paginate(10);
        }

        return [
            'pagination' => [
                'total'        => $conf_formatos->total(),
                'current_page' => $conf_formatos->currentPage(),
                'per_page'     => $conf_formatos->perPage(),
                'last_page'    => $conf_formatos->lastPage(),
                'from'         => $conf_formatos->firstItem(),
                'to'           => $conf_formatos->lastItem(),
            ],
            'conf_formatos' => $conf_formatos
        ];
    }

    
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $conf_formatos = new conf_formatos();
        
        $conf_formatos->tipo = $request->tipo;
        $conf_formatos->retencion = $request->retencion;
        $conf_formatos->no_inicio = $request->no_inicio;
        $conf_formatos->cierre = $request->cierre;
        $conf_formatos->acarreo = $request->acarreo;
        $conf_formatos->depreciacion = $request->depreciacion;
        $conf_formatos->fiscal = $request->fiscal;
        $conf_formatos->niif = $request->niif;
        $conf_formatos->nombre_formato = $request->nombre_formato;
        $conf_formatos->condicion = '1';
        $conf_formatos->save();

    }

    public function update(Request $request)
    {
        $conf_formatos = conf_formatos::findOrFail($request->id);
        $conf_formatos->tipo = $request->tipo;
        $conf_formatos->retencion = $request->retencion;
        $conf_formatos->no_inicio = $request->no_inicio;
        $conf_formatos->cierre = $request->cierre;
        $conf_formatos->acarreo = $request->acarreo;
        $conf_formatos->depreciacion = $request->depreciacion;
        $conf_formatos->fiscal = $request->fiscal;
        $conf_formatos->niif = $request->niif;
        $conf_formatos->nombre_formato = $request->nombre_formato;
        $conf_formatos->condicion = $request->condicion;
        $conf_formatos->save();
    }
    
    public function get_tipos_formatos(Request $request)
    {
        
       
        $conf_formatos = conf_formatos::where('condicion', 'like', '1')->orderBy('nombre_formato', 'asc')->get();
      
        return [
            
            'conf_formatos' => $conf_formatos
        ];
        
    }

    public function get_filt_tipo(Request $request){
        $cons="SELECT tipo from conf_formatos where id = ".$request->id_formato;        
        //echo $cons;
        $informes = DB::select($cons);
       // print_r($informes);
        $aux = $informes[0];
        return [
            
            'tipo' => $aux->tipo,
        ];
    }
}
