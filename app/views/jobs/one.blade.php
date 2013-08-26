@extends('master.layout1')

@section('body')
<div class="white-box events">
	<h2 class="title title-font">{{ $job->title }}</h2>

	<div class="event">

		<div class="user-info">
			<div><b>العضو: </b> <a href="{{ URL::profile($job->getUser()) }}">{{ $job->getUser()->getTwoName() }}</a></div>
		</div>


		<div class="info">
			<p>
				{{ $job->description }}
			</p>
		</div>
		<div class="img">
			@if($image = $job->image)
			<img src="{{ $image->getUrl( 113, 94 ) }}" width="113" />
			@endif
		</div>
		<div class="clr"></div>

		@include('social.facebook')
	</div>
	<div class="clr"></div>
</div><!-- END of white-box -->

@stop