jQuery(document).ready(function ($) {

	submenu_alignment = false;

	// Enable menu toggle for small screens
	(function() {
		var nav = $( '#primary-navigation' ), button, menu;
		if ( ! nav ) {
			return;
		}

		button = nav.find( '.menu-toggle' );
		if ( ! button ) {
			return;
		}

		// Hide button if menu is missing or empty.
		menu = nav.find( '.nav-menu' );
		if ( ! menu || ! menu.children().length ) {
			button.hide();
			return;
		}

		$( '.menu-toggle' ).on( 'click', function() {
			nav.toggleClass( 'toggled-on' );
		} );
	})();

	// Portfolio Archive
	$("#portfolio .portfolio-item").hover(function(){
		if ( !$(this).hasClass('no-thumb') ) {
	    $(this).children(".title-overlay").stop(true).fadeTo(300, 1.0); // Sets 100% on hover
		$(this).children(".thumb").stop(true).fadeTo(300, .5); // Sets 20% on hover
		}
	},function(){
		if ( !$(this).hasClass('no-thumb') ) {
	    $(this).children(".title-overlay").stop(true).fadeTo(400, 0.0); // Sets opacity back to 0% on mouseout
		$(this).children(".thumb").stop(true).fadeTo(1000, 1.0); // Sets opacity back to 100% on mouseout
		}
	});

	// Image Post Format
	$('#content .format-image').each( function() {
		var image = $(this).find('img:first');
		if (image.width() > 200 ) {
	    	var link = $(this).find('.entry-title').children();
	    	var title = link.text();
	    	image.unwrap('a');
	    	image.wrap('<div class="image-wrap" />');
	    	image.wrap(link.text(''));
	    	image.parent().append('<h3/>');
	    	$(this).find('h3').text(title);
		}
	});

    $('.format-image .image-wrap a').hover( function() {
    	var img_width  = $(this).children('img').width();
    	$(this).children('h3').width(img_width-20).slideDown(100);
    }, function(){
    	$(this).children('h3').slideUp(200);
    });

	// Centers the submenus directly under the top menu
    function portfolio_desktop_submenus() {
		if ( document.body.clientWidth > 780 && !submenu_alignment ) {
			$(".primary-navigation li").each( function() {
			    if ( $(this).find("ul").length > 0 ) {
			        var parent_width = $(this).outerWidth( true );
			        var child_width = $(this).find("ul").outerWidth( true );
			        var new_width = parseInt((child_width - parent_width)/2);
			        $(this).find("ul").css('margin-left', -new_width+"px");
			    }
			});
			submenu_alignment = true;
		}
	}

	// Clears submenu alignment for the mobile menu
	function portfolio_mobile_submenus() {
		if ( document.body.clientWidth <= 780 && submenu_alignment ) {
			nav = $( '#primary-navigation' );
			nav.find('ul').css('margin-left', '');
			submenu_alignment = false;
		}
	}

	// Menu Alignment
    portfolio_desktop_submenus();

    $(window).on('resize', function(){
		portfolio_desktop_submenus();
		portfolio_mobile_submenus();
	});

});