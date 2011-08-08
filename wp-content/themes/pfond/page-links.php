<?php
/*
Template Name: Links Page
*/
?>
<?php get_header() ?>

	<div id="content">
		<div class="padder">

		<div class="page" id="links-page">
		
			<h1>Helpful Links</h1>
		
			<?php
			$bookmarks = get_bookmarks(array(
				'orderby' => 'updated',
				'order' => 'DESC',
				'limit' => -1,
				'category_name' => 'Helpful Links',
				'categorize' => 0,
				'show_updated' => 1
			));
			
			foreach ($bookmarks as $bm) {
			?>
				<div class="bookmark" id="link-<?php echo $bm->link_id ?>">
					<a href="<?php echo $bm->link_url ?>" target="_blank">
						<h2><?php echo $bm->link_name ?><?php if (current_time('timestamp') - $bm->link_category_f > 432000): ?><span class="alert">New</span><?php endif; ?></h2>
						<div><?php echo $bm->link_description ?></div>
					</a>
				</div>
			<?php
			}
			?>
			
		</div><!-- .page -->
				
		</div><!-- .padder -->
	</div><!-- #content -->
	
	<?php locate_template( array( 'sidebar.php' ), true ) ?>

<?php get_footer(); ?>
