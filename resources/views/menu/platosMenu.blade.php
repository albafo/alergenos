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
        <div class="col-sm-4 text-center">
            <h4>Categorías</h4>
            <div class="lista-categorias" id="lista-categorias">
                <div class="panel panel-default caja-menu selected" id="categoria-5">
                    <div class="editDel">
                        <div class="editar">
                            <a href="#"  title="Editar" class="glyphicon glyphicon-pencil editCat"></a>
                        </div>
                        <div class="borrar">
                            <a href="#" title="Borrar" class="glyphicon glyphicon-remove"></a>
                        </div>
                    </div>
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
            <a id="addCat" class="glyphicon glyphicon-plus"></a>
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
jQuery(function($) {
    
    $('body').on('click', '#addCat', function() {
                    $('#cajaError').addClass('hidden');

        $('body').off('click', '#myModalSave');
        $('#myModal #myModalLabel').text('Crear categoría');
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
    
    
    
    $('body').on('click', '.editCat', function() {
        $('#cajaError').addClass('hidden');

        var id_cat=$(this).parent().parent().parent().attr('id');
        var text=$(this).parent().parent().parent().find('.panel-body').text();
        id_cat=id_cat.split("-")[1];
        $('body').off('click', '#myModalSave');
        $('#myModal #myModalLabel').text('Editar categoría');
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