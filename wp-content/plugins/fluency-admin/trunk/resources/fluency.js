(function($){

	fluencyZebra = {

		init:function() {

			$('table.form-table tr:even').addClass('even');
			$('table.form-table tr:odd').addClass('odd');

		}

	};

	fluencyClickMenu = {
		init : function() {
			var menu = $('#adminmenu');

			$('.wp-menu-toggle', menu).each( function() {
				var t = $(this), sub = t.siblings('.wp-submenu');
				if ( sub.length )
					t.click(function(){ fluencyClickMenu.toggle( sub ); });
				else
					t.hide();
			});

			this.favorites();

/*
			$('li.wp-menu-separator').remove();
			$('li.wp-menu-separator-last a.separator').text('Hide Menu')
			$('#adminmenu').append($('li.wp-menu-separator-last').remove().clone());
*/
			$('#menu-separator a.separator').text('Hide Menu');
			$('#menu-separator a.separator', menu).click(function(){
				if ( $('body').hasClass('hiddenMenu') ) {
					fluencyHoverMenu.fold(1);
					deleteUserSetting( 'mfold' );
				} else {
					fluencyHoverMenu.fold();
					setUserSetting( 'mfold', 'f' );
				}
				return false;
			});

			if ( $('body').hasClass('folded') ) {
				$('body').addClass('hiddenMenu').removeClass('folded');
				fluencyClickMenu.fold();
			} else if ( $('body').hasClass('hiddenMenu') ) {
				fluencyClickMenu.fold();
			}

			this.restoreMenuState();
		},

		restoreMenuState : function() {
			$('li.wp-has-submenu', '#adminmenu').each(function(i, e) {
				var v = getUserSetting( 'm'+i );
				if ( $(e).hasClass('wp-has-current-submenu') )
					return true; // leave the current parent open

				if ( 'o' == v )
					$(e).addClass('wp-menu-open');
				else if ( 'c' == v )
					$(e).removeClass('wp-menu-open');
			});
		},

		toggle : function(el) {
			var id = el.slideToggle(150, function() {
				el.css('display','');
			}).parent().toggleClass( 'wp-menu-open' ).attr('id');

			if ( id ) {
				$('li.wp-has-submenu', '#adminmenu').each(function(i, e) {
					if ( id == e.id ) {
						var v = $(e).hasClass('wp-menu-open') ? 'o' : 'c';
						setUserSetting( 'm'+i, v );
					}
				});
			}

			return false;
		},

		fold : function(off) {
			if (off) {
				$('body').removeClass('hiddenMenu');
			} else {
				$('body').addClass('hiddenMenu');
			}
		},

		favorites : function() {
			$('#favorite-inside').width( $('#favorite-actions').width() - 4 );
			$('#favorite-toggle, #favorite-inside').bind('mouseenter', function() {
				$('#favorite-inside').removeClass('slideUp').addClass('slideDown');
				setTimeout(function() {
					if ( $('#favorite-inside').hasClass('slideDown') ) {
						$('#favorite-inside').slideDown(100);
						$('#favorite-first').addClass('slide-down');
					}
				}, 200);
			}).bind('mouseleave', function() {
				$('#favorite-inside').removeClass('slideDown').addClass('slideUp');
				setTimeout(function() {
					if ( $('#favorite-inside').hasClass('slideUp') ) {
						$('#favorite-inside').slideUp(100, function() {
							$('#favorite-first').removeClass('slide-down');
						});
					}
				}, 300);
			});
		}
	};

	fluencyHoverMenu = {
		init : function() {

			var menu = $('#adminmenu');

			/* Menu Columns */
			$('#adminmenu li.wp-has-submenu div.wp-submenu ul').each(function(){
				var t = $(this);
				var menu_height = parseInt(t.children().length)*21;
				if((75+(menu_height/2)) > window.innerHeight){
					t.css('width','300%').addClass('clearfix');
					t.children().eq(1).css('borderTop','1px solid #333');
					t.children().eq(2).css('borderTop','1px solid #333');
					t.children().css('width','33.3%').css('float','left');
				} else if((65+menu_height) > window.innerHeight){
					t.css('width','200%').addClass('clearfix');
					t.children().eq(1).css('borderTop','1px solid #333');
					t.children().css('width','50%').css('float','left');
				}
			});

			$('#adminmenu li.wp-has-submenu').hoverIntent({
				over: function(e){
					var m, b, h, o, f;
					m = $(this).find('.wp-submenu');
					b = $(this).offset().top + m.height() + 1; // Bottom offset of the menu
					h = $('#wpwrap').height(); // Height of the entire page
					o = 60 + b - h;
					f = $(window).height() + $(window).scrollTop() - 15; // The fold
					if ( f < (b - o) ) {
						o = b - f;
					}
					if ( o > 1 ) {
						m.css({'marginTop':'-'+o+'px'});
					} else if ( m.css('marginTop') ) {
						m.css({'marginTop':''});
					}
					m.fadeIn('fast');
					$(this).addClass('hover');
				},
				out: function(){ $(this).find('.wp-submenu').fadeOut('fast',function(){$(this).css({'marginTop':''})}); $(this).removeClass('hover'); },
				timeout: 220,
				sensitivity: 8,
				interval: 100
			});

			this.favorites();

/*
			$('li.wp-menu-separator').remove();
			$('li.wp-menu-separator-last a.separator').text('Hide Menu')
			$('#adminmenu').append($('li.wp-menu-separator-last').remove().clone());
*/
			$('#menu-separator a.separator').text('Hide Menu');
			$('#menu-separator a.separator', menu).click(function(){
				if ( $('body').hasClass('hiddenMenu') ) {
					fluencyHoverMenu.fold(1);
					deleteUserSetting( 'mfold' );
				} else {
					fluencyHoverMenu.fold();
					setUserSetting( 'mfold', 'f' );
				}
				return false;
			});

			if ( $('body').hasClass('folded') ) {
				$('body').removeClass('folded'); //.addClass('hiddenMenu')
				fluencyHoverMenu.fold();
			} else if ( $('body').hasClass('hiddenMenu') ) {
				fluencyHoverMenu.fold();
			}

			this.restoreMenuState();
		},

		restoreMenuState : function() {
			$('li.wp-has-submenu', '#adminmenu').each(function(i, e) {
				var v = getUserSetting( 'm'+i );
				if ( $(e).hasClass('wp-has-current-submenu') )
					return true; // leave the current parent open

				if ( 'o' == v )
					$(e).addClass('wp-menu-open');
				else if ( 'c' == v )
					$(e).removeClass('wp-menu-open');
			});
		},

		fold : function(off) {
			if (off) {
				$('body').removeClass('hiddenMenu');
			} else {
				$('body').addClass('hiddenMenu');
			}
		},

		favorites : function() {
			$('#favorite-inside').width( $('#favorite-actions').width() - 4 );
			$('#favorite-toggle, #favorite-inside').bind('mouseenter', function() {
				$('#favorite-inside').removeClass('slideUp').addClass('slideDown');
				setTimeout(function() {
					if ( $('#favorite-inside').hasClass('slideDown') ) {
						$('#favorite-inside').slideDown(100);
						$('#favorite-first').addClass('slide-down');
					}
				}, 200);
			}).bind('mouseleave', function() {
				$('#favorite-inside').removeClass('slideDown').addClass('slideUp');
				setTimeout(function() {
					if ( $('#favorite-inside').hasClass('slideUp') ) {
						$('#favorite-inside').slideUp(100, function() {
							$('#favorite-first').removeClass('slide-down');
						});
					}
				}, 300);
			});
		}
	};

	fluencyKeys = {

		init:function() {

			var cc = new Array();
			cc[0] = $('li#menu-dashboard').children('div.wp-menu-toggle').text('D').siblings('div.wp-submenu').children('ul').children('li'); // d
			cc[1] = $('li#menu-posts').children('div.wp-menu-toggle').text('P').siblings('div.wp-submenu').children('ul').children('li'); // p
			cc[2] = $('li#menu-pages').children('div.wp-menu-toggle').text('G').siblings('div.wp-submenu').children('ul').children('li'); // g
			cc[3] = $('li#menu-media').children('div.wp-menu-toggle').text('M').siblings('div.wp-submenu').children('ul').children('li'); // m
			cc[4] = $('li#menu-links').children('div.wp-menu-toggle').text('L').siblings('div.wp-submenu').children('ul').children('li'); // l
			cc[5] = $('li#menu-comments').children('div.wp-menu-toggle').text('C').siblings('div.wp-submenu').children('ul').children('li'); // c
			cc[6] = $('li#menu-appearance').children('div.wp-menu-toggle').text('A').siblings('div.wp-submenu').children('ul').children('li'); // a
			cc[7] = $('li#menu-plugins').children('div.wp-menu-toggle').text('N').siblings('div.wp-submenu').children('ul').children('li'); // n
			cc[8] = $('li#menu-users').children('div.wp-menu-toggle').text('U').siblings('div.wp-submenu').children('ul').children('li'); // u
			cc[9] = $('li#menu-tools').children('div.wp-menu-toggle').text('T').siblings('div.wp-submenu').children('ul').children('li'); // t
			cc[10] = $('li#menu-settings').children('div.wp-menu-toggle').text('S').siblings('div.wp-submenu').children('ul').children('li'); // s

			var keyArray = new Array('1','2','3','4','5','6','7','8','9','B','E','F','H','I','J','K','O','Q','R','V','W','X','Y','Z');

			for(yy=0;yy<cc.length;yy++){
				var xx = 0;
				$(cc[yy]).each(function(){
					if(keyArray[xx]){
						$(this).append("<em>"+keyArray[xx]+"</em>");
					}
					xx = xx+1;
				});
			}

			var ik = "";
			var i = "";
			var gk = '';

			$(document).keydown(function(event) {

				if(event.shiftKey || event.metaKey || event.ctrlKey || event.altKey) { return true; }

				var el = event.target.tagName;
				var ek = event.which;
				switch(ek){
					case 68: i = $('li#menu-dashboard'); ik = "d"; break; // d
					case 80: i = $('li#menu-posts'); ik = "p"; break; // p
					case 71: i = $('li#menu-pages'); ik = "g"; break; // g
					case 77: i = $('li#menu-media'); ik = "m"; break; // m
					case 76: i = $('li#menu-links'); ik = "l"; break; // l
					case 67: i = $('li#menu-comments'); ik = "c"; break; // c
					case 65: i = $('li#menu-appearance'); ik = "a"; break; // a
					case 78: i = $('li#menu-plugins'); ik = "n"; break; // n
					case 85: i = $('li#menu-users'); ik = "u"; break; // u
					case 84: i = $('li#menu-tools'); ik = "t"; break; // t
					case 83: i = $('li#menu-settings'); ik = "s"; break; // s
				}
				var fk = ek-49;
				if( el == 'INPUT' || el == 'TEXTAREA' ){
					return true;
				} else if(fk>=0 && fk<42) {
					if(fk>15){
						switch(fk){
							case 17: gk = 9; break; // B
							case 20: gk = 10; break; // E
							case 21: gk = 11; break; // F
							case 23: gk = 12; break; // H
							case 24: gk = 13; break; // I
							case 25: gk = 14; break; // J
							case 26: gk = 15; break; // K
							case 30: gk = 16; break; // O
							case 32: gk = 17; break; // Q
							case 33: gk = 18; break; // R
							case 37: gk = 19; break; // V
							case 38: gk = 20; break; // W
							case 39: gk = 21; break; // X
							case 40: gk = 22; break; // Y
							case 41: gk = 23; break; // Z
						}
					} else {
						gk = fk;
					}
					switch(ik){
						case "d": var d = $('li#menu-dashboard div.wp-submenu ul li a'); break;
						case "p": var d = $('li#menu-posts div.wp-submenu ul li a'); break;
						case "g": var d = $('li#menu-pages div.wp-submenu ul li a'); break;
						case "m": var d = $('li#menu-media div.wp-submenu ul li a'); break;
						case "l": var d = $('li#menu-links div.wp-submenu ul li a'); break;
						case "c": var d = $('li#menu-comments div.wp-submenu ul li a'); break;
						case "a": var d = $('li#menu-appearance div.wp-submenu ul li a'); break;
						case "n": var d = $('li#menu-plugins div.wp-submenu ul li a'); break;
						case "u": var d = $('li#menu-users div.wp-submenu ul li a'); break;
						case "t": var d = $('li#menu-tools div.wp-submenu ul li a'); break;
						case "s": var d = $('li#menu-settings div.wp-submenu ul li a'); break;
					}
					if(dd=$(d[gk]).get(0)){ window.location=dd.href; }
				}

				if( el == 'INPUT' || el == 'TEXTAREA' ){
					return true;
				} else if(i) {
					if(i.children('div.wp-submenu').hasClass('open')) {
						var ul = i.children('div.wp-submenu').fadeOut('fast').removeClass('open');
					} else if(i.children('div.wp-submenu').length != 0) {
						$('#adminmenu li.wp-has-submenu.hover').removeClass('hover').children('div.wp-submenu').fadeOut('fast').removeClass('open');
						var w = $(window).get(0).innerHeight;
						var ul = i.children('div.wp-submenu').fadeIn('fast').addClass('open');
						var mh = ul.get(0).offsetHeight;
						var mt = ul.get(0).offsetTop;
						var t = parseInt(w)-((parseInt(mt)+15)+parseInt(mh));
						if(t<0){ul.css('top',parseInt(t)-15);}else if(t>mh){ul.css('top','');}
					} else {
						if(dd=i.children('a').attr('href')){ window.location=dd; }
					}
					i.toggleClass('hover');
					return false;
				} else {
					return true;
				}

			});

		}

	};


	$(document).ready(function(){

		fluencyZebra.init();
		
		$('.form-table input, .form-table select, .form-table textarea').bind('focus',function(){
			$(this).parents('.form-table tr').addClass('selected');
		}).bind('blur',function(){
			$(this).parents('.form-table tr').removeClass('selected');
		});

		// Don't reset this value - change in v2.4
		// $('p.search-box input.button, p#post-search input.button').val('Search');

		// Line 160 wp-admin/js/common.dev.js
		// screen settings tab
		$('#show-settings-link').unbind('click').click(function() {
			if ( $('#contextual-help-wrap').hasClass('contextual-help-open') ) {
				$('#contextual-help-wrap').slideUp('fast',function(){
					$('#contextual-help-link').removeClass('show-settings-link-open');
					$(this).removeClass('contextual-help-open');
				});
			}
			$('#screen-options-wrap').slideToggle('fast', function(){
				if ( $(this).hasClass('screen-options-open') ) {
					$('#show-settings-link').removeClass('show-settings-link-open');
					$(this).removeClass('screen-options-open');
				} else {
					$('#show-settings-link').addClass('show-settings-link-open');
					$(this).addClass('screen-options-open');
				}
			});
			return false;
		});

		// help tab
		$('#contextual-help-link').unbind('click').click(function() {
			if ( $('#screen-options-wrap').hasClass('screen-options-open') ) {
				$('#screen-options-wrap').slideUp('fast',function(){
					$('#show-settings-link').removeClass('show-settings-link-open');
					$(this).removeClass('screen-options-open');
				});
			}
			$('#contextual-help-wrap').slideToggle('fast', function(){
				if ( $(this).hasClass('contextual-help-open') ) {
					$('#contextual-help-link').removeClass('show-settings-link-open');
					$(this).removeClass('contextual-help-open');
				} else {
					$('#contextual-help-link').addClass('show-settings-link-open');
					$(this).addClass('contextual-help-open');
				}
			});
			return false;
		});

	});

	// fixes Akismet iFrame size when accessed from Comments menu.
	$('body.comments_page_akismet-stats-display #akismet-stats-frame').load(function(){
		var height = document.documentElement.clientHeight;
		height -= document.getElementById('akismet-stats-frame').offsetTop;
		height += 100; // magic padding
		document.getElementById('akismet-stats-frame').style.height = height +"px";
	});

	$('#wp-admin-bar-wp-fluency-unhide-menu a').click(function(event){
		event.preventDefault();
		if($(this).hasClass('unhidden')) {
			$('body').addClass('admin_menu_hidden');
			$(this).removeClass('unhidden').text('Unhide Menu');
		} else {
			$('body').removeClass('admin_menu_hidden');
			$(this).addClass('unhidden').text('Hide Menu');
		}
	});

	var farbtastic;

	fluencyFarbtastic = {

		init:function() {

			$(document).ready(function() {
				$('#fluency_custom_color').click(function() {
					$('#fluency_colorPickerDiv').show();
					return false;
				});
				$('#fluency_resetcolor').click(function(event) {
					event.preventDefault();
					$('#fluency_custom_color').val('#');
					$('#fluency_color_sample').css('background-color','');
					return false;
				});

				$('#fluency_custom_color').keyup(function() {
					var _hex = $('#fluency_custom_color').val(), hex = _hex;
					if ( hex.charAt(0) != '#' )
						hex = '#' + hex;
					hex = hex.replace(/[^#a-fA-F0-9]+/, '');
					if ( hex != _hex )
						$('#fluency_custom_color').val(hex);
					if ( hex.length == 4 || hex.length == 7 )
						fluencyFarbtastic.pickColor( hex );
				});

				farbtastic = jQuery.farbtastic('#fluency_colorPickerDiv', function(color) {
					fluencyFarbtastic.pickColor(color);
				});
				fluencyFarbtastic.pickColor($('#fluency_custom_color').val());

				$(document).mousedown(function(){
					$('#fluency_colorPickerDiv').each(function(){
						var display = $(this).css('display');
						if ( display == 'block' )
							$(this).fadeOut(2);
					});
				});
			});

		},

		pickColor:function(color) {
			farbtastic.setColor(color);
			$('#fluency_custom_color').val(color);
			$('#fluency_color_sample').css('background-color',color);
		}

	};

	// $('#fluency_admin_bar_on,#fluency_admin_bar_on_admin,#fluency_admin_bar_off').change(function(){
	// 		if($(this).val()==0) { // Disabled
	// 			$('#fluency_admin_drop_down_off,#fluency_hide_menu_off').attr('checked','checked').attr('disabled','true');
	// 			$('#fluency_admin_drop_down_single,#fluency_admin_drop_down_multiple,#fluency_hide_menu_on').attr('disabled','true');
	// 		} else if($(this).val()==2) { // Front-end + Admin
	// 			var dd = $('#fluency_admin_drop_down_off:checked,#fluency_admin_drop_down_single:checked,#fluency_admin_drop_down_multiple:checked');
	// 			$('#fluency_admin_drop_down_off,#fluency_admin_drop_down_single,#fluency_admin_drop_down_multiple').attr('disabled','');
	// 			if(dd.val()==0) {
	// 				$('#fluency_hide_menu_off,#fluency_hide_menu_on').attr('disabled','true');
	// 			} else {
	// 				$('#fluency_hide_menu_off,#fluency_hide_menu_on').attr('disabled','');
	// 			}
	// 		} else { // Front-end only (default)
	// 			$('#fluency_admin_drop_down_off,#fluency_admin_drop_down_single,#fluency_admin_drop_down_multiple').attr('disabled','');
	// 			$('#fluency_hide_menu_off').attr('checked','checked').attr('disabled','true');
	// 			$('#fluency_hide_menu_on').attr('disabled','true');
	// 		}
	// 	});
	// 	$('#fluency_admin_drop_down_off,#fluency_admin_drop_down_single,#fluency_admin_drop_down_multiple').change(function(){
	// 		if($(this).val()==0) {
	// 			$('#fluency_hide_menu_off').attr('checked','checked').attr('disabled','true');
	// 			$('#fluency_hide_menu_on').attr('disabled','true');
	// 		} else {
	// 			$('#fluency_hide_menu_off,#fluency_hide_menu_on').attr('disabled','');
	// 		}
	// 	});

	$('#fluency_admin_drop_down_off,#fluency_admin_drop_down_single,#fluency_admin_drop_down_multiple').change(function(){
		if($(this).val()==0) {
			$('#fluency_hide_menu_off').attr('checked','checked').attr('disabled','true');
			$('#fluency_hide_menu_on').attr('disabled','true');
		} else {
			$('#fluency_hide_menu_off,#fluency_hide_menu_on').attr('disabled','');
		}
	});

	$('li.ab-wp-fluency-just-write a, a#wp-fluency-just-write').click(function(event){
		event.preventDefault();
		var t = $(this);
		var ed = $('#editorcontainer #content');
		var i = $('#content_ifr');
		if(t.hasClass('is-on')){
			$('body').removeClass('just_write');
			t.removeClass('is-on');
			ed.css('height',ed.attr('data-height'));
			i.css('height',ed.attr('data-height'));
			$(window).unbind('resize');
			t.html('Just Write <small>Click to turn on</small>');
		} else {
			$('body').addClass('just_write');
			t.addClass('is-on');
			var edh = $('body').height()-32-28-74-35-23-60;
			ed.attr('data-height',ed.height()).css('height',edh);
			var ih = $('body').height()-32-28-74-35-21-23-60-28;
			i.attr('data-height',i.height()).css('height',ih);
			t.html('Just Write <small>Click to turn off</small>');
			$(window).resize(function(){
				if($('body').hasClass('just_write')){
					var ed = $('#editorcontainer #content');
					var edh = $('body').height()-32-28-74-35-23-60;
					ed.attr('data-height',ed.height()).css('height',edh);
					var i = $('#content_ifr');
					var ih = $('body').height()-32-28-74-35-21-23-60-28;
					i.attr('data-height',i.height()).css('height',ih);
				}
			});
		}
	});

	$('body.just_write #edButtonPreview, body.just_write #edButtonHTML').click(function(){
		var ed = $('#editorcontainer #content');
		var edh = $('body').height()-32-28-74-35-23-60;
		ed.attr('data-height',ed.height()).css('height',edh);
		var i = $('#content_ifr');
		var ih = $('body').height()-32-28-74-35-21-23-60-28;
		i.attr('data-height',i.height()).css('height',ih);
	});

})(jQuery);