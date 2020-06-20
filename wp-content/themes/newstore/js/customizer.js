/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	
	wp.customize( 'newstore_blog_content_width', function( value ) {
		value.bind( function( to ) {
			var total = 100;
			var sidebar_width = total - to;
			$( 'main#main.site-main' ).css({
				'-ms-flex': '0 0 '+to+'%',
			    'flex': '0 0 '+to+'%',
			    'max-width': to+'%',
			});

			$( 'aside#secondary.sidebar-widget-area' ).css({
				'-ms-flex': '0 0 '+sidebar_width+'%',
			    'flex': '0 0 '+sidebar_width+'%',
			    'max-width': sidebar_width+'%',
			});
			
		});
	});
	

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( '.site-title a, .site-description' ).css( {
					'color': to
				} );
			}
		} );
	} );

	wp.customize( 'newstore_site_content_width', function( value ) {
		value.bind( function( to ) {
			// console.log('asdf')
			var oth = to-200;
			var style = "@media (min-width:1200px){.container{max-width:"+oth+"px !important;}} @media (min-width:1400px){.container{max-width:"+to+"px !important;}}";
            if ($('#newstore_site_content_width-style-css').length) {
                $('#newstore_site_content_width-style-css').html(style);
            } else {
                $('body').prepend('<style id="newstore_site_content_width-style-css">'+style+'</style>');
            }
		});
	});

	wp.customize( 'newstore_site_layout_type', function( value ) {
		value.bind( function( to ) {
			$('body').removeClass('boxed');
			$('body').removeClass('full');
			$('body').addClass(to);
		});
	});

	wp.customize( 'newstore_theme_primary_color', function( value ) {
		value.bind( function( to ) {
			var style = "a, a:hover, a:focus { color: "+to+"; } a:hover { color: "+to+"; } .btn-theme-border { border: 1px solid "+to+"; } .widget ul li:hover a, .widget ul li:hover:before { color: "+to+"; } .calendar_wrap caption { background-color: "+to+"; } .calendar_wrap tfoot td:hover, .calendar_wrap tfoot td:hover a, .calendar_wrap tbody td:hover { color: "+to+"; } .calendar_wrap td a:hover { color: "+to+"; } .cart-link-contents span.count, .wishlist-link-contents span.count { background-color: "+to+"; } .entry-title.post-title a:hover { color: "+to+"; } .post-meta-item:hover i, .post-meta-item:hover a { color: "+to+"; } .woocommerce-page div.product div.summary a.button.add_to_wishlist { background-color: "+to+"; } .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button { background-color: "+to+"; } .woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover { background-color: "+to+"; } .woocommerce #respond input#submit.disabled:hover, .woocommerce #respond input#submit:disabled:hover, .woocommerce #respond input#submit:disabled[disabled]:hover, .woocommerce a.button.disabled:hover, .woocommerce a.button:disabled:hover, .woocommerce a.button:disabled[disabled]:hover, .woocommerce button.button.disabled:hover, .woocommerce button.button:disabled:hover, .woocommerce button.button:disabled[disabled]:hover, .woocommerce input.button.disabled:hover, .woocommerce input.button:disabled:hover, .woocommerce input.button:disabled[disabled]:hover { background-color: "+to+"; } #scroll-top { background-color: "+to+"9c; border: 1px solid "+to+"; } .product-van-heading { background-color: "+to+"; } .btn-main-slide { background-color: "+to+"; } .woocommerce ul.products li.product .onsale, .woocommerce span.onsale{background-color: "+to+";}";
            if ($('#newstore_theme_primary_color-style-css').length) {
                $('#newstore_theme_primary_color-style-css').html(style);
            } else {
                $('body').append('<style id="newstore_theme_primary_color-style-css">'+style+'</style>');
            }
		});
	});

	wp.customize( 'newstore_theme_link_color', function( value ) {
		value.bind( function( to ) {
			var style = "a{ color: "+to+"; }";
            if ($('#newstore_theme_link_color-style-css').length) {
                $('#newstore_theme_link_color-style-css').html(style);
            } else {
                $('body').append('<style id="newstore_theme_link_color-style-css">'+style+'</style>');
            }
		});
	});

	wp.customize( 'newstore_theme_link_hover_color', function( value ) {
		value.bind( function( to ) {
			var style = "a:hover, a:focus { color: "+to+"; }";
            if ($('#newstore_theme_link_hover_color-style-css').length) {
                $('#newstore_theme_link_hover_color-style-css').html(style);
            } else {
                $('body').append('<style id="newstore_theme_link_hover_color-style-css">'+style+'</style>');
            }
		});
	});

	wp.customize( 'newstore_theme_post_title_color', function( value ) {
		value.bind( function( to ) {
			var style = ".entry-title.post-title a { color: "+to+" !important; }";
            if ($('#newstore_theme_post_title_color-style-css').length) {
                $('#newstore_theme_post_title_color-style-css').html(style);
            } else {
                $('body').append('<style id="newstore_theme_post_title_color-style-css">'+style+'</style>');
            }
		});
	});

	wp.customize( 'newstore_theme_post_title_hover_color', function( value ) {
		value.bind( function( to ) {
			var style = ".entry-title.post-title a:hover { color: "+to+" !important; }";
            if ($('#newstore_theme_post_title_hover_color-style-css').length) {
                $('#newstore_theme_post_title_hover_color-style-css').html(style);
            } else {
                $('body').append('<style id="newstore_theme_post_title_hover_color-style-css">'+style+'</style>');
            }
		});
	});

	wp.customize( 'newstore_theme_post_meta_color', function( value ) {
		value.bind( function( to ) {
			var style = ".post-meta-item i, .post-meta-item a { color: "+to+" !important; }";
            if ($('#newstore_theme_post_meta_color-style-css').length) {
                $('#newstore_theme_post_meta_color-style-css').html(style);
            } else {
                $('body').append('<style id="newstore_theme_post_meta_color-style-css">'+style+'</style>');
            }
		});
	});

	wp.customize( 'newstore_theme_post_meta_hover_color', function( value ) {
		value.bind( function( to ) {
			var style = ".post-meta-item:hover i, .post-meta-item:hover a { color: "+to+" !important; }";
            if ($('#newstore_theme_post_meta_hover_color-style-css').length) {
                $('#newstore_theme_post_meta_hover_color-style-css').html(style);
            } else {
                $('body').append('<style id="newstore_theme_post_meta_hover_color-style-css">'+style+'</style>');
            }
		});
	});

} )( jQuery );
