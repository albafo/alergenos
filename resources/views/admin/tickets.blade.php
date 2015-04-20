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
            { "data": "usuarios.usuario" },
            { "data": "usuarios.email" },
            { "data": "peticion" },
            { "data": "created_at" },
            { "data": "leido" }
        ],
        "createdRow": function ( row, data, index ) {
            
            if ( data["leido"]==1 ) {
                $('td', row).eq(4).addClass('estado-activo');
                $('td', row).eq(4).text('Leído');
            }
            else {
                $('td', row).eq(4).addClass('estado-inactivo');
                $('td', row).eq(4).text('No Leído');
            
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