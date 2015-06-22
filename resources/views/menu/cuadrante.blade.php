@extends('app')
@section('content')
    <div class="row text-center">
        <a href="{{url('menu/export-cuadrante')}}" type="button" class="btn btn-primary">Exportar a pdf</a>
        <a href="{{url('menu/listado-ingredientes')}}" type="button" class="btn btn-primary">Modo listado</a>
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

            <h1>Cuadrante platos</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-right">Documento actualizado a fecha {{strftime("%d/%m/%Y", time())}}</div>
    </div>

    <table class="table table-bordered">
        <tr>
        <th></th>
        @foreach(\App\Alergeno::all() as $alergeno)
            <th class="text-center">
                {{$alergeno->nombre}}<br>
                <img height="40" src="{{asset($alergeno->img)}}" alt="{{$alergeno->nombre}}">
            </th>
        @endforeach
        </tr>

        @foreach(Auth::user()->platos() as $plato)
            <tr>
                <td>{{$plato->nombre}}</td>
            @foreach(\App\Alergeno::all() as $alergeno)
                    <td>
                @if($plato->hasAlergeno($alergeno->id))
                    X
                @endif
                    </td>
            @endforeach
            </tr>
        @endforeach
    </table>
@endsection