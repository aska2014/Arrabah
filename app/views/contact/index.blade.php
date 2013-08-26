@extends('master.layout1')

@section('body')
<div class="white-box">
	<h2 class="title title-font">إتصل بنا</h2>

	<form class="main-form" action="{{ URL::route('contact-us') }}" method="POST">

		<div class="clr"></div>

		<div class="row">
			<div class="right">
				<div class="label">عنوان الرسالة</div>
				<input type="text" class="txt" id="register-username" name="Contact[title]" value="{{ Input::old('Contact.title') }}" />
			</div>
		</div>

		<div class="clr"></div>

		<div class="row">
			<div class="right">
				<div class="label">نوع الرسالة</div>
				<select id="contact-type" class="slct-type" name="Contact[type]">
					<option value="1">إقتراح</option>
					<option value="0">إستفسار</option>
				</select>
			</div>
		</div>

		<div class="clr"></div>

		<div class="row">
			<div class="right">
				<div class="label">نص الرسالة</div>
				<textarea name="Contact[description]" class="txtarea"></textarea>
			</div>
		</div>

		<div class="clr"></div>

		<div class="row buttons">
			<input type="submit" class="register-btn message-btn" value="" />
		</div>
		
		<div class="clr"></div>

	</form>

</div><!-- END of white-box -->
@stop

@section('styles')
<style type="text/css">
.txtarea{ width:400px; border: 1px solid #BBB; height:200px; }
.main-form{margin-bottom:15px;}
.slct-type{width:193px;}
.register-btn{float: left;}
</style>
@stop


@section('scripts')
<script type="text/javascript">
$(document).ready(function()
{
	$("#contact-type").select2();
});
</script>
@stop