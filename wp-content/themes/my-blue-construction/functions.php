<?php
if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h2 class="sidebartitle">',
        'after_title' => '</h2>',
    ));
	
	
	if ( function_exists('register_nav_menu') ) {
		register_nav_menus(
			array(
				'menu_in_header' => 'menu in header' 
			)
		);
	}
	
	if ( ! isset( $content_width ) ) { 
		$content_width = 540; 
	}
	
	add_theme_support('automatic-feed-links');
	add_theme_support('post-thumbnails');
	
	define('_TITLE_'   ,'We\'re sorry! Our website is now under construction!');
	define('_CONTENT_' ,'Our website is temporarily unavailable. We apologise for the inconvenience. ');
	
	
	
	define('_LIMIT_',8);
	// Align Sidebar
	define('_SIDE_','left');
	
	
	// class nav - menu 
	
	
	//class mythemes_walker_nav_menu extends Walker {
	class mythemes_walker_nav_menu extends Walker {

		var $tree_type = array( 'post_type', 'taxonomy', 'custom' );
		var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );

		var $limit = 5;
		var $rootitemcount = 0;
		var $need_more = false; 
		var $item_type = '';
		
		function __construct($lm) {
				$this -> limit = $lm;
		} 
		
		function start_lvl(&$output, $depth) {
			$indent = str_repeat("\t", $depth);
			$output .= "\n$indent<ul class=\"sub-menu\">\n";
		}

		function end_lvl(&$output, $depth) {
			$indent = str_repeat("\t", $depth);
			$output .= "$indent</ul>\n";
		}

		function start_el(&$output, $item, $depth, $args) {
			
			if($this -> rootitemcount == 0){
				$output .= '<li class="page_item '; 
		
				if(is_home()){ $output .= 'current_page_item'; } 
		
				$output .= ' home_page_item">';
				$output .= ' 	<a href="'.home_url().'/" title="Home">Home</a>';
				$output .= '</li>';
			}
			
			if ($depth == 0){
				$this -> rootitemcount++;
				
				if($this -> limit == $this -> rootitemcount){
					$this -> need_more = true;
					$output .= '<li class="menu-item">';
					$output .= '<a href="#">More..</a>';
					$output .= '<div>';
					$output .= '<ul class="sub-menu">';
				}
			} /**/
			
			
		
			global $wp_query;
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

			$class_names = $value = '';

			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;

			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
			$class_names = ' class="' . esc_attr( $class_names ) . '"';

			$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
			$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

			$output .= $indent . '<li' . $id . $value . $class_names .'>';

			if ( ! empty( $item->post_type ) && $item->post_type == 'nav_menu_item' ) {
				$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
				$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
				$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
				$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
			} else {
				$attributes  = ! empty( $item->post_title ) ? ' title="'  . esc_attr( $item->post_title ) .'"' : '';
				$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
				$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
				$attributes .= ' href= "' . esc_attr( get_permalink( $item->ID ) ) . '"';			 
				$item->title = $item->post_title;
			}


			$item_output = '';
			
			if( !empty ( $args->before ) ) {
				$item_output .= $args->before;
			}
			
			$item_output .= '<a'. $attributes .'>';
			
			if( !empty ( $args->link_before ) ) {
				$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID );
			}else{
				$item_output .= apply_filters( 'the_title', $item->title, $item->ID );
			}
			
			if( !empty ( $args->link_after ) ) {
				$item_output .= $args->link_after;
			}
			
			$item_output .= '</a>';
			
			if( !empty( $args->after ) ){
				$item_output .= $args->after;
			}
			
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}

		function end_el(&$output, $item, $depth) {
			$output .= "</li>\n";
		}
	}
	
			
	function mythemes_menu(){
	
		
		if(my_menu_limit()){
			$limit = my_menu_limit();
		}else{
			$limit = _LIMIT_;
		}

		$my_nav_menu = new mythemes_walker_nav_menu($limit);

		
		$args = array(
			'menu'            => '', 
			'container'       => 'div', 
			'container_class' => 'container', 
			'container_id'    => '', 
			'menu_class'      => 'container', 
			'menu_id'         => '',
			'echo'            => false,
			'fallback_cb'     => '',
			'before'          => '',
			'after'           => '',
			'link_before'     => '',
			'link_after'      => '',
			'depth'           => 0,
			'walker'          => $my_nav_menu,
			'theme_location'  => 'menu_in_header',
		); //menu_in_header
		
		$result = wp_nav_menu( $args );
		
		if(!$result){
			$args['depth'] = -1;
			$my_nav_menu -> db_fields['id'] = 'ID';
			$args['walker'] = $my_nav_menu ;
			$args['fallback_cb'] = 'wp_page_menu';
			$result = wp_nav_menu( $args );
		}
		
		if($my_nav_menu -> need_more){
			$result .="</li></ul></div>";
		}

		echo $result;
	}
	/*
	
		Options  
	*/
	
	// Limit of displayed meniu

	/// add menu to admin --
	if (is_admin()){
		add_action('admin_menu', 'my_theme_options_menu');
		add_action('admin_init', 'my_theme_options_register');
	}
	// whitelist options --
	function my_theme_options_register() {
	
		register_setting('my_home_options_group', 'myfs_title');
		register_setting('my_home_options_group', 'myfs_content');
		
		register_setting('my_home_options_group', 'myfb_is_active_mail_feed');
		register_setting('my_home_options_group', 'myfs_mail_feed');
		
		register_setting('my_social_options_group', 'myfs_twitter');
		register_setting('my_social_options_group', 'myfs_facebook');
		
		register_setting('my_menu_options_group', 'myfi_limit');
		
		register_setting('my_template_options_group', 'myfs_side');
	}
	
	// admin menu page details --
	function my_theme_options_menu() {
		
		add_theme_page('My Theme Options', 'My Theme Options', 'administrator', 'my_home', 'my_home_options_group'); 
		add_theme_page('&nbsp;&nbsp;&raquo; social', '&nbsp;&nbsp;&raquo; social', 'administrator', 'my_social', 'my_social_options_group');
		add_theme_page('&nbsp;&nbsp;&raquo; template', '&nbsp;&nbsp;&raquo; template', 'administrator', 'my_template'  		, 'my_template_options_group');
		add_theme_page('&nbsp;&nbsp;&raquo; menu', '&nbsp;&nbsp;&raquo; menu', 'administrator', 'my_menu', 'my_menu_options_group'  );
		 
		
	}

	
	function my_home_options_group() { ?>
		<style>
			.wrap h2{
				border-bottom:1px solid #CCCCCC;
				padding-bottom:0;
			}
		</style>
		
		<div class="wrap">
			<div id="icon-options-general" class="icon32"><br /></div>
				<h2>
					<a href="?page=my_home" class="nav-tab  nav-tab-active">Home Options</a>
					<a href="?page=my_social" class="nav-tab">Social Options</a>
					<a href="?page=my_template" class="nav-tab">Template Options</a>
					<a href="?page=my_menu" class="nav-tab">Menu Options</a>
				</h2>
			
				<h3>Home Options</h3>
				<p>
					<form method="post" action="options.php">
						<?php settings_fields('my_home_options_group'); ?>
							<table class="form-table" style="margin-top: 20px; padding-bottom: 10px; border: 1px dotted #bbb; border-width:1px 0;">
								<tr valign="top">
									<th scope="row">
										<h3 style="margin-top: 10px;">Alternate heading (Write a title for your page):</h3>
										<p><input type="text"  name="myfs_title" style="width:400px;" value= "<?php if(strlen(get_option('myfs_title')) > 0){ echo get_option('myfs_title'); }else{ echo _TITLE_; } ?>"></p>
									</th>
								</tr>
								<tr valign="top">
									<th scope="row">
										<p>
										<h3>Text from page</h3> 
										(Choose a text for your page <br>
										<b>Basic HTML allowed</b>: <?php echo htmlspecialchars('<strong>text</strong>,').'<br/>'.htmlspecialchars('<a href="http://google.com">link</a></em>text</em>)'); ?>:</p>
										<p>
											<textarea style="width:400px; height:180px;" name="myfs_content"><?php if(strlen(get_option('myfs_content')) > 0){ echo get_option('myfs_content'); }else{ echo _CONTENT_; } ?></textarea>
										</p>

									</th>
								</tr>
		
								<tr valign="top">
									<th scope="row">
										<h3>Mail feed Subscription</h3>
										<p>You want activate subscription <input type="checkbox" value="1" name="myfb_is_active_mail_feed" onchange="if(this.checked){ this.form.myfs_mail_feed.disabled=false;}else{ this.form.myfs_mail_feed.disabled=true; this.form.myfs_mail_feed.value='';}; " <?php if(((int)get_option('myfb_is_active_mail_feed')) > 0) { echo 'checked="checked"'; }?>></p>
										<p>Fill with <b>Google FeedBurner </b> account :</p>
										<p><input type="text" <?php if(((int)get_option('myfb_is_active_mail_feed')) == 0){ ?>disabled="false" <?php } ?>  id="myfs_mail_feed" name="myfs_mail_feed" style="width:400px;" value= "<?php if(strlen(get_option('myfs_mail_feed')) > 0){ echo get_option('myfs_mail_feed'); } ?>"></p>
									</th>
								</tr>
								
							</table>
							<p class="submit">
		
								<!-- PalPay Button Donate -->
								<div style="float:right; display:inline;">
									<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
										<input type="hidden" name="cmd" value="_donations">
										<input type="hidden" name="business" value="S6JD2HALWXNPS">
										<input type="hidden" name="lc" value="RO">
										<input type="hidden" name="currency_code" value="EUR">
										<input type="hidden" name="bn" value="PP-DonationsBF:btn_donate_LG.gif:NonHosted">
										<center><input type="image" style="border:0px" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!"></center>
										<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
									</form>
								</div> 
							
								<input type="submit" class="button-primary" value="Save Changes" />
							</p>
					</form>
				</p>	
			</div>

	<?php 
	}
	
	function my_social_options_group(){ ?>	
	
		<style>
			.wrap h2{
				border-bottom:1px solid #CCCCCC;
				padding-bottom:0;
			}
		</style>
		
		<div class="wrap">
			<div id="icon-options-general" class="icon32"><br /></div>
				<h2>
					<a href="?page=my_home" class="nav-tab">Home Options</a>
					<a href="?page=my_social" class="nav-tab  nav-tab-active">Social Options</a>
					<a href="?page=my_template" class="nav-tab">Template Options</a>
					<a href="?page=my_menu" class="nav-tab">Menu Options</a>
				</h2>
				<h3>Social Options</h3>
				<p>
					<form method="post" action="options.php">
						<?php settings_fields('my_social_options_group'); ?>
							<table class="form-table" style="margin-top: 20px; padding-bottom: 10px; border: 1px dotted #bbb; border-width:1px 0;">
								<tr valign="top">
									<th scope="row">
										<h3 style="margin-top: 10px;">Fill this with your's twitter account</h3>
										 (if you want to display it)
										<p><input type="text"  name="myfs_twitter" style="width:400px;" value= "<?php if(strlen(get_option('myfs_twitter')) > 0){ echo get_option('myfs_twitter'); } ?>"></p>
									</th>
								</tr>
								<tr valign="top">
									<th scope="row">
										<h3 style="margin-top: 10px;">Fill with your's facebook account</h3>
										 (if you want to display it )
										<p><input type="text"  name="myfs_facebook" style="width:400px;" value= "<?php if(strlen(get_option('myfs_facebook')) > 0){ echo get_option('myfs_facebook'); } ?>"></p>
									</th>
								</tr>
							</table>
							<p class="submit">
								<!-- PalPay Button Donate -->
								<div style="float:right; display:inline;">
									<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
										<input type="hidden" name="cmd" value="_donations">
										<input type="hidden" name="business" value="S6JD2HALWXNPS">
										<input type="hidden" name="lc" value="RO">
										<input type="hidden" name="currency_code" value="EUR">
										<input type="hidden" name="bn" value="PP-DonationsBF:btn_donate_LG.gif:NonHosted">
										<center><input type="image" style="border:0px" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!"></center>
										<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
									</form>
								</div> 
							
								<input type="submit" class="button-primary" value="Save Changes" />
							</p>
					</form>
				</p>	
		</div>
		
	<?php 
	}
	
	
	function my_template_options_group(){
	?>
		<style>
			.wrap h2{
				border-bottom:1px solid #CCCCCC;
				padding-bottom:0;
			}
		</style>
		
		<?php
		
			if(get_option('myfs_side')){
				$value = get_option('myfs_side');
			}else{
				$value = _SIDE_;
			}
			
		?>

		<div class="wrap">
		<div id="icon-options-general" class="icon32"><br /></div>

		<!-- Title Page -->
		<h2>
			<a href="?page=my_home" class="nav-tab">Home Options</a>
			<a href="?page=my_social" class="nav-tab">Social Options</a>
			<a href="?page=my_template" class="nav-tab nav-tab-active">Template Options</a>
			<a href="?page=my_menu" class="nav-tab">Menu Options</a>
		</h2>
		<form method="post" action="options.php">
			<?php settings_fields('my_template_options_group'); ?>
			<table class="form-table" style="margin-top: 20px; padding-bottom: 10px; border: 1px dotted #bbb; border-width:1px 0;">
			<tr valign="middle">
				<td colspan="2" align="left">
					Choose the alignment type of the sidebar, in template.
				</td>
			</tr>	
			<tr valign="middle">
				<td width="20%"><strong>In left side :</strong></td>
				<td width="80%">
					<input type="radio" name="myfs_side" value="left" <?php if($value == 'left'){ echo 'checked'; } ?>/><br> 
				</td>
			</tr>
			<tr valign="middle">
				<td width="20%"><strong>In right side :</strong></td>
				<td width="80%">
					<input type="radio" name="myfs_side" value="right" <?php if($value == 'right'){ echo 'checked'; } ?>/><br> 
				</td>
			</tr>
			</table>
		
			<p class="submit">
			
				<!-- PalPay Button Donate -->
				<div style="float:right; display:inline;">
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
						<input type="hidden" name="cmd" value="_donations">
						<input type="hidden" name="business" value="S6JD2HALWXNPS">
						<input type="hidden" name="lc" value="RO">
						<input type="hidden" name="currency_code" value="EUR">
						<input type="hidden" name="bn" value="PP-DonationsBF:btn_donate_LG.gif:NonHosted">
						<center><input type="image" style="border:0px" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!"></center>
						<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
					</form>
				</div> 
			
				<input type="submit" class="button-primary" value="Save Changes" />
			</p>
		</form>
		</div>
	<?php	
	}
	
	function my_menu_options_group() { ?>
		<style>
			.wrap h2{
				border-bottom:1px solid #CCCCCC;
				padding-bottom:0;
			}
		</style>

		<div class="wrap">
		<div id="icon-options-general" class="icon32"><br /></div>

		
		<!-- Title Page -->
		<h2>
			<a href="?page=my_home" class="nav-tab">Home Options</a>
			<a href="?page=my_social" class="nav-tab">Social Options</a>
			<a href="?page=my_template" class="nav-tab">Template Options</a>
			<a href="?page=my_menu" class="nav-tab  nav-tab-active">Menu Options</a>
		</h2>
		<form method="post" action="options.php">
		<?php settings_fields('my_menu_options_group'); ?>
			<table class="form-table" style="margin-top: 20px; padding-bottom: 10px; border: 1px dotted #bbb; border-width:1px 0;">
			
			<tr valign="top">
				<td width="20%"><strong>Limit menu items</strong></td>
				<td width="80%">
					<input type="text" name="myfi_limit" style="width:300px; "value="<?php if(get_option('myfi_limit')){ echo get_option('myfi_limit'); } else { echo _LIMIT_; } ?>"/><br> 
					<small>Max items displayed in menu.</small>
				</td>
			</tr>
			</table>
		
			<p class="submit">
			
				<!-- PalPay Button Donate -->
				<div style="float:right; display:inline;">
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
						<input type="hidden" name="cmd" value="_donations">
						<input type="hidden" name="business" value="S6JD2HALWXNPS">
						<input type="hidden" name="lc" value="RO">
						<input type="hidden" name="currency_code" value="EUR">
						<input type="hidden" name="bn" value="PP-DonationsBF:btn_donate_LG.gif:NonHosted">
						<center><input type="image" style="border:0px" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!"></center>
						<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
					</form>
				</div> 
			
				<input type="submit" class="button-primary" value="Save Changes" />
			</p>
		</form>
		</div>

	<?php 
	}

	

	// custom hook for the posts --
	function my_home() {
		do_action('my_home');
	}

	function my_social() {
		do_action('my_social');
	}
	
	function my_menu() {
		do_action('my_menu');
	}

	function my_template() {
		do_action('my_template');
	}

	// and now for the post output --
	add_action('my_menu'  		, 'my_menu_limit');
	
	add_action('my_template'  	, 'my_sidebar_position');
	
	add_action('my_home', 'my_home_title_out');
	add_action('my_home', 'my_home_content_out');
	add_action('my_home', 'my_is_active_mail_feed');
	add_action('my_home', 'my_mail_feed_out');

	add_action('my_social', 'my_social_twitter_out');
	add_action('my_social', 'my_social_facebook_out');
	

	function my_menu_limit() {
		return get_option('myfi_limit');
	}

	function my_sidebar_position(){
		if(get_option('myfs_side')){
			$result = get_option('myfs_side');
		}else{
			$result = _SIDE_;
		}
		
		return $result;
	}

	function my_home_title_out() {
		echo get_option('myfs_title');
	}

	function my_home_content_out() {
		echo get_option('myfs_content');
	}

	function my_social_twitter_out() {
		echo get_option('myfs_twitter');
	}

	function my_social_facebook_out() {
		echo get_option('myfs_facebook');
	}

	function my_is_active_mail_feed(){
		return (int) get_option('myfb_is_active_mail_feed');
	}
	
	function my_mail_feed_out(){
		echo get_option('myfs_mail_feed');
	}
	
//GsL98DGtpo0W
?>