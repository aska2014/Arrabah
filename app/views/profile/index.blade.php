@extends('master.layout1')

@section('body')
<div class="white-box profile">

	<h2 class="title title-font">{{ $profileUser->getTwoName() }}</h2>

	@include('profile.submenu')

	<div class="profile-img">
		@if($profileUser->profileImage)
		<a href="{{ URL::image( $profileUser->profileImage ) }}">
			<img src="{{ $profileUser->profileImage->getUrl( 122, 122 ) }}" width="122" height="122" />
		</a>
		@else
		<img src="{{ URL::asset('albums/defaults/user-profile.jpg') }}" />
		@endif
		<div class="clr"></div>
		@if(! $authUser->same( $profileUser ))
		<a href="{{ URL::sendMessageTo($profileUser) }}"><div class="send-message">أرسل رسالة</div></a>
		@endif
	</div>

	<div class="profile-info">

		<div class="profile-section">
			<h3 class="info-title">بيانات شخصية <div class="plus-icon"> إخفاء </div></h3>

			<div class="box">
				<div class="row">
					<div class="right-row">
						<div class="key">الأسم الأول:</div><div class="value">{{ $profileUser->first_name }}</div>
					</div>
					<div class="left-row">
						<div class="key">أسم الأب:</div><div class="value">{{ $profileUser->father_name }}</div>
					</div>
				</div>

				<div class="clr"></div>

				<div class="row">
					<div class="right-row">
						<div class="key">أسم الجد:</div><div class="value">{{ $profileUser->grand_father_name }}</div>
					</div>
					<div class="left-row">
                        @if($profileUser->family)
						<div class="key">أسم العائلة:</div><div class="value">{{ $profileUser->family->name }}</div>
                        @endif
					</div>
				</div>

				<div class="clr"></div>
			</div>

		</div>

		<div class="clr"></div>

		<div class="profile-section">
			<h3 class="info-title">بيانات عامة <div class="plus-icon"> إخفاء </div></h3>

			<div class="box">
				<div class="row">
					<div class="right-row">
						<div class="key">تاريخ الميلاد:</div><div class="value">{{ EasyDate::arabic('F j, Y', $profileUser->day_of_birth) }}</div>
					</div>
					<div class="left-row">
						<div class="key">مكان الميلاد:</div><div class="value">{{ $profileUser->place_of_birth }}</div>
					</div>
				</div>

				<div class="clr"></div>

				@if($city = $profileUser->city)
				<div class="row">	
					<div class="key">العنوان:</div>
					<div class="only-value">
						<div class="value-section">{{ $city->getCountry()->arabic }}</div>
						<div class="value-section">{{ $city->getCity()->arabic }}</div>
						@if($city->isRegion())
						<div class="value-section">{{ $city->arabic }}</div>
						@endif
					</div>
				</div>
				@endif
				<div class="clr"></div>
			</div>
		</div>

		<div class="clr"></div>

		<div class="profile-section">
			<h3 class="info-title">بيانات التواصل <div class="plus-icon"> إخفاء </div></h3>
			<div class="box">
				<div class="row">
					<div class="right-row">
						<div class="key">رقم التليفون:</div><div class="value">{{ $profileUser->telephone_no }}</div>
					</div>
					<div class="left-row">
						<div class="key">الإيميل:</div><div class="value">{{ $profileUser->email }}</div>
					</div>
				</div>

				<div class="clr"></div>
			</div>

		</div>
	</div>

	<div class="clr"></div>

</diV>
@stop