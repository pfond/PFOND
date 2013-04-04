(function($) {
	$(document).ready(function() {
		// Only able to use if theme is using post class to identify post-id
		/*
		$('.post').each(function() {
			$this = $(this);
			id = $this.attr('id').replace('post-', '');
		});
		*/
		
		//prepopulate fields that need default values (using rel attribute)
		$('.pwddefault').each(function(){
				$(this).val( $(this).attr('rel') );
		});

		// get the comment post id
		$('#comment_post_ID').each(function() {
			$this = $(this);
			pid = $this.val();
		});
		
		// Turn cursor into pointer when over password field
		$('.pwddefault').on( 'mouseover', function(){
			$('.pwddefault').css('cursor', 'pointer');
		}); 
		
		//clear default value and add '.not-empty' class on click
		$('.pwddefault').on( 'focus', function(){
			$.post(sfw_pwd_field.ajaxurl, { action: 'sfw_cpf', post_id : pid }, function( response ) {
				$( '.pwddefault' ).val( response );
				$( '#comment_ready' ).html('<strong>Please leave your comment now.</strong>');
				return false;
			});
			if( $(this).val() == $(this).attr('rel') ){
				$(this).val('').addClass('pwdnotempty');
			}
		});   

		//restore default value and remove '.not-empty' class if left blank after click
		$('.pwddefault').on( 'blur', function(){
			if( $(this).val() =='' ){
			$(this).val( $(this).attr('rel') ).removeClass('pwdnotempty');
			}
		});

		// Grab post-id from hidden comment form field 
		/*$('#comment_post_ID').each(function() {
			$this = $(this);
			pid = $this.val();
		});
		
		$( '#pwdbtn' ).on( 'click', function() {
			$.post(sfw_pwd.ajaxurl, { action: 'sfw_ajax_hook', post_id : pid }, function( response ) {
				$( '#pwdfield' ).val( response );
				$( '#pwdbtn' ).remove();
				$( '#comment_ready' ).html('<strong>Please leave your comment now.</strong>');
				return false;
			});
		});*/
		
		$( '#comment' ).on( 'keydown', function() {
			$.post(sfw_client_ip.ajaxurl, { action: 'sfw_cip' }, function( response ) {
				$( '#comment_ip' ).val( response );
				return false;
			});
		});
	});
})(jQuery);




/* Notes

http://stackoverflow.com/questions/890090/jquery-call-function-after-load
http://api.jquery.com/click/
To put it all together, the following code simulates a click when the document finishes loading:

(function($) {
	$(document).ready(function() {
		$('#button').click();
		then .post ajax request  for most popularar post counter
 	});
})(jQuery);

*/