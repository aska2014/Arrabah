<form action="{{ URL::action('EventController@create') }}" method="POST" class="main-form" id="eventForm" enctype="multipart/form-data">
	<div class="form-section">
		<div class="form-title">إضافة مناسبة جديدة <div class="plus-icon"> إظهار </div></div>
		<div class="section-hidden padding-section">
			<div class="form-row">
				<div class="key">العنوان*</div>
				<div class="value">
					<select name="Event[title]" class="slct">
						<option value="">إختيار العنوان</option>
						@foreach($eventTitles as $eventTitle)
						<option value="{{ $eventTitle->title }}">{{ $eventTitle->title }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="clr"></div>
			<div class="form-row">
				<div class="key">تاريخ المناسبة</div><div class="value"><input type="text" class="txt datepicker-basic" name="Event[date_of_event]" value="{{ Input::old('Register.day_of_birth') }}" /></div>
				<div class="info">يمكنك تركها خالية</div>
			</div>
			<div class="clr"></div>
			<div class="form-row">
				<div class="key">المناسبة*</div><div class="value"><textarea name="Event[description]" class="txtarea"></textarea></div>
			</div>
			<div class="clr"></div>
			<div class="form-row">
				<div class="key">صورة رئيسية*</div><div class="value"><input type="file" name="main-image" /></div>
			</div>
			<div class="clr"></div>
		</div>
	</div>
	
	<div class="form-row-title">مكتبة الصور الخاصة بالمناسبة <div class="plus-icon"> إظهار </div></div>
	<div class="section-hidden">
		<div class="form-row">
			<div class="gallery-images-form">
				<input type="file" name="gallery-images[]" class="file" /><br />
			</div>
			<a class="add-image" href="javascript:void(0)">إضافة صورة + </a>
		</div>
		<div class="clr"></div>

		<div class="buttons">
			<input type="submit" class="sbmt" value="" />
		</div>

		<div class="clr"></div>
	</div>


	<input type="hidden" name="_token" value="{{ csrf_token() }}">
</form>

@section('scripts')
@parent

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
        data: {ajax : true},

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
	    },
	    success: function(response, status, xhr, $form) {
	        var percentVal = '100%';
	        bar.width(percentVal)
	        percent.html(percentVal);
	        showResponse(response, status);
	    },
		complete: function(xhr) {
			status.html();
		}
	}); 

});

function showRequest(formData, jqForm, options)
{
	var pos = jqForm.position();
	var width = jqForm.width();
	var height = jqForm.height();

	$("#eventForm").fadeTo(200, 0.3);
	$(".sbmt").attr('disabled', 'disabled');

	addLoadingIcon((pos.left + width / 2), (pos.top + height / 2));

	if($.ajaxSettings.xhr().upload) {

		$("#progressContainer").show();
		$(window).scrollTop(0);
	}

	return true;
}


function showResponse(response, status, xhr, $form)
{
	removeLoadingIcon();

	$("#eventForm").fadeTo(200, 1);

	$(window).scrollTop(0);

	if(response.message == 'success')

		$("#eventForm")[0].reset();

	$("#progressContainer").hide();
	$(".sbmt").removeAttr('disabled', 'disabled');

	showMessage(response.message, response.body);
}
</script>
@stop