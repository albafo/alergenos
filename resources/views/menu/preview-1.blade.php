@extends('app')

@section('class-body')
menu-template-1
@endsection

@section('content')
   
    
    <div class="row">
        <div class="col-md-10 col-md-offset-1 text-center" style="margin-top:30px;">
             @if(Auth::user()->icono_estb)
            <div class="row">
                <div class="col-md-12" >
                  
                    <img src="{{asset('iconos-estb/'.Auth::user()->id.'/'.Auth::user()->icono_estb)}}" style="max-width:100%; max-height:100px">
                   
                </div>
            </div>
            @endif
             @if(Auth::user()->nombre_establ)
            <div class="row">
                <div class="col-md-12 nombreRest" >
                    {{Auth::user()->nombre_establ}}
                </div>
            </div>
            @endif
            <div class="row row-centered">
                <div class="col-md-12">
                    <div class="fondoNombreMenu col-centered text-center">
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
                <div class="col-md-2 col-md-offset-5 col-centered text-center precio">
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