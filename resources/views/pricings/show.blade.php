@extends('layouts.main')

@section('page-title')
  Cotizacion
@endsection

@section('plugin-styles')    
  <link rel="stylesheet" href="/plugins/Datatables/Datatables/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="/plugins/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
@endsection

@section('body')
  <div>
    <a href="{{url('/pricings')}}"> &lt;&lt; Volver</a>
  </div>
  <br>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Cotizacion ID: {{$pricing->id}}</h3>
    </div>

    <div class="panel-body">

      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Cliente</h3>
        </div>
        <div class="panel-body">
          <label>Nombre:</label>
          <p>{{$pricing->client->name}}</p>
          <label>Teléfono:</label>
          <p>{{$pricing->client->phone}}</p>
          <label>Email:</label>
          <p>{{$pricing->client->email}}</p>
          <label>Dirección:</label>
          <p>{{$pricing->client->address}}</p>
        </div>        
      </div>

      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Cotización</h3>
        </div>
        <div class="panel-body">
          <label>Tipo de Impresión:</label> {{$pricing->printing_type->name}}
          <br>
          <label>Impresora:</label> {{$pricing->printer->model}}
          <br>
          <label>Operador:</label> {{$pricing->operator->name}}
          <br>
          <label>Tipo de Papel:</label> {{$pricing->paper->name}}
          <br>
          <label>Ancho (mm):</label> {{$pricing->tag_width}}
          <br>
          <label>Alto (mm):</label> {{$pricing->tag_height}}
          <br>
          <label>Area (mm<sup>2</sup>):</label> {{$pricing->tag_width * $pricing->tag_height}}
          <br>
          <label>Area (pulgadas<sup>2</sup>):</label> {{$pricing->tag_area}}

          <br>
          <label>Costo del Papel:</label> {{$pricing->paper_cost}}
          <br>
          <label>Tiempo de Impresiòn (horas):</label> {{$pricing->printing_time}}

          <br>
          <label>Porcentaje Ganancia:</label> {{$pricing->utility}}

          @if ($pricing->printing_type_id > 1)
            <br>
            <label>Tiempo de Perparación (horas):</label> {{$pricing->prep_time}}
            @if ($pricing->printing_type_id == 2)
                <label>% Papel Desperdiciado:</label> {{$pricing->wasted_paper}}
                <label>Numero de Tintas:</label> {{$pricing->inks_number}}
            @endif
          @endif

          <h4>Valor por cantidad de etiquetas:</h4>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Cantidad de Etiquetas</th>
                <th>Subtotal</th>
                <th>Subtotal + Ganacia</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($pricing->pricing_tag_quantities as $q)
                  <tr>
                    <td>{{$q->quantity}}</td>
                    <td> $ {{number_format($q->subtotal, 2)}}</td>
                    <td> $ {{number_format($q->total, 2)}}</td>
                  </tr>
              @endforeach
            </tbody>
          </table>
        </div>        
      </div>
    </div>
  </div>
  {{--  @include('pricings.pricing-modal')  --}}
@endsection

@section('plugin-scripts')
  <script src="/plugins/jquery/jquery-3.3.1.min.js"></script>
  <script src="/plugins/bootstrap/js/bootstrap.min.js"></script>
  {{--  <script src="/plugins/DataTables/datatables.min.js"></script>
  <script src="/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
  <script src="/plugins/jquery-validation/dist/localization/messages_es.min.js"></script>
  <script src="/plugins/sweetalert/sweetalert.min.js"></script>
  <script src="/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
  <script src="/scripts/pricings/index.js"></script>   --}}
@endsection