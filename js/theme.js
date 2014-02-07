jQuery(document).ready(function ($) {

	submenu_alignment = false;

	// Enable menu toggle for small screens
	(function() {
		var nav = $( '#navigation' ), button, menu;
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
			nav = $( '#navigation' );
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