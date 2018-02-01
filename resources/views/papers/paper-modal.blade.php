<div class="contianer">
<div
  class="modal fade"
  id="modalCreatePaper"
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
          Crear Nuevo Tipo de Papel
        </h4>
      </div>

      <input type="hidden" name="paperId" id="modalHiddenId">
      <div class="modal-body">
        <form
          id="formCreatePaper"
          class="form-horizontal"
          role="form">

          <div class="form-group">
            <label class="control-label col-sm-4">
              Tipo de Papel *
            </label>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="name"
                placeholder="Tipo de Papel"
                required>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default" id="btnModalCreatePaperCancel">Cancelar</button>
        <button class="btn btn-primary" id="btnModalCreatePaperSubmit">Registrar</button>
        <button class="btn btn-info" id="btnModalUpdatePaperSubmit">Actualizar</button>
      </div>
    </div>
  </div>
</div> 
</div>