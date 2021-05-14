<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Cuentas Pre-Exequiales</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                       <div class="form-group row">
                            <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-md-3 form-control-label float-left" for="email-input">Cuenta Registro</label>
                                <div class="float-right col-md-9">
                                     
                                    <div class="form-inline">
                                        <input type="text" readonly class="form-control" v-model="cuenta">
                                        <button @click="abrirModal()" class="btn btn-primary">...</button>
                                        <input type="hidden" class="form-control" v-model="codigo" @keyup.enter="buscarCuenta()" placeholder="Ingrese Cuenta">
                                    </div>  
                                </div>
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-md-3 form-control-label float-left" for="email-input">Cuenta Contrapartida</label>
                                <div class="float-right col-md-9">
                                    <div class="form-inline">
                                        <input type="text" readonly class="form-control" v-model="cuenta2">
                                        <button @click="abrirModal2()" class="btn btn-primary">...</button>
                                        <input type="hidden" class="form-control" v-model="codigo2" @keyup.enter="buscarCuenta()" placeholder="Ingrese Cuenta">
                                    </div> 
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="form-group row">
                             <div class="col-md-6">
                            <div class="form-group row">
                            <label class="col-md-3 form-control-label float-left" for="email-input">Tipo Formato</label>
                                <div class="float-right col-md-9">
                                    <div class="form-inline">
                                        <select class="form-control" v-model="tipo_formato_busq">
                                    <option value="0" >Seleccione</option>
                                    <option v-for="TipoFormato in arrayTiposFormatos" :key="TipoFormato.id" :value="TipoFormato.id" v-text="TipoFormato.nombre_formato"></option>
                                </select> 
                                    </div> 
                                </div>
                            </div>
                            </div>
                           
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-md-2"> 
                                <div class="input-group">
                                    <button type="submit" @click="registrarCuentas()" class="btn btn-primary">Guardar</button>
                                </div>
                            </div>
                        </div>
                        
                    </div>                        
                </div>
                
                <!-- Fin ejemplo de tabla Listado -->
            </div>
             <!-- Modal busqueda cuentas-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <div style="max-width: 120px !important;" class="col-md-2   ">
                                    <label style='margin-top: 3px; '><b>Cuenta</b></label>                                
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="cta_busq" v-model="cta_busq" @keyup="buscarCuentaB()">
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    
                                        <tr><th>Codigo</th><th>Cuenta</th><th>-</th></tr>
                                    
                                        <tr v-for="cuentas in arrayCuentasBusq" :key="cuentas.id">
                                            <td v-text="cuentas.codigo"></td>
                                            <td v-text="cuentas.nombre"></td>
                                            <td>
                                                <button type="button" style=" margin-right: -8px;" @click="cargarCuentaB(cuentas)" class="btn btn-success btn-sm" title='Ver formato'>
                                                    <i class="icon-check"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                <!-- Modal busqueda cuentas-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal2}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal2()" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <div style="max-width: 120px !important;" class="col-md-2   ">
                                    <label style='margin-top: 3px; '><b>Cuenta</b></label>                                
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="cta_busq" v-model="cta_busq" @keyup="buscarCuentaB()">
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    
                                        <tr><th>Codigo</th><th>Cuenta</th><th>-</th></tr>
                                    
                                        <tr v-for="cuentas in arrayCuentasBusq" :key="cuentas.id">
                                            <td v-text="cuentas.codigo"></td>
                                            <td v-text="cuentas.nombre"></td>
                                            <td>
                                                <button type="button" style=" margin-right: -8px;" @click="cargarCuentaB2(cuentas)" class="btn btn-success btn-sm" title='Ver formato'>
                                                    <i class="icon-check"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!--Fin del modal-->
        </main>
</template>

<script>
    export default {
        props : ['ruta'],
        data (){
            return {
                cargo_id: 0,
                id_cuenta: '',
                cuenta: '',
                cuenta2: '',
                doc_cuenta: '',
                arrayCuentas: [],
                errorInforme : 0,
                errorMostrarMsjInforme : [],
                modal: '',
                modal2: '',
                tituloModal: '',
                arrayCuentasBusq: '',
                cta_busq: '',
                codigo:'',
                codigo2: '',
                arrayTiposFormatos: [],
                arrayPrexcuentas: [],
                tipo_formato_busq: '',
                
            }
        },
        
        methods : {
            buscarCuenta()
            {
                let me=this;            
                var url= this.ruta +'/planCuentas/selectCuenta2?filtro=' + me.codigo;

                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCuentas = respuesta.cuentas;

                    if (me.arrayCuentas.length>0){
                        me.codigo=me.arrayCuentas[0]['codigo'];
                        me.id_cuenta=me.arrayCuentas[0]['id'];
                        me.cuenta=me.arrayCuentas[0]['nombre'];
                        me.naturaleza=me.arrayCuentas[0]['naturaleza'];
                        if(me.naturaleza=="Debito"){
                            $( "#debito" ).focus();
                            $( "#debito" ).val('');
                            //$("#credito").prop('disabled', true);
                        }
                        else{
                            $( "#credito" ).focus();
                            $( "#credito" ).val('');
                        }
                        me.tipo=me.arrayCuentas[0]['tipo'];
                        
                    //   me.id_tercero_det=me.id_tercero;
                    //   me.tercero_det_aux = me.doc_tercero;
                        if(me.id_tercero_det == '' ){
                            me.arrayCliente_detalle = me.arrayCliente;
                            me.id_tercero_det =  me.id_tercero;
                            me.tercero_det_aux = me.doc_tercero;
                            var mylist = document.getElementById("tercero_detalle_id");                           
                            var listitems= mylist.getElementsByClassName("form-control");
                            //var aux1 = $('#tercero_detalle_id').children('input').attr("placeholder", "Type your answer here");
                            //listitems[0].attr("placeholder", "Type your answer here");
                            var aux11 = $("#tercero_detalle_id").children().children().attr("placeholder", me.aux_nom_y_ced);
                        }
                    
                    }
                    else{
                        me.cuenta='No existe la cuenta';
                        me.id_cuenta='';
                    }
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            registrarCuentas(){
                // if (this.validarCuentas()){
                //         return;
                //     }
                    
                    let me = this;

                    axios.post(this.ruta +'/cuentaslapaz/registrarCuentas',{
                        'codigo': this.codigo,
                        'codigo2': this.codigo2,
                        'idformato': this.tipo_formato_busq
                    }).then(function (response) {
                        me.cerrarRegistro();
                        me.listarCuentas();
                    }).catch(function (error) {
                        console.log(error);
                });
            },
            abrirModal(){               
                this.arrayCuentasBusq=[];
                this.modal = 1;            
                this.tituloModal = 'Seleccione una cuenta';
                this.cta_busq = '';
            },
            abrirModal2(){               
                this.arrayCuentasBusq=[];
                this.modal2 = 1;            
                this.tituloModal2 = 'Seleccione una cuenta';
                this.cta_busq = '';
            },
            buscarCuentaB(){
                let me=this;            
                var url= this.ruta +'/planCuentas/selectCuentaInfo?busqueda=' + me.cta_busq;

                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCuentasBusq = respuesta.cuentas;

                    
                })
                .catch(function (error) {
                    console.log(error);
                });

            },
            selectTipoFormato(){ 
                let me=this;
                var url= this.ruta +'/conf_formatos/get_tipos_formatos';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayTiposFormatos = respuesta.conf_formatos;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarCuentas(){ 
                let me=this;
                var url= this.ruta +'/cuentaslapaz/listarCuentas';
                axios.get(url).then(function (response) {
                    console.log(response.data['cuentas'][0]);
                    var respuesta= response.data;

                    me.codigo = response.data['cuentas'][0]['id_cuenta1'];
                    me.cuenta = response.data['cuentas'][0]['codigo']+" - "+response.data['cuentas'][0]['nombre'];

                    me.codigo2 = response.data['cuentas'][0]['id_cuenta2'];
                    me.cuenta2 = response.data['cuentas'][0]['codigo2']+" - "+response.data['cuentas'][0]['nombre2'];

                    me.tipo_formato_busq = response.data['cuentas'][0]['id_formato'];
                    
                    //me.arrayPrexcuentas = respuesta.cuentas;
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cargarCuentaB(cuenta){
                let me=this;  
                me.codigo= cuenta['id'];
                me.id_cuenta= cuenta['id'];
                me.cuenta= cuenta['codigo']+' - '+cuenta['nombre'];
                me.naturaleza=cuenta['naturaleza'];
                if(me.naturaleza=="Debito"){
                    $( "#debito" ).focus();
                    $( "#debito" ).val('');
                    //$("#credito").prop('disabled', true);
                }
                else{
                    $( "#credito" ).focus();
                    $( "#credito" ).val('');
                }
                me.tipo=cuenta['tipo'];
                if(me.id_tercero_det == '' ){
                    me.arrayCliente_detalle = me.arrayCliente;
                    me.id_tercero_det =  me.id_tercero;
                    me.tercero_det_aux = me.num_documento
                    var mylist = document.getElementById("tercero_detalle_id");                           
                    var listitems= mylist.getElementsByClassName("form-control");
                    //var aux1 = $('#tercero_detalle_id').children('input').attr("placeholder", "Type your answer here");
                    //listitems[0].attr("placeholder", "Type your answer here");
                    var aux11 = $("#tercero_detalle_id").children().children().attr("placeholder", me.aux_nom_y_ced);
                    
                }
                this.cerrarModal();
            },
            cargarCuentaB2(cuenta2){
                let me=this;  
                me.codigo2= cuenta2['id'];
                me.id_cuenta2= cuenta2['id'];
                me.cuenta2= cuenta2['codigo']+' - '+cuenta2['nombre'];
            
                me.naturaleza=cuenta2['naturaleza'];
                if(me.naturaleza=="Debito"){
                    $( "#debito" ).focus();
                    $( "#debito" ).val('');
                    //$("#credito").prop('disabled', true);
                }
                else{
                    $( "#credito" ).focus();
                    $( "#credito" ).val('');
                }
                me.tipo=cuenta2['tipo'];
                if(me.id_tercero_det == '' ){
                    me.arrayCliente_detalle = me.arrayCliente;
                    me.id_tercero_det =  me.id_tercero;
                    me.tercero_det_aux = me.num_documento
                    var mylist = document.getElementById("tercero_detalle_id");                           
                    var listitems= mylist.getElementsByClassName("form-control");
                    //var aux1 = $('#tercero_detalle_id').children('input').attr("placeholder", "Type your answer here");
                    //listitems[0].attr("placeholder", "Type your answer here");
                    var aux11 = $("#tercero_detalle_id").children().children().attr("placeholder", me.aux_nom_y_ced);
                }
                this.cerrarModal2();
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.tipo_cta = '';
                this.cta_busq = '';
            },
            cerrarModal2(){
                this.modal2=0;
                this.tituloModal='';
                this.tipo_cta = '';
                this.cta_busq = '';
            }, 
            cerrarRegistro(){
                this.codigo='';
                this.codigo2='';
                this.cuenta='';
                this.cuenta2='';
                this.tipo_formato_busq='';
            },
        },
        
        mounted() {
            this.listarCuentas();
            this.selectTipoFormato();
            
        }
    }
</script>
<style>    
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>
