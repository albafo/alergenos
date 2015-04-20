<div class="col-sm-4 text-center">
    <h4>Categorías</h4>
    <div class="lista-categorias" id="lista-categorias">
        @unless($menu->categorias()->count())
        <span id="noCat">No has creado ninguna categoría todavía.</span>
        @else
        <span id="noCat" class="hidden">No has creado ninguna categoría todavía.</span>

        @foreach($menu->categorias->sortBy('orden', SORT_REGULAR, false) as $categoria)
        <div class="panel panel-default caja-menu" id="categoria-{{$categoria->id}}">
            <div class="editDel">
                <div class="editar">
                    <a href="#"  title="Editar" class="glyphicon glyphicon-pencil editCat"></a>
                </div>
                <div class="borrar">
                    <a href="#" title="Borrar" class="glyphicon glyphicon-remove delCat"></a>
                </div>
            </div>
            <div class="panel-body">{{$categoria->nombre}}</div>
        </div>
        @endforeach
        @endunless

    </div>
    <a id="addCat" class="glyphicon glyphicon-plus"></a>
</div> 

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
                <div class="alert alert-danger hidden cajaError" >
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