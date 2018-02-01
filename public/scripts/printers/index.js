$(function () {
  $('#datatable-index').DataTable({
    language: {
      url: '/plugins/DataTables/local/Spanish.json'
    },
    processing: true,
    serverSide: true,
    sortable: true,
    ajax: '/api/printers',
    columns: [
      { data: 'id', name: 'id' },
      { data: 'model', name: 'model' },
      { 
        data: 'prep_time',
        prep_time: 'prep_time',
        render: function(prep_time) {
          return prep_time + ' hora(s)'
        }
      },
      {
        data: 'max_width',
        name: 'max_width',
        render: function (max_width) {
          return max_width + ' pulgada(s)'
        }
      },
      {
        data: 'printing_speed',
        name: 'printing_speed',
        render: function (printing_speed) {
          return printing_speed + ' pulgadas/min'
        }
      },
      { data: 'estado', name: 'estado', searchable: false, sortable: false },
      {
        data: null,
        name: null,
        sortable: false,
        searchable: false,
        render: function (d) {
          var output = ''
          if (!d.deleted_at) {
            output += '<button class="btn btn-danger btnDeletePrinter" data-id="' + d.id + '">' +
              '<i class="fa fa-trash-o fa-lg"></i> Desactivar</button>'
            output += '<button class="btn btn-primary btnUpdatePrinter" data-id="' + d.id + '">' +
              '<i class="fa fa-pencil-square-o fa-lg"></i> Editar</button>'
          } else {
            output += '<button class="btn btn-success btnRestorePrinter" data-id="' + d.id + '">' +
              '<i class="fa fa-recycle fa-lg"></i> Restaurar</button>'
          }

          return output
        }
      }
    ]
  })

  $('#btnCreatePrinter').on('click', function (event) {
    $('#btnModalUpdatePrinterSubmit').hide()
    $('#btnModalCreatePrinterSubmit').show()
    $('#modal-title').html('Crear Nueva Impresora')
    $('#modalCreatePrinter').modal('show')
  })

  $('#btnModalCreatePrinterCancel').on('click', function () {
    $('#modalCreatePrinter').modal('hide')
  })

  $('#modalCreatePrinter').on('hidden.bs.modal', handleModalClose)

  function handleModalClose() {
    $('#formCreatePrinter').trigger('reset')
  }

  $('#btnModalCreatePrinterSubmit').on('click', function () {
    var $form = $('#formCreatePrinter')
    if ($form.valid()) handleSubmit()
  })

  function handleSubmit() {
    swal({
      title: '¿Confirma el registro de la impresora?',
      text: 'La impresora sera registrada en el sistema',
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
        var data = getFormData('#formCreatePrinter')
        if (confirm) {
          handleAjax({
            data,
            url: '/api/printers',
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
            $('#datatable-index').DataTable().draw()
            $('#modalCreatePrinter').modal('hide')
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
      swal("Error", "Error Interno del Sistema", "error")
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

  // delete printer
  $('#datatable-index').on('click', '.btnDeletePrinter', function (e) {
    var printerId = $(e.target).attr('data-id')
    swal({
      title: '¿Confirma la desactivación de la impresora?',
      text: 'La impresora sera desactivada del sistema',
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
            url: '/api/printers/' + printerId,
            type: 'DELETE'
          })
        }
      })
  })

  // restaurar printer
  $('#datatable-index').on('click', '.btnRestorePrinter', function (e) {
    var printerId = $(e.target).attr('data-id')
    swal({
      title: '¿Confirma la restauración de la impresora?',
      text: 'El registro de la impresora sera restaurado',
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
            url: '/api/printers/' + printerId + '/restore',
            type: 'PUT'
          })
        }
      })
  })

  // update PRINTER
  $('#datatable-index').on('click', '.btnUpdatePrinter', function (e) {
    var printerId = $(e.target).attr('data-id')
    $('#modalHiddenId').val(printerId)
    $('#btnModalUpdatePrinterSubmit').show()
    $('#btnModalCreatePrinterSubmit').hide()
    $('#modal-title').html('Editar Impresora')
    getPrinter(printerId)
  })

  function getPrinter(printerId) {
    $.ajax({
      url: '/api/printers/' + printerId,
      type: 'GET',
      dataType: 'json',
      success: function (printer) {
        populateForm(printer)
        $('#modalCreatePrinter').modal('show')
      },
      error: function (err) {
        // TODO error
        console.log(err)
      }
    })
  }

  $('#btnModalUpdatePrinterSubmit').on('click', function (e) {
    var $form = $('#formCreatePrinter')
    if ($form.valid()) handleUpdate()
  })

  function handleUpdate() {
    swal({
      title: '¿Confirma la actualización de la impresora?',
      text: 'El registro de la impresora sera actualizada en el sistema',
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
        let printerId = $('#modalHiddenId').val()
        var data = getFormData('#formCreatePrinter')
        if (confirm) {
          handleAjax({
            data,
            url: '/api/printers/' + printerId,
            type: 'PUT'
          })
        }
      })
  }

  function populateForm(printer) {
    $('#formCreatePrinter input[name="model"]').val(printer.model)
    $('#formCreatePrinter input[name="prep_time"]').val(printer.prep_time)
    $('#formCreatePrinter input[name="max_width"]').val(printer.max_width)
    $('#formCreatePrinter input[name="printing_speed"]').val(printer.printing_speed)
  }
})