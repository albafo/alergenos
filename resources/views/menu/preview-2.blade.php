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
        <div class="col-md-8  text-center" >
             
             
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
                        @if($traduccion > 1 && $categoria->hasTraduccion($traduccion))

                            {{ $categoria->traduccion()->find($traduccion)->pivot->content }}

                        @else
                            {{$categoria->nombre}}

                        @endif
                    </div>
                </div>

                <div class="separadorCategoria col-centered"></div>

                @foreach($categoria->platos as $plato)
                <div class="row">
                    <div class="col-md-12 plato">
                        <span>
                            @if($traduccion > 1 && $plato->hasTraduccion($traduccion))

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
                <div class="col-centered text-center precio">
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