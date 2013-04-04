(function($) {
	$(document).ready(function() {
		// get the comment post id
		$('#comment_post_ID').each(function() {
			$this = $(this);
			pid = $this.val();
		});
		
		//clear default value and add '.not-empty' class on click
		$('#comment').on( 'focus', function(){
			$.post(sfw_ipwd.ajaxurl, { action: 'sfw_i_pwd', post_id : pid }, function( response ) {
				$( '.pwddefault' ).val( response );
				$( '#comment_ready' ).html('<strong>Please leave your comment now.</strong>');
				return false;
			});
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