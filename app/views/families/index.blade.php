@extends('master.layout1')

@section('body')
<div class="white-box families" style="padding-bottom:20px;">
	<h2 class="title title-font"><div class="family-icon"></div>العائلات</h2>

	<div class="tools">

	</div>

	<div class="all">

		@foreach($families as $family)
			@if($oldestUser = $family->getOldestUser())
			<div class="boxgrid caption">
				<div class="user-stars">
				</div>
			    <a href="{{ URL::family($family) }}">
			    	@if($oldestUser->profileImage)
			    	<img src="{{ $oldestUser->profileImage->getUrl( 145, 145 ) }}" width="145" height="145" />
			    	@else
			    	<img src="{{ AlbumsManager::defaultImage('user.profile') }}" width="145" height="145" />
			    	@endif
			    </a>
			    <div class="cover boxcaption">
			        <p>{{ $family->name }}<br/></p>  
			    </div>  
			</div>
			@endif
		@endforeach

		<div class="clr"></div>

	</div>
</div><!-- END of white-box -->


<div class="pages">
	<ul>
		{{ $families->links() }}

		<!-- <li><a href="#" class="active">1</a></li>
		<li><a href="#">2</a></li>
		<li><a href="#">3</a></li> -->
	</ul>
</div>
@stop