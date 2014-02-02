@extends('master.layout2')

@section('body')

@if($homeWelcome && $homeContent = $homeWelcome->placeable)
<div class="white-box hello-box">
	<h2 class="title title-font">{{ $homeContent->title }}</h2>

    <p class="nice-font new-home" style="height:160px; overflow:hidden">
        <em>( و اعتصموا بحبل الله جميعا و لا تفرقوا )</em>

        <b>يسرنى </b>

        أن اتقدم نيابة عن الاخوة من أبناء عرابه فى المملكة العربية السعودية و رئيس و اعضاء رابطة أبناء عرابه فى المملكة العربية الاردنية الهاشمية بالتحية و التقدير الى جميع ابناء عرابه فى الوطن و المهجر.
        أخوانى اهالى عرابه الكرام, ان فكرة انشاء هذا الموقع كان الهدف الاساسى منه العمل على تنمية او مساعدة اهلنا فى عرابه و المهجر اينما كانوا و لم شملهم فى موقع الكترونى يكون مرجعا لكامل ابناء عرابه أينما وجدوا.
        و ان هذا الموقع يتيح للجميع التسجيل فى رابطة أبناء عرابه فى الاردن و الذى من خلال الانضمام الى الرابطة سوف يكون له الاثر الكبير فى العمل على مساعدة أبناء عرابه فى المهجر أينما كانوا.
        ان انضمامكم الى هذا الموقع يعبر بالاكيد عن انتمائكم و ولائكم لبلدنا الحبيب عرابه.
        الموقع الرسمى لاهالى عرابه فى الوطن و المهجر



        <b> www.arrabah.net</b><br />

        <strong>
            <b>أخوكم \</b>
            محمود غالب موسى</strong>

    </p>

	@if($welcomePage = $homeWelcome->page)
	<a href="{{ URL::page($welcomePage) }}"><div class="grey-more nice-font">المزيد</div></a>
	@endif
</div><!-- END of white-box -->
@endif

<div class="clr"></div>

<div id="body">
	<div class="right-section">

		<a href="{{ URL::route('contact-us') }}"><div class="banner-suggestions title-font"></div></a>
		@if(! $authUser)
		<a href="{{ URL::route('register') }}"><div class="banner-register title-font"></div></a>
		@else
		<a href="{{ URL::route('chat') }}"><div class="banner-chat title-font"></div></a>
		@endif

		<div class="white-box small-box">
			<h2 class="title title-font">صور متحركة</h2>

			<div class="image-slider" style="margin:20px; margin-bottom:40px">

				<div class="slides_container">
					@for($i = 0; $i < count($movingImages); $i+=2)

						<div class="slide">
							<a href="{{ URL::image($movingImages[$i]) }}"><img src="{{ $movingImages[$i]->getUrl(145, 145) }}" width="113"  /></a>
							@if(isset($movingImages[$i + 1]))
							<a href="{{ URL::image($movingImages[$i + 1]) }}"><img src="{{ $movingImages[$i + 1]->getUrl(145, 145) }}" width="113" style="margin-right:10px;" /></a>
							@endif
						</div>

					@endfor
				</div>
			</div>
		</div><!-- END of white-box -->


		<div class="white-box small-box">
			<h2 class="title title-font">مناسبات و أحداث</h2>
			@if($latestEvent)
			<h3 class="small-title">{{ Str::limit($latestEvent->title, 20) }}</h3>
			<p class="nice-font">
				{{ Str::limit($latestEvent->description, 100) }}
			</p>
			<div class="clr"></div>
			<a href="{{ URL::event($latestEvent) }}"><div class="grey-more nice-font">المزيد</div></a>
			@endif
		</div><!-- END of white-box -->


		<div class="clr"></div>

		<div class="other-logos">
			@foreach($allLinks as $link)
				@if(strpos($link->identifier, 'banner') > -1 && $image = $link->image)
				<div class="other-logo bwWrapper">
					<a href="{{ $link->url }}">
						<img src="{{ $image->getUrl(120, 120) }}" />
					</a>
				</div>
				@endif
			@endforeach

<!-- 			<a href="http://www.aljazeera.net/portal"><div class="other-logo aljazeera"></div></a>
			<a href="http://www.alarabiya.net/"><div class="other-logo alarabiya"></div></a>
			<a href="http://www.filgoal.com/Arabic/"><div class="other-logo yallakora"></div></a>
			<a href="http://www.alarab.net/"><div class="other-logo alarab"></div></a> -->
		</div>

		<style type="text/css">
		</style>
	</div><!-- END of right section -->

	<div class="left-section">
		@if(! $arrabahUsers->isEmpty())
		<div class="white-box city-box">
			<h2 class="title title-font">أبناء البلد</h2>

			<div id="city-slider">
				<div class="slides_container">

					@foreach($arrabahUsers as $user)
					<div class="slide">
						<p class="nice-font" style="width:200px; float:right;">
							<b>الأسم: </b> <span class="user-value">{{ $user->first_name }}</span><br />
                            @if($user->family)
							<b>العائلة: </b> <span class="user-value">{{ $user->family->name }}</span><br /><br />
                            @endif
							<b style="color:#900;">معلومات التواصل</b><br />
							<b>الإيميل: </b> <span class="user-value" style="font-size:12px;">{{ $user->email }}</span><br />
							<b>الدولة: </b> <span class="user-value">{{ $user->city->getCountry()->arabic }}</span><br />
							<b>المدينة: </b> <span class="user-value">{{ $user->city->getCity()->arabic }}

							@if($user->city->isRegion())
							,{{ $user->city->arabic }}
							@endif
							</span><br />
						</p>
						<div class="slider-box">
							<a href="{{ URL::profile($user) }}">
								@if($user->profileImage)
								<img src="{{ $user->profileImage->getUrl( 122, 122 ) }}" class="slider-img" width="122" height="122" />
								@else
								<img src="{{ URL::asset('albums/defaults/user-profile.jpg') }}" class="slider-img" />
								@endif
							</a>
							<div class="clr"></div>
							<div class="nav">
								<div class="next-btn"></div>
								<div class="prev-btn"></div>
							</div>
						</div>
					</div><!-- END of slide -->
					@endforeach

				</div>
			</div>
			<div class="clr"></div>
		</div>
		@endif

		<div class="clr"></div>

		@if($question)
		<div class="white-box" style="margin-top:10px; padding-bottom:10px;">
			<h2 class="title title-font">التصويت</h2>

			<form action="{{ URL::route('vote') }}" method="POST" id="votingForm">
				<p class="nice-font">
					<b style="font-size:16px;">{{ $question->title }}</b>

					<div style="margin-right:30px">
						@foreach($question->answers as $answer)
						<input type="radio" name="Vote[answer]" id="vote-answer[]" value="{{ $answer->id }}" /><span class="answer">{{ $answer->title }}</span><Br />
						@endforeach
					</div>
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="Vote[question]" id="vote-question" value="{{ $question->id }}" />
					<input type="submit" class="grey-btn" value="تصويت" style="float:left; margin-left:15px;" />
				</p>
			</form>
			<div class="clr"></div>
		</div>
		@endif
	</div><!-- END of left section -->

	<div class="clr"></div>

</div><!-- END of body -->

@stop


@section('scripts')

	@include('home.scripts')

@stop