<script type="text/javascript">

$(document).ready(function()
{
	$("#city-slider").easySlider();
	
	$form = $("#votingForm");

	$form.ajaxForm({
        beforeSubmit:  showRequest,
        dataType:  'json',
	    success: showResponse
	});

	$form.find('input[type=submit]').removeAttr('disabled', 'disabled');

	preLoadImages([
		@if(! $authUser)
		'images/register-banner-active.jpg',
		@else
		'images/chat-banner-active.jpg',
		@endif
		'images/suggestions-banner-active.jpg']);
});

$(window).load(function() {

	centerImages($(".bwWrapper"));

	$('.bwWrapper').BlackAndWhite({
        hoverEffect : true, // default true
        // set the path to BnWWorker.js for a superfast implementation
        webworkerPath : false,
        speed: { //this property could also be just speed: value for both fadeIn and fadeOut
            fadeIn: 150, // 200ms for fadeIn animations
            fadeOut: 800 // 800ms for fadeOut animations
        }
    });
});

function centerImages(images)
{
	var maxHeight = 0;

	// First loop to get maximum heigth.
	images.each(function()
	{
		maxHeight = $(this).height() > maxHeight ? $(this).height() : maxHeight;
	});

	// Center Images
	images.each(function()
	{
		$(this).css({
			'margin-top': maxHeight / 2 - $(this).height() / 2
		});
	});
}

function showRequest(formData, jqForm, options)
{
	jqForm.find('input[type=submit]').attr('disabled', 'disabled');
	jqForm.fadeTo(200, 0.1);

	return true;
}


function showResponse(response, status, xhr, $form)
{
	$form.find('input[type=submit]').removeAttr('disabled', 'disabled');

	if(response.message == 'success') {

		var html = '<div class="voting-result" style="display:none">';

		for(var i = 0; i < response.answers.length; i++) {

			html += '<div class="answer" id="answer' + i + '"><div class="label">' + response.answers[i].title + ' <span>(' + parseInt(response.answers[i].precentage) + '%)</span></div><div class="answer-div"><div class="precentage"><div class="completion"></div></div></div></div><div class="clr"></div>';
		}

		html += '</div>';

		$form.replaceWith(html);

		$(".voting-result").fadeTo(500, 1);

		for(var i = 0; i < response.answers.length; i++) {

			var target = $("#answer" + i);

			var width = (response.answers[i].precentage / 100) * target.find('.precentage').width();

			target.find('.completion').animate({

				width: width
			});
		}
	} else {

		$form.replaceWith('<div class="voting-result">' + response.body + '</div>');

	}
}

</script>