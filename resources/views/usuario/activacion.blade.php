@extends('app')
@section('content')
<div class="container">
    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
	<div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h3>Activación de usuario</h3>
            <form class="form-horizontal" method="post" action="{{url('auth/activar')}}">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <div class="form-group">
                            <label for="codigoActivacion" class="col-sm-4 control-label">Código de activación</label>
                            <div class="col-sm-8">
                                <input type="text" name="codigoActivacion" id="codigoActivacion" class="form-control" placeholder="Código">
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