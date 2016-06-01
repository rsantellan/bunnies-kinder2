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
            $('#account-debt-container-' + json.cuentaId).html(json.amount);
            if(json.positive){
              $('#account-panel-container-' + json.cuentaId).fadeOut('slow', function(){ $(this).remove(); });
            }
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
