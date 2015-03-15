@extends('app')

@section('content')
<div class="container" id="opciones-menu">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="container-fluid navbar-default" style="margin-bottom:15px;">
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-8">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="#">{{$menu->nombre}}</a>
                </div>
                  
                

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-8">
                  <ul class="nav navbar-nav">
                    <li @if(Request::is('menu/datos-menu/*')) class="active" @endif><a href="{{url('menu/datos-menu/'.$menu->id)}}">Datos</a></li>
                    <li @if(Request::is('menu/platos-menu/*')) class="active" @endif><a href="{{url('menu/platos-menu/'.$menu->id)}}">Platos</a></li>
                    <li @if(Request::is('menu/herramientas/*')) class="active" @endif><a href="#">Herramientas</a></li>
                  </ul>
                </div><!-- /.navbar-collapse -->
            </div>
            @yield('contentMenu')
		</div>
	</div>
</div>

@endsection
