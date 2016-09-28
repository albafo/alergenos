@extends('app')

@section('class-body')
menu-template-1 preview-menus @if(isset($clientPreview) && $clientPreview) client-preview @endif
@endsection

@section('content')
   
    
    <div class="row">
        <div class="col-md-10 text-center" style="margin-top:30px;">
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
            <div class="categoria-total">
                <div class="row">
                    <div class="col-md-12 categoriaPlato">

                        @if($traduccion > 1 && $categoria->hasTraduccion($traduccion))

                           {{ $categoria->traduccion()->find($traduccion)->pivot->content }}

                        @else
                            {{$categoria->nombre}}

                        @endif

                    </div>
                </div>

                <div class="row">
                    <div class="separadorCategoria col-centered"></div>
                </div>

                @foreach($categoria->platos as $plato)
                <div class="row">
                    <div class="col-md-12 plato">
                        <span>@if($traduccion > 1 && $plato->hasTraduccion($traduccion))

                                {{ $plato->traduccion()->find($traduccion)->pivot->content }}

                            @else
                                {{$plato->nombre}}

                            @endif
                        </span>


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
                        @foreach($plato->alergenos() as $alergeno)
                        <span><img class="preview-ico-alergeno" src="{{asset($alergeno->img)}}" alt="{{$alergeno->nombre}}"></span>
                        @endforeach

                        @if(count($plato->customAlergenos($menu->id))>0)

                            @foreach($plato->customAlergenos($menu->id) as $alergeno)
                                <span><img class="preview-ico-alergeno" src="{{asset($alergeno->img)}}" alt="{{$alergeno->nombre}}"></span>
                            @endforeach

                        @endif






                    </div>
                </div>
                @endforeach

             </div>
            @endforeach
            
            <div class="row">
                <div class="precio">
                    {{$menu->precio}}€
                </div>
            </div>
            
            <div class="row">
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
                <div class="col-md-12 text-center alergenos">
                    {{Auth::user()->direccion}}@if(Auth::user()->telefono) - Tlf:{{Auth::user()->telefono}}@endif
                </div>
            </div>
            
        </div>
    </div>

@endsection