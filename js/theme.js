jQuery(document).ready(function ($) {

	var PortfolioPressJS = {
		'nav' : $('#navigation'),
		'menu' : $('#navigation .nav-menu'),
		'submenu' : false
	};

	// Enable menu toggle for small screens
	(function() {
		if ( ! PortfolioPressJS.nav ) {
			return;
		}

		button = PortfolioPressJS.nav.find('.menu-toggle');
		if ( ! button ) {
			return;
		}

		// Hide button if menu is missing or empty.
		if ( ! PortfolioPressJS.menu || ! PortfolioPressJS.menu.children().length ) {
			button.hide();
			return;
		}

		button.on( 'click', function() {
			PortfolioPressJS.nav.toggleClass('toggled-on');
			PortfolioPressJS.menu.slideToggle( '200' );
		} );
	})();

	// Centers the submenus directly under the top menu
    function portfolio_desktop_submenus() {
		if ( document.body.clientWidth > 780 && !PortfolioPressJS.submenu ) {
			PortfolioPressJS.menu.attr('style','');
			PortfolioPressJS.nav.find('li').each( function() {
			    if ( $(this).find("ul").length > 0 ) {
			        var parent_width = $(this).outerWidth( true );
			        var child_width = $(this).find("ul").outerWidth( true );
			        var new_width = parseInt((child_width - parent_width)/2);
			        $(this).find("ul").css('margin-left', -new_width+"px");
			    }
			});
			PortfolioPressJS.submenu = true;
		}
	}

	// Clears submenu alignment for the mobile menu
	function portfolio_mobile_submenus() {
		if ( document.body.clientWidth <= 780 && PortfolioPressJS.submenu ) {
			PortfolioPressJS.nav.find('ul').css('margin-left', '');
			PortfolioPressJS.submenu = false;
		}
	}

	// Menu Alignment
    portfolio_desktop_submenus();

    $(window).on('resize', function(){
		portfolio_desktop_submenus();
		portfolio_mobile_submenus();
	});

});