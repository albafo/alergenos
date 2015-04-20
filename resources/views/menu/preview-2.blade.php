@extends('app')

@section('class-body')
menu-template-2
@endsection

@section('content')
   
    
    <div class="row">
        <div class="col-md-12 text-center nombreRest" style="margin-top:30px;">
            - {{Auth::user()->nombre_establ}} -
        </div>
    </div>
    
    
    <div class="row">
        <div class="col-md-8 col-md-offset-2 text-center" >
             
             
            <div class="row row-centered">
                <div class="col-md-12">
                    <div class="nombreMenu col-centered text-center">
                        {{$menu->nombre}}
                    </div>
                </div>
            </div>
            
             @foreach($menu->categorias->sortBy('orden') as $categoria)

            <div class="row">
                <div class="col-md-12 categoriaPlato">
                    {{$categoria->nombre}}
                </div>
            </div>
           
            <div class="separadorCategoria col-centered"></div>

            @foreach($categoria->platos as $plato)
            <div class="row">
                <div class="col-md-12 plato">
                    <span>{{$plato->nombre}}</span>
                   
                    @foreach($plato->alergenos() as $alergeno)
                    <span><img height="40" src="{{asset($alergeno->img)}}" alt="{{$alergeno->nombre}}"></span>
                    @endforeach
                </div>
            </div>
            @endforeach
            
            @endforeach
            
            <div class="row">
                <div class="col-centered text-center precio">
                    {{$menu->precio}}€
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12 text-center alergenos">
                    
                     @foreach($menu->alergenos() as $alergeno)
                     <div class="alergeno">
                         <img height="60" src="{{asset($alergeno->img)}}" alt="{{$alergeno->nombre}}"><br>
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