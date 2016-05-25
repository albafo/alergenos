@extends('admin.home')
@section('contentAdmin')
    <style>
        input[type='checkbox'] {
            -webkit-appearance:none;
            width:30px;
            height:30px;
            background:white;
            border-radius:5px;
            border:2px solid #555;
        }
        input[type='checkbox']:checked {
            background: #abd;
        }
    </style>
    <form action="{{url('admin/tickets')}}" method="post">
        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />

        <input type="checkbox" id="checkAll"> Seleccionar todos<br><br>
    <button id="marcarLeido" name="marcarLeido" value="1">Marcar como Leído</button> <button id="marcarResuelto" name="marcarResuelto" value="1">Marcar como Resuelto</button><br><br>
    <button id="marcarLeidoResulto" name="marcarLeidoResuelto" value="1">Marcar como Leído y resuelto</button><br><br>

    <table id="tableUsuarios" class="display" cellspacing="0" width="100%">

    <thead>
        <tr>

            <th>Usuario</th>
            <th>Email</th>
            <th>Consulta</th>
            <th>Fecha consulta</th>
            <th>Estado</th>
            <th>Resuelto</th>
            <th>Seleccionar</th>
        </tr>
    </thead>

   

    
</table>

    </form>
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
            { "data": "resuelto" },
            { "data": "checkbox"}
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





    $('#tableUsuarios tbody').on('click', 'tr', function (e) {

        if ( $( e.target ).is( 'input:checkbox' ) ) {
        } else {


            var id = $(this).attr('id');
            id = id.split("_")[1];
            window.location.href = "{{url('admin/ticket')}}/" + id;
        }
    } );


    $('#checkAll').change(function () {
        if($('#checkAll').prop('checked')) {
            $('#tableUsuarios input').prop("checked", true);
        }
        else {
            $('#tableUsuarios input').prop("checked", false);

        }
    });

    $('#marcarLeido')
   
	

});
</script>
@endsection