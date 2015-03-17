@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="col2height row">
				<div class="col-xs-6">
					<h3>Mis menús</h3>
				</div>
				<div class="col-xs-6 text-right">
					<h5 class="insertarMenu" id="insertarMenu" data-toggle="modal" data-target="#myModal">+ Insertar menú</h5>
				</div>
			</div>
			<?php use App\Librerias\DateFormat\DateSql; ?>
			@unless($menus->count())
			    <span>No has creado ningún menú todavía.</span>
			@else
				@foreach($menus as $menu)
				<div class="panel panel-default caja-menu" id="menu-{{$menu->id}}">
					<div class="panel-body">
						<div class="row">
							<div class="col-md-6"><strong>{{$menu->nombre}}</strong></div>
							
	
							<div class="col-md-6 text-right">Fecha de alta: {{DateSql::changeFromSql($menu->created_at)}}</div>
							
						</div>
						<div class="row">
							<div class="col-md-6"></div>
							<div class="col-md-6 text-right">Última modificación: {{DateSql::changeFromSqlTime($menu->updated_at)}}</div>
						</div>
						<div class="row">
							<div class="col-md-6"></div>
							@if ($menu->estado == 1)
							<div class="col-md-6 text-right estado-activo">Estado: Activo</div>
							@else
    						<div class="col-md-6 text-right estado-inactivo">Estado: Inactivo</div>
							@endif

						</div>
						
					</div>
				</div>
				@endforeach
			@endunless
			
			
			<?php echo $menus->render(); ?>

			<!-- Modal -->
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="myModalLabel">Nombre del menú</h4>
			      </div>
			      <div class="modal-body">
			        <div class="form-group">
					   
					    <input type="email" class="form-control" id="nombreMenu" placeholder="Inserte nombre">
                        
						
					
					  </div>
                      <div class="alert alert-danger hidden" id="cajaError">
							<strong>Ups!</strong> Hay algún error con el formulario.<br><br>
							<ul>
							    
							</ul>
						</div>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			        <button type="button" class="btn btn-primary" id="crearMenu">Crear menú</button>
			      </div>
			    </div>
			  </div>
			</div>
		</div>
	</div>
</div>
<script>
	$(function() {
		
		$('body').on('click', '#crearMenu', function() {
            $('#cajaError').addClass('hidden');

            var boton=$(this)
            boton.attr('disabled', true);
			if($('#nombreMenu').val()!="") {
				$.post("{{url('menu/create')}}", {'_token':'{{csrf_token()}}', 'nombreMenu':$('#nombreMenu').val()}, function(data) {
                    window.location.href = '{{url('menu/datos-menu')}}'+'/'+data.id; 
				}).fail(function(data) {
                    $('#cajaError ul').html('');
                    if(data.responseJSON !== undefined && data.responseJSON.nombreMenu.length>0) {
                        $('#cajaError ul').append('<li>'+data.responseJSON.nombreMenu+'</li>');
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
		
		$('body').on('click', '*[id*=menu-]:visible', function() {
			var id=$(this).attr('id').split("-");
			id=id[1];
			window.location.href = '{{url('menu/datos-menu')}}'+'/'+id; 
		});
	});
</script>
@endsection
