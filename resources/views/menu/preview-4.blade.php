@extends('app')

@section('class-body')
menu-template-4 preview-menus
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
                                @if($traduccion > 1 && $categoria->hasTraduccion($traduccion))

                                    {{ $categoria->traduccion()->find($traduccion)->pivot->content }}

                                @else
                                    {{$categoria->nombre}}

                                @endif
                            </div>
                        </div>

                        <table class="table table-bordered">


                            @foreach($categoria->platos as $plato)
                            <tr>

                                <td width="70%">
                                    @if($traduccion > 1 && $plato->hasTraduccion($traduccion))

                                        {{ $plato->traduccion()->find($traduccion)->pivot->content }}

                                    @else
                                        {{$plato->nombre}}

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

                                            @if($traduccion > 1 && $ingrediente->hasTraduccion($traduccion))

                                                {{ $ingrediente->traduccion()->find($traduccion)->pivot->content }}

                                            @else
                                                {{$ingrediente->nombre}}

                                            @endif
                                        <?php $i++;?>
                                        @endif
                                    @endforeach
                                    )</i>
                                        @endif
                                </td>
                                <td width="10%">@if($plato->categoria()->find($categoria->id)->pivot->precio>0){{$plato->categoria()->find($categoria->id)->pivot->precio}}€@endif</td>
                                <td>
                                    @foreach($plato->alergenos() as $alergeno)
                                    <span><img class="preview-ico-alergeno" src="{{asset($alergeno->img)}}" alt="{{$alergeno->nombre}}"></span>
                                    @endforeach

                                        @if(count($plato->customAlergenos($menu->id))>0)

                                                @foreach($plato->customAlergenos($menu->id) as $alergeno)
                                                    <span><img class="preview-ico-alergeno" src="{{asset($alergeno->img)}}" alt="{{$alergeno->nombre}}"></span>
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
                                 <img height="40" src="{{asset($alergeno->img)}}" alt="{{$alergeno->nombre}}"><br>
                                 <span>
                                     @if($traduccion > 1 && $alergeno->hasTraduccion($traduccion))

                                         {{ $alergeno->traduccion()->find($traduccion)->pivot->content }}

                                     @else
                                         {{$alergeno->nombre}}

                                     @endif
                                 </span>

                             </div>
                             @endforeach
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 text-center alergenos" style="margin-top:20px;">
                            {{Auth::user()->direccion}}@if(Auth::user()->telefono) - Tlf:{{Auth::user()->telefono}}@endif
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection