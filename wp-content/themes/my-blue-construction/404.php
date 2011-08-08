<?php get_header(); ?>
	<div id="container">
		<?php
			if(my_sidebar_position() == 'left'){
		?>	
				<div id="sidebar">
					<?php get_sidebar(); ?>
				</div>
		<?php		
			}
		?>
		<div id="content">
			<br /><br />
			<h2>Error 404 - Not Found</h2>
		</div>
		<?php
			if(my_sidebar_position() == 'right'){
		?>	
				<div id="sidebar">
					<?php get_sidebar(); ?>
				</div>
		<?php		
			}
		?>
	</div>
<?php get_footer(); ?>