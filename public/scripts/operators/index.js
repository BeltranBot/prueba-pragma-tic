$(function () {
  var idDatatable = '#datatable-index'
  var baseUrl = '/api/operators'

  // index
  var idBtnCreate = '#btnCreateOperator'

  var deleteClass = 'btnDeleteOperator'
  var restoreClass = 'btnRestoreOperator'
  var updateClass = 'btnUpdateOperator'

  // modal
  var idModal = '#modalCreateOperator'

  var modalInsertTitle = 'Crear nuevo Operador'
  var modalEditTitle = 'Editar Operador'

  var idBtnModalUpdate = '#btnModalUpdateOperatorSubmit'
  var idBtnModalCancel = '#btnModalCreateOperatorCancel'
  var idBtnModalSubmit = '#btnModalCreateOperatorSubmit'

  var idForm = '#formCreateOperator'

  // swal
  var insertTitle = '¿Confirma el registro Operador?'
  var insertText = 'El Operador sera registrado en el sistema'
  var deleteTitle = '¿Confirma la desactivación del Operador?'
  var deleteText = 'El Operador sera desactivado del sistema'
  var restoreTitle = '¿Confirma la restauración del Operador?'
  var restoreText = 'El registro del Operador sera restaurado'
  var updateTitle = '¿Confirma la actualización Operador?'
  var updateText = 'El registro Operador sera actualizado en el sistema'

  $(idDatatable).DataTable({
    language: {
      url: '/plugins/DataTables/local/Spanish.json'
    },
    processing: true,
    serverSide: true,
    sortable: true,
    ajax: baseUrl,
    columns: [
      { data: 'id', name: 'id' },
      { data: 'name', name: 'name' },
      { data: 'hour_cost', name: 'hour_cost' },
      { data: 'estado', name: 'estado', searchable: false, sortable: false },
      {
        data: null,
        name: null,
        sortable: false,
        searchable: false,
        render: function (d) {
          var output = ''
          if (!d.deleted_at) {
            output += '<button class="btn btn-danger ' + deleteClass + '" data-id="' + d.id + '">' +
              '<i class="fa fa-trash-o fa-lg"></i> Desactivar</button>'
            output += '<button class="btn btn-primary ' + updateClass + '" data-id="' + d.id + '">' +
              '<i class="fa fa-pencil-square-o fa-lg"></i> Editar</button>'
          } else {
            output += '<button class="btn btn-success ' + restoreClass + '" data-id="' + d.id + '">' +
              '<i class="fa fa-recycle fa-lg"></i> Restaurar</button>'
          }
          return output
        }
      }
    ]
  })

  $(idBtnCreate).on('click', function (event) {
    $(idBtnModalUpdate).hide()
    $(idBtnModalSubmit).show()
    $('#modal-title').html(modalInsertTitle)
    $(idModal).modal('show')
  })

  $(idBtnModalCancel).on('click', function () {
    $(idModal).modal('hide')
  })

  $(idModal).on('hidden.bs.modal', handleModalClose)

  function handleModalClose() {
    $(idForm).trigger('reset')
  }

  $(idBtnModalSubmit).on('click', function () {
    var $form = $(idForm)
    if ($form.valid()) handleSubmit()
  })

  function handleSubmit() {
    swal({
      title: insertTitle,
      text: insertText,
      icon: 'warning',
      closeOnClickOutside: false,
      closeOnEsc: false,
      buttons: {
        cancel: {
          text: 'Cancel',
          value: null,
          visible: true,
          closeModal: true,
        },
        confirm: {
          text: 'OK',
          value: true,
          visible: true,
          closeModal: false
        }
      }
    })
      .then((confirm) => {
        var data = getFormData(idForm)
        if (confirm) {
          handleAjax({
            data,
            url: baseUrl,
            type: 'POST'
          })
        }
      })
  }

  function handleAjax(config) {
    $.ajax({
      url: config.url,
      data: config.data,
      type: config.type,
      dataType: 'json',
      success: function (response) {
        swal(response.title, response.message, 'success')
          .then(function () {
            $(idDatatable).DataTable().draw()
            $(idModal).modal('hide')
            swal.close()
          })
      },
      error: handleError
    })
  }

  function getFormData(formId) {
    var form = $(formId).serializeArray()
    var data = {}
    for (var field of form) data[field.name] = field.value
    return data
  }

  function handleError(responseText) {
    if (responseText.status = 422) {
      var errors = responseText.responseJSON
      var formattedErrors =
        swal({
          content: {
            element: formatErrors(errors)
          },
          icon: 'error',
          title: 'Error'
        });
    } else if (responseText.status = 500) {
      swal('Error', 'Error Interno del Sistema', 'error')
    }
  }

  function formatErrors(errors) {
    var div = document.createElement('div')
    div.setAttribute('align', 'left')
    for (const error in errors['errors']) {
      var h3 = document.createElement('h3')
      var text = document.createTextNode(error)
      var ul = document.createElement('ul')

      h3.setAttribute('style', 'color:red')

      for (var i = 0; i < errors['errors'][error].length; i++) {
        var li = document.createElement('li')
        var textli = document.createTextNode(errors['errors'][error][i])
        li.setAttribute('style', 'color:black')
        li.appendChild(textli)
        ul.appendChild(li)
      }
      h3.appendChild(text)
      div.appendChild(h3)
      div.appendChild(ul)
    }
    return div
  }

  // delete operator
  $(idDatatable).on('click', '.' + deleteClass , function (e) {
    var itemId = $(e.target).attr('data-id')
    swal({
      title: deleteTitle,
      text: deleteText,
      icon: 'warning',
      closeOnClickOutside: false,
      closeOnEsc: false,
      dangerMode: true,
      buttons: {
        cancel: {
          text: 'Cancel',
          value: null,
          visible: true,
          closeModal: true,
        },
        confirm: {
          text: 'OK',
          value: true,
          visible: true,
          closeModal: false
        }
      }
    })
      .then((confirm) => {
        if (confirm) {
          handleAjax({
            data: null,
            url: baseUrl + '/' + itemId,
            type: 'DELETE'
          })
        }
      })
  })

  // restaurar operador
  $(idDatatable).on('click', '.' + restoreClass, function (e) {
    var itemId = $(e.target).attr('data-id')
    swal({
      title: restoreTitle,
      text: restoreText,
      icon: 'warning',
      closeOnClickOutside: false,
      closeOnEsc: false,
      buttons: {
        cancel: {
          text: 'Cancel',
          value: null,
          visible: true,
          closeModal: true,
        },
        confirm: {
          text: 'OK',
          value: true,
          visible: true,
          closeModal: false
        }
      }
    })
      .then((confirm) => {
        if (confirm) {
          handleAjax({
            data: null,
            url: baseUrl + '/' + itemId + '/restore',
            type: 'PUT'
          })
        }
      })
  })

  // update operator
  $(idDatatable).on('click', '.' + updateClass, function (e) {
    var itemId = $(e.target).attr('data-id')
    $('#modalHiddenId').val(itemId)
    $(idBtnModalUpdate).show()
    $(idBtnModalSubmit).hide()
    $('#modal-title').html(modalEditTitle)
    getItem(itemId)
  })

  function getItem(itemId) {
    $.ajax({
      url: baseUrl + '/' + itemId,
      type: 'GET',
      dataType: 'json',
      success: function (operador) {
        populateForm(operador)
        $(idModal).modal('show')
      },
      error: function (err) {
        // TODO error
        console.log(err)
      }
    })
  }

  $(idBtnModalUpdate).on('click', function (e) {
    var $form = $(idForm)
    if ($form.valid()) handleUpdate()
  })

  function handleUpdate() {
    swal({
      title: updateTitle,
      text: updateText,
      icon: 'warning',
      closeOnClickOutside: false,
      closeOnEsc: false,
      buttons: {
        cancel: {
          text: 'Cancel',
          value: null,
          visible: true,
          closeModal: true,
        },
        confirm: {
          text: 'OK',
          value: true,
          visible: true,
          closeModal: false
        }
      }
    })
      .then((confirm) => {
        let itemId = $('#modalHiddenId').val()
        var data = getFormData(idForm)
        if (confirm) {
          handleAjax({
            data,
            url: baseUrl + '/' + itemId,
            type: 'PUT'
          })
        }
      })
  }

  function populateForm(item) {
    $(idForm + ' input[name="name"]').val(item.name)
    $(idForm + ' input[name="hour_cost"]').val(item.hour_cost)
  }
})