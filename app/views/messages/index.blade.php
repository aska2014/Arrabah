@extends('master.layout1')

@section('body')
<div class="white-box profile">

	<h2 class="title title-font">صفحة الرسائل</h2>

	@include('messages.submenu')

	@if(! $messages->isEmpty())

    <table class="messages-table">
        <thead>
            <tr>
                @if(Route::currentRouteName() != 'sent')
            	<th width="20%">العضو</th>
                @endif
            	<th width="25%">عنوان الرسالة</th>
            	<th width="40%">نص الرسالة</th>
            	<th width="20%">الوقت</th>
            </tr>
        </thead>
        <tbody>
        	@foreach($messages as $message)
            <tr class="message-row{{ $message->isTo($authUser) && ! $message->isSeen() ? ' not-seen' : '' }}" target="{{ URL::message($message) }}">
                @if(Route::currentRouteName() != 'sent')
            	<td>{{ $message->getFromUser()->getTwoName() }}</td>
            	@endif
                <td>{{ $message->title }}</td>
            	<td>{{ Str::limit($message->description, 70) }}</td>
            	<td>
            		{{ EasyDate::arabic('j F', $message->created_at) }}<br />
            		<span style="color:#900">{{ EasyDate::arabic('H:i', $message->created_at) }}</span>
            	</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @else

	<div class="empty-message">لا يوجد رسائل فى هذه الصفحة.</div>

    @endif

    <div class="clr"></div>

	<div class="pages">
    	{{ $messages->links() }}
	</div>

</diV>
@stop


@section('scripts')
<script type="text/javascript">

$(document).ready(function()
{
	$(".message-row").mouseover(function() { $(this).fadeTo(10, 0.7); });
	$(".message-row").mouseout(function()  { $(this).fadeTo(10, 1);   });

	$(".message-row").click(function()
	{
		window.location.href = $(this).attr('target');
	});
});

</script>
@stop