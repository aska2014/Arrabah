@extends('master.layout1')

@section('body')
<div class="white-box" style="padding-bottom:20px;">
	<h2 class="title title-font"><div class="gallery-icon"></div>مكتبة الصور</h2>

	<div class="all" style="margin-top:20px;">

		@foreach($galleries as $gallery)
		<div class="boxgrid caption">
		    <a href="{{ URL::showGalleries($gallery) }}">
		    	@if($image = $gallery->getMainImage())
				<img class="img1" src="{{ $image->getUrl(145, 145) }}" />
				@endif
			</a>
		    <div class="cover boxcaption">
		    	<p>{{ $gallery->title }}</p><br />
		    </div>
		</div>
		@endforeach
	</div>
	<div class="clr"></div>

</div>
@stop