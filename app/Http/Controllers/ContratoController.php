<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Contrato;
use App\User;
use App\Beneficiario;
use App\Adicional;
use App\Persona;
use App\Ocupacion;
use App\Pagoslapaz;
use App\Formatos;
use App\Cuentas;
use App\CuentasPre_Exequial;
use App\PlanCuenta;

class ContratoController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $Bcontrato = $request->Bcontrato;
        $Bcliente = $request->tercero_id_filtro;
        $Bestado = $request->Bestado;
        $BestadoPago = $request->BestadoPago;
        $Btelefono = $request->Btelefono;
        $Bcelular = $request->Bcelular;
        

        $contratos = Contrato::join('personas','contratos.id_tercero','=','personas.id')
        ->join('ocupaciones','contratos.id_ocupacion','=','ocupaciones.id')
        ->select('personas.id as idpersona','personas.nombre1','personas.nombre2','personas.apellido1','personas.apellido2','personas.tipo_documento','personas.num_documento','personas.direccion','personas.telefono','personas.email','contratos.id as idcontrato','contratos.n_contrato','contratos.id_tercero','contratos.lugar_cedula','contratos.barrio','contratos.tel','contratos.cel','contratos.id_ocupacion','contratos.referencias','contratos.tel_referencia','contratos.estado','contratos.fecha_contrato','contratos.hora_contrato','contratos.vr_mensual','contratos.vr_semestre','contratos.vr_año','contratos.estadoPago');
        
        if($Bcontrato!='' && $Bcontrato!=null) 
        {
            $contratos = $contratos->where('contratos.n_contrato','like','%'.$Bcontrato.'%');
        }
        if($Bcliente!='' && $Bcliente!=null)
        {
            $contratos = $contratos->where('contratos.id_tercero','like','%'.$Bcliente.'%');
        }
        if($Bestado!='' && $Bestado!=null)
        {
            $contratos = $contratos->where('contratos.estado','like','%'.$Bestado.'%');
        }
        if($BestadoPago!='' && $BestadoPago!=null)
        {
            $contratos = $contratos->where('contratos.estadoPago','like','%'.$BestadoPago.'%');
        }
        if($Btelefono!='' && $Btelefono!=null)
        {
            $contratos = $contratos->where('contratos.tel','like','%'.$Btelefono.'%' );
        }
        

        $contratos = $contratos->orderBy('contratos.id', 'desc')
        ->paginate(20);

        return [
            'pagination' => [
                'total'        => $contratos->total(),
                'current_page' => $contratos->currentPage(),
                'per_page'     => $contratos->perPage(),
                'last_page'    => $contratos->lastPage(),
                'from'         => $contratos->firstItem(),
                'to'           => $contratos->lastItem(),
            ],
            'contratos' => $contratos
        ];
    }

    public function selectTercero(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $terceros = Persona::select('id','nombre1','nombre2','apellido1','apellido2','tipo_documento','num_documento')->orderBy('nombre', 'asc')->get();
        return ['terceros' => $terceros];
    }
    public function selectOcupa(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $ocupa = Ocupacion::select('id','ocupación')->orderBy('id', 'asc')->get();
        return ['ocupaciones' => $ocupa];
    }
    public function personas(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $personas = Persona::select('personas.nombre1','personas.nombre2','personas.apellido1','personas.apellido2','personas.direccion')->where('id','=',$request->contrato_id)->orderBy('id', 'asc')->get();
        return ['personas' => $personas];
    }

    public function store(Request $request){
        if (!$request->ajax()) return redirect('/');
        try{
            DB::beginTransaction();
        
        $usu_crea = Auth::user()->id;
        $contrato = new Contrato();
        $contrato->n_contrato = $request->n_contrato;
        $contrato->id_tercero = $request->tercero;
        $contrato->lugar_cedula = $request->lugar_cedula;
        $contrato->barrio = $request->barrio;
        $contrato->tel = $request->tel;
        $contrato->cel = $request->cel;
        $contrato->id_ocupacion= $request->id_ocupacion;
        $contrato->referencias = $request->referencias;
        $contrato->tel_referencia = $request->tel_referencia;
        $contrato->estado = $request->estado;
        $contrato->fecha_contrato = $request->fecha_contrato;
        $contrato->hora_contrato = $request->hora_contrato;
        $contrato->vr_mensual = $request->vr_mensual;
        $contrato->vr_semestre = $request->vr_semestre;
        $contrato->vr_año = $request->vr_año;
        $contrato->usu_crea = $usu_crea;
        $contrato->usu_edita = $usu_crea;
        $contrato->save();
       
        $valores = $request->items;

        foreach($valores as $valor)
        {    
             $usu_crea = Auth::user()->id;
             $beneficiarios = new Beneficiario();
             $beneficiarios->id_contrato = $contrato->id;
             $beneficiarios->nombre = $valor['nombre'];
             $beneficiarios->documento = $valor['documento'];
             $beneficiarios->tipo_documento = $valor['tipo_documento'];
             $beneficiarios->parentesco = $valor['parentesco'];
             $beneficiarios->fecha_nacimiento = $valor['edad'];
             $beneficiarios->fecha_afilia = $valor['fecha_afilia'];
             $beneficiarios->fecha_muere = $valor['fecha_muere'];
             $beneficiarios->usu_crea = $usu_crea;
             $beneficiarios->usu_edita = $usu_crea;
             $beneficiarios->save();
        }
        $valores2 = $request->items2;
        // return $valores2;

        foreach($valores2 as $valor2)
        {    
             $usu_crea = Auth::user()->id;
             $adicionales = new Adicional();
             $adicionales->id_contrato = $contrato->id;
             $adicionales->nombre = $valor2['nombre'];
             $adicionales->documento = $valor2['documento'];
             $adicionales->tipo_documento = $valor2['tipo_documento'];
             $adicionales->parentesco = $valor2['parentesco'];
             $adicionales->fecha_nacimiento = $valor2['edad'];
             $adicionales->fecha_afilia = $valor['fecha_afilia'];
             $adicionales->fecha_muere = $valor['fecha_muere'];
             $adicionales->usu_crea = $usu_crea;
             $adicionales->usu_edita = $usu_crea;
             $adicionales->save();
        }

        DB::commit();
    } catch (Exception $e){
        DB::rollBack();
    }
    }
    public function update(Request $request){
        if (!$request->ajax()) return redirect('/');
        try{
            DB::beginTransaction();

        $usu_crea = Auth::user()->id;
        $contrato = Contrato::findOrFail($request->id);
        $contrato->n_contrato = $request->n_contrato;
        $contrato->id_tercero = $request->tercero;
        $contrato->lugar_cedula = $request->lugar_cedula;
        $contrato->barrio = $request->barrio;
        $contrato->tel = $request->tel;
        $contrato->cel = $request->cel;
        $contrato->id_ocupacion= $request->id_ocupacion;
        $contrato->referencias = $request->referencias;
        $contrato->tel_referencia = $request->tel_referencia;
        $contrato->estado = $request->estado;
        $contrato->fecha_contrato = $request->fecha_contrato;
        $contrato->hora_contrato = $request->hora_contrato;
        $contrato->vr_mensual = $request->vr_mensual;
        $contrato->vr_semestre = $request->vr_semestre;
        $contrato->vr_año = $request->vr_año;
        // $contrato->usu_crea = $usu_crea;
        $contrato->usu_edita = $usu_crea;
        $contrato->save();
        
        Beneficiario::where('id_contrato','=',$request->id)->delete();

        // $eliminar = DB::table('tipo_documento')->delete('tipo_documento_id',$id)->where('id',$id)->get();
        // return $eliminar;

        $valores = $request->items;

        foreach($valores as $valor)
        {   
            $usu_crea = Auth::user()->id;
            $beneficiarios = new Beneficiario();
            $beneficiarios->id_contrato = $contrato->id;
            $beneficiarios->nombre = $valor['nombre'];
            $beneficiarios->documento = $valor['documento'];
            $beneficiarios->tipo_documento = $valor['tipo_documento'];
            $beneficiarios->parentesco = $valor['parentesco'];
            $beneficiarios->fecha_nacimiento = $valor['edad'];
            $beneficiarios->fecha_afilia = $valor['fecha_afilia'];
            $beneficiarios->fecha_muere = $valor['fecha_muere'];
            $beneficiarios->usu_crea = $usu_crea;
            $beneficiarios->usu_edita = $usu_crea;
            $beneficiarios->save();
        }
        Adicional::where('id_contrato','=',$request->id)->delete();
        $valores2 = $request->items2;

        foreach($valores2 as $valor)
        {   
            $usu_crea = Auth::user()->id;
            $adicionales = new Adicional();
            $adicionales->id_contrato = $contrato->id;
            $adicionales->nombre = $valor['nombre'];
            $adicionales->documento = $valor['documento'];
            $adicionales->tipo_documento = $valor['tipo_documento'];
            $adicionales->parentesco = $valor['parentesco'];
            $adicionales->fecha_nacimiento = $valor['edad'];
            $adicionales->fecha_afilia = $valor['fecha_afilia'];
             $adicionales->fecha_muere = $valor['fecha_muere'];
            $adicionales->usu_crea = $usu_crea;
            $adicionales->usu_edita = $usu_crea;
            $adicionales->save();
        }

        DB::commit();
    } catch (Exception $e){
        DB::rollBack();
    }
    }
    public function ocupacion(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        $ocupacion = new Ocupacion();
        $ocupacion->ocupación = $request->ocupacion;
        $ocupacion->save();
    }
    public function beneficiarios(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_contrato = $request->id_contrato;

        $aux_res = DB::select("select beneficiarios_contrato.id_contrato,beneficiarios_contrato.nombre,beneficiarios_contrato.documento,beneficiarios_contrato.tipo_documento,beneficiarios_contrato.parentesco,(YEAR(CURDATE()) - YEAR(fecha_nacimiento)) AS edad, fecha_muere, fecha_afilia from beneficiarios_contrato where id_contrato = $id_contrato order by id asc");


        return ['beneficiarios' => $aux_res];
    }    
    public function adicionales(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_contrato = $request->id_contrato;
        $aux_res = DB::select("select adicionales_contrato.id_contrato,adicionales_contrato.nombre,adicionales_contrato.documento,adicionales_contrato.tipo_documento,adicionales_contrato.parentesco,(YEAR(CURDATE()) - YEAR(fecha_nacimiento)) AS edad, fecha_muere, fecha_afilia from adicionales_contrato where id_contrato = $id_contrato order by id asc");

        
        return ['adicionales' => $aux_res];
    }
    public function actualizarB(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        $id_contrato = $request->id_contrato;
        $ben = Beneficiario::select('id_contrato','nombre','documento','tipo_documento','parentesco','fecha_nacimiento as edad','fecha_muere', 'fecha_afilia')->where('id_contrato','=',$id_contrato)->get();

        return ['actualizarB' => $ben];
    }
    public function actualizarA(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id_contrato = $request->id_contrato;
        $adi = Adicional::select('adicionales_contrato.id_contrato','adicionales_contrato.nombre','adicionales_contrato.documento','adicionales_contrato.tipo_documento','adicionales_contrato.parentesco','adicionales_contrato.fecha_nacimiento as edad, fecha_muere, fecha_afilia')->where('id_contrato','=',$id_contrato)->get();

        return ['actualizarA' => $adi];
    }
    public function fechas_pago(Request $request)
    {   
        if (!$request->ajax()) return redirect('/');
        $fecha_actual = $request->fecha_actual;
        $fechas = Pagoslapaz::select('pagoslapaz.estadoPago')->where('fecha_vence','>',$fecha_actual)->get();
        foreach($fechas as $vencidas)
        {
            $vencidos = Pagoslapaz::findOrFail($request->id);
            $vencidos->estadoPago = $vencidas['0'];
            $vencidos->save();
        }
    }
    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $contrato = Contrato::findOrFail($request->id);
        $contrato->estado = '0';
        $contrato->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $contrato = Contrato::findOrFail($request->id);
        $contrato->estado = '1';
        $contrato->save();
    }
    //FUNCIONES PARA LOS PAGOS
    public function indexPagos(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $Bfecha_desde = $request->Bfecha_desde;
        $Bfecha_hasta = $request->Bfecha_hasta;
       
        $id_contrato = $request->pago_id;
        $pagos = Pagoslapaz::join('contratos','pagoslapaz.id_contrato','=','contratos.id')
        ->select('pagoslapaz.id','pagoslapaz.id_contrato','pagoslapaz.fecha_vence','pagoslapaz.valor_pago','pagoslapaz.fecha_pago','pagoslapaz.observacion','contratos.id_tercero')
        ->where('id_contrato','=',$id_contrato)->orderBy('fecha_pago','desc');
        
        if($Bfecha_desde!='' && $Bfecha_hasta!='')
        {
            $pagos = $pagos->whereBetween('pagoslapaz.fecha_pago', [$Bfecha_desde,$Bfecha_hasta]);

        }

        $pagos = $pagos->orderBy('pagoslapaz.id', 'desc')->paginate(8);
        
        return [
            'pagination' => [
                'total'        => $pagos->total(),
                'current_page' => $pagos->currentPage(),
                'per_page'     => $pagos->perPage(),
                'last_page'    => $pagos->lastPage(),
                'from'         => $pagos->firstItem(),
                'to'           => $pagos->lastItem(),
            ],
            'pagos' => $pagos,
            // 'clientes' => $terceros,
            'fecha desde' =>  $Bfecha_desde,
            'fecha hasta' => $Bfecha_hasta,
        ];
        
    }
    public function clientesPagos(Request $request)
    {   
        if (!$request->ajax()) return redirect('/');
        $id_contrato = $request->id_contrato;
        $contratos = Contrato::select('contratos.id_tercero','contratos.n_contrato')->where('id','=',$id_contrato)->get();

        foreach ($contratos as $cliente){
        $clientes = Persona::select('personas.nombre1','personas.nombre2','personas.apellido1','personas.apellido2')->where('id','=',$cliente['id_tercero'])->get();
        
        }
        return ['clientes' => $clientes,
                'numeroscontratos' => $contratos];
    }

    public function anular_pago(Request $request){
        $id_pago = $request->id_pago;
        $form = DB::table('pagoslapaz')->where('id','=',$id_pago)->delete();

    }

    public function storePagos(Request $request){
        if (!$request->ajax()) return redirect('/');
        try{
            DB::beginTransaction();
        $usu_crea = Auth::user()->id;
        $pagos = new Pagoslapaz();
        $pagos->id_contrato = $request->id_contrato;
        $pagos->fecha_pago = $request->fecha_pago;
        $pagos->fecha_vence = $request->fecha_vence;
        $pagos->valor_pago = $request->valor_pago;
        $pagos->estado = '1';
        $pagos->observacion = $request->observacion;
        $pagos->usu_crea = $usu_crea;
        $pagos->usu_edita = $usu_crea;
        $pagos->save();

        
        //INSERT EN TABLA FORMATOS
        $id_contrato = $request->id_contrato;
        $pago = $request->valor_pago;
        $fecha = $request->fecha_vence;
        $tercero = Contrato::select('contratos.id_tercero')->where('id','=',$id_contrato)->get();
        $formato = CuentasPre_Exequial::select('cuentas_la_paz.id_formato','cuentas_la_paz.id_cuenta1','cuentas_la_paz.id_cuenta2')->get();
        // return ['terceros'=> $tercero,
        //         'formatos'=> $formato];
        foreach($tercero as $t)
        {
        $formatos = new Formatos();
        $formatos->tercero = $t['id_tercero'];
        $id_tercero = $t['id_tercero'];
        $nombre = Persona::select('personas.nombre1','personas.nombre2','personas.apellido1','personas.apellido2')->where('id','=',$id_tercero)->get();
        foreach($nombre as $n)
        {
            $formatos->detalle = 'Pago pre-exequiales, por valor '.$pago.' para la cobertura hasta '.$fecha.' del cliente '.$n['nombre1'].' '.$n['nombre2'].' '.$n['apellido1'].' '.$n['apellido2'];
        }
        }
        foreach($formato as $f)
        {
            $formatos->formato = $f['id_formato'];
            //Insert numero consecutivo
            $form = array();

            $form = DB::table('formatos')->select('numero')->where('formato','=',$f['id_formato'])->orderBy('id','desc')->limit(1)->get();
            // intval($form);
            if(count($form)<=0) 
                $Numero=1;
            else           
                $Numero = (int) $form[0]->numero + 1;
                
            if(strlen($Numero)==1){ $Numero = "0000".$Numero;}
            if(strlen($Numero)==2){ $Numero = "000".$Numero;}
            if(strlen($Numero)==3){ $Numero = "00".$Numero;}
            if(strlen($Numero)==4){ $Numero = "0".$Numero;}
        
            //Finaliza consecutivo
        }
        $formatos->fecha = $request->fecha_pago;
        $formatos->debes = $request->valor_pago;
        $formatos->haberes = $request->valor_pago;
        $formatos->forma_pago = 'Efectivo';
        $formatos->numero = $Numero;
        $formatos->usuario = $usu_crea;
        $formatos->save();

        $pagos->id_reg_cuenta = $formatos->id;
        $pagos->save();
        //INSERT TABLA CUENTAS
        foreach($tercero as $t)
        {
        $cuentas = new Cuentas();
        $cuentas->tercero = $t['id_tercero'];
        $cuentas->debe ='0';
        $cuentas->haber = $request->valor_pago;
        $id_tercero = $t['id_tercero'];
        $nombre = Persona::select('personas.nombre1','personas.nombre2','personas.apellido1','personas.apellido2')->where('id','=',$id_tercero)->get();
        foreach($nombre as $n)
        {
            $cuentas->detalle = 'Pago pre-exequiales, por valor '.$pago.' para la covertura hasta '.$fecha.' del cliente '.$n['nombre1'].' '.$n['nombre2'].' '.$n['apellido1'].' '.$n['apellido2'];
        }
        foreach($formato as $f)
            {   
                //Insert numero consecutivo
                $form = array();

                $form = DB::table('formatos')->select('numero')->where('formato','=',$f['id_formato'])->orderBy('id','desc')->limit(1)->get();
                // intval($form);
                if(count($form)<=0) 
                    $Numero=1;
                else           
                    $Numero = (int) $form[0]->numero;
                    
                if(strlen($Numero)==1){ $Numero = "0000".$Numero;}
                if(strlen($Numero)==2){ $Numero = "000".$Numero;}
                if(strlen($Numero)==3){ $Numero = "00".$Numero;}
                if(strlen($Numero)==4){ $Numero = "0".$Numero;}
            
                //Finaliza consecutivo
                $plan_cuentas = PlanCuenta::select('plan_cuentas.id','plan_cuentas.codigo')->where('id','=',$f['id_cuenta1'])->get();
                foreach($plan_cuentas as $c)
                {
                    $cuentas->cuenta = $c['id'];
                    $cuentas->num_cuenta = $c['codigo'];
                }
            }
        }
        $formato_id = Formatos::select('formatos.id')->where('numero','=',$Numero)->get();
        foreach($formato_id as $ff)
        {
            $cuentas->id_formato =$ff['id'];
        }
        
        $cuentas->numero = $Numero;
        $cuentas->fecha = $request->fecha_pago;
        $cuentas->usuario = $usu_crea;
        $cuentas->save();

        
        //INSERT TABLA CUENTAS22222
        foreach($tercero as $t)
        {
        $cuentas2 = new Cuentas();
        $cuentas2->tercero = $t['id_tercero'];
        $cuentas2->debe = $request->valor_pago;
        $cuentas2->haber = '0';
        $id_tercero = $t['id_tercero'];
        $nombre = Persona::select('personas.nombre1','personas.nombre2','personas.apellido1','personas.apellido2')->where('id','=',$id_tercero)->get();
        foreach($nombre as $n)
        {
            $cuentas2->detalle = 'Pago pre-exequiales, por valor '.$pago.' para la covertura hasta '.$fecha.' del cliente '.$n['nombre1'].' '.$n['nombre2'].' '.$n['apellido1'].' '.$n['apellido2'];
        }
        foreach($formato as $f)
            {   
                //Insert numero consecutivo
                $form = array();

                $form = DB::table('formatos')->select('numero')->where('formato','=',$f['id_formato'])->orderBy('id','desc')->limit(1)->get();
                // intval($form);
                if(count($form)<=0) 
                    $Numero=1;
                else           
                    $Numero = (int) $form[0]->numero;
                    
                if(strlen($Numero)==1){ $Numero = "0000".$Numero;}
                if(strlen($Numero)==2){ $Numero = "000".$Numero;}
                if(strlen($Numero)==3){ $Numero = "00".$Numero;}
                if(strlen($Numero)==4){ $Numero = "0".$Numero;}
            
                //Finaliza consecutivo
                $plan_cuentas = PlanCuenta::select('plan_cuentas.id','plan_cuentas.codigo')->where('id','=',$f['id_cuenta2'])->get();
                foreach($plan_cuentas as $c)
                {
                    $cuentas2->cuenta = $c['id'];
                    $cuentas2->num_cuenta = $c['codigo'];
                }
            }
        }
        $formato_id = Formatos::select('formatos.id')->where('numero','=',$Numero)->get();
        foreach($formato_id as $ff)
        {
            $cuentas2->id_formato =$ff['id'];
        }
        // $cuentas2->id_formato = '222';
        $cuentas2->numero = $Numero;
        $cuentas2->fecha = $request->fecha_pago;
        $cuentas2->usuario = $usu_crea;
        $cuentas2->save();
        DB::commit();
    } catch (Exception $e){
        DB::rollBack();
    }
    }

    public function comprobarPagosLaPaz(Request $request){
        if(!$request->ajax()) return redirect('/');
        $id_contrato = $request->id_contrato;
        $fecha_actual = $request->fec_act;
        $fecha_por_vencer = $request->fec_por;
        $pagos = array();
        $fb = array();
        // return['fecha_actuuual' => $fecha_actual,
        //     'fecha por vencer' =>$fecha_por_vencer];

        $contratos = Contrato::get();

        if(!empty($contratos))
        {
            foreach($contratos as $con)
            {
                $p = PagosLaPaz::where('id_contrato','=',$con['id'])
                ->orderBy('id', 'desc')
                ->limit(1)
                ->get();

                if(!empty($p))
                {
                    foreach($p as $p2)
                    {
                        $fecha_vence = strtotime('- 5 days' , strtotime($p2['fecha_vence']));
                        $fecha_vence = date('Y-m-d' , $fecha_vence);

                        if($fecha_actual<=$p2['fecha_vence'])
                        {
                            if($fecha_actual < $fecha_vence)
                            {
                                $actualizarContratos = Contrato::findOrFail($p2['id_contrato']);
                                $actualizarContratos->estadoPago = 2;//vigente
                                $actualizarContratos->save();
                            }
                            else
                            {
                                $actualizarContratos = Contrato::findOrFail($p2['id_contrato']);
                                $actualizarContratos->estadoPago = 4;//por vencer
                                $actualizarContratos->save();
                            }
                        }
                        else
                        {
                            $actualizarContratos = Contrato::findOrFail($p2['id_contrato']);
                            $actualizarContratos->estadoPago = 3;//vencido
                            $actualizarContratos->save();
                        }
                    }
                }
            }
        }
    }
    public function adicionalesvalor(Request $request){
        $id_contrato = $request->id_contrato;
        $numeroAdi = DB::table('adicionales_contrato')->where('id_contrato','=',$id_contrato)->count();
        $valor = $numeroAdi * 2000;
        return ['numeroAdi' => $valor];

    }
}
