    @extends('principal')
    @section('contenido')

    @if(Auth::check())
            @if (Auth::user()->idrol == 1)
            <template v-if="menu==0">
                <h1>Escritorio</h1>
            </template>

            <template v-if="menu==1">
                <categoria :ruta="ruta"></categoria>
            </template>

            <template v-if="menu==2">
                <articulo :ruta="ruta"></articulo>
            </template>

            <template v-if="menu==3">
                <ingreso :ruta="ruta"></ingreso>
            </template>

            <template v-if="menu==4">
                <proveedor :ruta="ruta"></proveedor>
            </template>

            <template v-if="menu==5">
                <venta :ruta="ruta"></venta>
            </template>

            <template v-if="menu==6">
                <cliente :ruta="ruta"></cliente>
            </template>
            <template v-if="menu==61">
                <contratos :ruta="ruta"></contratos>
            </template>
            <template v-if="menu==62">
                    <informeslapaz :ruta="ruta"></informeslapaz>
            </template>
            <template v-if="menu==63">
                <cuentaslapaz :ruta="ruta"></cuentaslapaz>
            </template>
            <template v-if="menu==7">
                <user :ruta="ruta"></user>
            </template>

            <template v-if="menu==8">
                <rol :ruta="ruta"></rol>
            </template>

            <template v-if="menu==9">
                <h1>Reporte ingresos</h1>
            </template>

            <template v-if="menu==10">
                <h1>Reporte de ventas</h1>
            </template>

            <template v-if="menu==11">
                <h1>Ayuda</h1>
            </template>

            <template v-if="menu==12">
                <h1>Acerca de</h1>
            </template>
            <template v-if="menu==13">
                <planCuentas :ruta="ruta"></planCuentas>
            </template>
            <template v-if="menu==15">
                <ConFormatos :ruta="ruta"></ConFormatos>
            </template>
            <template v-if="menu==16">
                <registroconta :ruta="ruta"></registroconta>
            </template>
            <template v-if="menu==17">
                <terceros :ruta="ruta"></terceros>
            </template>
            <template v-if="menu==21">
                <auxiliares_conta :ruta="ruta"></auxiliares_conta>
            </template>


            <template v-if="menu==18">
                <fab_proyectos :ruta="ruta"></fab_proyectos>
            </template>
            <template v-if="menu==19">
                <fab_cils_proyecto :ruta="ruta"></fab_cils_proyecto>
            </template>
            <template v-if="menu==20">
                <fab_list_cilindros :ruta="ruta"></fab_list_cilindros>
            </template>

            @elseif (Auth::user()->idrol == 2)
            <template v-if="menu==5">
                <venta :ruta="ruta"></venta>
            </template>

            <template v-if="menu==6">
                <cliente :ruta="ruta"></cliente>
            </template>
            <template v-if="menu==10">
                <h1>Reporte de ventas</h1>
            </template>

            <template v-if="menu==11">
                <h1>Ayuda</h1>
            </template>

            <template v-if="menu==12">
                <h1>Acerca de</h1>
            </template>

            @elseif (Auth::user()->idrol == 3)
            <template v-if="menu==1">
                <categoria :ruta="ruta"></categoria>
            </template>

            <template v-if="menu==2">
                <articulo :ruta="ruta"></articulo>
            </template>

            <template v-if="menu==3">
                <ingreso :ruta="ruta"></ingreso>
            </template>

            <template v-if="menu==4">
                <proveedor :ruta="ruta"></proveedor>
            </template>
            <template v-if="menu==9">
                <h1>Reporte ingresos</h1>
            </template>
            <template v-if="menu==11">
                <h1>Ayuda</h1>
            </template>

            <template v-if="menu==12">
                <h1>Acerca de</h1>
            </template>
            <template v-if="menu==13">
                xxxx
            </template>
            @else

            @endif

    @endif
       
        
    @endsection