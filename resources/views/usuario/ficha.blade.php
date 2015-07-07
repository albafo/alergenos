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
                        @if((Auth::user()->tipo=="user" && !Session::has('auth-admin')) || Auth::user()->tipo=="admin" || Auth::user()->tipo=="tecnico")
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
                        <div class="row">
                            <div class="col-sm-12">        
                                <div class="form-group">
                                    <label for="nombre_establ" class="col-sm-4 control-label">Nombre establecimiento</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="nombre_establ" id="nombre_establ" class="form-control"   value="{{Auth::user()->nombre_establ}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(Auth::user()->tipo=="user" && Session::has('auth-admin') && Session::get('auth-admin')->tipo=="admin")
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="nombre_establ" class="col-sm-4 control-label">Código de activación</label>
                                    <div class="col-sm-8">
                                        <span>{{Auth::user()->activation_code}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
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
                            <div class="col-sm-12">        
                                <div class="form-group">
                                    <label for="inputCaducidad" class="col-sm-4 control-label">Icono establecimiento</label>
                                        <div class="col-sm-8">
                                        <input id="file_img" type="file" name="icono_estb" accept="image/*" >
                                        <script>
                                        /* Initialize your widget via javascript as follows */
                                        $("#file_img").fileinput({
                                            @if(Auth::user()->icono_estb!="")
                                            initialPreview: [
                                                "<img src='{{asset('iconos-estb/'.Auth::user()->id.'/'.Auth::user()->icono_estb)}}' class='file-preview-image'>"
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
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="input-status" class="col-sm-4 control-label">Dirección establecimiento</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="direccion" class="form-control" value="{{Auth::user()->direccion}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="input-status" class="col-sm-4 control-label">Teléfono establecimiento</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="telefono" class="form-control" value="{{Auth::user()->telefono}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="caducidad" class="col-sm-4 control-label">Suscripción hasta</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="caducidad"  class="form-control"   value="{{DateSql::changeFromSqlTime(Auth::user()->expired_at)}} (UTC/GMT)" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label  class="col-sm-4 control-label"></label>
                                    <div class="col-sm-8">
                                        <button id="renovar" class="btn btn-primary @if(strtotime(Auth::user()->expired_at) - time() > env('TIME_ACTIVATE_RENEW')) disabled @endif">Renovar suscripción</button>
                                    </div>
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

                    @if(Auth::user()->tipo=="user" && Session::has('auth-admin') && Session::get('auth-admin')->tipo=="admin")
                    <div class="col-sm-6 text-center">
                        <div class="form-group">
                            <button type="submit" id="btnDelUser" class="btn btn-danger">Peligro: Eliminar usuario</button>
                        </div>
                    </div>
                    @endif
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
    
    @if(strtotime(Auth::user()->expired_at) - time() <= env('TIME_ACTIVATE_RENEW'))
        $('body').on('click', '#renovar', function (e) {
            e.preventDefault();
           alert("Próximamente activaremos la pasarela de pago para poder renovar su suscripción"); 
        });
    @endif


    @if(Auth::user()->tipo=="user" && Session::has('auth-admin') && Session::get('auth-admin')->tipo=="admin")

    $('body').on('click', '#btnDelUser', function(e) {
        e.preventDefault();
        bootbox.confirm("¿Estás seguro de eliminar el usuario? Esta acción es irreversible", function(result) {

            if(result) {
                window.location.href = '{{url('user/delete')}}';
            }
        });

    });
    @endif



});
</script>
@endsection