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
            <h3>Mis datos</h3>
            <form class="form-horizontal" method="post" action="{{url('usuario/datos')}}" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="input-nombre" class="col-sm-4 control-label">Nombre</label>
                            <div class="col-sm-8">
                                <input type="text" name="nombre" id="input-nombre" class="form-control"  value="{{Auth::user()->nombre}}">
                            </div>
                        </div>
                    </div> 
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="input-apellidos" class="col-sm-4 control-label">Apellidos</label>
                            <div class="col-sm-8">
                                <input type='text' class="form-control" id='input-apellidos' name="apellidos" value="{{Auth::user()->apellidos}}"/>                          
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="input-email" class="col-sm-4 control-label">Email</label>
                            <div class="col-sm-8">
                                <input type="text" name="email" id="input-email" class="form-control"  value="{{Auth::user()->email}}">
                            </div>
                        </div>
                    </div> 
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="input-email1" class="col-sm-4 control-label">Confirmación Email</label>
                            <div class="col-sm-8">
                                <input type='text' class="form-control" id='input-email1' name="email_confirmation" value="" placeholder="Rellene si cambia email"/>                          
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        @if((Auth::user()->tipo=="user" && !Session::has('auth-admin')) || Auth::user()->tipo=="admin")
                        <div class="row">
                            <div class="col-sm-12">        
                                <div class="form-group">
                                    <label for="input-password" class="col-sm-4 control-label">Antigua contraseña</label>
                                    <div class="col-sm-8">
                                        <input type="password" name="password_old" id="input-password" class="form-control" placeholder="Rellene si cambia contraseña"  value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-sm-12">        
                                <div class="form-group">
                                    <label for="input-password_new" class="col-sm-4 control-label">Nueva contraseña</label>
                                    <div class="col-sm-8">
                                        <input type="password" name="password" id="input-password_new" class="form-control" placeholder="Rellene si cambia contraseña"  value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">        
                                <div class="form-group">
                                    <label for="input-password_new1" class="col-sm-4 control-label">Confirmación nueva contraseña</label>
                                    <div class="col-sm-8">
                                        <input type="password" name="password_confirmation" id="input-password_new1" class="form-control" placeholder="Rellene si cambia contraseña"  value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="col-sm-6">
                        @if(Auth::user()->tipo=="user" && Session::has('auth-admin') && Session::get('auth-admin')->tipo=="admin")
                        <div class="row">
                            <div class="form-group">
                                <label for="input-status" class="col-sm-4 control-label">Usuario activo</label>
                                <div class="col-sm-8">
                                    <input type="checkbox" data-off-color="danger" name="status" class="switch-checkbox" @if(Auth::user()->status==1) checked @endif value="1">
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="row">
                            <div class="form-group">
                <label for="inputCaducidad" class="col-sm-4 control-label">Icono establecimiento</label>
                <div class="col-sm-8">
                    <input id="file_img" type="file" name="icono_estb" accept="image/*" >
                    <script>
                    /* Initialize your widget via javascript as follows */
                    $("#file_img").fileinput({
                        @if(Auth::user()->icono_estb!="")
                        initialPreview: [
                            "<img src='{{asset(Auth::user()->icono_estb)}}' class='file-preview-image'>"
                        ],
                        
                        initialPreviewShowDelete:false,
                        @endif
                        overwriteInitial: true,
                        maxFileSize: 500,
                        dropZoneEnabled: true,
                    	previewFileType: "image",
                    	browseClass: "btn btn-success",
                    	browseLabel: " Cargar icono",
                    	browseIcon: '<i class="glyphicon glyphicon-picture"></i>',
                    	removeClass: "btn btn-danger",
                    	removeLabel: " Borrar",
                    	removeIcon: '<i class="glyphicon glyphicon-trash"></i>',
                    	uploadClass: "btn btn-info",
                    	showUpload: false,
                    	uploadAsync: false,
                    	maxFilesNum: 1,
                    });
                    
                    
                    </script>
                </div>
            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 text-center">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Guardar datos</button>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="deletedImg" id="deletedImg" value="0" />
                <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />

            </form>
	    </div> 
    </div>
</div>
<script>
$(function() {
    $(".switch-checkbox").bootstrapSwitch();
    $('#file_img').on('fileclear', function(event) {
        $('#deletedImg').val(1);
    });
});
</script>
@endsection