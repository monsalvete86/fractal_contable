<template>
        <main class="main">
            <!-- Breadcrumb -->
        <div v-if="tipoAccionPagos==0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Contratos
                        <button type="button" @click="abrirModal('contrato','registrar')" class="btn btn-primary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-4">
                            <div class="form-group row">
                            <label class="col-md-3 form-control-label float-left" for="email-input">Contrato</label>
                                <div class="float-right col-md-9">
                                    <!--<input type="hidden" v-model="criterio" value="proyecto" >-->
                                    <input type="number" v-model="Bcontrato" @keyup.enter="listarContrato(1,Bcontrato,tercero_id_filtro,Bestado,BestadoPago,Btelefono)" class="form-control" placeholder="Texto a buscar">
                                </div>
                            </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                <label class="col-md-3 form-control-label float-left" for="email-input">Cliente</label>
                                <div class="form-inline float-right col-md-9">
                                    <input type="text" readonly class="form-control" style="width: 68%;" v-model="tercero_filtro" @keyup.enter="listarContrato(1,Bcontrato,tercero_id_filtro,Bestado,BestadoPago,Btelefono)">
                                    <button type="button" @click="abrirModal('contrato','tercero_filtro')" class="btn btn-primary">...</button>
                                    <button type="button" @click="quitar()" class="btn btn-danger" style="padding: -0.1% 4% 3.1% 4%;">
                                        <i class="icon-trash"></i>
                                    </button>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                <label class="col-md-3 form-control-label float-left" for="email-input">Estado</label>
                                <div class="float-right col-md-9">
                                    <select class="form-control col-md-6" v-model="Bestado" @keyup.enter="listarContrato(1,Bcontrato,tercero_id_filtro,Bestado,BestadoPago,Btelefono)">
                                      <option disabled >Seleccione</option>
                                      <option value="">Todos</option>
                                      <option value="1">Activo</option>
                                      <option value="0">Desactivado</option>
                                    </select>
                                   
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                            <div class="form-group row">
                            <label class="col-md-3 form-control-label float-left" for="email-input">Estado Pago</label>
                                <div class="float-right col-md-9">
                                    <select class="form-control col-md-12" v-model="BestadoPago" @keyup.enter="listarContrato(1,Bcontrato,tercero_id_filtro,Bestado,BestadoPago,Btelefono)">
                                      <option disabled >Seleccione</option>
                                      <option value="" >Todos</option>
                                      <option value="1">Sin Pago</option>
                                      <option value="2">Vigente</option>
                                      <option value="3">Vencido</option>
                                      <option value="4">Por Vencer</option>
                                    </select>
                                </div>
                            </div>
                            </div>
                            <div class="col-md-4">
                            <div class="form-group row">
                            <label class="col-md-3 form-control-label float-left" for="email-input">Celular</label>
                                <div class="float-right col-md-9">
                                    <!--<input type="hidden" v-model="criterio" value="proyecto" >-->
                                    <input type="text" v-model="Btelefono" @keyup.enter="listarContrato(1,Bcontrato,tercero_id_filtro,Bestado,BestadoPago,Btelefono)" class="form-control" placeholder="Texto a buscar">
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-2"> 
                                <div class="input-group">
                                    <button  type="submit" @click="listarContrato(1,Bcontrato,tercero_id_filtro,Bestado,BestadoPago,Btelefono)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>N° Contrato</th>
                                    <th>Cliente</th>
                                    <th>Estado</th>
                                    <th>Pago</th>
                                    <th>Telefono - Celular</th>
                                    <th>Beneficiarios</th>
                                    <th>Adicionales</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="contrato in arrayContrato" :key="contrato.id">
                                    <td v-text="contrato.n_contrato"></td>
                                    <td :value="contrato.id_tercero" v-text="contrato.nombre1 + ' ' + contrato.nombre2+ ' ' + contrato.apellido1 + ' ' + contrato.apellido2"></td>
                                    <td>
                                        <div v-if="contrato.estado">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                        
                                    </td>
                                    <td>
                                        <button v-if="contrato.estadoPago==1" type="button" @click="abrirModalPagos(contrato.idcontrato)" class="btn btn-secondary btn-sm">
                                            Sin Pago
                                        </button>
                                        <button v-else-if="contrato.estadoPago==2" type="button" @click="abrirModalPagos(contrato.idcontrato)" class="btn btn-success btn-sm">
                                            Vigente
                                        </button>
                                        <button v-else-if="contrato.estadoPago==3" type="button" @click="abrirModalPagos(contrato.idcontrato)" class="btn btn-danger btn-sm">
                                            Vencido
                                        </button>
                                        <button v-else-if="contrato.estadoPago==4" type="button" @click="abrirModalPagos(contrato.idcontrato)" class="btn btn-warning btn-sm">
                                            Por Vencer
                                        </button>
                                    </td>

                                    <td v-text="contrato.tel + ' / ' + contrato.cel"></td>
                                    <td><button type="button" @click="abrirModal('contrato','beneficiarios',contrato)" class="btn btn-primary btn-sm"><i class="icon-list"></i></button></td>
                                    <td><button type="button" @click="abrirModal('contrato','adicionales',contrato)" class="btn btn-primary btn-sm"><i class="icon-list"></i></button></td>
                                    <td>

                                        <button v-if="contrato.estado == 1" type="button" @click="abrirModal('contrato','actualizar',contrato)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button>
                                        <button v-else type="button" class="btn btn-secondary btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button>

                                        <template v-if="contrato.estado">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarContrato(contrato.idcontrato)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarContrato(contrato.idcontrato)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                </tr>                                
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,Bcontrato,tercero_id_filtro,Bestado,BestadoPago,Btelefono)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,Bcontrato,tercero_id_filtro,Bestado,BestadoPago,Btelefono)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,Bcontrato,tercero_id_filtro,Bestado,BestadoPago,Btelefono)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
        </div>
        <div v-if="tipoAccionPagos==1">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Pagos</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i>Formulario de Pago
                        <button type="button" @click="abrirModal('contrato','pagos',id_contrato_pagos)" class="btn btn-primary">
                            <i class="icon-plus"></i>&nbsp;Nuevo Pago
                        </button>
                        <button type="button" @click="tipoAccionPagos=0; comprobarPagosLaPaz(fecha_actual)" class="btn btn-danger">
                            <!--<i class="fa fa-window-close"></i>-->
                            Regresar
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-4">
                            <div class="form-group row">
                            <label class="col-md-3 form-control-label float-left" for="email-input">Cliente:</label>
                                <div class="float-right col-md-9">
                                    <!--<input type="hidden" v-model="criterio" value="proyecto" >-->
                                    <tr v-for="cliente in arrayCliente" :key="cliente.id">
                                    <td v-text="cliente.nombre1 + ' ' + cliente.nombre2+ ' ' + cliente.apellido1 + ' ' + cliente.apellido2"></td>
                                    </tr> 
                                </div>
                            </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                <label class="col-md-3 form-control-label float-left" for="email-input">Numero Contrato</label>
                                <div class="form-inline float-right col-md-9">
                                    <tr v-for="numero in arrayNumero" :key="numero.id">
                                    <td v-text="numero.n_contrato "></td>
                                    </tr>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">

                                <div class="form-group row">
                                <label class="col-md-3 form-control-label float-left" for="email-input">Desde</label>
                                <div class="float-right col-md-9">
                                    <input type="date" v-model="Bfecha_desde" @keyup.enter="listarPagoslaPaz(id_contrato_pagos,1,Bfecha_desde,Bfecha_hasta)" class="form-control" placeholder="Texto a buscar">
                                </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                            <div class="form-group row">
                            <label class="col-md-3 form-control-label float-left" for="email-input">Hasta</label>
                                <div class="float-right col-md-9">
                                    <!--<input type="hidden" v-model="criterio" value="proyecto" >-->
                                    <input type="date" v-model="Bfecha_hasta" @keyup.enter="listarPagoslaPaz(id_contrato_pagos,1,Bfecha_desde,Bfecha_hasta)"  class="form-control" placeholder="Texto a buscar">
                                </div>
                            </div>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-md-2"> 
                                <div class="input-group">
                                    <button  type="submit" @click="listarPagoslaPaz(id_contrato_pagos,1,Bfecha_desde,Bfecha_hasta)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                            <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Fecha Pago</th>
                                    <th>Fecha Vence</th>
                                    <th>Valor</th>
                                    <th>observacion</th>
                                    <th>Recibo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="pago in arrayPagos" :key="pago.id">
                                    <td v-text="pago.fecha_pago"></td>
                                    <td v-text="pago.fecha_vence"></td>
                                    <td v-text="pago.valor_pago"></td>
                                    <td v-text="pago.observacion"></td>
                                    <td>
                                        <button type="button" @click="pdfFormato(pago.id)" class="btn btn-info btn-sm">
                                        <i class="icon-doc"></i>
                                        </button>
                                    </td>
                                </tr>                                
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination2.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina2(id_contrato_pagos, pagination2.current_page - 1,Bfecha_desde,Bfecha_hasta)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber2" :key="page" :class="[page == isActived2 ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina2(id_contrato_pagos,page,Bfecha_desde,Bfecha_hasta)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination2.current_page < pagination2.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina2(id_contrato_pagos, pagination2.current_page + 1,Bfecha_desde,Bfecha_hasta)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
        </div>






            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content" style="width: 1000px !important;">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal" v-if="tipoAccionBeneficiario==0">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label class="col-md-1 form-control-label float-left" for="text-input">Cliente</label>
                                        <div class="form-inline col-md-11">
                                            <input type="text" readonly class="form-control" style="width: 70%;" v-model="tercero">
                                            <button type="button" @click="abrirModal('contrato','tercero')" class="btn btn-primary">...</button>
                                            <button type="button" @click="quitar()" class="btn btn-danger" style="padding: -0.1% 4% 3.1% 4%;">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label class="col-md-3 form-control-label float-left" for="text-input">N° Contrato</label>
                                        <div class="col-md-9 float-right">
                                             <input type="number" v-model="n_contrato" class="form-control float-right" placeholder="Numero de contrato"> 
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="col-md-3 form-control-label float-left" for="email-input">Dirección</label>
                                        <div class="col-md-9 float-right">
                                            <input type="text" readonly class="form-control" style="width: 100%;" v-model="direccion"  @keyup.enter="listarContrato(1,Bcontrato,tercero_id_filtro,Bestado,BestadoPago,Btelefono)">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="col-md-3 form-control-label float-left" for="email-input">Telefono</label>
                                        <div class="col-md-9 float-right">
                                            <input type="text" v-model="tel" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label class="col-md-3 form-control-label float-left" for="email-input">Celular</label>
                                        <div class="col-md-9 float-right">
                                            <input type="text" v-model="cel" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="col-md-3 form-control-label float-left" for="email-input">Estado</label>
                                        <div class="col-md-9 float-right">
                                            <select v-model="estado" class="form-control">
                                                <option value="0" disabled="disabled">--Seleccione--</option>
                                                <option value="1">Activo</option>
                                                <option value="0">Inactivo</option>
                                            </select>                                    
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="col-md-3 form-control-label float-left" for="email-input">Fecha Contrato</label>
                                        <div class="col-md-9 float-right">
                                            <input type="date" v-model="fecha_contrato" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label class="col-md-3 form-control-label float-left" for="email-input">Hora Contrato</label>
                                        <div class="col-md-9 float-right">
                                            <input type="time" v-model="hora_contrato" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="col-md-3 form-control-label float-left" for="email-input">Barrio</label>
                                        <div class="col-md-9 float-right">
                                            <input type="text" v-model="barrio" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="col-md-3 form-control-label float-left" for="email-input">Ocupacion</label>
                                        <div class="form-inline col-md-9 float-right">
                                            <select v-model="id_ocupacion" class="form-control" style="width:79%;">
                                                <option value="0" disabled>Seleccione</option>
                                                <option v-for=" ocupa in arrayOcupacion" :key="ocupa.id" :value="ocupa.id" v-text="ocupa.ocupación"></option>
                                            </select>
                                            <button type="button" class="btn btn-info" @click="abrirModal('contrato','ocupacion',contrato)" title="Nueva Ocupacion"><!-- para desplegar menu de filtros-->
                                                <i class="icon-plus" ></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label class="col-md-3 form-control-label float-left" for="email-input">Referencia</label>
                                        <div class="col-md-9 float-right">
                                            <input type="text" v-model="referencias" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="col-md-3 form-control-label float-left" for="email-input">Telefono Referencia</label>
                                        <div class="col-md-9 float-right">
                                            <input type="text" v-model="tel_referencia" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="col-md-3 form-control-label float-left" for="email-input">Valor Mensual</label>
                                        <div class="col-md-9 float-right">
                                            <input type="text" v-model="vr_mensual" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label class="col-md-3 form-control-label float-left" for="email-input">Valor Semestre</label>
                                        <div class="col-md-9 float-right">
                                            <input type="text" v-model="vr_semestre" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="col-md-3 form-control-label float-left" for="email-input">Valor Anual</label>
                                        <div class="col-md-9 float-right">
                                            <input type="text" v-model="vr_año" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="col-md-3 form-control-label float-left" for="email-input">Lugar Cedula</label>
                                        <div class="col-md-9 float-right">
                                            <input type="text" v-model="lugar_cedula" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="button" @click="tipoAccionBeneficiario=1; add()" class="btn btn-success float-right">Agregar beneficiarios</button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" @click="tipoAccionBeneficiario=2; add2()" class="btn btn-success float-left">Agregar adicionales</button>
                                    </div>
                                </div>

                                
                                    <!--  AQUI EMPIEZA NUEVO MODAL DE OCUPACION -->
                                    
                                    
                                    <div class="modal fade" tabindex="-1" :class="{'mostrarOcupacion' : modal2}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                                            <div class="modal-dialog modal-primary modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" v-text="tituloModal2"></h4>
                                                        <button type="button" class="close" @click="cerrarModalOcupa()" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                                            <div class="row">
                                                                <label class="col-md-3 form-control-label float-left" for="email-input">Nueva Ocupacion</label>
                                                                <div class="col-md-9 float-right">
                                                                    <input type="text" v-model="ocupacion" class="form-control" placeholder="">                              
                                                                </div>
                                                            </div>
                                                            <div v-show="errorOcupacion" class="form-group row div-error">
                                                                <div class="text-center text-error">
                                                                    <div v-for="error in errorMostrarMsjOcupacion" :key="error" v-text="error">

                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" @click="cerrarModalOcupa()">Cerrar</button>
                                                        <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="registrarOcupa()">Guardar</button>
                                                        
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>

                                    
                                <!-- AQUI TERMINA MODAL DE OCUPACION-->
                                  
                                <!--<app></app>-->

                                
                                
                                <div v-show="errorContrato" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjContrato" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>

                            
                                <!--Inicion template de agregar beneficiarios-->
                                <template v-if="tipoAccionBeneficiario==1">
                                    <div class="container mt-4">
                                        <h1>Tabla Beneficiarios</h1>
                                    <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                        <table class="table table-bordered mt-4">
                                        <thead class="thead-light">
                                            <tr>
                                            <th width="20%">Nombre</th>
                                            <th width="13%">Documento</th>
                                            <th width="15%">Tipo Documento</th>
                                            <th width="20%">Parentesco</th>
                                            <th width="10%">Edad</th>
                                            <th width="5%">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table table-bordered table-striped mb-0">
                                            <tr v-for="(item, index) in items" :key="index">
                                        
                                            <td>
                                                <span v-if="editIndex !== index">{{ item.nombre }}</span>
                                                <span v-if="editIndex === index">
                                                <input class="form-control form-control-sm" v-model="item.nombre">
                                                </span>
                                            </td>
                                            <td>
                                                <span v-if="editIndex !== index">{{ item.documento }}</span>
                                                <span v-if="editIndex === index">
                                                <input class="form-control form-control-sm" v-model="item.documento">
                                                </span>
                                            </td>
                                            <td>
                                                <span v-if="editIndex !== index">{{ item.tipo_documento }}</span>
                                                <span v-if="editIndex === index">
                                                <select class="form-control form-control-sm" v-model="item.tipo_documento">
                                                    <option value="">Seleccione</option>
                                                    <option value="Cédula de Ciudadanía">Cédula de Ciudadanía</option>
                                                    <option value=" Documento de Extrangeria"> Documento de Extrangeria</option>
                                                    <option value=" Registro Civil"> Registro Civil</option>
                                                    <option value="Tarjeta de Identidad">Tarjeta de Identidad</option>
                                                </select>
                                                </span>
                                            </td>
                                            <td>
                                                <span v-if="editIndex !== index">{{ item.parentesco }}</span>
                                                <span v-if="editIndex === index">
                                                <input class="form-control form-control-sm" v-model="item.parentesco">
                                                </span>
                                            </td>
                                            <td>
                                                <span v-if="editIndex !== index">{{ item.edad }}</span>
                                                <span v-if="editIndex === index">
                                                <input type="date" class="form-control form-control-sm" v-model="item.edad">
                                                </span>
                                            </td>
                                            
                                            <td>
                                                <span v-if="editIndex !== index">
                                                <button type="button" @click="edit(item, index)" class="btn btn-warning btn-sm"><i class="icon-pencil"></i></button>
                                                <button type="button" @click="remove(item, index)" class="btn btn-danger btn-sm" ><i class="icon-trash"></i></button>
                                                </span>
                                                
                                                                            
                                                                                    
                                                <span v-else>
                                                <button type="button" class="btn btn-danger btn-sm" @click="cancel(item)"><i class="icon-trash"></i></button>
                                                <button type="button" class="btn btn-success btn-sm" @click="save(item)"><i class="icon-check"></i></button>
                                                </span>
                                            </td>
                                            </tr>
                                        </tbody>
                                        </table>
                                    </div>
                                        <div class="col-3 offset-9 text-right my-3">
                                            <button type="button" class="btn btn-sm btn-secondary" @click="tipoAccionBeneficiario=0">Terminar</button>
                                            <button v-if="items.length<8" type="button" class="btn btn-sm btn-primary" @click="add()"><i class="icon-plus"></i></button>
                                            <button v-else type="button" class="btn btn-sm btn-secondary" ><i class="icon-plus"></i></button>
                                            <!--<button  v-show="!editIndex" class="btn btn-sm btn-secondary" v-else>Add item</button>-->
                                        </div>

                                    </div>
                                </template>

                                 <!--Inicion template de agregar Adicionales-->
                                <template v-if="tipoAccionBeneficiario==2">
                                    <div class="container mt-4 ">
                                        <h1>Tabla Adicionales</h1>
                                    <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                        <table class="table table-bordered mt-4" >
                                        <thead class="thead-light">
                                            <tr>
                                            <th width="20%">Nombre</th>
                                            <th width="13%">Documento</th>
                                            <th width="15%">Tipo Documento</th>
                                            <th width="20%">Parentesco</th>
                                            <th width="10%">Edad</th>
                                            <th width="5%">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table table-bordered table-striped mb-0">
                                            <tr v-for="(item2, index2) in items2" :key="index2" >
                                            
                                            <td>
                                                <span v-if="editIndex2 !== index2">{{ item2.nombre }}</span>
                                                <span v-if="editIndex2 === index2">
                                                <input class="form-control form-control-sm" v-model="item2.nombre">
                                                </span>
                                            </td>
                                            <td>
                                                <span v-if="editIndex2 !== index2">{{ item2.documento }}</span>
                                                <span v-if="editIndex2 === index2">
                                                <input class="form-control form-control-sm" v-model="item2.documento">
                                                </span>
                                            </td>
                                            <td>
                                                <span v-if="editIndex2 !== index2">{{ item2.tipo_documento }}</span>
                                                <span v-if="editIndex2 === index2">
                                                <select class="form-control form-control-sm" v-model="item2.tipo_documento">
                                                    <option value="">Seleccione</option>
                                                    <option value="Cédula de Ciudadanía">Cédula de Ciudadanía</option>
                                                    <option value=" Documento de Extrangeria"> Documento de Extrangeria</option>
                                                    <option value=" Registro Civil"> Registro Civil</option>
                                                    <option value="Tarjeta de Identidad">Tarjeta de Identidad</option>
                                                </select>
                                                </span>
                                            </td>
                                            <td>
                                                <span v-if="editIndex2 !== index2">{{ item2.parentesco }}</span>
                                                <span v-if="editIndex2 === index2">
                                                <input class="form-control form-control-sm" v-model="item2.parentesco">
                                                </span>
                                            </td>
                                            <td>
                                                <span v-if="editIndex2 !== index2">{{ item2.edad  }}</span>
                                                <span v-if="editIndex2 === index2">
                                                <input type="date" class="form-control form-control-sm" v-model="item2.edad" >
                                                </span>
                                            </td>
                                            
                                            <td>
                                                <span v-if="editIndex2 !== index2">
                                                <button type="button" @click="remove2(item2, index2)" class="btn btn-danger btn-sm" ><i class="icon-trash"></i></button>
                                                </span>
                                                
                                                                            
                                                                                    
                                                <span v-else>
                                                <button type="button" class="btn btn-danger btn-sm" @click="cancel2(item2)"><i class="icon-trash"></i></button>
                                                <button type="button" class="btn btn-success btn-sm" @click="save2(item2)"><i class="icon-check"></i></button>
                                                </span>
                                            </td>
                                            </tr>
                                        </tbody>
                                        </table>
                                    </div>
                                        <div class="col-3 offset-9 text-right my-3">
                                            <button type="button" class="btn btn-sm btn-secondary" @click="tipoAccionBeneficiario=0">Terminar</button>
                                            <button v-if="items2.length<8" type="button" class="btn btn-sm btn-primary" @click="add2()"><i class="icon-plus"></i></button>
                                            <button v-else type="button" class="btn btn-sm btn-secondary"><i class="icon-plus"></i></button>
                                            <!--<button  v-show="!editIndex2" class="btn btn-sm btn-secondary" v-else>Add item</button>-->
                                        </div>

                                    </div>
                                </template>

                        </div>
                        <div v-if="tipoAccionBeneficiario==0" class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarContrato()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarContrato()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
               <!--Inicio del MODAL PAGOSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modalpagos}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content" style="width: 700px !important;">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModalPagos"></h4>
                            <button type="button" class="close" @click="cerrarModalPagos()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal" v-if="tipoAccionBeneficiario==0">
                               
                                <div class="row">
                                    <input type="hidden" readonly v-model="id_contrato_pagos" class="form-control" placeholder="">
                                    <input type="hidden" v-model="id_tercero" class="form-control float-right" placeholder=""> 
                                    <div class="form-group col-md-6">
                                        <label class="col-md-4 form-control-label float-left" for="text-input">Fecha Pago</label>
                                        <div class="col-md-8 float-right">
                                             <input type="date" v-model="fecha_pago" class="form-control float-right" placeholder=""> 
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="col-md-4 form-control-label float-left" for="email-input">Fecha Vence</label>
                                        <div class="col-md-8 float-right">
                                            <input type="date" class="form-control" style="width: 100%;" v-model="fecha_vence">
                                        </div>
                                    </div>  
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="col-md-4 form-control-label float-left" for="email-input">Adicionales</label>
                                        <div class="col-md-8 float-right">
                                            <input type="double" readonly v-model="numeroAdi" class="form-control" placeholder="">
                                        </div>
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label class="col-md-2 form-control-label float-left" for="email-input">Observacion</label>
                                        <div class="col-md-10 float-right">
                                            <textarea type="text" v-model="observacion" class="form-control" placeholder="">
                                            </textarea>
                                        </div>
                                    </div>
                               </div>
                                <div class="row">   
                                    <div class="form-group col-md-6">
                                        <label class="col-md-4 form-control-label float-left" for="email-input">Valor Pago</label>
                                        <div class="col-md-8 float-right">
                                            <input type="double" v-model="valor_pago" class="form-control" placeholder="">
                                        </div>
                                    </div> 
                                </div>
                               

                                
                                
                                <div v-show="errorContrato" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjContrato" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div  class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModalPagos()">Cerrar</button>
                            <button type="button"  class="btn btn-primary" @click="registrarPagos()">Guardar</button>
                            
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal PAGOS SSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS-->
            <!-- Modal busqueda tercero-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modalTerceros}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="titulomodalTerceros"></h4>
                            <button type="button" class="close" @click="cerrarModalT()" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <div style="max-width: 120px !important;" class="col-md-2   ">
                                    <label style='margin-top: 3px; '><b>Tercero</b></label>                                
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="cta_busq" v-model="terc_busq" @keyup="buscarTercero()">
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    
                                        <tr><th>Documento</th><th>Nombre</th><th style="    width: 35px;">-</th></tr>
                                    
                                        <tr v-for="tercero in arrayTerceros" :key="tercero.id">
                                            <td v-text="tercero.num_documento"></td>
                                            <td v-if="tercero.nombre && !tercero.nombre1">{{ tercero.nombre }}  </td>
                                            <td v-else>{{ tercero.nombre1 + ' ' + validarUnder(tercero.nombre2)+' '+tercero.apellido1+' '+validarUnder(tercero.apellido2) }} </td>
                                            <td>
                                                <button v-if="tipoAccionModalTerceros==1" type="button" style=" margin-right: -8px;" @click="cargarTercero(tercero)" class="btn btn-success btn-sm" title='Ver formato'>
                                                    <i class="icon-check"></i>
                                                </button>
                                                <button v-if="tipoAccionModalTerceros==2" type="button" style=" margin-right: -8px;" @click="cargarTerceroFiltro(tercero)" class="btn btn-success btn-sm" title='Ver formato'>
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
            <!-- Fin Modal buscar tercero -->
            <!-- Modal busqueda agregados-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modalAgregados}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="titulomodalAgregados"></h4>
                            <button type="button" class="close" @click="cerrarModalA()" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                             <div class="container-fluid">
                                    
                                <!-- Inicio tabla beneficiarios -->
                                
                                        <table class="table table-bordered table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Documento</th>
                                                    <th>Tipo Documento</th>
                                                    <th>Parentesco</th>
                                                    <th>Edad</th>
                                                </tr>
                                            </thead>
                                            <tbody v-if="tipoAccionAgregados==1">
                                                <tr v-for="benefi in itemsB" :key="benefi.id">
                                                    <td v-text="benefi.nombre"></td>
                                                    <td v-text="benefi.documento"></td>
                                                    <td v-text="benefi.tipo_documento"></td>
                                                    <td v-text="benefi.parentesco"></td>                       
                                                    <td v-text="benefi.edad"></td>
                                                </tr>
                                            </tbody>
                                            <tbody v-if="tipoAccionAgregados==2">
                                                <tr v-for="adicio in itemsA" :key="adicio.id">
                                                    <td v-text="adicio.nombre"></td>
                                                    <td v-text="adicio.documento"></td>
                                                    <td v-text="adicio.tipo_documento"></td>
                                                    <td v-text="adicio.parentesco"></td> 
                                                    <td v-text="adicio.edad"></td>
                                                </tr>
                                            </tbody>
                                        </table>                                  
                                <!--Fin tabla brnrficiarios-->
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fin Modal buscar agregados -->
            
                                    
                                    
            
          


<!-- AQUI TERMINA MODAL DE PAGOS-->
        </main>
</template>


<script>
    export default {
        props : ['ruta'],
        
        data (){
            return {
                //variables tabla dinamica beneficiarios
                editIndex: null,
                originalData: null,
                items: [],
                //variables tabla dinamica adicionales
                editIndex2: null,
                originalData2: null,
                items2: [],

                direccion: '',
                ocupacion: '',
                contrato_id: '',
                n_contrato : '',
                id_tercero: '',
                lugar_cedula : '',
                barrio : '',
                tel : '',
                cel : '',
                id_ocupacion : '',
                referencias : '',
                tel_referencia: '',
                estado: '',
                fecha_contrato: '',
                hora_contrato: '',
                vr_mensual: '',
                vr_semestre: '',
                vr_año: '',
                beneficiarios: '',
                adicionales: '',
                arrayContrato : [],
                arrayTercero: [],
                arrayOcupacion: [],
                modal : 0,
                modal2: 0,
                tituloModal : '',
                tituloModal2 : '',
                tipoAccion : 0,
                errorContrato : 0,
                errorOcupacion: 0,
                errorMostrarMsjOcupacion: [],
                errorMostrarMsjContrato : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,

                pagination2 : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset2 : 3,

                criterio : 'nombre',
                buscar : '',

                arrayBeneficiarios : [],

                tipoAccionBeneficiario : 0,
                //Variables agregados
                titulomodalAgregados: '',
                modalAgregados:0,
                tipoAccionAgregados : 0,
                itemsA: [],
                itemsB: [],

                // variables modulo terceros
                tipoAccionModalTerceros : 0,
                arrayTerceros : [],
                titulomodalTerceros : '',
                modalTerceros : 0,
                tercero : '',
                tercero_id : '',
                tercero_doc : '',
                terc_busq : '',
                tipoAutoretenedorTercero : '',

                //Variables de filtros

                Bcontrato:'',
                tercero_filtro : '',
                tercero_id_filtro : '',
                tercero_doc_filtro : '',
                Bestado: '',
                BestadoPago: '',
                Btelefono: '',

                //Variables pagos
                pago_id: '',
                fecha_vence: '',
                valor_pago: '',
                cant_adicionales: '',
                estadoPago: '',
                fecha_pago: '',
                observacion: '',
                arrayPagos: [],
                tipoAccionPagos: 0,
                tituloModalPagos: '',
                modalpagos: 0,
                errorPagos: 0,
                errorMostrarMsjPagos: [],
                d:'',
                numeroAdi: [],
                
                //variable del id del contrato para registrar pagos
                id_contrato_pagos : 0,
                arrayCliente: [],
                arrayNumero:[],

                //Variables filtros
                Bfecha_desde:'',
                Bfecha_hasta:'',

                fecha_actual : '',
                fecha_por_vencer: '',

                edadBeneficiarios:[],
                edadAdicionales: [],
            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             

            },
            
            isActived2: function(){
                return this.pagination2.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber2: function() {
                if(!this.pagination2.to) {
                    return [];
                }
                
                var from = this.pagination2.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination2.last_page){
                    to = this.pagination2.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             
            },
        },
        
        methods : {
             //Funciones formulario dinamico beneficiarios
               add() {
                this.originalData = null;
                this.items.push({ nombre: '', documento: '', tipo_documento: '', parentesco: '', edad: '' })
                this.editIndex = this.items.length - 1;
                },

                edit(item, index) {
                this.originalData = Object.assign({}, item)
                this.editIndex = index
                },

                cancel(item) {
                this.editIndex = null

                if (!this.originalData) {
                    this.items.splice(this.items.indexOf(item), 1)
                    return
                }

                Object.assign(item, this.originalData)
                this.originalData = null
                },

                remove(item, index) {
                this.items.splice(index, 1)
                },

                save(item) {
                this.originalData = null
                this.editIndex = null
                },
            //Funciones formulario dinamico adicionales
                add2() 
                {
                this.originalData2 = null
                this.items2.push({ nombre: '', documento: '', tipo_documento: '', parentesco: '', edad: '' })
                this.editIndex2 = this.items2.length - 1
                },

                edit2(item2, index2) {
                this.originalData2 = Object.assign({}, item2)
                this.editIndex2 = index2
                },

                cancel2(item2) {
                this.editIndex2 = null

                if (!this.originalData2) {
                    this.items2.splice(this.items2.indexOf(item2), 1)
                    return
                }

                Object.assign(item2, this.originalData2)
                this.originalData2 = null
                },

                remove2(item2, index2) {
                this.items2.splice(index2, 1)
                },

                save2(item2) {
                this.originalData2 = null
                this.editIndex2 = null
                },

                //Termina funcines de formulario dinamico


            cargarTercero(tercero){
                this.tercero = tercero['num_documento']+' - '+tercero['nombre1']+' '+tercero['apellido1'];
                this.tercero_id = tercero['id'];
                this.direccion = tercero['direccion'];
                this.tercero_doc = tercero['num_documento'];
                this.tipoAutoretenedorTercero = tercero['autoretenedor']
                
                this.cerrarModalT();
            },
            cargarTerceroFiltro(tercero){
                this.tercero_filtro = tercero['num_documento']+' - '+tercero['nombre1']+' '+tercero['apellido1'];
                this.tercero_id_filtro = tercero['id'];
                this.tercero_doc_filtro = tercero['num_documento'];
                
                this.cerrarModalT();
            },
            buscarTercero(){
                let me=this;
                var search = this.terc_busq;
                var url= this.ruta +'/cliente/selectCliente?filtro='+search;
                    axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayTerceros = respuesta.clientes;                    
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            validarUnder(valor)
            {
                if(valor == "undefined" || valor=="" || !valor)
                    return "";
                else
                    return valor;
            },
            quitar(){
                this.tercero_id_filtro = '';
                this.tercero_filtro = '';
                this.tercero_id = '';
                this.tercero = '';
                this.direccion = '';
            },
            cerrarModalT(){
                let me=this;
                me.modalTerceros=0;
                me.titulomodalTerceros='';
                me.terc_busq = '';
            },

            listarContrato(page,Bcontrato,tercero_id_filtro,Bestado,BestadoPago,Btelefono){
                let me=this;
                var url= this.ruta +'/contratos?page='+ page + '&Bcontrato='+ Bcontrato + '&tercero_id_filtro='+ tercero_id_filtro + '&Bestado='+ Bestado + '&BestadoPago='+ BestadoPago + '&Btelefono='+ Btelefono;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayContrato = respuesta.contratos.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarPagoslaPaz(id,page2,Bfecha_desde,Bfecha_hasta){
                let me=this;
                var url= this.ruta +'/contratos/pagoslapaz?pago_id=' + id + '&page='+ page2 + '&Bfecha_desde=' + Bfecha_desde + '&Bfecha_hasta=' + Bfecha_hasta;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayPagos = respuesta.pagos.data;
                    me.pagination2= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarTercero(id){

                let me=this;
                var url= this.ruta +'/contratos/terceros?id_tercero=' + id;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayPersona = respuesta.personas;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarCliente(id){

                let me=this;
                var url= this.ruta +'/contratos/clientesPagos?id_contrato=' + id;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCliente = respuesta.clientes;
                    me.arrayNumero = respuesta.numeroscontratos;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            comprobarPagosLaPaz(fecha_actual){
                let me=this;
                axios.put(this.ruta +'/contratos/comprobarPagosLaPaz',{
                    'fec_act': this.fecha_actual
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            buscarBeneficiarios(id){

                let me=this;
                var url= this.ruta +'/contratos/beneficiarios?id_contrato=' + id;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    console.log(respuesta);
                    me.itemsB = respuesta.beneficiarios;
                    me.edadBeneficiarios = respuesta.edaddes;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            buscarAdicionales(id){

                let me=this;
                var url= this.ruta +'/contratos/adicionales?id_contrato=' + id;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.itemsA = respuesta.adicionales;
                    me.numeroAdi = repuesta.numeroAdi;
                    me.edadAdicionales = respuesta.edadadi;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarBeneficiarios(id){

                let me=this;
                var url= this.ruta +'/contratos/beneficiariosAct?id_contrato=' + id;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    console.log(respuesta);
                    me.items = respuesta.actualizarB;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarAdicionales(id){

                let me=this;
                var url= this.ruta +'/contratos/adicionalesAct?id_contrato=' + id;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.items2 = respuesta.actualizarA;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            adicionalesvalor(id){

                let me=this;
                var url= this.ruta +'/contratos/adicionalesvalor?id_contrato=' + id;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.numeroAdi = respuesta.numeroAdi;
                    console.log(me.numeroAdi);
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectTercero(){
                let me=this;
                var url= this.ruta +'/contratos/selectTercero';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayTercero = respuesta.terceros;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectOcupacion(){
                let me=this;
                var url= this.ruta +'/contratos/selectOcupacion';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayOcupacion = respuesta.ocupaciones;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            
            cambiarPagina(page,Bcontrato,tercero_id_filtro,Bestado,BestadoPago,Btelefono){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarContrato(page,Bcontrato,tercero_id_filtro,Bestado,BestadoPago,Btelefono);
            },
            cambiarPagina2(id_contrato_pagos,page2,Bfecha_desde,Bfecha_hasta){
                let me = this;
                //Actualiza la página actual
                me.pagination2.current_page = page2;
                //Envia la petición para visualizar la data de esa página
                me.listarPagoslaPaz(id_contrato_pagos,page2,Bfecha_desde,Bfecha_hasta);
            },
            
            registrarContrato(){
                if (this.validarContrato()){
                    return;
                }
                
                let me = this;

                axios.post(this.ruta +'/contratos/registrar',{
                    'n_contrato': this.n_contrato,
                    'tercero': this.tercero_id,
                    'lugar_cedula': this.lugar_cedula,
                    'barrio': this.barrio,
                    'tel': this.tel,
                    'cel': this.cel,
                    'id_ocupacion': this.id_ocupacion,
                    'referencias':this.referencias,
                    'tel_referencia':this.tel_referencia,
                    'estado':this.estado,
                    'fecha_contrato':this.fecha_contrato,
                    'hora_contrato':this.hora_contrato,
                    'vr_mensual':this.vr_mensual,
                    'vr_semestre':this.vr_semestre,
                    'vr_año':this.vr_año,
                    'items': this.items,
                    'items2': this.items2
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarContrato(1,'','','','','');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            registrarOcupa(){
                if (this.validarOcupacion()){
                    return;
                }
                
                let me = this;

                axios.post(this.ruta +'/contratos/registrarOcupa',{
                    'ocupacion': this.ocupacion
                }).then(function (response) {
                    me.cerrarModalOcupa();
                    me.selectOcupacion();
                }).catch(function (error) {
                    console.log(error);
                });
            },
            registrarPagos(){
                if (this.validarPagos()){
                    return;
                }
                
                let me = this;

                axios.post(this.ruta +'/contratos/registrarPagos',{
                    'id_contrato':this.id_contrato_pagos,
                    'fecha_pago': this.fecha_pago,
                    'fecha_vence': this.fecha_vence,
                    'valor_pago': this.valor_pago,
                    'observacion': this.observacion,
                    'id_tercero': this.id_tercero
                }).then(function (response) {
                    me.cerrarModalPagos();
                    me.comprobarPagosLaPaz(me.fecha_actual);
                    me.listarPagoslaPaz(me.id_contrato_pagos,1,'','');
                    me.listarContrato(1,'','','','','');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarContrato(){
               if (this.validarContrato()){
                    return;
                }
                
                let me = this;

                axios.put(this.ruta +'/contratos/actualizar',{
                    'n_contrato': this.n_contrato,
                    'tercero': this.tercero_id,
                    'lugar_cedula': this.lugar_cedula,
                    'barrio': this.barrio,
                    'tel': this.tel,
                    'cel': this.cel,
                    'id_ocupacion': this.id_ocupacion,
                    'referencias':this.referencias,
                    'tel_referencia':this.tel_referencia,
                    'estado':this.estado,
                    'fecha_contrato':this.fecha_contrato,
                    'hora_contrato':this.hora_contrato,
                    'vr_mensual':this.vr_mensual,
                    'vr_semestre':this.vr_semestre,
                    'vr_año':this.vr_año,
                    'items': this.items,
                    'items2': this.items2,
                    'id':this.contrato_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarContrato(1,'','','','','');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
                    
            validarContrato(){
                let me = this;

                this.errorContrato=0;
                this.errorMostrarMsjModulo =[];

                if (!this.tercero_id) this.errorMostrarMsjContrato.push("El nombre del contratante no puede estar vacío.");
                if (!this.n_contrato) this.errorMostrarMsjContrato.push("Numero de contrato puede estar vacío.");
                if (!this.cel) this.errorMostrarMsjContrato.push("Numero de telefono no pude estar vacío.");
                if (!this.estado) this.errorMostrarMsjContrato.push("Seleccione estado.");
                if (!this.fecha_contrato) this.errorMostrarMsjContrato.push("Ingresar fecha de contrato.");
                if (!this.barrio) this.errorMostrarMsjContrato.push("Ingresar barrio.");
                if (!this.id_ocupacion) this.errorMostrarMsjContrato.push("Ingresar ocupacion del cliente.");
                if (!this.referencias) this.errorMostrarMsjContrato.push("Ingresar referencia personal.");
                if (!this.tel_referencia) this.errorMostrarMsjContrato.push("Ingresar telefono referencia personal.");
                if (!this.vr_mensual) this.errorMostrarMsjContrato.push("Ingresar valor mensual.");
                if (!this.vr_semestre) this.errorMostrarMsjContrato.push("Ingresar valor semestre.");
                if (!this.vr_año) this.errorMostrarMsjContrato.push("Ingresar valor año.");
                if (!this.lugar_cedula) this.errorMostrarMsjContrato.push("Ingresar lugar de expedición");




                
                
                if (this.errorMostrarMsjContrato.length) this.errorContrato = 1;

                return this.errorContrato;
            },
            validarOcupacion(){
                let me = this;

                this.errorOcupacion=0;
                this.errorMostrarMsjOcupacion =[];

                if (!this.ocupacion) this.errorMostrarMsjOcupacion.push("El nombre de la ocupación no puede estar vacío.");
                
                
                if (this.errorMostrarMsjOcupacion.length) this.errorOcupacion = 1;

                return this.errorOcupacion;
            },
            validarPagos(){
                let me = this;

                this.errorPagos=0;
                this.errorMostrarMsjPagos =[];

                if (!this.fecha_pago) this.errorMostrarMsjPagos.push("Seleccione fecha de pago.");
                if (!this.fecha_vence) this.errorMostrarMsjPagos.push("Seleccione fecha vence.");
                if (!this.valor_pago) this.errorMostrarMsjPagos.push("Ingrese el valor del pago.");
                
                
                
                if (this.errorMostrarMsjPagos.length) this.errorPagos = 1;

                return this.errorPagos;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.n_contrato='';
                this.id_tercero='';
                this.tercero='';
                this.lugar_cedula= '';
                this.barrio= '';
                this.tel= '';
                this.cel='';
                this.id_ocupacion='';
                this.referencia= '';
                this.tel_referencia= '';
                this.estado= '';
                this.fecha_contrato= '';
                this.hora_contrato= '';
                this.vr_mensual= '';
                this.vr_semestre= '';
                this.vr_año= '';
                this.items=[];
                this.items2=[];
                this.errorContrato=0;
                this.tipoAccionBeneficiario=0;
                this.tipoAccionAdicionales=0;
            },
            cerrarModalOcupa(){
                this.modal2=0;
                this.tituloModal2='';
                this.ocupacion='';
                this.errorOcupacion=0;
            },
            cerrarModalA(){
                this.modalAgregados=0;
                this.titulomodalAgregados='';
                this.items='';
                this.items2='';
                this.tipoAccionAgregados=0;
            },
            cerrarModalPagos(){
                this.modalpagos=0;
                this.tituloModalPagos='';
                this.id_contrato= '';
                this.fecha_vence= this.fecha_vence;
                this.valor_pago= '';
                this.cant_adicionales= '';
                this.estado= '';
                this.fecha_pago= this.fecha_pago;
                this.observacion= '';
                this.n_contrato= '';
                this.tercero= '';
                this.comprobarPagosLaPaz(this.fecha_actual);
                this.listarContrato(1,'','','','','');
            },
            abrirModal(modelo, accion, data = [])
            {
                this.selectTercero();
                this.selectOcupacion();
                switch(modelo){
                    case "contrato":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Crear Contrato';
                                this.n_contrato='';
                                this.id_tercero='';
                                this.tercero='';
                                this.direccion=data['direccion'];
                                // this.listarTercero(data['id']);
                                this.lugar_cedula= '';
                                this.barrio= '';
                                this.tel= '';
                                this.cel='';
                                this.id_ocupacion='';
                                this.referencias= '';
                                this.tel_referencia= '';
                                this.estado= '';
                                this.fecha_contrato= '';
                                this.hora_contrato= '';
                                this.vr_mensual= '';
                                this.vr_semestre= '';
                                this.vr_año= '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Contrato';
                                this.tipoAccion=2;
                                this.contrato_id=data['idcontrato'];
                                this.n_contrato=data['n_contrato'];
                                //this.tercero=data['id_tercero'];
                                this.direccion=data['direccion'];
                                // this.listarTercero(data['id']);
                                this.lugar_cedula=data['lugar_cedula'];
                                this.barrio=data['barrio'];
                                this.tel=data['tel'];
                                this.cel=data['cel'];
                                this.id_ocupacion=data['id_ocupacion'];
                                this.referencias=data['referencias'];
                                this.tel_referencia=data['tel_referencia'];
                                this.estado=data['estado'];
                                this.fecha_contrato=data['fecha_contrato'];
                                this.hora_contrato=data['hora_contrato'];
                                this.vr_mensual=data['vr_mensual'];
                                this.vr_semestre=data['vr_semestre'];
                                this.vr_año=data['vr_año'];
                                //this.listarTercero('id');

                                this.tercero = data['nombre1']+' '+data['nombre2']+' '+data['apellido1']+' '+data['apellido2'];
                                this.tercero_id = data['idpersona'];
                                this.tercero_doc = data['num_documento'];
                                this.listarBeneficiarios(data['idcontrato']);
                                this.listarAdicionales(data['idcontrato']);
                                break;
                            }
                            case 'ocupacion':
                            {   
                                this.tituloModal2='Crear Ocupacion';
                                this.modal2=1;
                                this.ocupacion= '';
                                this.tipoAccion = 2;
                                break;
                            }
                            case 'tercero':
                            {
                                this.arrayTerceros=[];
                                this.modalTerceros = 1;
                                this.titulomodalTerceros = 'Seleccione un tercero';
                                this.tipoAccionModalTerceros = 1;
                                break;
                            }
                            case 'tercero_filtro':
                            {
                                this.arrayTerceros=[];
                                this.modalTerceros = 1;
                                this.titulomodalTerceros = 'Seleccione un tercero para la busqueda';
                                this.tipoAccionModalTerceros = 2;
                                break;
                            }
                            case 'beneficiarios':
                            {
                                this.modalAgregados=1;
                                this.titulomodalAgregados='Lista de Beneficiarios';
                                this.tipoAccionAgregados = 1;
                                this.contrato_id=data['idcontrato'];
                                this.nombre=data['nombre'];
                                this.documento=data['documento'];
                                this.tipo_documento=data['tipo_documento'];
                                this.parentesco=data['parentesco'];
                                this.fecha_nacimiento=data['fecha_nacimiento'];
                                this.buscarBeneficiarios(this.contrato_id);
                                break; 
                            }
                            case 'adicionales':
                            {
                                this.modalAgregados=1;
                                this.titulomodalAgregados='Lista de Adcionales';
                                this.tipoAccionAgregados = 2;
                                this.contrato_id=data['idcontrato'];
                                this.nombre=data['nombre'];
                                this.documento=data['documento'];
                                this.tipo_documento=data['tipo_documento'];
                                this.parentesco=data['parentesco'];
                                this.fecha_nacimiento=data['fecha_nacimiento'];
                                this.buscarAdicionales(this.contrato_id);
                                break; 
                            }
                            case 'pagos':
                            {
                                this.modalpagos=1;
                                this.tituloModalPagos='Formato de pagos ';
                                this.tipoAccionPagos = 1;
                                this.pagos_id=this.id_contrato_pagos;
                                this.id_tercero = data['idpersona'];
                                this.valor_pago= '';
                                this.cant_adicionales= '';
                                this.estado= '';
                                this.fecha_pago= this.fecha_pago;
                                this.fecha_vence= this.fecha_vence;
                                this.observacion= '';
                                this.n_contrato= data['n_contrato'];
                                
                                this.listarPagoslaPaz(this.pagos_id,1,'','');
                                this.listarCliente(this.pagos_id,1,'','');
                                break; 
                            }
                        }
                    }
                }
            },
            abrirModalPagos(id){
                this.tipoAccionPagos=1;
                this.id_contrato_pagos = id;
                this.listarPagoslaPaz(id,1,'','');
                this.listarCliente(id);
                this.adicionalesvalor(id);
            },
            desactivarContrato(id){
               swal({
                title: 'Esta seguro de desactivar este contrato?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    // console.log('hijos');
                    // console.log('id: '+id);
                    axios.put(me.ruta +'/contratos/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarContrato(1,'','','','','');
                        swal(
                        'Desactivado!',
                        'El contrato ha sido desactivado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                })
            },
            activarContrato(id){
               swal({
                title: 'Esta seguro de activar este contrato?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put(this.ruta +'/contratos/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarContrato(1,'','','','','');
                        swal(
                        'Activado!',
                        'El contrato ha sido activado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            pdfFormato(id){
                window.open(this.ruta +'/formatos/pdfAfiliados/'+ id);
            }, 
        },
        mounted() {
            let me= this;
            var d = new Date();
            
            
            var dd = d.getDate();
            var mm = d.getMonth()+1;
            var yyyy = d.getFullYear();
            var h = d.getHours();
            var min = d.getMinutes();
            var sec = d.getSeconds();
            
            if(dd<10){
                dd='0'+dd;
            } 
            if(mm<10){
                mm='0'+mm;
            } 
            d = yyyy+'-'+mm+'-'+dd;
            me.anio = yyyy;
            //Fecha vence
            // let me= this;
            var v = new Date();
            
            
            var dd = v.getDate();
            var mm = v.getMonth()+2;
            var yyyy = v.getFullYear();
            var h = v.getHours();
            var min = v.getMinutes();
            var sec = v.getSeconds();
            
            if(dd<10){
                dd='0'+dd;
            } 
            if(mm<10){
                mm='0'+mm;
            } 
            v = yyyy+'-'+mm+'-'+dd;
            me.anio = yyyy;
            
            this.fecha_pago = d;
            this.fecha_vence = v;
            this.fecha_actual = d;
            

            this.comprobarPagosLaPaz(d);
            this.listarContrato(1,this.Bcontrato,this.tercero_id_filtro,this.Bestado,this.BestadoPago,this.Btelefono);
            this.listarPagoslaPaz(this.id_contrato_pagos,1,this.Bfecha_desde,this.Bfecha_hasta);
           
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
    .mostrarOcupacion{
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
    .my-custom-scrollbar {
position: relative;
height: 200px;
overflow: auto;
}
.table-wrapper-scroll-y {
display: block;
}

    
</style>
