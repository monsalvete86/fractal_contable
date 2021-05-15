<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Empresa;
//use App\Categoria;

class InfAuxiliaresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        echo "indexx";
    }

    public function selectInformes(Request $request){
        //if (!$request->ajax()) return redirect('/');
        $cons="SELECT numero,nom_informe from informes_contables where condicion = 1 and tipo_informe = 'Auxiliares' order by nom_informe";        
        //echo $cons;
        $informes = DB::select($cons);
        return ['informes' => $informes];
    }

    public function AuxConSaldos(Request $request){
        $fec_ini = $request->fecha_ini;
        $fec_fin = $request->fecha_fin;
        $cuenta_ini =""; $cuenta_fin = ""; $id_tercero="";
        if($request->cuenta_ini) $cuenta_ini =" and num_cuenta>='".$request->cuenta_ini."'";
        if($request->cuenta_fin) $cuenta_fin =" and num_cuenta<='".$request->cuenta_fin."'";
        if($request->id_tercero) $id_tercero =" and cuentas.tercero='".$request->id_tercero."'";
        if($request->id_formato) $id_tercero =" and conf_formatos.id='".$request->id_formato."'";
        $Aux = array();
        $html = "";
        //print_r($_GET);
        //echo "cuenta_ini = $cuenta_ini";
        $cons="SELECT cast(num_cuenta as integer) as num_cuenta,cuentas.fecha,nombre_formato,cuentas.numero ,cuentas.doc_afecta_long , cuentas.detalle, personas.nombre,nombre1,nombre2,apellido1,apellido2,num_documento,debe,haber , (debe - haber) as saldo, cuentas.id, plan_cuentas.nombre as nom_cuenta, acumulado_credito, acumulado_debito FROM cuentas,conf_formatos,formatos, personas, plan_cuentas WHERE formatos.condicion = 1 and cuentas.id_formato = formatos.id and formatos.formato = conf_formatos.id and plan_cuentas.id = cuentas.cuenta and personas.id = cuentas.tercero and cuentas.fecha >= '$fec_ini' and cuentas.fecha <='$fec_fin' $cuenta_ini $cuenta_fin $id_tercero order by num_cuenta asc, cuentas.fecha";
        $AuxConSaldos = DB::select($cons);
        $cuenta_ant = "";
        $sum_d = 0; $sum_h = 0; $sum_s = 0; $acum_deb = 0; $acum_cred = 0; $acum_saldo = 0; $ini_acum_deb = 0; $ini_acum_cred = 0; 
       // return $AuxConSaldos;
        foreach($AuxConSaldos as $acs){
            
            if($cuenta_ant != $acs->num_cuenta){
                $cuenta_ant = $acs->num_cuenta;
                $ini_acum_deb = $acs->acumulado_debito - $acs->debe;
                $ini_acum_cred = $acs->acumulado_credito - $acs->haber;
            }

            if(!isset($Aux[$cuenta_ant]['debe']))   $Aux[$cuenta_ant]['debe'] = 0;
            if(!isset($Aux[$cuenta_ant]['debe']))   $Aux[$cuenta_ant]['debe'] = 0;
            if(!isset($Aux[$cuenta_ant]['debe']))   $Aux[$cuenta_ant]['debe'] = 0;
            if(!isset($Aux[$cuenta_ant]['haber']))  $Aux[$cuenta_ant]['haber'] = 0;
            if(!isset($Aux[$cuenta_ant]['saldo']))  $Aux[$cuenta_ant]['saldo'] = 0;
            if(!isset($Aux[$cuenta_ant]['cuenta'])) $Aux[$cuenta_ant]['cuenta'] = $acs->num_cuenta;
            if(!isset($Aux[$cuenta_ant]['nom_cuenta'])) $Aux[$cuenta_ant]['nom_cuenta'] = $acs->nom_cuenta;
            if(!isset($Aux[$cuenta_ant]['acum_cred']))  $Aux[$cuenta_ant]['acum_cred'] = $acs->acumulado_credito;
            if(!isset($Aux[$cuenta_ant]['acum_deb']))  $Aux[$cuenta_ant]['acum_deb'] = $acs->acumulado_debito;
            if(!isset($Aux[$cuenta_ant]['ini_acum_cred']))  $Aux[$cuenta_ant]['ini_acum_cred'] = $ini_acum_cred;
            if(!isset($Aux[$cuenta_ant]['ini_acum_deb']))  $Aux[$cuenta_ant]['ini_acum_deb'] = $ini_acum_deb;
            if(!isset($Aux[$cuenta_ant]['acum_saldo']))  $Aux[$cuenta_ant]['acum_saldo'] = $acs->acumulado_debito - $acs->acumulado_credito;

            $sum_d += $acs->debe;
            $sum_h += $acs->haber;
            $sum_s += $acs->saldo;            

            if($acs->nombre!="") 
                $nombre=$acs->nombre;
            else{
                $nombre= $acs->nombre1." ".$acs->nombre2." ".$acs->apellido1." ".$acs->apellido2; 
            }   
            $Aux[$cuenta_ant]['nom_ter'] = $nombre;
            $Aux[$cuenta_ant]['dets_cuentas'][] = $acs;
            $Aux[$cuenta_ant]['debe']+= $acs->debe;
            $Aux[$cuenta_ant]['haber']+= $acs->haber;
            $Aux[$cuenta_ant]['saldo']+= $acs->saldo;
            $Aux[$cuenta_ant]['acum_cred']+= $acs->saldo;
            $Aux[$cuenta_ant]['ini_acum_cred'] = $ini_acum_cred;
            $Aux[$cuenta_ant]['ini_acum_deb'] = $ini_acum_deb;            
            $Aux[$cuenta_ant]['acum_cred'] = $acs->acumulado_credito;
            $Aux[$cuenta_ant]['acum_deb'] = $acs->acumulado_debito;
            $Aux[$cuenta_ant]['acum_saldo'] = $acs->acumulado_debito - $acs->acumulado_credito;
        }
        //print_r($Aux);
        
        $long = count($Aux); $cont=0;
        foreach($Aux as $clave => $a){
            $cont++;
            $html.= '<table class="table table-bordered table-striped table-sm" style="font-size: 12px !important;">';
            $html.='<tr>
                        <th>Cuenta</th><th colspan="5"><center>'.$a['cuenta'].' - '.$a['nom_cuenta'].'</center></th>
                        <th colspan="4">Saldo a Corte</th><th>'.number_format($a['ini_acum_deb'],2).'</th><th>'.number_format($a['ini_acum_cred'],2).'</th><th>
                    </tr>
                    <tr><th style="text-align: center;">Fecha</th>
                        <th style="text-align: center;">Comprobante</th><th style="text-align: center;">Número</th>
                        <th style="text-align: center;">Doc Ref</th><th style="text-align: center;">Descripcion</th>
                        <th style="text-align: center;">Tercero</th><th style="text-align: center;">Identficación</th>
                        <th style="text-align: center;">Debitos</th><th style="text-align: center;">Creditos</th>
                        <th style="text-align: center;">Saldo</th>
                        <th style="text-align: center;">Acum. Deb</th><th style="text-align: center;">Acum. Cred</th>
                        <th style="text-align: center;">Saldo Acum</th>
                    </tr>';
            $lastdeb = 0; $lastcred = 0;
            foreach($a['dets_cuentas'] as $key => $dc){
                if($dc->doc_afecta_long=="''"){$dc->doc_afecta_long=null;}
                if($dc->nombre!="''") 
                    $nombre=$dc->nombre;
                else{
                    $nombre= $dc->nombre1." ".$dc->nombre2." ".$dc->apellido1." ".$dc->apellido2; 
                }
                $nombre = $a['nom_ter'];
                $html.='<tr>
                    <td>'.$dc->fecha.'</td><td>'.$dc->nombre_formato.'</td><td>'.$dc->numero.'</td><td>'.$dc->doc_afecta_long.'</td>
                    <td>'.$dc->detalle.'</td><td>'.$nombre.' </td><td>'.$dc->num_documento.'</td>
                    <td style="    text-align: right;">'.number_format($dc->debe,2).'</td>
                    <td style="    text-align: right;">'.number_format($dc->haber,2).'</td>
                    <td style="    text-align: right;">'.number_format($dc->saldo,2).'</td>
                    <td style="    text-align: right;">'.number_format($dc->acumulado_debito,2).'</td>
                    <td style="    text-align: right;">'.number_format($dc->acumulado_credito,2).'</td>
                    <td style="    text-align: right;">'.number_format(($dc->acumulado_debito - $dc->acumulado_credito),2).'</td>
                </tr>';
                $lastdeb = $dc->acumulado_debito;
                $lastcred = $dc->acumulado_credito;
            }
            $html.='
                <tr>
                    <th style="text-align: right;" colspan="7">TOTALES</th>
                    <th style="text-align: right;">'.number_format($a['debe'],2).'</th>
                    <th style="text-align: right;">'.number_format($a['haber'],2).'</th>
                    <th style="text-align: right;">'.number_format($a['saldo'],2).'</th>
                    <th style="text-align: right;">'.number_format($lastdeb,2).'</th>
                    <th style="text-align: right;">'.number_format($lastcred,2).'</th>
                    <th style="text-align: right;">'.number_format(($lastdeb - $lastcred),2).'</th>
                </tr>';
                $acum_deb += $lastdeb;
                $acum_cred += $lastcred;
            
            if($cont==$long){
                $html.= '
                    <tr>
                        <th style="text-align: right;" colspan="7">GRAN TOTAL</th>
                        <th style="text-align: right;">'.number_format($sum_d,2).'</th>
                        <th style="text-align: right;">'.number_format($sum_h,2).'</th>
                        <th style="text-align: right;">'.number_format($sum_s,2).'</th>
                        <th style="text-align: right;">'.number_format($acum_deb,2).'</th>
                        <th style="text-align: right;">'.number_format($acum_cred,2).'</th>
                        <th style="text-align: right;">'.number_format(($acum_deb - $acum_cred), 2).'</th>
                        
                    </tr>';
            }
            $html.= '</table><br>';
            
        }
        
        

                      
        return ['html' => $html ] ;
    }

    public function redirect_log(){
        return redirect('/');
    }
   

    
}
