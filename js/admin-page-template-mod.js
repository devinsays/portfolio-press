jQuery(document).ready(function ($) {

	var select = $('#page_template');

	if ( ! select ) {
		return;
	}

	var templates = [ 'templates/portfolio.php', 'templates/full-width-portfolio.php' ];

	templates.forEach( function( element ) {
		var option = select.find( 'option[value="' + element + '"]' );
		if ( !option.is(':selected') ) {
			option.remove();
		}
	});

});