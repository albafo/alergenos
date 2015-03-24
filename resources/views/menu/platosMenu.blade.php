@extends('menu.home')
@section('contentMenu')
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
    <div id="mensajes-platos-ok">   
    </div>
    <div class="row" id="pag-platos">
        @include('menu.categorias.categorias')
        @include('menu.platos.platos')
        @include('menu.ingredientes.ingredientes')
        
    </div>
    
    
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="myModalLabel">Editar categoría</h4>
			      </div>
			      <div class="modal-body">
			        <div class="form-group">
					   
					    <input type="text" class="form-control" id="myModalInput" placeholder="Inserte nombre">
                        
						
					
					  </div>
                      <div class="alert alert-danger hidden" id="cajaError">
							<strong>Ups!</strong> Hay algún error con el formulario.<br><br>
							<ul>
							    
							</ul>
						</div>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			        <button type="button" class="btn btn-primary" id="myModalSave">Guardar cambios</button>
			      </div>
			    </div>
			  </div>
			</div>


           
			

            


<script>
var selectedCat=-1;
jQuery(function($) {
    
    $('body').on('click', '#addCat', function() {
        $('#cajaError').addClass('hidden');
        $('body').off('click', '#myModalSave');
        $('#myModal .modal-title').text('Crear categoría');
        $('#myModal #myModalSave').text('Crear categoría');
        $('#myModalInput').val('');

        $('#myModal').modal();
        $('body').on('click', '#myModalSave', function(){

            var boton=$(this);
            boton.attr('disabled', true);
			if($('#myModalInput').val()!="") {
                
				$.post("{{url('categoria/store/'.$menu->id)}}", {'_token':'{{csrf_token()}}', 'nombre':$('#myModalInput').val()}, function(data) {
                    //window.location.href = '{{url('menu/datos-menu')}}'+'/'+data.id; 
                    $('#lista-categorias').append(data.html);
                    $('#noCat').addClass('hidden');
                    $('#myModal').modal('hide');
                    boton.attr('disabled', false);

                    $('#mensajes-platos-ok').bootstrapAlert({
                        title:"Enhorabuena!",
                        messages:['Categoría gurdada con éxito'],
                        type:'success',
                        time:5000
                    });
				}).fail(function(data) {
                    $('#cajaError ul').html('');
                    if(data.responseJSON !== undefined && data.responseJSON.nombre.length>0) {
                        $('#cajaError ul').append('<li>'+data.responseJSON.nombre+'</li>');
                        $('#cajaError').removeClass('hidden');
                    }
                    else {
                        $('#cajaError ul').append('<li>Fallo de conexión. Compruebe su acceso a la red.</li>');
                        $('#cajaError').removeClass('hidden');
                    }
                    boton.attr('disabled', false);

                    
                }, "json");
                    
                
			}
        });
    });
    
    
    $('body').on('click', '.delCat', function(e) {
        e.stopPropagation();
        var id_cat=$(this).parent().parent().parent().attr('id');
        id_cat=id_cat.split("-")[1];
        bootbox.confirm("¿Estás seguro de eliminar la categoría? Se eliminarán todos los platos que la contengan", function(result) {
            if(result) {
                $.post("{{url('categoria/destroy/'.$menu->id)}}/"+id_cat, {'_token':'{{csrf_token()}}'}, function(data) {
                    $('#categoria-'+id_cat).remove();
                    $('#mensajes-platos-ok').bootstrapAlert({
                        title:"Enhorabuena!",
                        messages:['Categoría eliminada con éxito.'],
                        type:'danger',
                        time:5000
                    });
                    if($('#lista-categorias div').length<1) {
                        $('#noCat').removeClass('hidden');
                    }
                }).fail(function(data) {
                    $('#mensajes-platos-ok').bootstrapAlert({
                        title:"Error!",
                        messages:['Fallo al conectar con el servidor.'],
                        type:'success',
                        time:5000
                    });
                }, "json");
            }
        }); 
    });
    
    
    $('body').on('click', '.editCat', function(e) {
        e.stopPropagation();
        $('#cajaError').addClass('hidden');

        var id_cat=$(this).parent().parent().parent().attr('id');
        var text=$(this).parent().parent().parent().find('.panel-body').text();
        id_cat=id_cat.split("-")[1];
        $('body').off('click', '#myModalSave');
        $('#myModal .modal-title').text('Editar categoría');
        $('#myModal #myModalSave').text('Reemplazar nombre');
        $('#myModalInput').val(text);

        $('#myModal').modal();
        $('body').on('click', '#myModalSave', function(){
            var boton=$(this);
            boton.attr('disabled', true);
			if($('#myModalInput').val()!="") {
				$.post("{{url('categoria/update/'.$menu->id)}}/"+id_cat, {'_token':'{{csrf_token()}}', 'nombre':$('#myModalInput').val()}, function(data) {
                    //window.location.href = '{{url('menu/datos-menu')}}'+'/'+data.id; 
                    $('#categoria-'+id_cat+' .panel-body').text($('#myModalInput').val());
                    $('#myModal').modal('hide');
                    $('#mensajes-platos-ok').bootstrapAlert({
                        title:"Enhorabuena!",
                        messages:['Categoría modificada con éxito'],
                        type:'success',
                        time:5000
                    });
                    boton.attr('disabled', false);

				}).fail(function(data) {
                    $('#cajaError ul').html('');
                    if(data.responseJSON !== undefined && data.responseJSON.nombre.length>0) {
                        $('#cajaError ul').append('<li>'+data.responseJSON.nombre+'</li>');
                        $('#cajaError').removeClass('hidden');
                    }
                    else {
                        $('#cajaError ul').append('<li>Fallo de conexión. Compruebe su acceso a la red.</li>');
                        $('#cajaError').removeClass('hidden');
                    }
                    boton.attr('disabled', false);

                    
                }, "json");
                    
                
			}
        });
    });
    
    $('body').on('click', "[id^='categoria-']", function(e) {
       var id_cat=$(this).attr('id').split("-")[1];
       $.get("{{url('plato/show')}}/"+id_cat, {'_token':'{{csrf_token()}}'}, function(data) {
           $("[id^='categoria-']").removeClass('selected');
           $("#categoria-"+id_cat).addClass('selected');
           $('#lista-platos').html('');
           if(data.html=="") {
               $('#msgPlatos').text('No has añadido ningún plato en esta categoría');
               $('#msgPlatos').removeClass('hidden');
           }
           else {
               $('#msgPlatos').addClass('hidden');
               $('#lista-platos').append(data.html);
               
           }
           selectedCat=id_cat;
           $('#addPlato').removeClass('hidden');
           
       }).fail(function() {
           $('#mensajes-platos-ok').bootstrapAlert({
               title:"Error!",
               messages:['Fallo al conectar con el servidor.'],
               type:'danger',
               time:5000
           });
       });
    });
    
    $('body').on('click', "#addPlato", function() {
        if(selectedCat!=-1) {
            $('#myModalPlato .modal-title').text('Crear plato');
            $('#myModalPlato #savePlato').text('Crear plato');
            $('#myModalPlato').modal();
            $('body').off('click', '#savePlato');
            $('body').on('click', "#savePlato", function() {
                
                var data=$( "#formPlato" ).serializeArray();
                
                data.push({name: '_token', value: '{{csrf_token()}}'});
                $.post("{{url('plato/store')}}/"+selectedCat, data, function(data) {
                    $('#msgPlatos').addClass('hidden');
                    $('#lista-platos').append(data.html);
                    $('#myModalPlato').modal('hide');
                    $('#mensajes-platos-ok').bootstrapAlert({
                        title:"Enhorabuena!",
                        messages:['Plato añadido con éxito'],
                        type:'success',
                        time:5000
                    });
                }).fail(function(data) {
                    if(data.responseJSON!==undefined) {
                        var messages_a=new Array();
                        
                        for(var i in data.responseJSON) {
                           
                            messages_a.push(data.responseJSON[i]);
                            
                        }
                        $('#myModalPlato').modal('hide');
                        $('#mensajes-platos-ok').bootstrapAlert({
                            title:"Error!",
                            messages:messages_a,
                            type:'danger',
                            time:5000
                        });
                    }
                    else {
                        $('#myModalPlato').modal('hide');
                        $('#mensajes-platos-ok').bootstrapAlert({
                            title:"Error!",
                            messages:['Error al conectar con el servidor'],
                            type:'danger',
                            time:5000
                        });
                    }
                }, "json");
            });
        }
        else {
            $('#mensajes-platos-ok').bootstrapAlert({
                title:"Error!",
                messages:['No hay seleccionada ninguna categoría.'],
                type:'danger',
                time:5000
            });
        }
        
    });
    
    
    $('body').on('click', '.editPlato', function(e) {
        e.stopPropagation();
        $('#cajaError').addClass('hidden');

        var id_plato=$(this).parent().parent().parent().attr('id');
        id_cat=id_cat.split("-")[1];
        $('body').off('click', '#savePlato');
        $('#myModalPlato #myModalLabel').text('Editar categoría');
        $('#myModal #myModalSave').text('Reemplazar nombre');
        $('#myModalInput').val(text);

        $('#myModal').modal();
        $('body').on('click', '#myModalSave', function(){
            var boton=$(this);
            boton.attr('disabled', true);
			if($('#myModalInput').val()!="") {
				$.post("{{url('categoria/update/'.$menu->id)}}/"+id_cat, {'_token':'{{csrf_token()}}', 'nombre':$('#myModalInput').val()}, function(data) {
                    //window.location.href = '{{url('menu/datos-menu')}}'+'/'+data.id; 
                    $('#categoria-'+id_cat+' .panel-body').text($('#myModalInput').val());
                    $('#myModal').modal('hide');
                    $('#mensajes-platos-ok').bootstrapAlert({
                        title:"Enhorabuena!",
                        messages:['Categoría modificada con éxito'],
                        type:'success',
                        time:5000
                    });
                    boton.attr('disabled', false);

				}).fail(function(data) {
                    $('#cajaError ul').html('');
                    if(data.responseJSON !== undefined && data.responseJSON.nombre.length>0) {
                        $('#cajaError ul').append('<li>'+data.responseJSON.nombre+'</li>');
                        $('#cajaError').removeClass('hidden');
                    }
                    else {
                        $('#cajaError ul').append('<li>Fallo de conexión. Compruebe su acceso a la red.</li>');
                        $('#cajaError').removeClass('hidden');
                    }
                    boton.attr('disabled', false);

                    
                }, "json");
                    
                
			}
        });
    });
    
    
    
    
    $( ".lista-categorias" ).sortable({
        axis: "y",
        items: "div[id^='categoria-']",
        update: function( event, ui ) {
            var data = $(this).sortable('toArray');
           
            $.post("{{url('categoria/reordenar/'.$menu->id)}}", {'_token':'{{csrf_token()}}', 'data':data}, function() {
                 $('#mensajes-platos-ok').bootstrapAlert({
                        title:"Enhorabuena!",
                        messages:['Categorías reordenadas con éxito'],
                        type:'success',
                        time:5000
                    });
            }).fail(function(data) {
                $('#mensajes-platos-ok').bootstrapAlert({
                        title:"Error!",
                        messages:['Fallo al conectar con el servidor.'],
                        type:'danger',
                        time:5000
                    });
            }, "json");
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