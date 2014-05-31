@extends('master.layout1')

@section('body')
<div class="white-box events">
	<h2 class="title title-font">{{ $job->title }}</h2>

	<div class="event">

		<div class="user-info">
			<div><b>العضو: </b> <a href="{{ URL::profile($job->getUser()) }}">{{ $job->getUser()->getTwoName() }}</a></div>
		</div>


		<div class="info">
            <div class="info-part">
                <h4>مكان الوظيفة</h4>
                <p>
                    {{ $job->place }}
                </p>
            </div>
            <div class="clr"></div>
            <div class="info-part">
                <h4>تفاصيل الوظيفة</h4>
                <p>
                    {{ $job->description }}
                </p>
            </div>
            <div class="clr"></div>
            <div class="info-part">
                <h4>الخبرات المطلوبة</h4>
                <p>
                    {{ $job->professions }}
                </p>
            </div>
		</div>
		<div class="img">
			@if($image = $job->image)
            <a href="{{ URL::image($image) }}"><img src="{{ $image->getUrl( 113, 94 ) }}" width="113" /></a>
			@endif
		</div>
		<div class="clr"></div>

		@include('social.facebook')

        <Br /><Br/>
<!--        <a href=" URL::route('apply-job', $job->id) " class="green-btn" style="float:left; margin:30px; text-decoration: none;">تقدم للوظيفة &#8592;</a>-->
        <div class="clr"></div>
	</div>
	<div class="clr"></div>
</div><!-- END of white-box -->

@stop