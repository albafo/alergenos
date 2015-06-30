@extends('app')

@section('class-body')
listado-ingredientes
@endsection

@section('content')
   <div class="row">
       
      
       
       <div class="col-md-8 col-md-offset-2">
           <div class="row text-center">
               <a href="{{url('menu/export-listado')}}" type="button" class="btn btn-primary">Exportar a pdf</a>
               <a href="{{url('menu/cuadrante-platos')}}" type="button" class="btn btn-primary">Modo cuadrante</a>
           </div>
           
           <div class="row">
                <div class="col-md-12 text-center nombreRest">
                    @if(Auth::user()->icono_estb)
                        <img src="{{asset('iconos-estb/'.Auth::user()->id.'/'.Auth::user()->icono_estb)}}" style="max-width:100%; max-height:100px">
                        <br>
                    @endif
                   {{Auth::user()->nombre_establ}}
               </div>
           </div>
           <div class="row">
                 <div class="col-md-12">
                     
                    <h1>Book de fichas de cocina</h1>
                </div>
            </div>
           <div class="row">
               <div class="col-md-12 text-right">Documento actualizado a fecha {{strftime("%d/%m/%Y", time())}}</div>
           </div>
            <div class="row plato">
                <div class="col-md-12">
                    @foreach(Auth::user()->platos() as $plato)
                    <div class="grupo-plato">
                        <h3>{{$plato->nombre}}</h3>
                        <ul class="list-group listado-ingredientes">
                            @foreach($plato->ingredientes as $ingrediente)
                                <li class="list-group-item">
                                    {{$ingrediente->nombre}}
                                    @foreach($ingrediente->alergenos as $alergeno)
                                    <img height="40" src="{{asset($alergeno->img)}}" alt="{{$alergeno->nombre}}">
                                    @endforeach
                                </li>

                            @endforeach
                        </ul>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center alergenos">
                        
                     @foreach(\Alergeno::all() as $alergeno)
                     <div class="alergeno">
                         <img height="50" src="{{asset($alergeno->img)}}" alt="{{$alergeno->nombre}}"><br>
                         <span>{{$alergeno->nombre}}</span>
                     </div>
                     @endforeach
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center alergenos">
                    {{Auth::user()->direccion}} - Tlf:{{Auth::user()->telefono}}
                </div>
            </div>
       </div>
    </div>
    
@endsection