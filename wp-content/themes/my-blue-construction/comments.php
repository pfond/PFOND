<?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

        if (!empty($post->post_password)) { // if there's a password
            if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
				?>

				<p class="nocomments">This post is password protected. Enter the password to view comments.<p>

				<?php
				return;
            }
        }

		/* This variable is for alternating comment background */
		$oddcomment = 'alt';
?>

<!-- You can start editing here. -->
	<div id="comments">
	<?php 
		if ($comments) { 
	?>
			<h3 class="comments-title"><?php comments_number('No Responses', 'One Response', '% Responses' );?> to &#8220;<?php the_title(); ?>&#8221;</h3> 

			<ol class="comment-list">
				<?php wp_list_comments ( array( 'before' => '<div class="navigation">' . __( 'Comments : ', '' ), 'after' => '</div>' ) ); ?>
			</ol>
	<?php 
			paginate_comments_links( array('prev_text' => '&laquo;', 'next_text' => '&raquo;') );
		}else{ // this is displayed if there are no comments so far 
 
			if ('open' == $post->comment_status) { 
				//<!-- If comments are open, but there are no comments. -->
			}else{ // comments are closed 
		?>
				<!-- If comments are closed. -->
				<?php 
					if(is_page()){
					}else{ 
				?>
					<p class="nocomments">Comments are closed.</p>
				<?php 
					} 
				?>
		<?php 
			} 
		} 

		if ('open' == $post->comment_status) { 
	?>
		<?php 
			if( get_option('comment_registration') && !$user_ID ) { 
		?>
				<p>You must be <a href="<?php echo site_url(); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">logged in</a> to post a comment.</p>
		<?php 
			}else{ 
				
					$format = 'You may use these HTML tags and attributes: <a href="" title=""> <abbr title=""> <acronym title=""> <b> <blockquote cite=""> <cite> <code> <del datetime=""> <em> <i> <q cite=""> <strike> <strong>';
					$format =  htmlspecialchars($format);
					$args = array(
						'comment_field' => '<p class="comment-form-comment">Comment<br /><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
						'comment_notes_after' =>'<p class="comment-field">'.$format.'</p>'
					);
					comment_form($args);
				
			} // If registration required and not logged in 
		} // if you delete this the sky will fall on your head 
	?>
	</div>