@extends('app')

@section('content')
<div class="container" id="opciones-menu">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			
            @yield('contentAdmin')
		</div>
	</div>
</div>

@endsection

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
              <li @if(Request::is('admin/alergenos*')) class="active" @endif><a href="{{url('admin/alergenos')}}">Alérgenos</a></li>
              <li @if(Request::is('admin/ingredientes*')) class="active" @endif><a href="{{url('admin/ingredientes')}}">Ingredientes</a></li>
              <li @if(Request::is('admin/usuarios*')) class="active" @endif><a href="{{url('admin/usuarios')}}">Usuarios</a></li>
              <li @if(Request::is('admin/ticket*')) class="active" @endif>
                    @if(Ticket::noReaded()>0)
                    <div class="numberAlert badge">
                        {{Ticket::noReaded()}}
                    </div>
                    @endif
                <a href="{{url('admin/tickets')}}">Tickets</a>
              </li>

            </ul>
          </div><!-- /.navbar-collapse -->
      </div>

@endsection