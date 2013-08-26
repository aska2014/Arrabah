@extends('master.layout1')

@section('body')
<div class="white-box message">

	<h2 class="title title-font">صفحة الرسائل</h2>

	@include('messages.submenu')

	<div class="info">
		@if(! $message->getFromUser()->same( $authUser ))
		<div class="row">
			<div class="key">من</div>
			<div class="value">
				<a href="{{ URL::profile($message->getFromUser()) }}">{{ $message->getFromUser()->getTwoName() }}</a>
				<a href="{{ URL::sendMessageTo($message->getFromUser()) }}" class="small-red">إرسال رسالة لهذا العضو ؟</a>
			</div>
		</div>
		<div class="clr"></div>
		@endif
		@if(! $message->getToUser()->same( $authUser ))
		<div class="row">
			<div class="key">إلى</div>
			<div class="value">
				<a href="{{ URL::profile($message->getToUser()) }}">{{ $message->getToUser()->getTwoName() }}</a>
				<a href="{{ URL::sendMessageTo($message->getToUser()) }}" class="small-red">إرسال رسالة لهذا العضو ؟</a>
			</div>
		</div>
		<div class="clr"></div>
		@endif
		<div class="row">
			<div class="key">وقت الإرسال</div><div class="value">{{ EasyDate::arabic('j F, h:i a', $message->created_at) }}</div>
		</div>
		<div class="clr"></div>
		@if($message->title)
		<div class="row">
			<div class="key">عنوان الرسالة</div><div class="value">{{ $message->title }}</div>
		</div>
		<div class="clr"></div>
		@endif
		<div class="row">
			<div class="key">نص الرسالة</div><div class="value">{{ $message->description }}</div>
		</div>
		<div class="clr"></div>
	</div>

</div>
@stop