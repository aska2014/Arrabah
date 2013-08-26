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
<div class="white-box families" style="padding-bottom:20px;">
	<h2 class="title title-font"><div class="gallery-icon"></div>{{ $gallery->title }}</h2>



	@if($authUser->same( $profileUser ))
	<div class="form-big box-form">

			@include('galleries.imageform')
	</div>
	<div class="clr"></div>
	<hr />
	@endif

	<div class="clr"></div>

	<div class="all" style="margin-top:20px;">

		@foreach($images as $image)
			<div class="boxgrid caption">
				<a href="{{ URL::image($image) }}">
				@if($image->hasImage())
			    <img src="{{ $image->getUrl( 145, 145 ) }}" width="145" height="145" />
		    	@else
			    <img src="{{ AlbumsManager::defaultImage('gallery.image') }}" width="145" height="145" />
		    	@endif
		    	</a>
			</div>
		@endforeach

		<div class="clr"></div>

	</div>
</div><!-- END of white-box -->


<div class="pages">
	<ul>
		{{ $images->links() }}

		<!-- <li><a href="#" class="active">1</a></li>
		<li><a href="#">2</a></li>
		<li><a href="#">3</a></li> -->
	</ul>
</div>
@stop
