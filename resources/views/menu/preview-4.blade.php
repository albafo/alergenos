@extends('app')

@section('class-body')
menu-template-4
@endsection

@section('content')
   
    <div class="row">
        <div class="col-md-10 col-md-offset-1" style="margin-top:30px;">
            <div class="row">
                <div class="col-md-8 nota-alergenos">
                    LISTA DE ALÉRGENOS - {{Auth::user()->nombre_establ}}<br>
                    Adaptación a la normativa (UE) Nº 1 1169/2011 ALERGIAS
                </div>
                <div class="col-md-4">
                      @if(Auth::user()->icono_estb)
                        <img src="{{asset('iconos-estb/'.Auth::user()->id.'/'.Auth::user()->icono_estb)}}" style="max-width:100%; max-height:100px">
                    @endif        
                </div>
            </div>
            
            <div class="row text-center" style="margin-bottom:25px;">
                <div class="col-md-12  nombreRestaurante">
                    {{ Auth::user()->nombre_establ }}<br>
                </div>
                 (Alimentos susceptibles de contener alérgenos)
            </div>
            
            <div class="row">
                <div class="col-md-12" >
                     
                     
                    
                    
                    @foreach($menu->categorias->sortBy('orden') as $categoria)
                    <div class="categoria-total">
                        <div class="row">
                            <div class="col-md-12 categoriaPlato text-center">
                                {{$categoria->nombre}}
                                @if($traduccion)
                                    @foreach(\App\Idioma::all() as $idioma)

                                    @if($categoria->hasTraduccion($idioma->id))
                                        - {{ $categoria->traduccion()->find($idioma->id)->pivot->content }}
                                    @endif

                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <table class="table table-bordered">


                            @foreach($categoria->platos as $plato)
                            <tr>

                                <td width="80%">{{$plato->nombre}} - {{$plato->categoria()->find($categoria->id)->pivot->precio}}€

                                @if($traduccion)
                                @foreach(\App\Idioma::all() as $idioma)

                                @if($plato->hasTraduccion($idioma->id))
                                    <br>{{ $plato->traduccion()->find($idioma->id)->pivot->content }}
                                @endif

                                @endforeach
                                @endif
                                    @if($plato->numIngVisibles()>0)
                                    <br>
                                    <i>(
                                    <?php $i=0; ?>
                                    @foreach($plato->ingredientes as $ingrediente)
                                        @if($ingrediente->plato()->find($plato->id)->pivot->visible_home)
                                        @if($i>0)
                                            ,
                                        @endif
                                    {{$ingrediente->nombre}}
                                            @if($traduccion)
                                                @foreach(\App\Idioma::all() as $idioma)
                                                    @if($ingrediente->hasTraduccion($idioma->id))
                                                        / {{$ingrediente->traduccion()->find($idioma->id)->pivot->content}}
                                                    @endif
                                                @endforeach
                                            @endif
                                        <?php $i++;?>
                                        @endif
                                    @endforeach
                                    )</i>
                                        @endif
                                </td>
                                <td>
                                    @foreach($plato->alergenos() as $alergeno)
                                    <span><img height="40" src="{{asset($alergeno->img)}}" alt="{{$alergeno->nombre}}"></span>
                                    @endforeach

                                        @if(count($plato->customAlergenos($menu->id))>0)

                                                @foreach($plato->customAlergenos($menu->id) as $alergeno)
                                                    <span><img height="40" src="{{asset($alergeno->img)}}" alt="{{$alergeno->nombre}}"></span>
                                            @endforeach

                                        @endif

                                </td>
                            </tr>
                            @endforeach
                           </table>
                     </div>
                    @endforeach
                    
                    
                    <div class="row listado-ingredientes" style="margin-top:20px;">
                        <div class="col-md-12 text-center alergenos">

                            @foreach(Alergeno::all() as $alergeno)
                             <div class="alergeno">
                                 <img height="60" src="{{asset($alergeno->img)}}" alt="{{$alergeno->nombre}}"><br>
                                 <span>{{$alergeno->nombre}}</span>
                                 @if($traduccion)
                                     @foreach(\App\Idioma::all() as $idioma)
                                         @if($alergeno->hasTraduccion($idioma->id))
                                             / {{$alergeno->traduccion()->find($idioma->id)->pivot->content}}
                                         @endif
                                     @endforeach
                                 @endif
                             </div>
                             @endforeach
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 text-center alergenos" style="margin-top:20px;">
                            {{Auth::user()->direccion}} - Tlf:{{Auth::user()->telefono}}
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection