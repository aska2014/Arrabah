<div class="title-menu">
	<a href="{{ URL::profile($profileUser) }}">
		<div class="title-button{{ Route::currentRouteName() == 'profile' ? ' active-button' : '' }}">
			الصفحة الشخصية
		</div>
	</a>
	<a href="{{ URL::userEvents( $profileUser ) }}">
		<div class="title-button{{ Route::currentRouteName() == 'user-events' ? ' active-button' : '' }}">
			مناسبات وأحداث
		</div>
	</a>
	<a href="{{ URL::userJobs($profileUser) }}">
		<div class="title-button{{ Route::currentRouteName() == 'user-jobs' ? ' active-button' : '' }}">
			وظائف
		</div>
	</a>
	<a href="{{ URL::userGallery($profileUser) }}">
		<div class="title-button{{ Route::currentRouteName() == 'user-gallery' ? ' active-button' : '' }}">
			معارض الصور
		</div>
	</a>
</div>