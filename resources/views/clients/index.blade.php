@extends('layouts.main')

@section('page-title')
  Clientes
@endsection

@section('plugin-styles')  
  <link rel="stylesheet" href="/plugins/Datatables/Datatables/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="/plugins/font-awesome/css/font-awesome.min.css">
@endsection

@section('body')
  <div>
    <a href="{{url('/')}}"> &lt;&lt; Volver</a>
  </div>
  <br>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Clientes</h3>
    </div>

    <div class="panel-body">

      <div class="panel panel-default">
        <div class="panel-body">
          <button class="btn btn-primary" id="btnCreateNewClient">
            Nuevo Cliente <i class="fa fa-plus"></i>
          </button>
        </div>
      </div>

      <div class="panel panel-default">
        <table class="table table-bordered" id="datatable-index">
          <thead>
            <tr>
              <th>id</th>
              <th>NIT</th>
              <th>Cliente</th>
              <th>Teléfono</th>
              <th>Email</th>
              <th>Dirección</th>
              <th>Estado</th>
              <th>Opciones</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
  @include('clients.client-modal')
@endsection

@section('plugin-scripts')
  <script src="/plugins/jquery/jquery-3.3.1.min.js"></script>
  <script src="/plugins/bootstrap/js/bootstrap.min.js"></script>
  <script src="/plugins/DataTables/datatables.min.js"></script>
  <script src="/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
  <script src="/plugins/jquery-validation/dist/localization/messages_es.min.js"></script>
  <script src="/plugins/sweetalert/sweetalert.min.js"></script>
  <script src="/scripts/clients/index.js"></script> 
@endsection