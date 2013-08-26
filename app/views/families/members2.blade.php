@extends('master.layout1')

@section('body')

<div class="clr"></div>

@include('premium.banner')

<div class="white-box families" style="padding-bottom:20px;">
	<h2 class="title title-font"><div class="family-icon"></div>{{ $membersTitle }}</h2>

	<div class="title-menu">
		<a href="{{ URL::route('premium-members') }}">
			<div class="title-button{{ Route::currentRouteName() == 'premium-members' ? ' active-button' : '' }}">
				أعضاء مشاركة
			</div>
		</a>
		<a href="{{ URL::route('normal-members') }}">
			<div class="title-button{{ Route::currentRouteName() == 'normal-members' ? ' active-button' : '' }}">
				أعضاء شرف
			</div>
		</a>
		<a href="{{ URL::route('arrabah-members') }}">
			<div class="title-button{{ Route::currentRouteName() == 'arrabah-members' ? ' active-button' : '' }}">
				أبناء البلد
			</div>
		</a>
	</div>

	<div class="clr"></div>

	<div class="all" style="margin-top:20px;">

		@foreach($familyUsers as $user)
			<div class="boxgrid caption">
				<div class="user-stars">
					@if($user->fromArrabah())
					<div class="green-star user-star" tip="هذا العضو من أبناء البلد"></div>
					@endif
					@if($user->isPremium())
					<div class="red-star user-star" tip="هذا العضو مشترك فى رابطة عرابة"></div>
					@endif
				</div>
			    <a href="{{ URL::profile($user) }}">
			    	@if($user->profileImage)
			    	<img src="{{ $user->profileImage->getUrl( 145, 145 ) }}" width="145" height="145" />
			    	@else
			    	<img src="{{ AlbumsManager::defaultImage('user.profile') }}" width="145" height="145" />
			    	@endif
			    </a>
			    <div class="cover boxcaption">
			        <p>{{ $user->first_name }} - {{ $user->father_name }}<br/></p>  
			    </div>  
			</div>
		@endforeach

		<div class="clr"></div>

	</div>
</div><!-- END of white-box -->

<div class="pages">
	<ul>
		{{ $familyUsers->links() }}
	</ul>
</div>
@stop

@section('scripts')
<script type="text/javascript">
$(document).ready(function()
{
	$('.user-star').toolTip();
});

</script>
@stop