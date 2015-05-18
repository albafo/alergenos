@extends('admin.home')
@section('contentAdmin')
<form class="form-horizontal" method="post" action= @if(isset($alergeno)) "{{url('admin/alergenos/editar')."/".$alergeno->id}}" @else "{{url('admin/alergenos/nuevo/')}}" @endif enctype="multipart/form-data">
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
        <div class="col-sm-6">
            <div class="form-group">
                <label for="inputNombre" class="col-sm-2 control-label">Nombre</label>
                <div class="col-sm-10">
                    <input type="text" name="nombre" class="form-control" id="inputNombre" placeholder="Nombre alérgeno" value="{{ $alergeno->nombre or '' }}">
                </div>
            </div>
            <hr style="  border-top: 1px solid #ccc;">
            <h4>Idiomas</h4>

            @foreach(\App\Idioma::all() as $idioma)
                <div class="form-group">
                    <label for="idioma-{{$idioma->id}}" class="col-sm-2 control-label">{{$idioma->nombre}}</label>
                    <div class="col-sm-10">
                        <input type="text" name="idioma[{{$idioma->id}}]" class="form-control inputIdioma" id="idioma-{{$idioma->id}}" placeholder="{{$idioma->nombre}}" value="@if($alergeno->hasTraduccion($idioma->id)){{$alergeno->traduccion()->find($idioma->id)->pivot->content}}@endif">
                    </div>
                </div>
            @endforeach

        </div> 
        <div class="col-sm-6">
            <div class="form-group">
                <label for="inputCaducidad" class="col-sm-2 control-label">Imagen</label>
                <div class="col-sm-10">
                    <input id="file_img" type="file" name="image" accept="image/*" >
                    <script>
                    /* Initialize your widget via javascript as follows */
                    $("#file_img").fileinput({
                        @if(isset($alergeno->img))
                        initialPreview: [
                            "<img src='{{asset($alergeno->img)}}' class='file-preview-image'>"
                        ],
                        
                        initialPreviewShowDelete:false,


                        @endif
                        overwriteInitial: true,
                        maxFileSize: 100,
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
        <div class="col-sm-6">
            <div class="form-group">
                <label for="inputDescrip" class="col-sm-2 control-label">Descripción</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="inputDescrip" name="descripcion" rows="5" maxlength="255" >{{ $alergeno->descripcion or '' }}</textarea>
                    <span id="inputDescrip_feedback" class="textarea_feedback"></span>
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
        <div class="col-sm-6 text-center">
            <div class="form-group">
                @if(isset($alergeno))
                <button type="button" class="btn btn-danger"  data-toggle="modal" data-target="#myModal">Eliminar alérgeno</button>
                @endif
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">¡¡¡ALERTA!!!</h4>
                            </div>
                            <div class="modal-body">
                                ¿Estás seguro de eliminar el alérgeno?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-danger" id="delAlergeno">Confirmar eliminación</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
</form>
<script>
	$(function () {
        $('#datetimepicker1').datetimepicker({
            locale: 'es',
            viewMode:'years',
            format:'DD/MM/YYYY'
        });
        
        var text_max = $('#inputDescrip').attr('maxlength');
        var text_length = $('#inputDescrip').val().length;
        var text_remaining = text_max - text_length;
        $('#inputDescrip_feedback').html(text_remaining + ' caracteres restantes.');

        $('#inputDescrip').keyup(function() {
            var text_length = $('#inputDescrip').val().length;
            var text_remaining = text_max - text_length;
            $('#inputDescrip_feedback').html(text_remaining + ' caracteres restantes.');
        });
        $(".switch-checkbox").bootstrapSwitch();
        @if(isset($alergeno))
        $('body').on('click', '#delAlergeno', function() {
            location.href='{{url('admin/alergenos/eliminar/'.$alergeno->id)}}';
        });
        @endif
        
    });
</script>
@endsection