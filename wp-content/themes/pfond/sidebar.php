<?php do_action( 'bp_before_sidebar' ) ?>

<div id="sidebar">
	<div class="padder">

	<?php do_action( 'bp_inside_before_sidebar' ) ?>

	<?php dynamic_sidebar( 'sidebar' ) ?>

	<?php do_action( 'bp_inside_after_sidebar' ) ?>

	</div><!-- .padder -->
</div><!-- #sidebar -->

<?php do_action( 'bp_after_sidebar' ) ?>
