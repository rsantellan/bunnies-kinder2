function sendAddDetalleFacturaModal(element){
      $.ajax({
          url: $(element).attr('href'),
          success: function(data){
            $('#addFacturaDetalleBody').html(data.html);
            $('#addFacturaDetalleModal').modal('show');
          },
          complete: function()
          {
          }
      });
      return false;
}

function saveFacturaForm(form)
{
  $.ajax({
      url: $(form).attr('action'),
      data: $(form).serialize(),
      type: 'post',
      dataType: 'json',
      success: function(json){
        if(json.result){
            toastr.info(json.message);
            $('#addFacturaDetalleModal').modal('hide');

        }else{
          toastr.error(json.message);
          $('#addFacturaDetalleBody').html(data.html);
        }

      }
      ,
      complete: function()
      {
      }
  });
  return false;
}

function sendAddCobroModal(element){
      $.ajax({
          url: $(element).attr('href'),
          success: function(data){
            $('#addCobroModalBody').html(data.html);
            $('#addCobroModal').modal('show');
            $(".datepicker").datepicker();
          },
          complete: function()
          {
          }
      });
      return false;
}

function saveCobroForm(form)
{
  $.ajax({
      url: $(form).attr('action'),
      data: $(form).serialize(),
      type: 'post',
      dataType: 'json',
      success: function(json){
        if(json.result){
            toastr.info(json.message);
            $('#addCobroModal').modal('hide');
            $('#accordion').prepend(json.html);
            $('#cuenta-dash-amount-circle').removeClass( "bg-danger bg-success");
            if(json.positive){
              $('#cuenta-dash-amount-circle').addClass('bg-success');
            }else{
              $('#cuenta-dash-amount-circle').addClass('bg-danger');
            }
            $('#cuenta-dash-amount').html(json.amount);
        }else{
          toastr.error(json.message);
          $('#addCobroModalBody').html(data.html);
          $(".datepicker").datepicker();
        }

      }
      ,
      complete: function()
      {
      }
  });
  return false;
}

function cancelOrActivateCobro(cobroId, element, confirmationText)
{
  if(confirm(confirmationText))
  {
	  $.ajax({
		url: $(element).attr('href'),
		dataType: 'json',
    type: 'post',
		success: function(json){
      if(json.result){
          toastr.info(json.message);
          $('#cobro-panel-' + cobroId).replaceWith(json.html);
          //$('#accordion').prepend(json.html);
          $('#cuenta-dash-amount-circle').removeClass( "bg-danger bg-success");
          if(json.positive){
            $('#cuenta-dash-amount-circle').addClass('bg-success');
          }else{
            $('#cuenta-dash-amount-circle').addClass('bg-danger');
          }
          $('#cuenta-dash-amount').html(json.amount);

          $.each(json.facturas, function(i, item){
            $('#factura-panel-' + item.id).replaceWith(item.html);
          });
      }else{
        toastr.error(json.message);
      }
		},
		complete: function()
		{
		}
	  });
  }
  return false;
}

function cancelOrActivateFactura(facturaId, element, confirmationText)
{
  if(confirm(confirmationText))
  {
	  $.ajax({
		url: $(element).attr('href'),
		dataType: 'json',
    type: 'post',
		success: function(json){
      if(json.result){
          toastr.info(json.message);
          $('#factura-panel-' + facturaId).replaceWith(json.html);
          //$('#accordion').prepend(json.html);
          $('#cuenta-dash-amount-circle').removeClass( "bg-danger bg-success");
          if(json.positive){
            $('#cuenta-dash-amount-circle').addClass('bg-success');
          }else{
            $('#cuenta-dash-amount-circle').addClass('bg-danger');
          }
          $('#cuenta-dash-amount').html(json.amount);
      }else{
        toastr.error(json.message);
      }
		},
		complete: function()
		{
		}
	  });
  }
  return false;
}
