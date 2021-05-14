<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Informe Pre-Exequiales</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                       <div class="form-group row">
                            <div class="col-md-4">
                            <div class="form-group row">
                            <label class="col-md-3 form-control-label float-left" for="email-input">N° Contrato</label>
                                <div class="float-right col-md-9">
                                    <input type="text" v-model="Bn_contrato" @keyup.enter="listarinforme(Bn_contrato,Bcliente,Bdesde,Bhasta)" class="form-control" placeholder="Texto a buscar">
                                </div>
                            </div>
                            </div>
                            <div class="col-md-4">
                            <div class="form-group row">
                            <label class="col-md-3 form-control-label float-left" for="email-input">Cliente</label>
                                <div class="float-right col-md-9">
                                    <!--<input type="hidden" v-model="criterio" value="proyecto" >-->
                                    <input type="text" v-model="Bcliente" @keyup.enter="listarinforme(Bn_contrato,Bcliente,Bdesde,Bhasta)" class="form-control" placeholder="Texto a buscar">
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                            <div class="form-group row">
                            <label class="col-md-3 form-control-label float-left" for="email-input">Desde</label>
                                <div class="float-right col-md-9">
                                    <input type="date" v-model="Bdesde" @keyup.enter="listarinforme(Bn_contrato,Bcliente,Bdesde,Bhasta)" class="form-control" placeholder="Texto a buscar">
                                </div>
                            </div>
                            </div>
                            <div class="col-md-4">
                            <div class="form-group row">
                            <label class="col-md-3 form-control-label float-left" for="email-input">Hasta</label>
                                <div class="float-right col-md-9">
                                    <!--<input type="hidden" v-model="criterio" value="proyecto" >-->
                                    <input type="date" v-model="Bhasta" @keyup.enter="listarinforme(Bn_contrato,Bcliente,Bdesde,Bhasta)" class="form-control" placeholder="Texto a buscar">
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-2"> 
                                <div class="input-group">
                                    <button type="submit" @click="listarinforme(Bn_contrato,Bcliente,Bdesde,Bhasta)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Cliente</th>
                                    <th>N° Contrato</th>
                                    <th>Fecha Pago</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(informe,index) in arrayInforme" :key="index">
                                    <td>{{ index + 1 }}</td>
                                    <td :value="informe.id_tercero" v-text="informe.num_documento + ' - '+informe.nombre1 + ' ' + informe.nombre2+ ' ' +informe.apellido1 + ' ' +informe.apellido2"></td>
                                    <td v-text="informe.n_contrato"></td>
                                    <td v-text="informe.fecha_pago"></td>
                                    <td v-text="informe.valor_pago"></td>
                                </tr>                                
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
        
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
                arrayInforme : [],
                errorInforme : 0,
                errorMostrarMsjInforme : [],
                Bcliente: '',
                Bn_contrato: '',
                Bdesde:'',
                Bhasta: ''
            }
        },
        
        methods : {
            listarinforme (Bn_contrato,Bcliente,Bdesde,Bhasta){
                let me=this;
                var url= this.ruta +'/informeslapaz?Bn_contrato=' + Bn_contrato + '&Bcliente=' + Bcliente + '&Bdesde=' + Bdesde + '&Bhasta=' + Bhasta ;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayInforme = respuesta.informes;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
        },
        
        mounted() {
            this.listarinforme(this.Bn_contrato,this.Bcliente,this.Bdesde,this.Bhasta);
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
