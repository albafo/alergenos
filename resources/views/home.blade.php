@extends('app')
@section('content')
    <div class="container">
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
                    <div class="col-md-5 productoHome certificado" data-toggle="tooltip" data-placement="top" title="Próximamente ofreceremos este servicio.">
                        <h3>CERTIFICADO<br>acreditativo sobre normativa de alérgenos</h3>
                        @if($user->hasCompletedMenu() && $user->manual_downloaded)
                            <a href="{{url('#')}}"></a>

                        @endif
                    </div>
                    <div class="col-md-5 col-md-offset-2 productoHome book" data-toggle="tooltip" data-placement="top" title="Podrás visualizar o descargarte en pdf el Book de fichas de cocina cuando hayas completado al menos un menú en la herramienta de gestión de menús o cartas.">
                        <h3>Book de fichas de cocina</h3>
                        <a href="{{url('menu/listado-ingredientes')}}"></a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 productoHome herramienta" data-toggle="tooltip" data-placement="top" title="Entra y comienza a introducir tus platos. La herramienta está programada para hacer el resto en relación con la normativa de alérgenos">
                        <h3>Herramienta de Gestión de Menús o Cartas</h3>
                        <a href="{{url('menu')}}"></a>
                    </div>
                    <div class="col-md-5 col-md-offset-2 productoHome manual" data-toggle="tooltip" data-placement="top" title="Descárgate este manual. Conocerás todas las claves y cuestiones importantes de la normativa sobre alérgenos.">
                        <h3>Manual sobre la normativa de alérgenos</h3>
                        <a href="{{url('user/manual')}}"></a>
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