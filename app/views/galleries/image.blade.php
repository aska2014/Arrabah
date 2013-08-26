@extends('master.layout1')

@section('body')
<div class="white-box events">
	<h2 class="title title-font"><div class="gallery-icon"></div>{{ $image->title }}</h2>

	<div style="margin-top:20px;">

		<div class="user-info">

			@if($user = $image->getUser())
				<div><b>العضو: </b> <a href="{{ URL::profile($user) }}">{{ $user->getTwoName() }}</a></div>

				@if($user->same( $authUser ) && $image->attachedToUser())
				<div class="image-tools">
					<div>
						<form action="{{ URL::route('replace-image') }}" method="POST" enctype="multipart/form-data">
							<b>أستبدال الصورة: </b><input type="file" name="Profile[image]" /><br />
							<input type="submit" value="إستبدال" class="sbmt" />
						</form>
					</div>

				</div>
				@endif
			@endif

			{{-- If image attached to gallery --}}
			@if($image->attachedToGallery() && $gallery = $image->getAttached())

			<div><b>معرض الصور: </b> <a href="{{ URL::gallery($gallery) }}">{{ $gallery->title }}</a></div>

			@endif

			@if($image->description)
			<div><b>وصف الصورة: </b>{{ $image->description }}</div>
			@endif


			@if($user->same( $authUser ) && !$image->attachedToUser())
				<div class="image-tools">
					<div><a href="{{ URL::deleteImage( $image ) }}">(×) حذف الصورة</a></div>
				</div>
			@endif


		</div>
		<div class="clr"></div><br />
		<div class="img" style="float:none; text-align:center">

			@if($image->hasImage())
				<img src="{{ $image->getLargestUrl() }}" style="max-width:400px;" />

				@include('social.facebook')
			@else

			<div class="empty-message">هذه الصورة غير متاحة.</div>
			
			@endif
		</div>
		<div class="clr"></div>
	</div>
	<div class="clr"></div>
</div><!-- END of white-box -->

@stop

@section('styles')
<style type="text/css">
.image-tools{ background:#EEE; border-right:4px solid #333;margin-top:30px; padding:15px 20px; }
.image-tools .sbmt{ background: #333; border: 0px; color:#FFF; padding:5px 10px; font-size:12px; font-family: Tahoma; cursor: pointer; }
.image-tools .sbmt:hover{background: #666;}
</style>
@stop