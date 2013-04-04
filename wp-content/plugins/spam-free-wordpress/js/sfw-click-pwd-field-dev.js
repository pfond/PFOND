(function($) {
	$(document).ready(function() {
		// prepopulate fields that need default values (using rel attribute)
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
		
		// clear default value and add '.not-empty' class on click
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

		// get remote IP address
		$( '#comment' ).on( 'keydown', function() {
			$.post(sfw_client_ip.ajaxurl, { action: 'sfw_cip' }, function( response ) {
				$( '#comment_ip' ).val( response );
				return false;
			});
		});
	});
})(jQuery);