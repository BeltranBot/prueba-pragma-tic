@extends('layouts.main')

@section('page-title')
  Prueba Pragma-tic
@endsection

@section('body')
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Enlaces</h3>        
      </div>
    <div class="panel-body">
      <ul>
        <li><a href="{{url('clients')}}">Clientes</a></li>
        <li><a href="{{url('printers')}}">Impresoras</a></li>
        <li><a href="{{url('papers')}}">Papeles</a></li>
        <li><a href="{{url('operators')}}">Operadores</a></li>
        <li><a href="{{url('pricings')}}">Cotizaciones</a></li>
      </ul>
    </div>
  </div>
@endsection