$(function() {
	
	$( ":submit" ).on('click', function(){
		$(this).addClass('show-loading');
	    $(this).attr('disabled', true);
	});

});