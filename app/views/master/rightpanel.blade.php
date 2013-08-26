<div class="events right-box">
	<h2>مناسبات وأحداث</h2>
	
	<div class="content">
		<div class="slides_container">

			@foreach($sliderEvents as $event)
			<div class="slide">
				<h3><a href="{{ URL::event($event) }}">{{ Str::limit($event->title, 20) }}</a></h3>
				<p>
					{{ Str::limit($event->description, 60) }}
				</p>

				@if($event->image)
					<img src="{{ $event->image->getUrl( 113, 94 ) }}"  />
				@endif
				<div class="clr"></div>
				<a href="{{ URL::event($event) }}"><div class="grey-more nice-font">المزيد</div></a>
			</div>
			@endforeach
		</div>
	</div>
</div>

<div class="right-box" style="height:180px;">
	<h2 class="title title-font">صور متحركة</h2>

	<div class="image-slider" style="margin:20px; margin-bottom:40px">

		<div class="slides_container">
			@for($i = 0; $i < count($movingImages); $i+=2)

				<div class="slide">
					<a href="{{ URL::image($movingImages[$i]) }}"><img src="{{ $movingImages[$i]->getUrl(145, 145) }}" width="85"  /></a>
					@if(isset($movingImages[$i + 1]))
					<a href="{{ URL::image($movingImages[$i + 1]) }}"><img src="{{ $movingImages[$i + 1]->getUrl(145, 145) }}" width="85" style="margin-right:10px;" /></a>
					@endif
				</div>

			@endfor
		</div>
	</div>
</div><!-- END of white-box -->

<div class="clr"></div>