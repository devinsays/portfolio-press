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
    
});