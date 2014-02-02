(function($) {

  $.fn.easySlider = function( params ) {

	// merge default and user parameters
	params = $.extend( {speed: 500, pagination: true, autoPlay : false, autoSpeed: 2000}, params);

	this.each(function() {

		var slider = $(this);
		var slider_width = slider.width();
		var margin_left = 10;
		var total_width = slider_width + margin_left;

		var current_slide = 0;
		var no_of_slides = slider.find('.slide').size();

		var forward = true;

		slider.css({
			'width' : slider_width,
			'overflow' : 'hidden'
		});

		slider.find('.slides_container').css({
			'width' : '100000px',

		});
		
		slider.find('.slide').css({
			'float' : 'right',
			'position' : 'relative',
			'margin-left' : margin_left + 'px',
			'width' : slider_width
		});

		slider.find('.next-btn, .prev-btn').css({
			'cursor' : 'pointer'
		});


		if(params.autoPlay)
		{
			setInterval(function()
			{
				if(forward)
				{
					if(current_slide < no_of_slides - 1) {

						slider.find('.slide').animate({
							left:'+=' + total_width + 'px'
						}, params.speed);

						current_slide ++;
					}else {

						forward = false;
					}
				} else {

					if(current_slide > 0) {
					
						slider.find('.slide').animate({
							left:'-=' + total_width + 'px'
						}, params.speed);

						current_slide --;
					}else {
						forward = true;
					}
				}
			}, params.autoSpeed);
		}


		else if(params.pagination)
		{
			slider.find('.next-btn').click(function()
			{
				if(current_slide < no_of_slides - 1) {

					slider.find('.slide').animate({
						left:'+=' + total_width + 'px'
					}, params.speed);
					current_slide ++;
				}
			});

			slider.find('.prev-btn').click(function()
			{
				if(current_slide > 0) {
				
					slider.find('.slide').animate({
						left:'-=' + total_width + 'px'
					}, params.speed);

					current_slide --;
				}
			});
		}
	});
  };
})(jQuery);


