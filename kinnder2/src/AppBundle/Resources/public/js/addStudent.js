$(function () {
  $(".datepicker").datepicker();    
});

function checkAccountNumber(url, accountId)
{
  
  $.ajax({
      url: url,
      data: { account : $('#' + accountId).val()},
      type: 'post',
      dataType: 'json',
      success: function(json){
          toastr.info(json.data);
      }
      , 
      complete: function()
      {
      }
  });
  return false;   
}