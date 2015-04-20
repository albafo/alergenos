@extends('app')

@section('class-body')
listado-ingredientes
@endsection

@section('content')
   <div class="row">
       <div class="col-md-8 col-md-offset-2">
           <div class="row text-center">
               <a href="{{url('menu/export-listado')}}" type="button" class="btn btn-primary">Exportar a pdf</a>
           </div>
           <div class="row">
                 <div class="col-md-12">
                    <h1>Fichas de cocina</h1>
                </div>
            </div>
            <div class="row plato">
                <div class="col-md-12">
                    @foreach(Auth::user()->platos() as $plato) 
                    <h3>{{$plato->nombre}}</h3>
                    <ul class="list-group"> 
                        @foreach($plato->ingredientes as $ingrediente)
                            <li class="list-group-item">
                                {{$ingrediente->nombre}} 
                                @foreach($ingrediente->alergenos as $alergeno) 
                                <img height="50" src="{{asset($alergeno->img)}}" alt="{{$alergeno->nombre}}"> 
                                @endforeach
                            </li> 
                            
                        @endforeach
                    </ul>
                    @endforeach
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center alergenos">
                        
                     @foreach(\Alergeno::all() as $alergeno)
                     <div class="alergeno">
                         <img height="60" src="{{asset($alergeno->img)}}" alt="{{$alergeno->nombre}}"><br>
                         <span>{{$alergeno->nombre}}</span>
                     </div>
                     @endforeach
                </div>
            </div>
       </div>
    </div>
    
@endsection