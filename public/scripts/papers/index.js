$(function () {
  $('#datatable-index').DataTable({
    language: {
      url: '/plugins/DataTables/local/Spanish.json'
    },
    processing: true,
    serverSide: true,
    sortable: true,
    ajax: '/api/papers',
    columns: [
      { data: 'id', name: 'id' },
      { data: 'name', name: 'name' },
      { data: 'estado', name: 'estado', searchable: false, sortable: false },
      {
        data: null,
        name: null,
        sortable: false,
        searchable: false,
        render: function (d) {
          var output = ''
          if (!d.deleted_at) {
            output += '<button class="btn btn-danger btnDeletePaper" data-id="' + d.id + '">' +
              '<i class="fa fa-trash-o fa-lg"></i> Desactivar</button>'
            output += '<button class="btn btn-primary btnUpdatePaper" data-id="' + d.id + '">' +
              '<i class="fa fa-pencil-square-o fa-lg"></i> Editar</button>'
          } else {
            output += '<button class="btn btn-success btnRestorePaper" data-id="' + d.id + '">' +
              '<i class="fa fa-recycle fa-lg"></i> Restaurar</button>'
          }

          return output
        }
      }
    ]
  })

  $('#btnCreatePaper').on('click', function (event) {
    $('#btnModalUpdatePaperSubmit').hide()
    $('#btnModalCreatePaperSubmit').show()
    $('#modal-title').html('Crear Nuevo Tipo de Papel')
    $('#modalCreatePaper').modal('show')
  })

  $('#btnModalCreatePaperCancel').on('click', function () {
    $('#modalCreatePaper').modal('hide')
  })

  $('#modalCreatePaper').on('hidden.bs.modal', handleModalClose)

  function handleModalClose() {
    $('#formCreatePaper').trigger('reset')
  }

  $('#btnModalCreatePaperSubmit').on('click', function () {
    var $form = $('#formCreatePaper')
    if ($form.valid()) handleSubmit()
  })

  function handleSubmit() {
    swal({
      title: '¿Confirma el registro del Tipo de Papel?',
      text: 'El tipo de Papel sera registrado en el sistema',
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
        var data = getFormData('#formCreatePaper')
        if (confirm) {
          handleAjax({
            data,
            url: '/api/papers',
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
            $('#modalCreatePaper').modal('hide')
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

  // delete paper
  $('#datatable-index').on('click', '.btnDeletePaper', function (e) {
    var paperId = $(e.target).attr('data-id')
    swal({
      title: '¿Confirma la desactivación del tipo de Papel?',
      text: 'El tipo de papel sera desactivado del sistema',
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
            url: '/api/papers/' + paperId,
            type: 'DELETE'
          })
        }
      })
  })

  // restaurar paper
  $('#datatable-index').on('click', '.btnRestorePaper', function (e) {
    var paperId = $(e.target).attr('data-id')
    swal({
      title: '¿Confirma la restauración del Tipo de Papel?',
      text: 'El registro del Tipo de Papel sera restaurado',
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
            url: '/api/papers/' + paperId + '/restore',
            type: 'PUT'
          })
        }
      })
  })

  // update paper
  $('#datatable-index').on('click', '.btnUpdatePaper', function (e) {
    var paperId = $(e.target).attr('data-id')
    $('#modalHiddenId').val(paperId)
    $('#btnModalUpdatePaperSubmit').show()
    $('#btnModalCreatePaperSubmit').hide()
    $('#modal-title').html('Editar Tipo de Papel')
    getPaper(paperId)
  })

  function getPaper(paperId) {
    $.ajax({
      url: '/api/papers/' + paperId,
      type: 'GET',
      dataType: 'json',
      success: function (paper) {
        populateForm(paper)
        $('#modalCreatePaper').modal('show')
      },
      error: function (err) {
        // TODO error
        console.log(err)
      }
    })
  }

  $('#btnModalUpdatePaperSubmit').on('click', function (e) {
    var $form = $('#formCreatePaper')
    if ($form.valid()) handleUpdate()
  })

  function handleUpdate() {
    swal({
      title: '¿Confirma la actualización del Tipo de Papel?',
      text: 'El registro del Tipo de Papel sera actualizado en el sistema',
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
        let paperId = $('#modalHiddenId').val()
        var data = getFormData('#formCreatePaper')
        if (confirm) {
          handleAjax({
            data,
            url: '/api/papers/' + paperId,
            type: 'PUT'
          })
        }
      })
  }

  function populateForm(paper) {
    $('#formCreatePaper input[name="name"]').val(paper.name)
  }
})