@extends('master.layout1')

@section('body')
<div class="white-box profile">

	<h2 class="title title-font">صفحة الرسائل</h2>

	@include('messages.submenu')

	<div class="form-big box-form">

		<div class="form-section-all">
			<h3 class="form-title">إرسال رسالة<div class="plus-icon"> إخفاء </div></h3>

			<div class="padding-section">
				<form action="{{ URL::route('compose') }}" method="POST" enctype="multipart/form-data">
					<div class="form-row">
						<div class="key">العضو*</div>
						<div class="value">

							<select class="slct basic-select" id="member-slct" name="Message[user]" style="width:212px;">
								<option value=""></option>
								@foreach( $acceptedUsers as $user )
								<option value="{{ $user->id }}">{{ $user->getTwoName() }}</option>
								@endforeach
							</select>

						</div>
					</div>
					<div class="clr"></div>
					<div class="form-row">
						<div class="key">عنوان الرسالة</div><div class="value"><input type="text" class="txt" name="Message[title]" value="{{ Input::old('Message.title') }}" /></div>
						<div class="info">يمكنك تركها خالية</div>
					</div>
					<div class="clr"></div>
					<div class="form-row">
						<div class="key">الرسالة*</div><div class="value"><textarea name="Message[description]" class="txtarea">{{ Input::old('Message.description') }}</textarea></div>
					</div>
					<div class="clr"></div>
					<div class="buttons">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="submit" class="message-btn" value="" />
					</div>
					<div class="clr"></div>
				</form>
			</div>
			<div class="clr"></div>
		</div>
		<div class="clr"></div>
	</div>
	<div class="clr"></div>
</diV>
@stop

@section('scripts')
<script type="text/javascript">

$(document).ready(function()
{
	$( '.basic-select' ).select2({
		placeholder: 'أختر العضو'
	});

	@if(isset($sendToUserId) && $sendToUserId)
	$("#member-slct").select2('val', "{{ $sendToUserId }}");
	@else
	$("#member-slct").select2('val', "{{ Input::old('Message.user') }}");
	@endif
});

</script>

@stop
