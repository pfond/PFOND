<?php header('Content-type: text/css'); ?>
<?php $custom_color = strip_tags($_GET['color']); ?>

#wpwrap {border-left:140px solid #<?php echo $custom_color; ?>;}
#adminmenu {background:#<?php echo $custom_color; ?> url('images/custom/fluency2.png') no-repeat top left;}
.hiddenMenu #adminmenu {background-image:url('images/custom/hidden-fluency2.png');}
#adminmenu .menu-top-last a.menu-top {background:url('images/custom/menu-item-bg.png') no-repeat bottom left;}
/*#adminmenu a:hover, #adminmenu div.wp-submenu ul a:hover, #adminmenu a:active, #adminmenu div.wp-submenu ul a:active, #adminmenu a:focus, #adminmenu div.wp-submenu ul a:focus {color:#FFF !important;}*/
#adminmenu li {background-color:#<?php echo $custom_color; ?> ;}
.hiddenMenu #adminmenu li.wp-first-item, .hiddenMenu #adminmenu li.wp-has-submenu, .hiddenMenu #adminmenu li.menu-top.menu-top-last {background:transparent url('images/custom/menu-item-bg.png') no-repeat scroll bottom left;}
/*#adminmenu li.wp-menu-separator-last {background:transparent url('images/custom/menu-arrows.png') no-repeat scroll left top;}*/
/*#adminmenu li div.wp-menu-image {background-image:url('images/custom/menu.png') !important;}*/
#adminmenu li a.wp-has-submenu, #adminmenu li.menu-top-first a.wp-has-submenu, #adminmenu li a.menu-top {border:0px none transparent;background:url('images/custom/menu-item-bg.png') no-repeat bottom left;}
/*#adminmenu li.hover a.wp-has-submenu, #adminmenu li.menu-top-first.hover a.wp-has-submenu, #adminmenu li.hover a.menu-top {background-position:right bottom;}*/
#adminmenu li a.wp-has-current-submenu #adminmenu li.menu-top-first a.wp-has-current-submenu {border:0px none transparent;}
#adminmenu li.wp-has-current-submenu a.wp-has-current-submenu, #adminmenu li.menu-top > a.current {background:rgba(0,0,0,0.2) url('images/custom/menu-item-bg.png') no-repeat bottom left;}
#adminmenu li .wp-menu-toggle {color:rgba(255,255,255,0.3);}
#adminmenu li.wp-has-submenu .wp-menu-toggle, #adminmenu li.wp-menu-open .wp-menu-toggle {background:transparent url('images/custom/menu-bits.png') repeat-x scroll 8px -45px;}
.hiddenMenu #adminmenu li.wp-has-submenu .wp-menu-toggle, .hiddenMenu #adminmenu li.wp-menu-open .wp-menu-toggle {color:transparent;background:transparent url('images/custom/hidden-menu-bits.png') repeat-x scroll -8px -45px;}
.hiddenMenu #adminmenu li .wp-menu-toggle, .hiddenMenu #adminmenu li.wp-has-submenu .wp-menu-toggle, .hiddenMenu #adminmenu li.wp-menu-open .wp-menu-toggle {color:transparent;width:6px;background:transparent url('images/custom/hidden-menu-bits.png') repeat-x scroll -8px -45px;}
#adminmenu li.wp-has-current-submenu a.wp-has-current-submenu:hover, #adminmenu li.menu-top > a.current:hover {background:rgba(0,0,0,0.2) url('images/custom/menu-item-bg.png') no-repeat bottom left;}
#adminmenu li.wp-has-current-submenu.hover a.wp-has-current-submenu, #adminmenu li.menu-top.hover > a.current {background:rgba(0,0,0,0.2) url('images/custom/menu-item-bg.png') no-repeat bottom left;}
#adminmenu li.menu-top:hover, #adminmenu li.menu-top.hover {background:rgba(0,0,0,0.2) url('images/custom/menu-item-bg.png') no-repeat bottom left;}
#adminmenu li.wp-has-submenu.hover .wp-menu-toggle, #adminmenu li.wp-has-submenu:hover .wp-menu-toggle {background:transparent url('images/custom/menu-bits.png') no-repeat scroll 8px -112px;}
.hiddenMenu #adminmenu li.wp-has-submenu.hover .wp-menu-toggle, .hiddenMenu #adminmenu li.wp-has-submenu:hover .wp-menu-toggle {background:transparent url('images/custom/hidden-menu-bits.png') no-repeat scroll -8px -112px;}
#adminmenu li.wp-first-item.current, #adminmenu li.wp-has-current-submenu {background:rgba(0,0,0,0.1) url('images/custom/menu-item-bg.png') no-repeat bottom left;}
.hiddenMenu #adminmenu li.wp-first-item.current, .hiddenMenu #adminmenu li.wp-has-current-submenu, .hiddenMenu #adminmenu li.current {background:rgba(0,0,0,0.2) url('images/custom/menu-item-bg.png') no-repeat bottom left !important;}
#adminmenu li.wp-has-current-submenu .wp-menu-toggle {background:transparent url('images/custom/menu-bits.png') no-repeat scroll 8px -112px;}
.hiddenMenu #adminmenu li.wp-has-current-submenu .wp-menu-toggle {background:transparent url('images/custom/hidden-menu-bits.png') no-repeat scroll -8px -112px;}
#adminmenu li.wp-has-current-submenu.wp-menu-open .wp-menu-toggle, #adminmenu li.wp-has-current-submenu:hover .wp-menu-toggle {background:transparent url('images/custom/menu-bits.png') no-repeat scroll 8px -112px;}
.hiddenMenu #adminmenu li.wp-has-current-submenu.wp-menu-open .wp-menu-toggle, .hiddenMenu #adminmenu li.wp-has-current-submenu:hover .wp-menu-toggle {background:transparent url('images/custom/hidden-menu-bits.png') no-repeat scroll -8px -112px;}
.hiddenMenu #adminmenu li.wp-has-submenu.hover, .hiddenMenu #adminmenu li.wp-first-item.current.hover, .hiddenMenu #adminmenu li.wp-has-current-submenu.hover {background-position:bottom left !important;}
.hiddenMenu #adminmenu li.menu-top.menu-top-last:hover, .hiddenMenu #adminmenu li.menu-top.menu-top-last.hover {background-color:rgba(0,0,0,0.2);}
.hiddenMenu #adminmenu li.menu-top.menu-top-last.hover {background-position:-106px bottom !important;width:42px;}
#adminmenu .menu-top-single a.wp-has-submenu, #adminmenu.folded li.menu-top-single {border:0px none;}
#adminmenu .menu-top-last a.wp-has-submenu, #adminmenu.folded li.menu-top-last {border-bottom:0 none;}
.hiddenMenu #adminmenu li.wp-first-item, .hiddenMenu #adminmenu li.wp-has-submenu, .hiddenMenu #adminmenu li.menu-top.menu-top-last, .hiddenMenu #adminmenu li.menu-top {width:34px;background:transparent url('images/custom/menu-item-bg.png') no-repeat scroll left bottom;}


#footer {border-left:140px solid #<?php echo $custom_color; ?>;}

/*
#adminmenu li div.wp-submenu ul {background:rgba(0,16,32,0.9);}
*:first-child+html #adminmenu li div.wp-submenu ul {background:#234;}
#adminmenu li div.wp-submenu ul li {border-bottom:1px solid #345;}
#adminmenu li div.wp-submenu ul li.wp-first-item {border-top:1px solid #345;}
#adminmenu li div.wp-submenu ul li a {color:#F6F9FF;}
#adminmenu li div.wp-submenu ul li a:hover {background:rgba(0,16,32,0.9) !important;color:#FFF !important;}
*:first-child+html #adminmenu li div.wp-submenu ul li a:hover {background:#012 !important;}
#adminmenu li div.wp-submenu ul li.current, .hiddenMenu #adminmenu li div.wp-submenu ul li.current {background:#012 !important	;color:#FFFFFF;}
#adminmenu .wp-submenu li.current, #adminmenu .wp-submenu li.current a, #adminmenu .wp-submenu li.current a:hover, #adminmenu .wp-submenu .current a.current {background:#012;color:#FFFFFF;border-color:#234 !important;}
#adminmenu li.wp-has-current-submenu a.wp-has-submenu {color:#FFFFFF;}
#adminmenu li div.wp-submenu ul li em {color:#456;}
*/