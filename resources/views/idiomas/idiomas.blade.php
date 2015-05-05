@extends('app')
@section('content')
<div class="container">
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
	    <div class="col-md-10 col-md-offset-1">
            <h3>Idiomas</h3>
            <form class="form-horizontal" method="post" action="{{url('idioma/nuevo')}}" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="input-nombre" class="col-sm-4 control-label">Nuevo idioma:</label>
                            <div class="col-sm-4">
                                <input type="text" name="nombre" id="input-nombre" class="form-control"  value="" placeholder="Nombre idioma">
                            </div>
                            <div class="col-sm-4">
                                <input type="submit" class="btn btn-primary" value="Nuevo idioma">
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

            </form>
            <h4>Idiomas registrados</h4>
            @foreach(Auth::user()->idiomas as $idioma)
            <form class="form-horizontal" method="get" action="{{url('idioma/editar/'.$idioma->id)}}">
                <div class="row" style="margin-top:15px">
                    <div class="col-sm-12">
                        <div class="form-group">
                           
                            <div class="col-sm-4">
                                <input type="text" name="nombre" id="input-nombre" class="form-control"  value="{{$idioma->nombre}}" placeholder="Nombre idioma">
                            </div>
                            <div class="col-sm-4">
                                <button type="submit" class="btn btn-primary">Editar idioma</button> <a href="{{url('idioma/borrar/'.$idioma->id)}}" class="btn btn-danger btn-borrar-idioma">Borrar idioma</a>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </form>
            @endforeach
        </div>
	</div>
</div>
<script>
    $(function() {
        $('body').on('click', '.btn-borrar-idioma', function(e) {
            e.preventDefault();
            var href=$(this).attr('href');
            bootbox.confirm("¿Estás seguro de eliminar el idioma? Se eliminarán todas las traducciones realizadas", function(result) {
            
                if(result) {
                   window.location.href = href;
                }
            });
        })
    });
</script>
@endsection