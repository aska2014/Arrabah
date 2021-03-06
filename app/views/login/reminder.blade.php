@extends('master.layout1')

@section('body')
<div class="white-box">
	<h2 class="title title-font">إستعادة كلمة السر</h2>

	<p>

		<form action="{{ URL::route('reminder') }}" method="POST">
			<div class="main-form">

				<div class="clr"></div>
				<div class="row">
					<div class="right">
						<div class="label">إيميل المستخدم</div>
						<input type="text" name="Reset[email]" />
					</div>
				</div>
				
				<div class="clr"></div>

				<div class="row buttons">
					<input type="submit" class="register-btn grey-btn" value="إستعادة" />
				</div>
			</div>
			
		</form>
	</p>


</div><!-- END of white-box -->
@stop

@section('styles')

<style type="text/css">
	.main-form .row .label{text-align: right;}
</style>

@stop