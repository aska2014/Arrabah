WebFont.load({
	google: {
		families: ['Droid Arabic Kufi']
	}
});

$(document).ready(function()
{
	$(".events > .content").easySlider({autoPlay:true, pagination:false, autoSpeed:3000, speed:1000});
	$(".image-slider").easySlider({pagination:false, autoPlay:true, autoSpeed:3000, speed:1000});

	// Load font
	$(".title-font").css('font-family', 'Droid Arabic Kufi');

	// Easy slider has loaded then show all slides
	$(".slides_container .slide").css('display', 'block');

	// Close of errors
	$(".errors .close, .success .close").live('click', function()
	{
		$(this).parent().fadeTo("slow", 0, function()
		{
			$(this).remove();
		});
	});

	// Safari CSS and Webkit Google Chrome
	if ($.browser.webkit) {
		$(".search-btn").css('top', '2px');
	}

	if(! $.browser.webkit ) {
		$(".title-font").css({'line-height' : '40px' });
		$("#top-header h2").css({'position':'relative', 'bottom' : '7px'});
		$("#top-header-form").css({'position':'relative', 'top' : '3px'});
		$("#top-header-form .btn").css({'top' : '0px'});
	}

	$(".plus-icon").each(function()
	{
		$(this).parent().css('cursor', 'pointer');
	});

	$(".plus-icon").parent().click(function()
	{
		triggerPlusIcon($(this).next('div'), $(this).find(".plus-icon"));
	});
	
    //Caption Sliding (Partially Hidden to Visible)  
    $('.boxgrid.caption').hover(function(){  
        $(".cover", this).stop().animate({top:'105px'},{queue:false,duration:160});  
    }, function() {  
        $(".cover", this).stop().animate({top:'165px'},{queue:false,duration:160});  
    });


	preLoadImages(['images/light-grey-gradient.jpg']);
});


function preLoadImages( images )
{
	// create object
	imageObj = new Image();

	// start preloading
	for(var i=0; i<images.length; i++) 
	{
		imageObj.src = assetUrl + 'css/' + images[i];
	}
}



function triggerPlusIcon( target, button )
{
	if(target.is(":visible")) {

		target.slideUp('slow');

		if(button !== undefined)

			button.html('إظهار');

	}
	else{

		target.slideDown('slow');

		if(button !== undefined)

			button.html('إخفاء');
	}
}

function addLoadingIcon( x, y )
{
	removeLoadingIcon();

	$('<div class="circle-loader"></div>').css({
		left: x - 10 + 'px',
		top:  y - 10 + 'px',
	}).prependTo('body');
}

function removeLoadingIcon()
{
	$(".circle-loader").remove();
}


function showMessage( type, messages )
{
	var string = '<div class="' + type + '"><div class="close">×</div><ul>';

	if(messages instanceof Array) {
		
		for(var i = 0; i < messages.length; i++) {

			string += '<li>' + messages[i] + '</li>';
		}
	}else {

		string += '<li>' + messages + '</li>';
	}

	string += '</ul></div>';

	$("#left-body").prepend(string);
}