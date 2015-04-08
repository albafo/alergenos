@extends('admin.home')
@section('contentAdmin')
<div id="mensajes">   
</div>
<div class="row">
    <div class="col-sm-12">
        <ul class="list-inline text-center" id="letrasIngredientes">
            @for($i='A'; $i<'Z'; $i++) 
            <li><a href="#">{{$i}}</a></li>
            <li class="separator">|</li>
            @endfor
            <li><a href="#">Z</a></li>
        </ul>
    </div>
    
</div>
<div class="row">
    <form id="buscadorIng" class="form-horizontal">
        
        <div class="col-md-8 col-md-offset-2">
            

                <input type="text" name="nombre" class="form-control" id="findIng" placeholder="Buscar ingrediente">

            
        </div> 
    </form>
</div>
<div class="row">
    <div class="col-md-12 text-right clickable"><a href="#" id="newIngrediente">+ Nuevo ingrediente</a></div>
</div>

<div class="row">
    <div class="col-md-12" id="listaIngredientes">
        
    </div>
</div>

<div class="modal fade" id="myModalIng" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nuevo Ingrediente</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="formIngrediente">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="inputNombre" class="col-sm-2 control-label">Nombre</label>
                                <div class="col-sm-10">
                                    <input type="text" name="nombre" class="form-control" id="inputNombre" placeholder="Nombre ingrediente">
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="row" id="forCopyAlerg">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="inputNombre" class="col-sm-2 control-label">Alérgeno</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="alergeno_id[]">
                                        <option value="none">Ningún alérgeno</option>
                                        @foreach($alergenos as $alergeno)
                                        <option value="{{$alergeno->id}}">{{$alergeno->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div id="capaMoreAlerg"></div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <a href="#" id="moreAlerg">+ Alérgenos</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="pull-left">
                    <button type="button" class="btn btn-danger hidden" id="delIngrediente" data-toggle="modal" data-target="#myModalDelIng">Eliminar ingrediente</button>
                </div>
                <div class="pull-right">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="saveIngrediente">Crear ingrediente</button>
                </div>
               
                

            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="myModalDelIng" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">¡¡¡ALERTA!!!</h4>
            </div>
            <div class="modal-body">
                ¿Estás seguro de eliminar el ingrediente?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmDelIngrediente">Confirmar eliminación</button>
            </div>
        </div>
    </div>
</div>

<script>
var selectedIng=-1;
$(function() {
    $('body').on('click', '#letrasIngredientes li a', function(e) { 
        var letra=$(this).text();
        $.get('{{url('ingrediente/buscar-letra-alerg')}}/'+letra, {'_token':'{{csrf_token()}}'}, function(data){
            if(data.html!="") {
                
                $('#listaIngredientes').html(data.html);
            }
            else {
                $('#listaIngredientes').text("No hay ningún ingrediente que empieze por la letra "+letra);
            }
            
        }).fail(function(data) {
            $('#myModalIng').modal('hide');
            $('#mensajes').bootstrapAlert({
                title:"Error!",
                messages:['Fallo al conectar con el servidor.'],
                type:'danger',
                time:5000
            });
            
        }, "json");
    });
    
    $('body').on('click', '#newIngrediente', function() {
        $('#capaMoreAlerg').html('');
        $('#myModalIng').modal('show');
        $('#myModalIng .modal-title').text("Nuevo ingrediente");
        $('#myModalIng #saveIngrediente').text("Nuevo ingrediente");
        $('#myModalIng #delIngrediente').addClass('hidden');
        $('body').off('click', '#saveIngrediente');
        $('body').on('click', '#saveIngrediente', function() {
            var data=$('#formIngrediente').serialize();
            data+="&_token={{csrf_token()}}";
            $.post("{{url('ingredientes/nuevo')}}", data, function() {
                $('#myModalIng').modal('hide');
                $('#mensajes').bootstrapAlert({
                    title:"Enhorabuena!",
                    messages:['Ingrediente registrado con éxito'],
                    type:'success',
                    time:5000
                });
            }).fail(function(data) {
                var error="";
                if(data.responseJSON !== undefined && data.responseJSON.nombre.length>0) {
                    error=data.responseJSON.nombre;
                }
                else {
                    error="Fallo al conectar con el servidor";
                }
                $('#myModalIng').modal('hide');
                $('#mensajes').bootstrapAlert({
                    title:"Error!",
                    messages:[error],
                    type:'danger',
                    time:5000
                });
            });
        });
    });
    
    
    
    $('body').on('keydown', '#findIng', function(e) {
        if(e.keyCode==13) {
            e.preventDefault();
        }
       
        
    });
        
    
    $('body').on('keyup', '#findIng', function(e) {
        
        if($(this).val().length>2) {
            $.get("{{url('ingredientes/findWithAlerg')}}", {'find':$(this).val()}, function(data) {
                if(data.html!="") {
                
                    $('#listaIngredientes').html(data.html);
                }
                else {
                    $('#listaIngredientes').text("No hay ningún ingrediente que cumpla esta búsqueda");
                }
            }).fail(function () {
                $('#mensajes').bootstrapAlert({
                    title:"Error!",
                    messages:["Problema al conectar con el servidor de búsqueda"],
                    type:'danger',
                    time:5000
                });
            });
            
        }
        else {
            $('#listaIngredientes').html("");
        }
    });
    
    $('body').on('click', '#listaIngredientes p', function(data) {
        $('#myModalIng .modal-title').text("Editar ingrediente");
        $('#myModalIng #saveIngrediente').text("Guardar cambios");
        $('#myModalIng #delIngrediente').removeClass('hidden');
        var id=$(this).attr('data-index');
        selectedIng=id;
        $.get("{{url('ingredientes/show')}}/"+id, {'_token':'{{csrf_token()}}'}, function (data) {
            
            $('#myModalIng #capaMoreAlerg').html('');
            
            if(data.alergenos.length>0) {
                $('#forCopyAlerg select').val(data.alergenos[0].id);
                for(var i=1; i<data.alergenos.length; i++) {
                    
                    $clone=$('#myModalIng #forCopyAlerg').clone().removeAttr('id');
                    $clone.find('select').val(data.alergenos[i].id);
                    $clone.appendTo('#myModalIng #capaMoreAlerg');


                }
            }
            $('#myModalIng #inputNombre').val(data.nombre);
            $('body').off('click', '#saveIngrediente');
            $('body').on('click', '#saveIngrediente', function() {
                var data=$('#formIngrediente').serialize();
                data+="&_token={{csrf_token()}}";
                $.post("{{url('ingredientes/editar')}}/"+id, data, function() {
                    $('#listaIngredientes').html("");
                    $('#myModalIng').modal('hide');
                    $('#mensajes').bootstrapAlert({
                        title:"Enhorabuena!",
                        messages:['Ingrediente editado con éxito'],
                        type:'success',
                        time:5000
                    });
                }).fail(function(data) {
                    var error="";
                    if(data.responseJSON !== undefined && data.responseJSON.nombre.length>0) {
                        error=data.responseJSON.nombre;
                    }
                    else {
                        error="Fallo al conectar con el servidor";
                    }
                    $('#myModalIng').modal('hide');
                    $('#mensajes').bootstrapAlert({
                        title:"Error!",
                        messages:[error],
                        type:'danger',
                        time:5000
                    });
                });
            });
            $('#myModalIng').modal('show');
        
        }).fail(function (data) {
        
        });
    });
    
    $('body').on('click', '#moreAlerg', function(){
        $clone=$('#forCopyAlerg').clone();
        $clone.removeAttr('id');
        $('#capaMoreAlerg').append($clone);
        
    });
    
    $('body').on('click', '#confirmDelIngrediente', function() {
        if(selectedIng!=-1) {
            $.get("{{url('ingredientes/eliminar')}}/"+selectedIng, {"_csrf_token":'{{csrf_token()}}'}, function(data) {
                $('#listaIngredientes').html("");

                $('#myModalIng').modal('hide');
                $('#myModalDelIng').modal('hide');
                $('#mensajes').bootstrapAlert({
                    title:"Enhorabuena!",
                    messages:["Ingrediente eliminado con éxito"],
                    type:'success',
                    time:5000
                });
            }).fail(function(data){
                $('#myModalIng').modal('hide');
                $('#myModalDelIng').modal('hide');
                $('#mensajes').bootstrapAlert({
                    title:"Error!",
                    messages:["Fallo al conectar con el servidor"],
                    type:'danger',
                    time:5000
                });
            });
        }
    });
    
});
</script>
@endsection