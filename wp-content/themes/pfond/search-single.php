<?php get_header();?>
        <div id="content">
			<div class="padder">
			
				<p>Showing results for: <em><?php echo $_REQUEST['mssearch'] ?></em><p>
			
				<div class="post-search-result search-result">
					<h3 class="content-title"><?php _e("Post Results","bpmag");?></h3>
					<?php if (function_exists(ms_global_search_page)) { ms_global_search_page(array( 'excerpt' => 'yes' )); } ?>
				</div>
				
				<?php do_action("advance-search");//this is the only line you need?>
				<!-- let the search put the content here -->
								   
			</div> <!-- end of padder... -->
			<div class="clear"> </div>
        </div><!-- Container ends here... -->
        <?php locate_template( array( 'sidebar.php' ), true ) ?>
  <?php get_footer();?>