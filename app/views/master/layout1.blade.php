@include('master.header')

<div id="content">
	
	<div id="right-panel">
		<div id="logo"></div>

		@include('master.rightpanel')

		@yield('rightpanel')
	</div>


	<div id="left-body">

		@if(! empty($success))
		<div class="success">
			<div class="close">×</div>
			<ul>
			@foreach($success as $successMessage)
				<li>{{ $successMessage }}</li>
			@endforeach
			</ul>
		</div>
		@endif

		@if(! empty($errors))
		<div class="errors">
			<div class="close">×</div>
			<ul>
			@foreach($errors as $error)

				<li>{{ $error }}</li>

			@endforeach
			</ul>
		</div>
		@endif

		<div class="clr"></div>

		@yield('body')

	</div><!-- END of body -->

	<div class="clr"></div>

</div>

@include('master.footer')