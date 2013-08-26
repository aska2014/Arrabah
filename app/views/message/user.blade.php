@extends('master.layout1')

@section('body')
<div class="white-box">

	<h2 class="title title-font">{{ $messenger->getTitle() }}</h2>

	<p>
		{{ $messenger->getDescription() }}
	</p>

</div>
@stop