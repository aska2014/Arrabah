@extends('master.layout1')

@section('body')
    
@if(isset($profileUser) && $profileUser->same( $authUser ))
<div id="progressContainer">
	<div class="progress">
	    <div class="bar"></div >
	    <div class="percent">0%</div >
	</div>

	<div id="status"></div>
</div>
@endif

<div class="white-box events">
	<h2 class="title title-font"><div class="events-icon"></div>{{ $eventTitle }}</h2>

	@if(isset($profileUser) && $profileUser)
		@include('profile.submenu')
	@endif

	<div class="form-big box-form">

		@if(isset($profileUser) && $authUser->same( $profileUser ))

		@include('events.form')

		@endif

		<div class="clr"></div>
	</div>


	@if(isset($profileUser) && $authUser->same( $profileUser ))
	<div class="clr"></div>
	<hr />
	<div class="clr"></div>
	@endif
	

	@if($events->isEmpty())

	<div class="empty-message">لا يوجد اى مناسبات او احداث فى هذه الصفحة بعد.</div>

	@endif

	@foreach($events as $event)
	<div class="event">
		<div class="info">
			<h3><a href="{{ URL::event($event) }}">{{ $event->title }}</a></h3>
			<p>
				{{ Str::limit($event->description, 200) }}
			</p>
		</div>
		<div class="img">
			@if($event->image)
				<img src="{{ $event->image->getUrl( 113, 94 ) }}" width="113" />
			@endif
		</div>
		<div class="clr"></div>
	</div>
	<div class="clr"></div>
	@endforeach
</div><!-- END of white-box -->


<div class="pages">
	{{ $events->links() }}
</div>

@stop

@section('scripts')
<script type="text/javascript">

$(document).ready(function()
{
	$( '.datepicker-basic' ).datepicker();
});

</script>

@stop
