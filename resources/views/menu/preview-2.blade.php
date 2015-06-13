@extends('app')

@section('class-body')
menu-template-2 preview-menus
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
            <div class="categoria-total">
                <div class="row">
                    <div class="col-md-12 categoriaPlato">
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

                <div class="separadorCategoria col-centered"></div>

                @foreach($categoria->platos as $plato)
                <div class="row">
                    <div class="col-md-12 plato">
                        <span>{{$plato->nombre}}</span>
                        @if($traduccion)
                            <br><span class="platosTraduccion">(
                                @foreach(\App\Idioma::all() as $idioma)

                                    @if($plato->hasTraduccion($idioma->id))
                                        <span class="traduccion">{{ $plato->traduccion()->find($idioma->id)->pivot->content }}</span>
                                    @endif

                                @endforeach
                                )</span>

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
                        @foreach($plato->alergenos() as $alergeno)
                        <span><img width="30" src="{{asset($alergeno->img)}}" alt="{{$alergeno->nombre}}"></span>
                        @endforeach

                        @if(count($plato->customAlergenos($menu->id))>0)

                            @foreach($plato->customAlergenos($menu->id) as $alergeno)
                                <span><img width="30" src="{{asset($alergeno->img)}}" alt="{{$alergeno->nombre}}"></span>
                                @endforeach

                                @endif



                    </div>
                </div>
                @endforeach
                    
            </div>
            @endforeach
            
            <div class="row">
                <div class="col-centered text-center precio">
                    {{$menu->precio}}€
                </div>
            </div>
            
            <div class="row">
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
                <div class="col-md-12 text-center alergenos">
                    {{Auth::user()->direccion}} - Tlf:{{Auth::user()->telefono}}
                </div>
            </div>
            
        </div>
    </div>

@endsection