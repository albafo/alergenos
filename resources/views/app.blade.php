<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CartaONline</title>
	<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Muli' rel='stylesheet' type='text/css'>

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/web.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/bootstrap-switch.min.css') }}" rel="stylesheet">
    <link href="{{ asset('bootstrap-fileinput/css/fileinput.min.css') }}" media="all" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/plug-ins/1.10.6/integration/bootstrap/3/dataTables.bootstrap.css">

	<!-- Fonts -->
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="{{asset('js/jquery-ui.min.js')}}"></script>
        <script src="{{asset('js/jquery.ui.touch-punch.min.js')}}"></script>

    <script src="{{asset('js/moment-with-locales.js')}}"></script>
    <script src="{{asset('js/transition.js')}}"></script>
    <script src="{{asset('js/collapse.js')}}"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script src="{{asset('js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-switch.min.js')}}"></script>
    <script src="{{asset('js/extra.js')}}"></script>
    <script src="{{asset('js/bootbox.min.js')}}"></script>
	<script src="{{asset('bootstrap-fileinput/js/fileinput.min.js')}}" type="text/javascript"></script>
	<script type="text/javascript" language="javascript" src="http://cdn.datatables.net/1.10.6/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="http://cdn.datatables.net/plug-ins/1.10.6/integration/bootstrap/3/dataTables.bootstrap.js"></script>
    <script src="{{asset('js/albafo.typeahead.js')}}"></script>


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body class="page-{{App\MyRequest::mySegments()}} @yield('class-body')">
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/') }}"><i class="glyphicon glyphicon-home"></i> {{trans('web.inicio')}}</a></li>

					@if(!Auth::guest() && Auth::user()->tipo=="user" && Session::has('auth-admin') && Session::get('auth-admin')->tipo=="admin")
					<li><a href="{{ url('admin/usuarios') }}">{{trans('web.admin')}}</a></li>
					@endif
                    @if(!Auth::guest() && Auth::user()->tipo=="user" && Session::has('auth-tecnico') && Session::get('auth-tecnico')->tipo=="tecnico")
                        <li><a href="{{ url('admin/usuarios') }}">{{trans('web.admin')}}</a></li>
                    @endif
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())

						<li><a href="http://www.ecede.es/formulario.php">{{trans('web.registro')}}</a></li>
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="glyphicon glyphicon-pencil"></i> {{ Auth::user()->nombre }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('usuario/datos') }}">{{trans('web.misDatos')}}</a></li>
								<li><a href="{{ url('/auth/logout') }}">{{trans('web.salir')}}</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>
	<div class="row cabeceraLogo">
		<div class="col-sm-5 col-sm-offset-1">
			<h1>CartaONline</h1>
		</div>
		<div class="col-sm-6 menuCabecera">
			@yield('menuCabecera')
		</div>
	</div>
     @if (Session::get('ok'))
						<div class="alert alert-success">
							<strong>{{trans('mensajes.titleCong')}}</strong><br><br>
							<ul>

									<li>{{ Session::get('ok')}}</li>

							</ul>
						</div>
					@endif
	@yield('content')


   

	<!-- Scripts -->



</body>
</html>
