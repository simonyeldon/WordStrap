/*
 * Javascript file to use Farbtastic in the admin interface
 */
jQuery(document).ready(function($) {
	$('.colourpicker').hide();
	
	$('.colourpicker-wrapper').each(function() {
		var $picker = $('.colourpicker', $(this));
		var $field = $('.colour', $(this));
		
		$picker.farbtastic($field);

		$field.click(function() {
			$picker.fadeIn();
		});

	});

	$(document).mousedown(function() {
		$('.colourpicker').each(function() {
			var display = $(this).css('display');
			if( display == "block" ) {
				$(this).fadeOut();
			}
		});
	});


});
