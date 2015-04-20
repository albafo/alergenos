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
        <div class="col-sm-6">
            <div class="form-group">
                <label for="inputNombre" class="col-sm-2 control-label">Nombre</label>
                <div class="col-sm-10">
                    <input type="text" name="nombre" class="form-control" id="inputNombre" placeholder="Nombre menú" value="{{$menu->nombre}}">
                </div>
            </div>
        </div> 
        <div class="col-sm-6">
            <div class="form-group">
                <label for="precio" class="col-sm-2 control-label">Precio</label>
                <div class="col-sm-10">
                    
                    <input type='text' class="form-control"  name="precio" value="{{$menu->precio}}"/>                          
                </div>
            </div>
        </div> 
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="inputDescrip" class="col-sm-2 control-label">Descripción</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="inputDescrip" name="descripcion" rows="5" maxlength="255" >{{$menu->descripcion}}</textarea>
                    <span id="inputDescrip_feedback" class="textarea_feedback"></span>
                </div>
            </div>
        </div> 
        <div class="col-sm-6">
            <div class="form-group">
                <label for="inputCaducidad" class="col-sm-2 control-label">Activo</label>
                <div class="col-sm-10">
                    <input type="checkbox" data-off-color="danger" name="estado" class="switch-checkbox" @if($menu->estado==1) checked @endif value="1">

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
                <button type="button" class="btn btn-danger"  data-toggle="modal" data-target="#myModal">Eliminar menú</button>
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">¡¡¡ALERTA!!!</h4>
                            </div>
                            <div class="modal-body">
                                ¿Estás seguro de eliminar el menú?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-danger" id="delMenu">Confirmar eliminación</button>
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
        
        $('body').on('click', '#delMenu', function() {
            location.href='{{url('menu/destroy/'.$menu->id)}}';
        })
    });
</script>
@endsection