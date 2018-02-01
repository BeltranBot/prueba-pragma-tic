<div class="contianer">
<div
  class="modal fade"
  id="modalCreateNewClient"
  tabindex="-1"
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
          Crear Nuevo Cliente
        </h4>
      </div>

      <input type="hidden" name="clientId" id="modalHiddenId">
      <div class="modal-body">
        <form
          id="formCreateNewClient"
          class="form-horizontal"
          role="form">

          <div class="form-group">
            <label class="control-label col-sm-4">
              NIT *
            </label>
            <div class="col-sm-8">
              <input type="number" class="form-control has-error" name="nit"
                min=0
                placeholder="NIT"
                required>
            </div>
          </div>
        
          <div class="form-group">
            <label class="control-label col-sm-4">
              Nombre Cliente *
            </label>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="name"
                placeholder="Nombre Cliente"
                pattern=".{4,}"
                required>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-4">
              Email *
            </label>
            <div class="col-sm-8">
              <input type="email" class="form-control" name="email"
                placeholder="example@example.com"
                required>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-4">
              Teléfono *
            </label>
            <div class="col-sm-8">
              <input type="number" class="form-control" name="phone"
                min=0
                placeholder="Teléfono"
                pattern="\d{7,}"
                required>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-4">
              Dirección *
            </label>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="address"
                placeholder="Dirección"
                required>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default" id="btnModalCreateNewClientCancel">Cancelar</button>
        <button class="btn btn-primary" id="btnModalCreateNewClientSubmit">Registrar</button>
        <button class="btn btn-info" id="btnModalUpdateClientSubmit">Actualizar</button>
      </div>
    </div>
  </div>
</div> 
</div>