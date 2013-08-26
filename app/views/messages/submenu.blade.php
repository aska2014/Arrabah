<div class="title-menu">
	<a href="{{ URL::route('inbox') }}">
		<div class="title-button{{ Route::currentRouteName() == 'inbox' ? ' active-button' : '' }}">
			الرسائل الواردة
		</div>
	</a>
	<a href="{{ URL::route('sent') }}">
		<div class="title-button{{ Route::currentRouteName() == 'sent' ? ' active-button' : '' }}">
			الرسائل المرسلة
		</div>
	</a>
	<a href="{{ URL::route('compose') }}">
		<div class="title-button{{ in_array(Route::currentRouteName(), array('compose', 'send-message-to')) ? ' active-button' : '' }}">
			رسالة جديدة
		</div>
	</a>
</div>