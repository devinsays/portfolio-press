/**
 * Upgrade notice for Portfolio+
 */

( function( $ ) {

	// Add Upgrade Message
	if ('undefined' !== typeof portfoliopressL10n) {
		upgrade = $('<a class="portfoliopress-customize-plus"></a>')
			.attr('href', portfoliopressL10n.plusURL)
			.attr('target', '_blank')
			.text(portfoliopressL10n.plusLabel)
			.css({
				'background-color' : '#2EA2CC',
				'color' : '#fff',
				'text-transform' : 'uppercase',
				'padding' : '3px 6px',
				'font-size': '9px',
				'letter-spacing': '1px',
				'line-height': '1.5',
				'text-decoration': 'none'
			})
		;
		$('.preview-notice').append(upgrade);
		// Remove accordion click event
		$('.portfoliopress-customize-plus').on('click', function(e) {
			e.stopPropagation();
		});
	}

} )( jQuery );
