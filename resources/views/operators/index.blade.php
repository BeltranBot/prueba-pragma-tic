@extends('layouts.main')

@section('page-title')
  Operadores
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
      <h3 class="panel-title">Operadores</h3>
    </div>

    <div class="panel-body">

      <div class="panel panel-default">
        <div class="panel-body">
          <button class="btn btn-primary" id="btnCreateOperator">
            Nueva Operador <i class="fa fa-plus"></i>
          </button>
        </div>
      </div>

      <div class="panel panel-default">
        <table class="table table-bordered" id="datatable-index">
          <thead>
            <tr>
              <th>id</th>
              <th>Nombre</th>
              <th>Costo por hora</th>
              <th>Estado</th>
              <th>Opciones</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
  @include('operators.operator-modal')
@endsection

@section('plugin-scripts')
  <script src="/plugins/jquery/jquery-3.3.1.min.js"></script>
  <script src="/plugins/bootstrap/js/bootstrap.min.js"></script>
  <script src="/plugins/DataTables/datatables.min.js"></script>
  <script src="/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
  <script src="/plugins/jquery-validation/dist/localization/messages_es.min.js"></script>
  <script src="/plugins/sweetalert/sweetalert.min.js"></script>
  <script src="/scripts/operators/index.js"></script> 
@endsection