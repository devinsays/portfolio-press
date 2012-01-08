jQuery(document).ready(function($){
	
	// Portfolio Archive
    $("#portfolio .title-overlay").css('opacity', 0.0); // Sets opacity to fade down to 0% when page loads
    $("#portfolio .portfolio-item").hover(function(){
        $(this).children(".title-overlay").stop(true).fadeTo(300, 1.0); // Sets 100% on hover
		$(this).children(".thumb").stop(true).fadeTo(300, .5); // Sets 20% on hover
    },function(){
        $(this).children(".title-overlay").stop(true).fadeTo(400, 0.0); // Sets opacity back to 0% on mouseout
		$(this).children(".thumb").stop(true).fadeTo(1000, 1.0); // Sets opacity back to 100% on mouseout
    });
    
    // Image Post Format
    $('#content .format-image').each( function() {
    	var title = $(this).find('.entry-title').text();
    	$(this).find('img:first').wrap('<div class="image-wrap" />');
    	$(this).find('.image-wrap').append('<h3>' + title + '</h3>');
    });
    
    $('.format-image .image-wrap').hover( function() {
    	$(this).children('h3').slideDown(100);
    }, function(){
    	$(this).children('h3').slideUp(200);
    });
    
});