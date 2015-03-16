@extends('menu.home')
@section('contentMenu')
<form class="form-horizontal" method="post" action="{{url('menu/edit/'.$menu->id)}}">
    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="row">
        <div class="col-sm-4 text-center">
            <h4>Categorías</h4>
            <div class="lista-categorias">
                <div class="panel panel-default caja-menu selected" id="categoria-5">
                    <div class="panel-body">Entrantes</div>
                </div>
                <div class="panel panel-default caja-menu">
                    <div class="panel-body">Carnes</div>
                </div>
                <div class="panel panel-default caja-menu">
                    <div class="panel-body">Pescados</div>
                </div>
                <div class="panel panel-default caja-menu">
                    <div class="panel-body">Arroces</div>
                </div>
                <div class="panel panel-default caja-menu">
                    <div class="panel-body">Postres</div>
                </div>
            </div>
        </div> 
        <div class="col-sm-4 text-center">
            <h4>Platos</h4>
            <div class="lista-platos">
                <div class="panel panel-default caja-menu">
                    <div class="panel-body">Calamares en su tinta</div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 text-center">
            <h4>Ingredientes</h4>
            <span>Seleccione un plato</span>
        </div> 
    </div>
    
    
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
</form>
<script>
jQuery(function($) {
    $( ".lista-categorias" ).sortable({
        axis: "y",
        update: function( event, ui ) {
            alert(ui.item.attr('id'));
        }
        
    });       
    $( ".lista-platos" ).sortable({
        axis: "y",
        update: function( event, ui ) {
            alert(ui.item.attr('id'));
        }
        
    });       
});
</script>
@endsection