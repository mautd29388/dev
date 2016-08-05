(function($) {
	"use strict";

	$(document).ready(function($){
		
		var $checkbox = $('.widget-logic-box .checkbox-parent'),
			$logic_children = $checkbox.parent().siblings('.widget-logic-children');
		
		$('.wrap').on('click', '.widget-logic-box .checkbox-parent', function($e) {
			$checkbox = $(this);
			$logic_children = $checkbox.parent().siblings('.widget-logic-children');
			
			if ( $checkbox.is(':checked') ) {
				$logic_children.slideToggle(350);
			} else {
				$logic_children.slideToggle(350);
				$logic_children.find('input[type=checkbox]').prop( "checked", false );
			}
		});
	});
	
})(jQuery);