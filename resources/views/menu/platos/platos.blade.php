<div class="col-sm-4 text-center">
    <h4>Platos</h4>
    <span id="msgPlatos">Seleccione una categoría</span>

    <div class="lista-platos" id="lista-platos">

    </div>
    <a id="addPlato" class="glyphicon glyphicon-plus hidden"></a>
</div>

<div class="modal fade" id="myModalPlato" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Editar Plato</h4>
            </div>
            <div class="modal-body">
                <form id="formPlato">
                    <div class="form-group">

                        <input type="text" name="nombre" class="form-control" id="inputNombrePlato" placeholder="Nombre">
                    </div>
                    <div class="form-group">
                        <input type="text" name="precio" class="form-control" id="inputPrecioPlato" placeholder="Precio">

                    </div>
                </form>
            </div>
            <div class="alert alert-danger hidden cajaError">
                <strong>Ups!</strong> Hay algún error con el formulario.<br><br>
                <ul>

                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="savePlato">Guardar cambios</button>
            </div>
        </div>
    </div>
</div>