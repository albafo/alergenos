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
                <hr/>
                <div class="row text-center" id="listaIngredientesModal">
                    <span>No ha seleccionado ninguna letra</span>
                </div>
                
            </div>
            <div class="alert alert-danger hidden" id="cajaError">
                <strong>Ups!</strong> Hay algún error con el formulario.<br><br>
                <ul>

                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="saveIngrediente" disabled>Guardar cambios</button>
            </div>
        </div>
    </div>
</div>
