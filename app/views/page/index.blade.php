@extends('master.layout1')

@section('body')
<div class="white-box events">
	<h2 class="title title-font"><div class="page-icon"></div>{{ $page->title }}</h2>

	<div class="description">

		{{ $page->description }}

	</div>

	<div class="clr"></div>
	@include('social.facebook')
	
</div><!-- END of white-box -->

@stop

@section('styles')
<style type="text/css">
.white-box .description{ margin:20px; }
</style>
@stop