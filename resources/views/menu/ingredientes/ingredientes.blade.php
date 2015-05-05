<div class="col-sm-4 text-center">
    <h4>Ingredientes</h4>
    <span id="msgIngredientes">Seleccione un plato</span>

    <div class="lista-ingredientes" id="lista-ingredientes">

    </div>
    <a id="addIngrediente" class="glyphicon glyphicon-plus hidden"></a>
</div>
<div class="modal fade" id="myModalIng" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar Plato</h4>
            </div>
            <div class="modal-body">
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
                    
                        <div class="col-md-12">
                        
                            <input type="text" name="nombre" class="form-control" id="findIng" placeholder="Buscar ingrediente">
            
                        </div> 
                    </form>
                </div>
                <hr/>
                <div class="row text-center" id="listaIngredientesModal">
                    <span>No ha seleccionado ninguna letra</span>
                </div>
                <form id="idiomasIngredientes">
                <div class="otrosIdiomas">
                        @foreach(Auth::user()->idiomas as $idioma) 
                            <p>{{$idioma->nombre}}</p>
                            <p><input type="text" class="form-control" name="idioma[{{$idioma->id}}]" data-id="{{$idioma->id}}" placeholder="{{$idioma->nombre}}"> </p>
                        @endforeach
                </div>
                </form>
                
            </div>
            <div class="alert alert-danger hidden cajaError" >
                <strong>Ups!</strong> Hay algún error con el formulario.<br><br>
                <ul>

                </ul>
            </div>
            <div class="alert alert-success hidden" id="cajaOk">
                <strong>Gracias!</strong><br><br>
                <ul>
                    <li>Su solicitud ha sido enviada con éxito. Le informaremos cuando hayamos resuelto su petición.</li> 
                </ul>
            </div>
            <div class="modal-footer">
                <div class="pull-left">
                     <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModalLostIng"  id="lostIngrediente">Falta algún ingrediente</button>
                </div>
                <div class="pull-right">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="saveIngrediente" disabled>Guardar cambios</button>
                </div>
                    
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="myModalLostIng" tabindex="-1" role="dialog" aria-labelledby="lostIngrediente" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Enviar petición de ingredientes</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 textoLostIng"> 
                        <strong>¿Falta algún ingrediente?</strong><br> Envíenos los ingredientes que faltan y en breve los insertaremos en el sistema.<br>
                        Gracias por su colaboración.
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <form class="form-horizontal">
                          <div class="form-group">
                            
                            <div class="col-sm-12">
                              <textarea class="form-control" id="peticion" placeholder="Indíquenos los ingredientes que faltan" rows="5"></textarea>
                            </div>
                          </div>
                        </form>
                    </div> 
                </div>
                
                
            </div>
            
            
            
            
            <div class="modal-footer">
                
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="sendPeticion" d>Enviar</button>
                
                    
            </div>
        </div>
    </div>
</div>

<script>
    $('body').on('click', '#sendPeticion', function(e) {
       e.preventDefault();
       $.post("{{url('ingredientes/peticion')}}", {'peticion':$('#peticion').val(), '_token':'{{csrf_token()}}' }, function() {
            $('#cajaOk').removeClass('hidden');
            $('#myModalLostIng').modal('hide');
        }).fail(function () {
                       
                       

            $('.cajaError').removeClass('hidden');
            $('.cajaError ul').html('');
            
            $('.cajaError ul').append('<li>Fallo al enviar el formulario</li>');
            
            
            $('#myModalLostIng').modal('hide');
                    
        });
    });

    $('body').on('keyup', '#findIng', function(e) {
        
        if($(this).val().length>2) {
            $.get("{{url('ingredientes/find')}}", {'find':$(this).val()}, function(data) {
                if(data.html!="") {
                
                    $('#listaIngredientesModal').html(data.html);
                }
                else {
                    $('#listaIngredientesModal').text("No hay ningún ingrediente que cumpla esta búsqueda");
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
</script>