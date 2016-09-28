@extends('menu.home')
@section('contentMenu')
<div id="listadoHerramientas">
    <div class="row" id="alert-ingredients" style="margin-bottom: 20px;">
        <div class="col-md-12 text-center btn-danger">
            <span>AVISO: Recuerde que ciertos ingredientes que han sido adquiridos a proveedores externos y no elaborados en el mismo establecimiento pueden contener alérgenos. CHEQUEAR ETIQUETADO e incluir de forma adicional los alérgenos correspondientes</span>
        </div>
    </div>
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

                <div class="panel-body"><a href="{{url('menu/listado-ingredientes')}}">Book de fichas de cocina</a></div>
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
              <div class="col-md-12 text-center">
                <label for="idiomaActivado">Idioma:</label>
                  <select id="idiomaActivado" name="idiomaActivado">
                      <option value="1">CASTELLANO</option>
                      @foreach(App\Idioma::all() as $idioma)
                          <option value="{{$idioma->id}}">{{$idioma->nombre}}</option>
                      @endforeach
                  </select>
              </div>
              @if((Session::has('auth-admin') && Session::get('auth-admin')->tipo=="admin") || (Session::has('auth-tecnico') && Session::get('auth-admin')->tipo=="tecnico"))
              <br><br>
              <div class="col-md-12 text-center">
                  <label for="demo">Marca de agua DEMO:</label>
                  <input type="checkbox" id="demo" name="demo">
              </div>
              @endif
              <div class="col-md-12 tituloModalidadPdf text-center">Modalidad menú</div>
              <div class="col-md-6" style="margin-top:10px;">
                   <a href="#" data-index="1"><img src="{{asset('img/plantilla-1.jpg')}}"></a>    
              </div>
              
              <div class="col-md-6" style="margin-top:10px;">
                   <a href="#" data-index="2"><img src="{{asset('img/plantilla-2.jpg')}}"></a>    
              </div>
              <div class="col-md-12 tituloModalidadPdf text-center">Modalidad carta</div>

              <div class="col-md-6" style="margin-top:10px;">
                   <a href="#" data-index="3"><img src="{{asset('img/plantilla-3.png')}}"></a>    
              </div>
              <div class="col-md-6" style="margin-top:10px;">
                  <a href="#" data-index="4"><img src="{{asset('img/plantilla-4.png')}}"></a>
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
      
       $('body').on('click', '#modalPlantillas .cuerpo a', function (e) {
             e.preventDefault();
             var traduccion = $('#idiomaActivado').val();
            var url = $(this).attr('href')+"/"+traduccion;
            if($('#demo').is(':checked')) {
                url+="?demo=1";
            }

             window.location.href=url;
       });
      
    });
</script>
@endsection