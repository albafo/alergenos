@extends('app')
@section('content')
<div class="container" id="opciones-admin">
    
    <div id="listadoHerramientas">
        <h1 class="text-center">Administración</h1>
        <div clas="row">
            <div class="col-md-12">
                <div class="panel panel-default caja-menu ui-sortable-handle caja-link">
    
                    <div class="panel-body"><a href="{{url('admin/alergenos')}}">Alérgenos</a></div>
                </div>
            </div>
        </div>
        <div clas="row">
            <div class="col-md-12">
                <div class="panel panel-default caja-menu ui-sortable-handle caja-link">
    
                    <div class="panel-body"><a href="{{url('admin/ingredientes')}}">Ingredientes</a></div>
                </div>
            </div>
        </div>
        <div clas="row">
            <div class="col-md-12">
                <div class="panel panel-default caja-menu ui-sortable-handle caja-link">
    
                    <div class="panel-body"><a href="{{url('admin/usuarios')}}">Usuarios</a></div>
                </div>
            </div>
        </div>
        <div clas="row">
            <div class="col-md-12">
                <div class="panel panel-default caja-menu ui-sortable-handle caja-link">
                    @if(Ticket::noReaded()>0)
                    <div class="numberAlert badge">
                        {{Ticket::noReaded()}}
                    </div>
                    
                    @endif
                    <div class="panel-body"><a href="{{url('admin/tickets')}}">Tickets</a></div>
                </div>
            </div>
        </div>
        <div clas="row">
            <div class="col-md-12">
                <div class="panel panel-default caja-menu ui-sortable-handle caja-link caja-href">

                    <div class="panel-body"><a href="{{url('idiomas')}}">Idiomas</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
       $('.caja-menu').click(function(){
          var link=$(this).find('a').attr('href');
          window.location.href=link;  
       }); 
    });
</script>
@endsection