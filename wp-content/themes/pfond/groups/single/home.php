<?php
if ( !bp_is_group_admin_page() && !bp_is_group_forum() ) {
	wp_redirect( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . 'forum/' );
	exit();
}
?>
<?php get_header() ?>

	<div id="content">
		<div class="padder">
			<?php if ( bp_has_groups() ) : while ( bp_groups() ) : bp_the_group(); ?>

			<?php do_action( 'bp_before_group_home_content' ) ?>
					
			<div id="item-header">
				<?php locate_template( array( 'groups/single/group-header.php' ), true ) ?>
			</div><!-- #item-header -->

			<?php
			global $bp;
			$group_options = $bp->bp_options_nav[$bp->current_component];
			
			$has_admin_option = false;
			foreach ($group_options as $option) {
				if ($option['name'] == 'Admin') {
					$has_admin_option = true;
					break;
				}
			}
			
			// only display the nav bar if current user has admin privileges to this group
			if ($has_admin_option) :?>
				<div id="item-nav">
					<div class="item-list-tabs no-ajax" id="object-nav">
						<ul>
							<?php foreach ($group_options as $option) {
								// only display the forum & admin tabs
								if ($option['name'] != 'Forum' && $option['name'] != 'Admin') continue;
								
								$selected = '';
								if ($option['slug'] == $bp->current_action) {
									$selected = ' class="current"';
								}
								
								echo '<li' . $selected . '><a id="' . $option['css_id'] . '" href="' . $option['link'] . '">' . $option['name'] . '</a></li>';
							} ?>
						</ul>
					</div>
				</div><!-- #item-nav -->
			<?php endif; ?>

			<div id="item-body">
				<?php do_action( 'bp_before_group_body' ) ?>

				<?php if ( bp_is_group_admin_page() && bp_group_is_visible() ) : ?>
					<?php locate_template( array( 'groups/single/admin.php' ), true ) ?>

				<?php elseif ( bp_is_group_forum() && bp_group_is_visible() ) : ?>
					<?php locate_template( array( 'groups/single/forum.php' ), true ) ?>

				<?php else : ?>
					<?php
						/* If nothing sticks, just load a group front template if one exists. */
						locate_template( array( 'groups/single/front.php' ), true );
					?>
				<?php endif; ?>

				<?php do_action( 'bp_after_group_body' ) ?>
			</div><!-- #item-body -->

			<?php do_action( 'bp_after_group_home_content' ) ?>

			<?php endwhile; endif; ?>
		</div><!-- .padder -->
	</div><!-- #content -->

	<?php locate_template( array( 'sidebar.php' ), true ) ?>

<?php get_footer() ?>
