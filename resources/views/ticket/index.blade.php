@extends('admin.home')
@section('contentAdmin')
    <div class="row ticketRow">
        <div class="col-md-3">
            <strong>Usuario:<strong>
        </div>
        <div class="col-md-9">
            <span>{{$ticket->usuarios->nombre}} {{$ticket->usuarios->apellidos}}</span>
        </div>
    </div>
    <div class="row ticketRow">
        <div class="col-md-3">
            <strong>Email:<strong>
        </div>
        <div class="col-md-9">
            <span>{{$ticket->usuarios->email}}</span>
        </div>
    </div>
    <div class="row ticketRow">
        <div class="col-md-3">
            <strong>Petición:</strong>
        </div>
        <div class="col-md-9">
            <span>{{$ticket->peticion}}</span>
        </div>
    </div>
    <div class="row ticketRow">
        <div class="col-md-3">
            <strong>Resuelto:</strong>
        </div>
        <div class="col-md-9">
            <span>@if($ticket->resuelto) Ticket resuelto @else Ticket no resuelto @endif</span>
        </div>
    </div>
    <div class="row ticketRow">
        <div class="col-md-3">
            <a href="{{url('admin/ticket/noReaded/'.$ticket->id)}}" type="button" class="btn btn-primary">Marcar como no leído</a><br><br>
            <a href="{{url('admin/ticket/resolved/'.$ticket->id)}}" type="button" class="btn btn-primary">Marcar como solucionado</a>
        </div>
        <div class="col-md-9">
            <a href="{{url('admin/ticket/delete/'.$ticket->id)}}" type="button" class="btn btn-danger">Eliminar Ticket</a>
        </div>
    </div>
@endsection