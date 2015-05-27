@extends('menu.home')
@section('contentMenu')
<div id="mensajes-platos-ok">   
   
</div>
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

            


           
			

            


<script>
    var selectedCat=-1;
    var selectedPlato=-1;
    var selectedIng=-1;
    
    function obtener_platos(id_cat){
        
        $.get("{{url('plato/show')}}/"+id_cat, {'_token':'{{csrf_token()}}'}, function(data) {
               selectedPlato=-1;
               $('#msgIngredientes').text('Seleccione un plato');
               $('#lista-ingredientes').html('');
               $('#msgIngredientes').removeClass('hidden');
               $('#addIngrediente').addClass('hidden');
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
    }
    
    function obtener_ingredientes(id_plato){
        $.get("{{url('plato/ingredientes')}}/"+id_plato, {'_token':'{{csrf_token()}}'}, function(data) {
               $("[id^='plato-']").removeClass('selected');
               $("#plato-"+id_plato).addClass('selected');
               $('#lista-ingredientes').html('');
               if(data.html=="") {
                   $('#msgIngredientes').text('No has añadido ningún ingrediente a este plato');
                   $('#msgIngredientes').removeClass('hidden');
               }
               else {
                   $('#msgIngredientes').addClass('hidden');
                   $('#lista-ingredientes').append(data.html);

               }
               selectedPlato=id_plato;
               $('#addIngrediente').removeClass('hidden');

           }).fail(function() {
               $('#mensajes-platos-ok').bootstrapAlert({
                   title:"Error!",
                   messages:['Fallo al conectar con el servidor.'],
                   type:'danger',
                   time:5000
               });
           });
    }
    
    function ajax_errors(errores) {
        var messages_a=new Array();
                        
        for(var i in errores) {

            messages_a.push(errores[i]);

        }
        $('#mensajes-platos-ok').bootstrapAlert({
            title:"Error!",
            messages:messages_a,
            type:'danger',
            time:5000
        });
    }
    
    
jQuery(function($) {
    
    $('body').on('click', '#addCat', function() {
        
        $('.cajaError').addClass('hidden');
        $('body').off('click', '#myModalSave');
        $('#myModal .modal-title').text('Crear categoría');
        $('#myModal #myModalSave').text('Crear categoría');
        $('#myModalInput').val('');
        $('input').val('');
        $('#myModal').modal();
                $('.cajaError').addClass('hidden');

        $('body').on('click', '#myModalSave', function(){
          
            var boton=$(this);
			if($('#myModalInput').val()!="") {
                boton.attr('disabled', true);
                var data= $('#formCat').serializeArray();
               
                data.push({name: '_token', value: '{{csrf_token()}}'});

				$.post("{{url('categoria/store/'.$menu->id)}}", data, function(data) {
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
                    $('.cajaError ul').html('');
                    if(data.responseJSON !== undefined && data.responseJSON.nombre.length>0) {
                        $('.cajaError ul').append('<li>'+data.responseJSON.nombre+'</li>');
                        $('.cajaError').removeClass('hidden');
                    }
                    else {
                        $('.cajaError ul').append('<li>Fallo de conexión. Compruebe su acceso a la red.</li>');
                        $('.cajaError').removeClass('hidden');
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
                        type:'success',
                        time:5000
                    });
                    if($('#lista-categorias div').length<1) {
                        $('#noCat').removeClass('hidden');
                    }
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
    });
    
    
    $('body').on('click', '.editCat', function(e) {
        e.stopPropagation();
        $('.cajaError').addClass('hidden');

        var id_cat=$(this).parent().parent().parent().attr('id');
        var text=$(this).parent().parent().parent().find('.panel-body').text();
        id_cat=id_cat.split("-")[1];
        $('body').off('click', '#myModalSave');
        $('#myModal .modal-title').text('Editar categoría');
        $('#myModal #myModalSave').text('Reemplazar nombre');
        $('#myModalInput').val(text);
        $.get("{{url('categoria/idiomas/')}}/"+id_cat, {'_token':'{{csrf_token()}}'}, function(data){
             $('#myModal .otrosIdiomas p').remove();
            $.each(data, function( index, idioma ) {
                  $('#myModal .otrosIdiomas').append('\
                  <p>'+idioma.nombreIdioma+'</p>\
                  <p><input type="text" class="form-control" value="'+idioma.traduccion+'" name="idioma['+idioma.idIdioma+']" data-id="'+idioma.idIdioma+'" placeholder="'+idioma.nombreIdioma+'"></p>')
            });
            
       
            $('#myModal').modal();
            $('.cajaError').addClass('hidden');
    
            $('body').on('click', '#myModalSave', function(){
                var boton=$(this);
                boton.attr('disabled', true);
    			if($('#myModalInput').val()!="") {
    			    var data= $('#formCat').serializeArray();
               
                    data.push({name: '_token', value: '{{csrf_token()}}'});
    				$.post("{{url('categoria/update/'.$menu->id)}}/"+id_cat, data, function(data) {
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
                        $('.cajaError ul').html('');
                        if(data.responseJSON !== undefined && data.responseJSON.nombre.length>0) {
                            $('.cajaError ul').append('<li>'+data.responseJSON.nombre+'</li>');
                            $('.cajaError').removeClass('hidden');
                        }
                        else {
                            $('.cajaError ul').append('<li>Fallo de conexión. Compruebe su acceso a la red.</li>');
                            $('.cajaError').removeClass('hidden');
                        }
                        boton.attr('disabled', false);
    
                        
                    }, "json");
                        
                    
    			}
            });
        }, "json");
    });
    
    $('body').on('click', "[id^='categoria-']", function(e) {
       var id_cat=$(this).attr('id').split("-")[1];
       obtener_platos(id_cat);
    });
    
    $('body').on('click', "#addPlato", function() {
        if(selectedCat!=-1) {
            $('#myModalPlato .modal-title').text('Crear plato');
            $('#myModalPlato #savePlato').text('Crear plato');
            $('#myModalPlato #platosList').removeClass('hidden');
            $('#myModalPlato #platosList').val(0);
            $('#inputNombrePlato').val("");
            $('#inputPrecioPlato').val("");
            $('#myModalPlato .otrosIdiomas p input').val('');
            $('#myModalPlato').modal();
            $('.cajaError').addClass('hidden');

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
                        ajax_errors(data.responseJSON);
                        $('#myModalPlato').modal('hide');

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
        $('.cajaError').addClass('hidden');
        var id_plato=$(this).parent().parent().parent().attr('id');
        id_plato=id_plato.split("-")[1];
        $('body').off('click', '#savePlato');
        $('#myModalPlato #myModalLabel').text('Editar plato');
        $('#myModalPlato #myModalSave').text('Reemplazar nombre');
        $.get("{{url('plato/datos/')}}/"+id_plato+"/"+selectedCat, {'_token':'{{csrf_token()}}'}, function(data){
            $('#inputNombrePlato').val(data.nombre);
            $('#inputPrecioPlato').val(data.precio);
            $('#myModalPlato #platosList').addClass('hidden');
            $.get("{{url('plato/idiomas/')}}/"+id_plato, {'_token':'{{csrf_token()}}'}, function(data){
                $('#myModalPlato .otrosIdiomas p').remove();
                $.each(data, function( index, idioma ) {
                      $('#myModalPlato .otrosIdiomas').append('\
                      <p>'+idioma.nombreIdioma+'</p>\
                      <p><input type="text" class="form-control" value="'+idioma.traduccion+'" name="idioma['+idioma.idIdioma+']" data-id="'+idioma.idIdioma+'" placeholder="'+idioma.nombreIdioma+'"></p>')
                });
                $('#myModalPlato').modal();
            
                $('.cajaError').addClass('hidden');
    
                $('body').on('click', '#savePlato', function(){
                    var data=$( "#formPlato" ).serializeArray();
                    data.push({name: '_token', value: '{{csrf_token()}}'});
                    $.post("{{url('plato/update')}}/"+id_plato+"/"+selectedCat, data,
                    function(data) {
                        obtener_platos(selectedCat);
                        $('#myModalPlato').modal('hide');
                        $('#mensajes-platos-ok').bootstrapAlert({
                            title:"Enhorabuena!",
                            messages:['Plato editado con éxito'],
                            type:'success',
                            time:5000
                        });
                    }).fail(function(data){
                        if(data.responseJSON!==undefined) {
                            ajax_errors(data.responseJSON);
                            $('#myModalPlato').modal('hide');
    
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
                        
                    });
                    
                });
            });
        });
    });
    
    $('body').on('click', '.delPlato', function(e) {
        e.stopPropagation();
        var id_plato=$(this).parent().parent().parent().attr('id');
        id_plato=id_plato.split("-")[1];
        bootbox.confirm("¿Estás seguro de eliminar este plato?", function(result) {
            if(result) {
                $.post("{{url('plato/destroy')}}/"+id_plato+"/"+selectedCat, {'_token':'{{csrf_token()}}'}, function(data) {
                    $('#plato-'+id_plato).remove();
                    $('#mensajes-platos-ok').bootstrapAlert({
                        title:"Enhorabuena!",
                        messages:['Plato eliminado con éxito.'],
                        type:'success',
                        time:5000
                    });
                    if($('#lista-platos div').length<1) {
                        $('#msgPlatos').removeClass('hidden');
                    }
                }).fail(function(data) {
                    if(data.responseJSON!==undefined) {
                        ajax_errors(data.responseJSON);
                        $('#myModalPlato').modal('hide');

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
    
    $('body').on('click', "[id^='plato-']", function(e) {
       var id_plato=$(this).attr('id').split("-")[1];
       obtener_ingredientes(id_plato);
    });
    
    $('body').on('click', "#addIngrediente", function(e) {
        if(selectedPlato!=-1) {
            $('#myModalIng .modal-title').text('Añadir Ingrediente');
            $('#myModalIng #saveIngrediente').text('Añadir ingrediente');

            $('#myModalIng').modal();
                    $('.cajaError').addClass('hidden');

            $('body').off('click', '#saveIngrediente');
            $('body').on('click', "#saveIngrediente", function() {
                
            });
        }
        else {

            $('#mensajes-platos-ok').bootstrapAlert({
                title:"Error!",
                messages:['No hay seleccionado ningún plato.'],
                type:'danger',
                time:5000
            });
        }
    });
    
    $('body').on('click', '#letrasIngredientes li a', function(e) {
        var letra=$(this).text();
        $.get('{{url('ingrediente/buscar-letra')}}/'+letra, {'_token':'{{csrf_token()}}'}, function(data){
            if(data.html!="") {
                
                $('#listaIngredientesModal').html(data.html);
            }
            else {
                $('#listaIngredientesModal').text("No hay ningún ingrediente que empieze por la letra "+letra);
            }
            selectedIng=-1;
            $( "#myModalIng #saveIngrediente" ).prop( "disabled", true );
        }).fail(function(data) {
            $('#myModalIng').modal('hide');
            $('#mensajes-platos-ok').bootstrapAlert({
                title:"Error!",
                messages:['Fallo al conectar con el servidor.'],
                type:'danger',
                time:5000
            });
            
        }, "json");
    });
    
    $('body').on('click', '#listaIngredientesModal p', function(e) {
        $('#listaIngredientesModal p').removeClass('selected');
        $(this).addClass('selected');
        selectedIng=$(this).attr('data-index');
        $.get('{{url('ingrediente/customAlerg/'.$menu->id)}}/'+selectedIng, {}, function(data){
            $('#alergCustom1 option[value="0"]').prop('selected', true);
            $('#alergCustom2 option[value="0"]').prop('selected', true);
            if(data!="")
                for(var i=0; i<data.length; i++)
                    $('#alergCustom'+(i+1)+' option[value="'+data[i]+'"]').prop('selected', true);
        });
        $( "#myModalIng #saveIngrediente" ).prop( "disabled", false );

    });
    
    $('body').on('click', '#myModalIng #saveIngrediente', function(e) {
        if(selectedPlato!=-1 && selectedIng!=-1) {
             var data=$( "#customAlergeno" ).serializeArray();
            data.push({name: '_token', value: '{{csrf_token()}}'});
            $.post("{{url('plato/add-ingrediente')}}/{{$menu->id}}/"+selectedPlato+"/"+selectedIng, data, function(data){
                if(data.repeated) {
                   $('#myModalIng').modal('hide');
                   $('#mensajes-platos-ok').bootstrapAlert({
                        title:"Error!",
                        messages:['Ingrediente ya añadido al plato'],
                        type:'danger',
                        time:5000
                    });
                }
                else {
                    $('#mensajes-platos-ok').bootstrapAlert({
                        title:"Enhorabuena!",
                        messages:['Ingrediente añadido al plato'],
                        type:'success',
                        time:5000
                    });
                    obtener_ingredientes(selectedPlato);
                    $('#myModalIng').modal('hide');
                }
            }).fail(function(data) {
                $('#myModalIng').modal('hide');
                $('#mensajes-platos-ok').bootstrapAlert({
                        title:"Error!",
                        messages:['Fallo al conectar con el servidor.'],
                        type:'danger',
                        time:5000
                    });
            }, "json");
        }
    });


    $('body').on('click', '.editarVisibilidad', function() {

        var id_ing=$(this).parent().parent().attr('id').split("-")[1];
        if(selectedPlato!=-1) {
            $.post("{{url('ingredientes/editar-visibilidad')}}/"+selectedPlato+"/"+id_ing, {'_token':'{{csrf_token()}}'},function() {
                obtener_ingredientes(selectedPlato);
            });
        }
    });
    
    $('body').on('click', '.delIngrediente', function() {
        var id_ing=$(this).parent().parent().parent().attr('id').split("-")[1];
        if(selectedPlato!=-1) {
            bootbox.confirm("¿Estás seguro de eliminar este ingrediente del plato seleccionado?", function(result) {
                if(result) {
                    $.post("{{url('plato/eliminar-ingrediente')}}/"+selectedPlato+"/"+id_ing, {'_token':'{{csrf_token()}}'},function() {
                        obtener_ingredientes(selectedPlato);
                        $('#mensajes-platos-ok').bootstrapAlert({
                            title:"Error!",
                            messages:['Ingrediente eliminado del plato'],
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
        }
    });

    
    
    $( ".lista-platos" ).sortable({
        axis: "y",
        items: "div[id^='plato-']",
        update: function( event, ui ) {
            var data = $(this).sortable('toArray');
           
            $.post("{{url('plato/reordenar')}}/"+selectedCat, {'_token':'{{csrf_token()}}', 'data':data}, function() {
                 $('#mensajes-platos-ok').bootstrapAlert({
                        title:"Enhorabuena!",
                        messages:['Platos reordenados con éxito'],
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
    
    
});
</script>
@endsection