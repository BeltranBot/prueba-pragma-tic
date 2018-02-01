<div class="contianer">
<div
  class="modal fade"
  id="modalCreateOperator"
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
          Crear Nuevo Operador
        </h4>
      </div>

      <input type="hidden" name="operatorId" id="modalHiddenId">
      <div class="modal-body">
        <form
          id="formCreateOperator"
          class="form-horizontal"
          role="form">

          <div class="form-group">
            <label class="control-label col-sm-4">
              Operador *
            </label>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="name"
                placeholder="Operador"
                required>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-4">
              Costo por Hora *
            </label>
            <div class="col-sm-8">
              <input type="number" class="form-control" name="hour_cost"
                min=0.01
                step=0.01
                placeholder="Costo Por HOra"
                required>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default" id="btnModalCreateOperatorCancel">Cancelar</button>
        <button class="btn btn-primary" id="btnModalCreateOperatorSubmit">Registrar</button>
        <button class="btn btn-info" id="btnModalUpdateOperatorSubmit">Actualizar</button>
      </div>
    </div>
  </div>
</div> 
</div>