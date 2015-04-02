@extends('menu.home')
@section('contentMenu')
<div id="listadoHerramientas">
    <div clas="row">
        <div class="col-md-12">
            <div class="panel panel-default caja-menu ui-sortable-handle caja-link">

                <div class="panel-body"><a href="{{url('menu/preview/'.$menu->id)}}">Previsualizar Menú</a></div>
            </div>
        </div>
    </div>
    <div clas="row">
        <div class="col-md-12">
            <div class="panel panel-default caja-menu ui-sortable-handle caja-link">

                <div class="panel-body"><a href="{{url('menu/menu-pdf/'.$menu->id)}}">Exportar Menú a PDF</a></div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
       $('.caja-menu').click(function(){
          var link=$(this).find('a').attr('href');
          window.location.href=link;  
       }); 
    });
</script>
@endsection