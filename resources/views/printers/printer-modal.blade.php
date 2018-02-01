<div class="contianer">
<div
  class="modal fade"
  id="modalCreatePrinter"
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
          Crear Nueva Impresora
        </h4>
      </div>

      <input type="hidden" name="printerId" id="modalHiddenId">
      <div class="modal-body">
        <form
          id="formCreatePrinter"
          class="form-horizontal"
          role="form">

          <div class="form-group">
            <label class="control-label col-sm-4">
              Modelo *
            </label>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="model"
                placeholder="Modelo"
                required>
            </div>
          </div>
        
          <div class="form-group">
            <label class="control-label col-sm-4">
              Tiempo de Preparación (horas) *
            </label>
            <div class="col-sm-8">
              <input type="number" class="form-control" name="prep_time"
                min=0.01
                step=0.01
                placeholder="Tiempo de Preparación"
                required>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-4">
              Ancho Máximo Rodillo (pulgadas) *
            </label>
            <div class="col-sm-8">
              <input type="number" class="form-control" name="max_width"
                min=0.0001
                step=0.0001
                placeholder="Ancho Máximo Rodillo"
                required>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-4">
              Velocidad de Impresión (pulgadas/min) *
            </label>
            <div class="col-sm-8">
              <input type="number" class="form-control" name="printing_speed"
                min=0.0001
                step=0.0001
                placeholder="Velocidad de Impresión"
                required>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default" id="btnModalCreatePrinterCancel">Cancelar</button>
        <button class="btn btn-primary" id="btnModalCreatePrinterSubmit">Registrar</button>
        <button class="btn btn-info" id="btnModalUpdatePrinterSubmit">Actualizar</button>
      </div>
    </div>
  </div>
</div> 
</div>