jQuery(document).ready(function($){

	$('a[name=modal-login]').fancybox({
		'transitionIn'		: 'fade',
		'transitionOut'		: 'none',
		'centerOnScroll'	: true,
		'showCloseButton'	: true,
		'overlayOpacity'	: 0.5,
		'padding'			: 0
	});
 
/*
    //select all the a tag with name equal to modal
    $('a[name=modal]').click(function(e) {
		
        //Cancel the link behavior
        e.preventDefault();
        //Get the A tag
        var id = $(this).attr('href');
         
        //transition effect     
        $('#mask').fadeIn("fast");
		$('#mask').fadeTo("fast", 0.8);
     
        //transition effect
        $(id).fadeIn("fast"); 
     
    });
	
	//if close button is clicked
    $('#login-window .close').click(function (e) {
        //Cancel the link behavior
        e.preventDefault();
        $('#mask, #login-window').hide();
    });
     
    //if mask is clicked
    $('#mask').click(function () {
        $(this).hide();
        $('#login-window').hide();
    });
	
	$(document).keyup(function(e) {
		// ENTER = 13, ESCAPE = 27
		if(e.keyCode == 13 || e.keyCode == 27) {
			$('#mask').hide();
			$('#login-window').hide();
		}
	});
	*/
     
});