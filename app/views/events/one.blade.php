@extends('master.layout1')

@section('body')

<div class="white-box events">
	<h2 class="title title-font">{{ $event->title }}</h2>

	<div class="event">

		<div class="user-info" style="margin-top:0px;">
			<div><b>العضو: </b> <a href="{{ URL::profile($event->getUser()) }}">{{ $event->getUser()->getTwoName() }}</a></div>

			@if(EasyDate::valid($event->getDate()))
			<div><b>تاريخ المناسبة: </b>{{ EasyDate::arabic('j F, Y', $event->getDate()) }}</div>
			@endif
		</div>

		<div class="info">

			<p>
				{{ $event->description }}
			</p>
		</div>
		<div class="img">
			@if($event->image)
				<a href="{{ URL::image($event->image) }}"><img src="{{ $event->image->getUrl( 113, 94 ) }}" width="113" /></a>
			@endif
		</div>
		<div class="clr"></div>
		@include('social.facebook')
	</div>

	<div class="clr"></div>

	@if($event->gallery && $event->gallery->hasImages())
	<div class="galleries">

		<div class="clr"></div>

		<div class="gallery">

		</div>

		<div class="clr"></div>
	</div>
	@endif

	<div class="clr"></div>

    <div class="comments">
        @foreach($event->comments()->orderBy('id', 'DESC')->take(15)->get()->reverse() as $comment)
        <div class="comment">

            <div class="user-info" style="margin-top:0px;">
                <div><b>العضو: </b> <a href="{{ URL::profile($comment->user) }}">{{ $comment->user->getTwoName() }}</a></div>

                @if(EasyDate::valid($comment->getDate()))
                <div>{{ EasyDate::arabic('j F, Y', $comment->getDate()) }}</div>
                @endif
            </div>

            <div class="info">
                <p>{{ $comment->description }}</p>
            </div>

        </div>
        @endforeach
    </div>

    <form action="{{ URL::route('comment.create') }}" method="POST" id="comment-form">
        <div class="row">
            <div class="right">
                <textarea type="text" name="Comment[description]" class="txtarea" rows="5" placeholder="نص التعليق" ></textarea>
            </div>

            <input type="hidden" name="Comment[c_type]" value="{{ Crypt::encrypt('Social\Event\Event') }}"/>
            <input type="hidden" name="Comment[c_id]" value="{{ Crypt::encrypt($event->id) }}"/>
        </div>

        <div class="clr"></div>

        <div class="row buttons">
            <input type="submit" class="register-btn grey-btn" value="إضافة تعليق" />
        </div>
    </form>
</div><!-- END of white-box -->

@stop

@section('scripts')
@if($event->gallery)
<script type="text/javascript">

$(document).ready(function()
{

	$('.gallery').isotope({
	  	// options
	  	itemSelector : '.item',
	  	layoutMode : 'fitRows'
	});

	@foreach($event->gallery->getExistImages( 20 ) as $image)
		loadImage('{{ $image->getUrl( 145, 145 ) }}', 145, 145, $('.gallery'), '{{ URL::image($image) }}');
	@endforeach


	$(".gallery-section").live('mouseover', function()
	{
		$(this).fadeTo(10, '0.4');
	});

	$(".gallery-section").live('mouseout', function()
	{
		$(this).fadeTo(10, '1');
	});
});



function loadImage(path, width, height, $container, link)
{
    $('<img onclick="window.location.href = \'' + link + '\'" src="'+ path +'">').load(function()
    {
    	$elem = $('<div class="gallery-section item"></div>');

    	$(this).width(width).height(height).appendTo( $elem );

    	$container.isotope( 'insert', $elem );

    });
}
</script>
@endif
@stop