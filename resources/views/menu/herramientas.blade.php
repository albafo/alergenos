@extends('menu.home')
@section('contentMenu')
<div id="listadoHerramientas">
    <div clas="row">
        <div class="col-md-12">
            <div class="panel panel-default caja-menu ui-sortable-handle caja-link caja-modal">

                <div class="panel-body"><a href="{{url('menu/preview/'.$menu->id)}}">Previsualizar Menú</a></div>
            </div>
        </div>
    </div>
    <div clas="row">
        <div class="col-md-12">
            <div class="panel panel-default caja-menu ui-sortable-handle caja-link caja-modal">

                <div class="panel-body"><a href="{{url('menu/menu-pdf/'.$menu->id)}}">Exportar Menú a PDF</a></div>
            </div>
        </div>
    </div>
    <div clas="row">
        <div class="col-md-12">
            <div class="panel panel-default caja-menu ui-sortable-handle caja-link caja-href">

                <div class="panel-body"><a href="{{url('menu/listado-ingredientes')}}">Fichas de cocina</a></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalPlantillas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Seleccione Plantilla</h4>
      </div>
      <div class="modal-body cuerpo">
          <div class="row">
              <div class="col-md-6">
                   <a href="#" data-index="1"><img src="{{asset('img/plantilla-1.jpg')}}"></a>    
              </div>
              
              <div class="col-md-6">
                   <a href="#" data-index="2"><img src="{{asset('img/plantilla-2.jpg')}}"></a>    
              </div>
          </div>
           
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
       
      </div>
    </div>
  </div>
</div>


<script>
    $(document).ready(function(){
       $('.caja-modal').click(function(e){
            e.preventDefault();
            var link=$(this).find('a').attr('href');
            
            $('#modalPlantillas .cuerpo a').each(function() {
                
                $(this).attr('href', link+"/"+$(this).attr('data-index'));
            });
            $('#modalPlantillas').modal();
          //window.location.href=link;  
       }); 
       
       $('.caja-href').click(function(e){
           var link=$(this).find('a').attr('href');
           window.location.href=link;  
       });
      
      
    });
</script>
@endsection