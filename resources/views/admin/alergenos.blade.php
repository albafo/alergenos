@extends('admin.home')
@section('contentAdmin')
<div class="row">
    <div class="col-md-12 text-right clickable"><a href="{{url('admin/alergenos/nuevo')}}">+ Nuevo alérgeno</a></div>
</div>
<div class="row">
    @unless($alergenos->count())
        <span>No has creado ningún alérgeno todavía.</span>
    @else
        @foreach($alergenos as $alergeno)
            <div class="col-md-6">
                <div class="panel panel-default caja-menu caja-alergenos" data-id="{{$alergeno->id}}">
					<div class="panel-body">
					    <div class="row">
					       <div class="row-same-height">
        					    <div class="col-xs-4 col-xs-height">
        					        <img src="{{asset($alergeno->img)}}">
        					    </div>
        					    <div class="col-xs-8 col-xs-height">
        					        {{$alergeno->nombre}}
        					    </div>
        			        </div>
    				    </div>
					</div>
			    </div>
            </div>
		@endforeach
	@endunless
</div>
<script>

$(function() {
      $('body').on('click', '.caja-alergenos', function() {
          var id=$(this).attr('data-id');
          window.location.href="{{url('admin/alergenos/editar')}}/"+id;
      });
});

</script>
@endsection
