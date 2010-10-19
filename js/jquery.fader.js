jQuery(document).ready(function(){

// Fade
    jQuery("#portfolio .title-overlay").css('opacity', 0.0); // Sets opacity to fade down to 0% when page loads
	
    jQuery("#portfolio .portfolio-item").hover(function(){
        jQuery(this).children(".title-overlay").stop(true).fadeTo(300, 1.0); // Sets 100% on hover
		jQuery(this).children(".thumb").stop(true).fadeTo(300, .5); // Sets 20% on hover
    },function(){
        jQuery(this).children(".title-overlay").stop(true).fadeTo(400, 0.0); // Sets opacity back to 0% on mouseout
		jQuery(this).children(".thumb").stop(true).fadeTo(1000, 1.0); // Sets opacity back to 100% on mouseout
    });
});