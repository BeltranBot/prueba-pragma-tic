$(function () {
  var idDatatable = '#datatable-index'
  var baseUrl = '/api/pricings'

  // index
  var idBtnCreate = '#btnCreatePricing'

  var deleteClass = 'btnDeletePricing'
  var restoreClass = 'btnRestorePricing'
  var updateClass = 'btnUpdatePricing'

  // modal
  var idModal = '#modalCreatePricing'

  var modalInsertTitle = 'Crear Nueva Cotización'
  var modalEditTitle = 'Editar Cotización'

  var idBtnModalUpdate = '#btnModalUpdatePricingSubmit'
  var idBtnModalCancel = '#btnModalCreatePricingCancel'
  var idBtnModalSubmit = '#btnModalCreatePricingSubmit'

  var idForm = '#formCreatePricing'

  // swal
  var insertTitle = '¿Confirma el registro de la Cotización?'
  var insertText = 'La Cotización sera registrada en el sistema'
  var deleteTitle = '¿Confirma la desactivación de la Cotización?'
  var deleteText = 'La Cotización sera desactivada del sistema'
  var restoreTitle = '¿Confirma la restauración de la Cotización?'
  var restoreText = 'El registro de la Cotización sera restaurado'
  var updateTitle = '¿Confirma la actualización de la Cotización?'
  var updateText = 'El registro de la Cotización sera actualizado en el sistema'

  $(idDatatable).DataTable({
    language: {
      url: '/plugins/DataTables/local/Spanish.json'
    },
    processing: true,
    serverSide: true,
    sortable: true,
    ajax: baseUrl,
    scrollX: true,
    searching: false,
    sort: false,
    columns: [
      { data: 'id', name: 'id' },
      { data: 'pricing_type_name', name: 'pricing_type_name' },
      { data: 'client_name', name: 'client_name' },
      { data: 'printer_model', name: 'printer_model' },
      { data: 'operator_name', name: 'operator_name' },
      { data: 'operator_hour_cost', name: 'operator_hour_cost' },
      { data: 'paper_name', name: 'paper_name' },
      { data: 'pricing_paper_cost', name: 'pricing_paper_cost' },
      { data: 'pricing_tag_width', name: 'pricing_tag_width' },
      { data: 'pricing_tag_height', name: 'pricing_tag_height' },
      { data: 'pricing_printing_time', name: 'pricing_printing_time' },
      { data: 'quantities', name: 'quantities', searchable: false, sortable: false },
      { data: 'estado', name: 'estado', searchable: false, sortable: false },
      {
        data: null,
        name: null,
        sortable: false,
        searchable: false,
        render: function (d) {
          var output = '<a href="/pricings/ ' + d.id + '" class="btn btn-info">' +
              '<i class="fa fa-eye fa-lg"></i> Ver</a>'
          // if (!d.deleted_at) {
          //   output += '<button class="btn btn-danger ' + deleteClass + '" data-id="' + d.id + '">' +
          //     '<i class="fa fa-trash-o fa-lg"></i> Desactivar</button>'
          //   output += '<button class="btn btn-primary ' + updateClass + '" data-id="' + d.id + '">' +
          //     '<i class="fa fa-pencil-square-o fa-lg"></i> Editar</button>'
          // } else {
          //   output += '<button class="btn btn-success ' + restoreClass + '" data-id="' + d.id + '">' +
          //     '<i class="fa fa-recycle fa-lg"></i> Restaurar</button>'
          // }
          return output
        }
      }
    ]
  })

  $(idBtnCreate).on('click', function (event) {
    $(idBtnModalUpdate).hide()
    $(idBtnModalSubmit).show()
    $('#modal-title').html(modalInsertTitle)
    custom()
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
    if ($form.valid()) {
      var tags = $('input[name=quantities]').tagsinput('items')
      if (tags.length === 0) {
        swal('Error', 'Debe ingresar Al menos una cantidad de etiquetas', 'error')
      } else {
        handleSubmit()
      }
    }
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
    data['quantities'] = $('input[name=quantities]').tagsinput('items')
    if (!Array.isArray(data['quantities'])) {
      data['quantities'] = [$('input[name=quantities]').tagsinput('items')]
    }
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

  // delete pricing
  $(idDatatable).on('click', '.' + deleteClass, function (e) {
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

  // update pricing
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

  // custom

  function custom () {
    initializeFields()
  }

  $('select[name="printing_type_id"').on('change', function (e) {
    var printing_type_id = +$(e.target).val()
    if (printing_type_id) {
      showingFields(printing_type_id)
    } else {
      initializeFields()
    }
  })

  function showingFields (type) {

    $('.hideGroup0').show()
    $('.hideGroup1').show()
    $('.hideGroup1 select').prop('required', true)
    $('.hideGroup1 input').prop('required', true)

    if (type === 1) {
      hideGroup(2)
      hideGroup(3)
    } else {
      $('.hideGroup2').show()
      $('.hideGroup2 select').prop('required', true)
      $('.hideGroup2 input').prop('required', true)

      if (type === 3) {
        $('.hideGroup3').show()
        $('.hideGroup3 select').prop('required', true)
        $('.hideGroup3 input').prop('rxequired', true)
        hideGroup(4)
      } else {
        $('.hideGroup4').show()
        $('.hideGroup4 select').prop('required', true)
        $('.hideGroup4 input').prop('required', true)
      }
    }
  }

  function initializeFields() {
    hideGroup(0)
    hideGroup(1)
    hideGroup(2)
    hideGroup(3)
    hideGroup(4)
  }

  function hideGroup (n){
    $('.hideGroup' + n).hide()
    $('.hideGroup' + n + ' select').val('')
    $('.hideGroup' + n + ' select').removeAttr('required')
    $('.hideGroup' + n + ' input').val('')
    $('.hideGroup' + n + ' input').removeAttr('required')
  }

  function populateForm(item) {
    $(idForm + ' input[name="name"]').val(item.name)
    $(idForm + ' input[name="hour_cost"]').val(item.hour_cost)
  }

  $('input[name=quantities]').on('beforeItemAdd', function (event) {
    var item = +event.item
    if (!item || !Number.isInteger(item) || item === 0) event.cancel = true
  });
})