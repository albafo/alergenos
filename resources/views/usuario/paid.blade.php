@extends('app')
@section('content')
    <div class="container">

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> Hay algún problema con el formulario.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-md-4">
                <img src="{{asset('img/logo_ecede.png')}}">
            </div>
            <div class="col-md-8">
                <div class="row text-center">
                    <h3>Bienvenido/a a la herramienta CartaOnline</h3>
                    <h4>Estás a punto de poder cumplir con la normativa sobre alérgenos, finaliza el registro.</h4>
                </div>

                <form class="form-horizontal" method="post" action="{{url("user/paid/{$id}")}}">
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <div class="form-group">
                                <label for="password" class="col-sm-4 control-label">Contraseña</label>
                                <div class="col-sm-4">
                                    <input type="password" name="password" id="password" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation" class="col-sm-4 control-label">Confirme contraseña</label>
                                <div class="col-sm-4">
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-4 control-label">Establecimiento</label>
                                <div class="col-sm-4">
                                    <input type="text"  class="form-control" value="{{$user->nombre_establ}}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-4 control-label">Email</label>
                                <div class="col-sm-4">
                                    <input type="text"  class="form-control" value="{{$user->email}}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-4 control-label">Teléfono</label>
                                <div class="col-sm-4">
                                    <input type="text"  class="form-control" value="{{$user->telefono}}" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-sm-4 control-label">Persona de contacto</label>
                                <div class="col-sm-4">
                                    <input type="text"  class="form-control" value="{{$user->nombre}}" readonly>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm-6 text-center">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Activar usuario</button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="deletedImg" id="deletedImg" value="0" />
                    <input type="hidden" name="_token" id="csrf-token" value="{{ csrf_token() }}" />

                </form>
            </div>
        </div>
    </div>

@endsection