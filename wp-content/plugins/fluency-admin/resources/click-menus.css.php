<?php header('Content-type: text/css'); ?>
#adminmenu {position:absolute;}
#adminmenu li.wp-menu-open .wp-submenu {display:block;}
#adminmenu li div.wp-submenu {position:static;top:inherit;left:inherit;border-top:0px none;}
#adminmenu li div.wp-submenu ul {border:none;-moz-border-radius:0;border-radius:0;padding:0;}
.hiddenMenu #adminmenu li div.wp-submenu ul {border:none;-moz-border-radius:6px;border-radius:6px;padding:6px 0;}
<?php if(!empty($_GET['classic']) &&  $_GET['classic'] == 'true') { ?>
#adminmenu li div.wp-submenu ul {background:#456;}
#adminmenu li div.wp-submenu ul li.current {background:#234;}
.hiddenMenu #adminmenu li div.wp-submenu ul {background:#012;background:rgba(0,16,32,0.9);}
<?php } else if(!empty($_GET['color']) ) { ?>
<?php $custom_color = strip_tags($_GET['color']); ?>
#adminmenu li div.wp-submenu ul {background:#<?php echo $custom_color; ?>;}
#adminmenu li div.wp-submenu ul li {background:#333;background:rgba(0,0,0,0.1);border-bottom:1px solid rgba(0,0,0,0.25) !important;}
#adminmenu li div.wp-submenu ul li.current {background:#262626;background:rgba(0,0,0,0.2) !important;border-bottom:1px solid rgba(0,0,0,0.25) !important;}
#adminmenu li div.wp-submenu ul li.current a.current, #adminmenu li div.wp-submenu ul li a:hover {background:#222;background:rgba(0,0,0,0.3) !important;}
.hiddenMenu #adminmenu li div.wp-submenu ul {background:#111;background:rgba(0,0,0,0.86);}
<?php } else { ?>
#adminmenu li div.wp-submenu ul {background:#464646;}
#adminmenu li div.wp-submenu ul li.current {background:#262626;}
.hiddenMenu #adminmenu li div.wp-submenu ul {background:#111;background:rgba(0,0,0,0.86);}
<?php } ?>
#adminmenu li div.wp-submenu ul li.wp-first-item {border-top-width:0;}
.hiddenMenu #adminmenu li div.wp-submenu ul li.wp-first-item {border-top-width:1px;}
#adminmenu li .wp-submenu a #awaiting-mod, #adminmenu li.current a #awaiting-mod, #adminmenu li a .update-plugins, #adminmenu li.wp-has-submenu a .update-plugins, #adminmenu li.wp-has-submenu a .update-plugins,
#adminmenu li.current a .update-plugins, #adminmenu li.wp-has-current-submenu a .update-plugins, #adminmenu li.wp-has-current-submenu a .update-plugins, #adminmenu li#menu-dashboard a .update-plugins {right:8px;left:auto;}
#adminmenu li.wp-has-submenu .wp-menu-toggle, #adminmenu li.wp-menu-open .wp-menu-toggle {left:0;right:0;width:100%;z-index:100;background-image:url('images/screen-options-right.png');background-position:right center;background-repeat:no-repeat;}
#adminmenu li.wp-has-submenu:hover .wp-menu-toggle, #adminmenu li.wp-menu-open:hover .wp-menu-toggle {background-image:url('images/screen-options-right.png');background-position:right center;background-repeat:no-repeat;}
#adminmenu li.wp-has-submenu .wp-menu-toggle:hover, #adminmenu li.wp-menu-open .wp-menu-toggle:hover {background-image:url('images/screen-options-right.png');background-position:right center;background-repeat:no-repeat;}
#adminmenu li.wp-has-current-submenu.wp-menu-open .wp-menu-toggle, #adminmenu li.wp-has-current-submenu:hover .wp-menu-toggle {background-image:url('images/screen-options-right.png');background-position:right center;background-repeat:no-repeat;}
.hiddenMenu #adminmenu li.wp-has-submenu .wp-menu-toggle, .hiddenMenu #adminmenu li.wp-menu-open .wp-menu-toggle {width:34px;background-image:none;}
.hiddenMenu #adminmenu li.wp-has-submenu:hover .wp-menu-toggle, .hiddenMenu #adminmenu li.wp-menu-open:hover .wp-menu-toggle {background-image:none;}
.hiddenMenu #adminmenu li.wp-has-submenu .wp-menu-toggle:hover, .hiddenMenu #adminmenu li.wp-menu-open .wp-menu-toggle:hover {background-image:none;}
.hiddenMenu #adminmenu li.wp-has-current-submenu.wp-menu-open .wp-menu-toggle, .hiddenMenu #adminmenu li.wp-has-current-submenu:hover .wp-menu-toggle {background-image:none;}
.hiddenMenu #adminmenu li div.wp-submenu {position:absolute;top:-7px;left:42px;border-top:0px none;}
