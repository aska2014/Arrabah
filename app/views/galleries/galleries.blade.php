@extends('master.layout1')

@section('body')
<div class="white-box">

	<h2 class="title title-font"><div class="gallery-icon"></div>مكتبة الصور</h2>
	<div class="user-info" id="user-info">
		<div><b>العضو: </b> <a href="{{ URL::profile($firstGallery->getUser()) }}" class="user-name">{{ $firstGallery->getUser()->getTwoName() }}</a></div>

		<div><b>أسم معرض الصور: </b> <a href="{{ URL::gallery($firstGallery) }}" class="gallery-name">{{ $firstGallery->title }}</a></div>
		@if($firstGallery->description)
		<div><b>وصف المعرض: </b> <span class="gallery-description">{{ $firstGallery->description }}</span></div>
		@endif
	</div>

	<div class="clr"></div><hr /><div class="clr"></div>


	<div class="nav">
		<div class="prev-btn"></div>
		<div class="next-btn"></div>
	</div>

	<div class="clr"></div>

	<div class="galleries">

		<div class="clr"></div>

		<div class="gallery">

		</div>

		<div class="clr"></div>
	</div>

	<div class="clr"></div>

</div>
@stop


@section('scripts')
<script type="text/javascript">

$(document).ready(function()
{

	$('.gallery').isotope({
	  	// options
	  	itemSelector : '.item',
	  	layoutMode : 'fitRows'
	});

	@foreach($firstGallery->getExistImages( 8 ) as $image)
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


	@if($firstGallery->hasNext())
	$(".next-btn").show();
	@endif

	@if($firstGallery->hasPrevious())
	$(".prev-btn").show();
	@endif

	$(".prev-btn").click(function()
	{
		requestGalleryInfo( $(this), "prev", function()
		{
			$(".next-btn").show();	
		});
	});

	$(".next-btn").click(function()
	{
		requestGalleryInfo( $(this), "next", function()
		{
			$(".prev-btn").show();
		});
	});

});



var requestGalleryUrl = "{{ URL::to('request-gallery-info/{id}/{type}') }}";
var currentGalleryId  = {{ $firstGallery->id }};

function requestGalleryInfo( target, type, success )
{
	if(currentGalleryId > 0) {

		var pos = $("#user-info").position();
		var width = $("#user-info").width();
		var height = $("#user-info").height();

		addLoadingIcon(pos.left + width/2, pos.top + height/2);
		$("#user-info").fadeTo(200, '0.2');

		$.ajax({
			cache:false,
			url: requestGalleryUrl.replace('{id}', currentGalleryId).replace('{type}', type),
			success:function( data )
			{
				if(data.success !== undefined && data.success) {

					$(".user-name").html(data.user.twoName);
					$(".gallery-name").html(data.gallery.title);
					$(".gallery-description").html(data.gallery.description);

					$(".gallery").isotope( 'remove', $(".item"), function()
					{
						for(var i = 0; i < data.images.length; i++) {
							loadImage(data.images[i].url, 145, 145, $('.gallery'), data.images[i].link);
						}
					});

					currentGalleryId = data.currentId;

					if(data.noMore) target.hide();

					success();
				}

				$("#user-info").fadeTo(200, '1');
				removeLoadingIcon();
			}
		});
	}
}



function loadImage(path, width, height, $container, link)
{
    $('<img onclick="window.location.href=\'' + link + '\'" src="'+ path +'">').load(function()
    {
    	$elem = $('<div class="gallery-section item"></div>');

    	$(this).width(width).height(height).appendTo( $elem );

    	$container.isotope( 'insert', $elem );

    });
}

</script>

@stop