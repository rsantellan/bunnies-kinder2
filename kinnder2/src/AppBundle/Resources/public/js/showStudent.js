$(function () {
  $('#parentAddSubmitButton').prop('disabled', true);
  $( "#progenitorautocomplete" ).autocomplete({
    source: $('#progenitorAutocompleteUrl').val(),
    minLength: 2,
    select: function( event, ui ) {
      $('#progenitorAutocompleteRealId').val(ui.item.id);
      $('#parentAddSubmitButton').prop('disabled', false);
      log( ui.item ?
        "Selected: " + ui.item.value + " aka " + ui.item.id :
        "Nothing selected, input was " + this.value );
    }
  });
});


function log( message ) {
  return false;
  $( "<div>" ).text( message ).prependTo( "#log" );
  $( "#log" ).scrollTop( 0 );
}
 
function removeProgenitorFromStudent(element, confirmationText){
    if(confirm(confirmationText)){
      $.ajax({
        url: $(element).attr('href'),
        type: 'post',
        success: function(data){
          if(data.result){
            toastr.info(data.message);
            $('#progenitor-'+data.id).fadeOut('slow', function(){$(this).remove();});
          }else{
            toastr.error(data.message);
          }
        },
        complete: function()
        {
        }
      });
    }
    return false;
}

function addProgenitorToStudent(form){
  $.ajax({
      url: $(form).attr('action'),
      data: $(form).serialize(),
      type: 'post',
      dataType: 'json',
      success: function(json){
        if(json.result){
            toastr.info(json.message);
            $('#progenitorList').append(json.html);
            $('#parentAddSubmitButton').prop('disabled', true);
        }else{
          toastr.error(json.message);
        }

      }
      ,
      complete: function()
      {
        $('#progenitorautocomplete').val('');
      }
  });
  
  return false;
}