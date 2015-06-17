@extends('admin.home')
@section('contentAdmin')
<table id="tableUsuarios" class="display" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Usuario</th>
            <th>Email</th>
            <th>Consulta</th>
            <th>Fecha consulta</th>
            <th>Estado</th>
            <th>Resuelto</th>
        </tr>
    </thead>

   

    
</table>
<script>
$(function() {
    
    $('#tableUsuarios')
        .removeClass( 'display' )
        .addClass('table table-striped table-bordered');
		
    $('#tableUsuarios').dataTable({
        "ajax": "{{url('admin/ticketsTable')}}",
         "processing": true,
        "serverSide": true,
        "columns": [
            { "data": "usuario" },
            { "data": "email" },
            { "data": "peticion" },
            { "data": "created_at" },
            { "data": "leido" },
            { "data": "resuelto" }
        ],
        "aaSorting": [],
        "createdRow": function ( row, data, index ) {
            
            if ( data["leido"]==1 ) {
                $('td', row).eq(4).addClass('estado-activo');
                $('td', row).eq(4).text('Leído');
            }
            else {
                $('td', row).eq(4).addClass('estado-inactivo');
                $('td', row).eq(4).text('No Leído');
            
            }

            if ( data["resuelto"]==1 ) {
                $('td', row).eq(5).addClass('estado-activo');
                $('td', row).eq(5).text('Resuelto');
            }
            else {
                $('td', row).eq(5).addClass('estado-inactivo');
                $('td', row).eq(5).text('No resuelto');
            }
        }
    });

    $('#tableUsuarios tbody').on('click', 'tr', function () {
        var id = $(this).attr('id');
        id=id.split("_")[1];
        window.location.href="{{url('admin/ticket')}}/"+id;
    } );
   
	

});
</script>
@endsection