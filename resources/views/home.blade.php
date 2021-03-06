@extends('app')
@section('content')
    <div class="container" style="position: relative">
        <div class="buttonHelp">
            <span>VÍDEO-AYUDA</span>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><img src="{{asset('img/btn_help.png')}}" width="50"></a>
            <ul class="dropdown-menu" role="menu" style="left:-165px">
                <li><a href="https://www.youtube.com/watch?v=qtWEuWZLPpY&list=PLXC20vLfXNNmrjBJN86ghgHR3TguK344v&index=2" target="_blank">Manual normativa alérgenos</a></li>
                <li><a href="https://www.youtube.com/watch?v=iua8B9Zgt2I&index=5&list=PLXC20vLfXNNmrjBJN86ghgHR3TguK344v" target="_blank">Certificado</a></li>
                <li><a href="https://www.youtube.com/watch?v=c2WTtLyBJdw&list=PLXC20vLfXNNmrjBJN86ghgHR3TguK344v&index=6" target="_blank">Datos del usuario</a></li>
            </ul>

        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <h2>Bienvenid@ a nuestra herramienta cartaonline certificada por ECEDE</h2>
            </div>
                <div class="col-md-12 text-center" >
                    <img src="{{asset('img/logo_ecede.png')}}" height="150">
                </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1 text-center">
                <div class="row">
                    <div class="col-md-5   productoHome manual" data-toggle="tooltip" data-placement="top" title="Descárgate este manual. Conocerás todas las claves y cuestiones importantes de la normativa sobre alérgenos.">
                        <h3>1.- Manual sobre la normativa de alérgenos</h3>
                        <a href="{{url('user/manual')}}"></a>
                    </div>
                    <div class="col-md-5 col-md-offset-2 productoHome herramienta" data-toggle="tooltip" data-placement="top" title="Entra y comienza a introducir tus platos. La herramienta está programada para hacer el resto en relación con la normativa de alérgenos">
                        <h3>2.- Gestor de Menús o Cartas</h3>
                        <a href="{{url('menu')}}"></a>
                    </div>


                </div>
                <div class="row">
                    <div class="col-md-5  productoHome book" data-toggle="tooltip" data-placement="top" title="Podrás visualizar o descargarte en pdf el Book de fichas de cocina cuando hayas completado al menos un menú en la herramienta de gestión de menús o cartas.">
                        <h3>3.- Book de fichas de cocina</h3>
                        <a href="{{url('menu/listado-ingredientes')}}"></a>
                    </div>
                    <div class="col-md-5 col-md-offset-2 productoHome certificado" data-toggle="tooltip" data-placement="top" title="Podrás descargarte este certificado una vez hayas descargado el manual sobre la normativa de alérgenos y hayas completado al menos un menú en la herramienta de gestión de menús o cartas.">
                        <h3>4.- CERTIFICADO<br>acreditativo sobre normativa de alérgenos</h3>
                        @if($user->hasCompletedMenu() && $user->manual_downloaded)
                            <a href="{{url('user/certificado')}}"></a>

                        @endif
                    </div>

                </div>

            </div>
        </div>
    </div>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endsection