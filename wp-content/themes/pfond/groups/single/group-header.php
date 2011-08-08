<?php do_action( 'bp_before_group_header' ) ?>

<div id="item-actions">
	<?php if ( bp_group_is_visible() ) : ?>

		<h3><?php _e( 'Group Admins', 'buddypress' ) ?></h3>
		<?php bp_group_list_admins() ?>

		<?php do_action( 'bp_after_group_menu_admins' ) ?>

		<?php if ( bp_group_has_moderators() ) : ?>
			<?php do_action( 'bp_before_group_menu_mods' ) ?>

			<h3><?php _e( 'Group Mods' , 'buddypress' ) ?></h3>
			<?php bp_group_list_mods() ?>

			<?php do_action( 'bp_after_group_menu_mods' ) ?>
		<?php endif; ?>

	<?php endif; ?>
</div><!-- #item-actions -->

<div id="item-header-avatar">
	<a href="<?php echo home_url(bp_get_group_slug()) ?>" title="<?php bp_group_name() ?>">
		<?php bp_group_avatar() ?>
	</a>
</div><!-- #item-header-avatar -->

<div id="item-header-content">
	<h2><a href="<?php echo home_url(bp_get_group_slug()) ?>" title="<?php bp_group_name() ?>"><?php bp_group_name() ?></a></h2>
	<span class="highlight"><?php printf( __( 'Last post: %s ago', 'buddypress' ), bp_get_group_last_active() ) ?></span>

	<?php do_action( 'bp_before_group_header_meta' ) ?>
	
	<?php /*
	<div id="item-meta">
		<?php //bp_group_description() ?>

		<div id="item-buttons">

			<?php do_action( 'bp_group_header_actions' ); ?>

		</div><!-- #item-buttons -->

		<?php do_action( 'bp_group_header_meta' ) ?>
	</div>*/?>
	
</div><!-- #item-header-content -->

<?php do_action( 'bp_after_group_header' ) ?>

<?php do_action( 'template_notices' ) ?>