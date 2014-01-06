jQuery(window).load( function(){

	$ = jQuery;

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

});