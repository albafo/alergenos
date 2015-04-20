@extends('app')

@section('menuCabecera')

<div class="container-fluid navbar-default navbar-right" style="margin-bottom:15px;">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-8">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          
        </div>
                  
                

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-8">
            <ul class="nav navbar-nav">
              <li @if(Request::is('menu/datos-menu/*')) class="active" @endif><a href="{{url('menu/datos-menu/'.$menu->id)}}">Datos</a></li>
              <li @if(Request::is('menu/platos-menu/*')) class="active" @endif><a href="{{url('menu/platos-menu/'.$menu->id)}}">Platos</a></li>
              <li @if(Request::is('menu/herramientas/*')) class="active" @endif><a href="{{url('menu/herramientas/'.$menu->id)}}">Herramientas</a></li>
            </ul>
          </div><!-- /.navbar-collapse -->
      </div>

@endsection

@section('content')
<div class="container" id="opciones-menu">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			
            @yield('contentMenu')
		</div>
	</div>
</div>

@endsection
