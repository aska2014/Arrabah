<form action="{{ URL::route('add-image', $gallery->id) }}" method="POST" class="main-form" id="eventForm" enctype="multipart/form-data">
	<div class="form-title" style="margin-top:10px;">إضافة صور فى هذا المعرض <div class="plus-icon"> إظهار </div></div>
	<div class="section-hidden">
		<div class="form-row">
			<div class="gallery-images-form">
				<input type="file" name="gallery-images[]" class="file" /><br />
			</div>
			<a class="add-image" href="javascript:void(0)">إضافة صورة + </a>
		</div>
		<div class="clr"></div>

		<div class="buttons">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="submit" class="sbmt" value="" />
		</div>

		<div class="clr"></div>
	</div>

</form>


@section('scripts')

<script type="text/javascript">
$(document).ready(function()
{
	$(".add-image").click(function()
	{
		$(".gallery-images-form").append('<input type="file" name="gallery-images[]" /><br />');
	});
	
	var bar = $('.bar');
	var percent = $('.percent');
	var status = $('#status');

    $('#eventForm').ajaxForm({
        beforeSubmit:  showRequest,
        dataType:  'json',            // 'xml', 'script', or 'json' (expected server response type) 

	    beforeSend: function() {
	        status.empty();
	        var percentVal = '0%';
	        bar.width(percentVal)
	        percent.html(percentVal);
	    },
	    uploadProgress: function(event, position, total, percentComplete) {
	        var percentVal = percentComplete + '%';
	        bar.width(percentVal)
	        percent.html(percentVal);
			console.log(percentVal, position, total);
	    },
	    success: function(response, status, xhr, $form) {
	        var percentVal = '100%';
	        bar.width(percentVal)
	        percent.html(percentVal);

	        showResponse(response, status);
	    },
		complete: function(xhr) {
			status.html(xhr.responseText);
		}
	}); 

});

function showRequest(formData, jqForm, options)
{
	$("#eventForm").fadeTo(200, 0.5);
	$("#progressContainer").show();
	$(".sbmt").attr('disabled', 'disabled');

	$(window).scrollTop(0);
	
	return true;
}


function showResponse(response, status, xhr, $form)
{
	$("#eventForm").fadeTo(200, 1);
	if(response.message == 'success') 

		$("#eventForm")[0].reset();

	$("#progressContainer").hide();
	$(".sbmt").removeAttr('disabled', 'disabled');

	showMessage(response.message, response.body);
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
</script>
@stop