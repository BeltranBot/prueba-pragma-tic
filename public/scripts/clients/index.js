$(function () {
  $('#datatable-index').DataTable({
    language: {
      url: '/plugins/DataTables/local/Spanish.json'
    },
    processing: true,
    serverSide: true,
    sortable: true,
    ajax: '/api/clients',
    columns: [
      { data: 'id', name: 'id' },
      { data: 'nit', name: 'nit' },
      { data: 'name', name: 'name' },
      { data: 'phone', name: 'phone' },
      { data: 'email', name: 'email' },
      { data: 'address', name: 'address' },
      { data: 'estado', name: 'estado', searchable: false, sortable: false },
      {
        data: null,
        name: null,
        sortable: false,
        searchable: false,
        render: function (d) {
          var output = ''
          if (!d.deleted_at) {
            output += '<button class="btn btn-danger btnDeleteClient" data-id="' + d.id + '">' +
                '<i class="fa fa-trash-o fa-lg"></i> Desactivar</button>'
            output += '<button class="btn btn-primary btnUpdateClient" data-id="' + d.id + '">' +
              '<i class="fa fa-pencil-square-o fa-lg"></i> Editar</button>'
          } else {
            output += '<button class="btn btn-success btnRestoreClient" data-id="' + d.id + '">' +
              '<i class="fa fa-recycle fa-lg"></i> Restaurar</button>'
          }
          
          return output
        }
      }
    ]
  })

  $('#btnCreateNewClient').on('click', function (event) {
    $('#btnModalUpdateClientSubmit').hide()
    $('#btnModalCreateNewClientSubmit').show()
    $('#modal-title').html('Crear Nuevo Cliente')
    $('#modalCreateNewClient').modal('show')
  })

  $('#btnModalCreateNewClientCancel').on('click', function () {
    $('#modalCreateNewClient').modal('hide')
  })

  $('#modalCreateNewClient').on('hidden.bs.modal', handleModalClose)

  function handleModalClose () {
    $('#formCreateNewClient').trigger('reset')
  }

  $('#btnModalCreateNewClientSubmit').on('click', function () {
    var $form = $('#formCreateNewClient')
    if ($form.valid()) handleSubmit()
  })

  function handleSubmit () {    
    swal({
      title: '¿Confirma el registro del cliente?',
      text: 'El cliente sera registrado en el sistema',
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
      var data = getFormData('#formCreateNewClient')
      if (confirm) {
        handleAjax({
          data,
          url: '/api/clients',
          type: 'POST'
        })
      }
    })    
  }

  function handleAjax (config) {    
    $.ajax({
      url: config.url,
      data: config.data,
      type: config.type,
      dataType: 'json',
      success: function (response) {
        swal(response.title, response.message, 'success')
          .then(function () {
            $('#datatable-index').DataTable().draw()
            $('#modalCreateNewClient').modal('hide')
            swal.close()
          })
      },
      error: handleError
    })
  }

  function getFormData (formId) {
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

  // delete client
  $('#datatable-index').on('click', '.btnDeleteClient', function(e) {
    var clientId = $(e.target).attr('data-id')
    swal({
      title: '¿Confirma la desactivación del cliente?',
      text: 'El cliente sera desactivado del sistema',
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
          url: '/api/clients/' + clientId,
          type: 'DELETE'
        })
      }
    })
  })

  // restaurar client
  $('#datatable-index').on('click', '.btnRestoreClient', function(e) {
    var clientId = $(e.target).attr('data-id')
    swal({
      title: '¿Confirma la restauración del cliente?',
      text: 'El registro del cliente sera restaurado',
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
          url: '/api/clients/' + clientId + '/restore',
          type: 'put'
        })
      }
    })
  })

  // update client
  $('#datatable-index').on('click', '.btnUpdateClient', function (e) {
    var clientId = $(e.target).attr('data-id')
    $('#modalHiddenId').val(clientId)
    $('#btnModalUpdateClientSubmit').show()
    $('#btnModalCreateNewClientSubmit').hide()
    $('#modal-title').html('Editar Cliente')
    getClient(clientId)
  })

  function getClient (clientId) {
    $.ajax({
      url: '/api/clients/' + clientId,
      type: 'GET',
      dataType: 'json',
      success: function (client) {
        populateForm(client)
        $('#modalCreateNewClient').modal('show')
      },
      error: function (err) {
        // TODO error
        console.log(err)
      }
    })
  }

  $('#btnModalUpdateClientSubmit').on('click', function (e) {
    var $form = $('#formCreateNewClient')
    if ($form.valid()) handleUpdate()
  })

  function handleUpdate() {
    swal({
      title: '¿Confirma la actualización del cliente?',
      text: 'El registro del cliente sera actualizado en el sistema',
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
      let clientId = $('#modalHiddenId').val()
      var data = getFormData('#formCreateNewClient')
      if (confirm) {
        handleAjax({
          data,
          url: '/api/clients/' + clientId,
          type: 'PUT'
        })
      }
    })
  }

  function populateForm (client) {
    $('#formCreateNewClient input[name="name"]').val(client.name)
    $('#formCreateNewClient input[name="nit"]').val(client.nit)
    $('#formCreateNewClient input[name="phone"]').val(client.phone)
    $('#formCreateNewClient input[name="email"]').val(client.email)
    $('#formCreateNewClient input[name="address"]').val(client.address)
  }
})