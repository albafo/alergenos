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
