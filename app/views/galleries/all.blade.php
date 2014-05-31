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
<div class="white-box profile">

	<h2 class="title title-font">{{ $profileUser->getTwoName() }}</h2>

	@include('profile.submenu')

	<div class="form-big box-form">

		@if($authUser->same( $profileUser ))
			@include('galleries.form')
		@endif

	</div>

	@if($authUser->same( $profileUser ))
	<div class="clr"></div>
	<hr />
	<div class="clr"></div>
	@endif


	@if(! $galleries->isEmpty())

	<div class="all">
		@foreach($galleries as $gallery)
		<div class="boxgrid caption">
			<a href="{{ URL::gallery($gallery) }}">
				@if($gallery->getMainImage())
                <a href="{{ URL::image($gallery->getMainImage()) }}"><img src="{{ $gallery->getMainImage()->getUrl( 145, 145 ) }}" width="145" height="145" /></a>
				@else
			    <img src="{{ AlbumsManager::defaultImage( 'gallery.image' ) }}" width="145" height="145" />
				@endif
			</a>
		    <div class="cover boxcaption">
		        <p>{{ Str::limit($gallery->title, 20) }}<br/></p>  
		    </div>  
		</div>
		@endforeach
		<div class="clr"></div>
	</div>

	@else

	<div class="empty-message">هذا العضو لم يضف اى معرض صور بعد.</div>

	@endif

	<div class="clr"></div>

</diV>
@stop