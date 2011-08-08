<?php get_header() ?>

	<div id="content">
		<div class="padder">

		<div class="page" id="expert-single">

			<?php if (have_posts()) : while (have_posts()) : the_post();
			$contact = get_post_meta(get_the_ID(), "expert-contact", true);
			$website = get_post_meta(get_the_ID(), "expert-link", true);
			?>

				<div class="post" id="expert-<?php the_ID(); ?>">
				
					<h2 class="posttitle"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ) ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

					<div class="expertmetadata">
						<div class="portrait"></div>
						Contact: <a href="mailto:<?php echo $contact ?>"><?php echo $contact ?></a><br />
						Website: <a href="<?php echo $website ?>" target="_blank"><?php echo $website ?></a><br />
						<?php pfond_get_terms(get_the_ID(), "Location", "location") ?><br />
						<?php pfond_get_terms(get_the_ID(), "Specializations", "specialization") ?>
					</div>

					<?php the_content(); ?>
					
					<p class="postmetadata"><span class="comments"><?php comments_popup_link( __( 'No Comments &#187;', 'buddypress' ), __( '1 Comment &#187;', 'buddypress' ), __( '% Comments &#187;', 'buddypress' ) ); ?></span></p>

				</div>

			<?php comments_template(); ?>

			<?php endwhile; else: ?>

				<p><?php _e( 'Sorry, no posts matched your criteria.', 'buddypress' ) ?></p>

			<?php endif; ?>

		</div>

		</div><!-- .padder -->
	</div><!-- #content -->

	<?php locate_template( array( 'sidebar.php' ), true ) ?>

<?php get_footer() ?>