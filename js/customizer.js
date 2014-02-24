( function( $ ) {
    var $title = $( '#site-title a' ),
        $tagline = $( '#site-description' ),
        $branding = $( '#branding' );

	/* Title Text */
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$title.text( to );
		} );
	} );

	/* Tagline Text */
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$tagline.text( to );
		} );
	} );

	/* Header Background Color */
	wp.customize( 'portfoliopress[header_color]', function( value ) {
		value.bind( function( to ) {
			$branding.css( 'background-color', to );
		} );
	} );

} )( jQuery );