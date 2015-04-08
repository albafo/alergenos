@extends('app')
@section('content')

    <div class="container text-center">
        <div class="row">
            <div class="col-md-12">
                <h1>{{$menu->nombre}}</h1>
            </div>
        </div>
        @foreach($menu->categorias as $categoria)
        <div class="row">
            <div class="col-md-12">
                <h3>{{$categoria->nombre}}</h3>
            </div>
        </div>
       

        @foreach($categoria->platos as $plato)
        <div class="row">
            <div class="col-md-12">
                <span>{{$plato->nombre}} - {{$plato->precio}}€</span>
               
                @foreach($plato->alergenos() as $alergeno)
                <span><img height="50" src="{{asset($alergeno->img)}}" alt="{{$alergeno->nombre}}"></span>
                @endforeach
            </div>
        </div>
        @endforeach
        @endforeach
        
    </div>

@endsection