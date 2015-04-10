@extends('admin.home')
@section('contentAdmin')
<table id="tableUsuarios" class="display" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Email</th>
            <th>Fecha de alta</th>
            <th>Caduca</th>
            <th>Estado</th>
        </tr>
    </thead>

    <tfoot>
        <tr>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Email</th>
            <th>Fecha de alta</th>
            <th>Caduca</th>
            <th>Estado</th>
        </tr>
    </tfoot>

    
</table>
<script>
$(function() {
    
    $('#tableUsuarios')
        .removeClass( 'display' )
        .addClass('table table-striped table-bordered');
		
    $('#tableUsuarios').dataTable({
        "ajax": "{{url('admin/usuarios/datatable')}}",
         "processing": true,
        "serverSide": true,
        "columns": [
            { "data": "nombre" },
            { "data": "apellidos" },
            { "data": "email" },
            { "data": "created_at" },
            { "data": "expired_at" },
            { "data": "status" }
        ],
        "createdRow": function ( row, data, index ) {
            
            if ( data["status"]==1 ) {
                $('td', row).eq(5).addClass('estado-activo');
                $('td', row).eq(5).text('Activo');
            }
            else {
                $('td', row).eq(5).addClass('estado-inactivo');
                $('td', row).eq(5).text('Inactivo');
            
            }
        }
    }); 
    $('#tableUsuarios tbody').on('click', 'tr', function () {
        var id = $(this).attr('id');
        id=id.split("_")[1];
        window.location.href="{{url('admin/usuario')}}/"+id;
    } );
   
	

});
</script>
@endsection