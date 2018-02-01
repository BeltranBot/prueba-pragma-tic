<div class="contianer">
<div
  class="modal fade"
  id="modalCreatePricing"
  role="dialog"
  data-backdrop="static"
  data-keyboard="false"
  aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button
          type="button"
          class="close"
          data-dismiss="modal"
          aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
        <h4
          class="modal-title"
          id="modal-title">
          Crear Nueva Cotización
        </h4>
      </div>

      <input type="hidden" name="pricingId" id="modalHiddenId">
      <div class="modal-body">
        <form
          id="formCreatePricing"
          class="form-horizontal"
          role="form">

          <div class="form-group">
            <label class="control-label col-sm-4">
              Tipo de Impresión *
            </label>
            <div class="col-sm-8">
              <select class="form-control" name="printing_type_id" required>
                <option value="" selected>Seleccione Tipo de Impresión</option>
                @foreach ($printing_types as $printing_type)
                  <option value="{{$printing_type->id}}">
                    {{$printing_type->name}}
                  </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-group hideGroup1">
            <label class="control-label col-sm-4">
              Cliente *
            </label>
            <div class="col-sm-8">
              <select class="form-control" name="client_id" required>
                <option value="" selected>Seleccione Cliente</option>
                @foreach ($clients as $client)
                  <option value="{{$client->id}}">
                    {{$client->nit . ' ' . $client->name}}
                  </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-group hideGroup1">
            <label class="control-label col-sm-4">
              Impresora *
            </label>
            <div class="col-sm-8">
              <select class="form-control" name="printer_id" required>
                <option value="" selected>Seleccione Impresora</option>
                @foreach ($printers as $printer)
                  <option value="{{$printer->id}}"
                    data-printerPrepTime="{{$printer->prep_time}}">
                    {{$printer->model}}
                  </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-group hideGroup1">
            <label class="control-label col-sm-4">
              Operador *
            </label>
            <div class="col-sm-8">
              <select class="form-control" name="operator_id" required>
                <option value="" selected>Seleccione Operador</option>
                @foreach ($operators as $operator)
                  <option value="{{$operator->id}}"
                    data-operatorCostHour="{{$operator->hour_cost}}">
                    {{$operator->name . ' ($ ' . $operator->hour_cost. ')'}}
                  </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-group hideGroup1">
            <label class="control-label col-sm-4">
              Tipo de Papel *
            </label>
            <div class="col-sm-8">
              <select class="form-control" name="paper_id" required>
                <option value="" selected>Seleccione Tipo de Papel</option>
                @foreach ($papers as $paper)
                  <option value="{{$paper->id}}">
                    {{$paper->name}}
                  </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-group hideGroup1">
            <label class="control-label col-sm-4">
              Costo del Papel *
            </label>
            <div class="col-sm-8">
              <input type="number"
                class="form-control"
                placeholder="Costo del papel"
                min=0.0001
                step=0.0001
                name="paper_cost" required>
            </div>
          </div>

          <div class="form-group hideGroup4">
            <label class="control-label col-sm-4">
              Porcentaje de Papel Desperdiciado *
            </label>
            <div class="col-sm-8">
              <input type="number"
                class="form-control"
                placeholder="Porcentaje de Papel Desperdiciado"
                min=0.01
                step=0.01
                max=1.00
                name="wasted_paper" required>
            </div>
          </div>

          <div class="form-group hideGroup1">
            <label class="control-label col-sm-4">
              Ancho de Etiqueta (mm) *
            </label>
            <div class="col-sm-8">
              <input type="number"
                class="form-control"
                placeholder="Ancho Etiqueta"
                min=0.01
                step=0.01
                name="tag_width" required>
            </div>
          </div>

          <div class="form-group hideGroup1">
            <label class="control-label col-sm-4">
              Alto de Etiqueta (mm) *
            </label>
            <div class="col-sm-8">
              <input type="number"
                class="form-control"
                placeholder="Ancho Etiqueta"
                min=0.01
                step=0.01
                name="tag_height" required>
            </div>
          </div>

          <div class="form-group hideGroup1">
            <label class="control-label col-sm-4">
              Tiempo de Impresión *
            </label>
            <div class="col-sm-8">
              <input type="number"
                class="form-control"
                placeholder="Tiempo de Impresión"
                min=0.01
                step=0.01
                name="printing_time" required>
            </div>
          </div>

          <div class="form-group hideGroup4">
            <label class="control-label col-sm-4">
              Numero de Tintas *
            </label>
            <div class="col-sm-8">
              <input type="number"
                class="form-control"
                placeholder="Numero de Tintas"
                min=1
                step=1
                name="inks_number" required>
            </div>
          </div>

          <div class="form-group hideGroup0">
            <label class="control-label col-sm-4">
              Numero de Etiquetas *
            </label>
            <div class="col-sm-8">
              <input type="text"
                class="form-control"
                placeholder="Enter para nuevo valor"
                data-role="tagsinput"
                name="quantities">
            </div>
          </div>

          <div class="form-group hideGroup1">
            <label class="control-label col-sm-4">
              Porcentaje de Utilidad *
            </label>
            <div class="col-sm-8">
              <input type="number"
                class="form-control"
                placeholder="Porcentaje de Utilidad"
                min=0.0001
                max=1.0000
                step=0.0001                
                name="utility" required>
            </div>
          </div>


        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default" id="btnModalCreatePricingCancel">Cancelar</button>
        <button class="btn btn-primary" id="btnModalCreatePricingSubmit">Registrar</button>
        <button class="btn btn-info" id="btnModalUpdatePricingSubmit">Actualizar</button>
      </div>
    </div>
  </div>
</div> 
</div>