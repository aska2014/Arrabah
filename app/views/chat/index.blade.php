@extends('master.layout1')

@section('body')
<div class="chat-holder">	
	<div class="tabs">
	</div>

	<div class="clr"></div>

	<div class="chat">
		<div class="filter">
			<div class="family-filter">
				<form action="#" method="POST">
					<div class="input">
						<select class="family-slct">
							<option value="0">جميع العائلات</option>
							@foreach($families as $family)
							<option value="{{ $family->id }}">{{ $family->name }}</option>
							@endforeach
						</select>
					</div>
				</form>
			</div>

			<div class="clr"></div>

			<div class="members-filter">
				@foreach($allUsers as $user)
				<div class="member-filter" id="member{{ $user->id }}">
					<img src="{{ $user->profileImage->getUrl(40, 40) }}" />
					<div class="name">{{ $user->getTwoName2() }}</div>
				</div>
				@endforeach
			</div>
		</div><!-- /.filter -->

		<div class="all-tabs"></div>

		<div class="chat-form">
			<form action="{{ URL::route('send-chat') }}" method="POST" id="chatForm">
				<textarea name="Chat[description]" id="chat-txtarea" class="txtarea"></textarea>
				<input type="submit" value="إرسال" class="sbmt" />
			</form>
		</div>
		<div class="clr"></div>
	</div>
</div>
@stop


@section('scripts')
<script type="text/javascript">

$(document).ready(function(){$(".family-slct").select2();htmlHandler=new HtmlHandler();manager=new Manager(htmlHandler,{getOnlineUsers:"{{ URL::route('get-online-users', Route::currentRouteName()) }}",requestChatMessages:"{{ URL::route('request-chat-messages') }}",sendChat:"{{ URL::route('send-chat') }}"});manager.openTab(new Tab('جميع العائلات','all'));$("#chatForm").submit(function(){var txtarea=$(this).find('textarea');if(txtarea.val()=='')return false;manager.sendChatMessage("{{ $authUser->profileImage->getUrl(40, 40) }}","{{ $authUser->getTwoName2() }}",txtarea.val());txtarea.val('');return false});$("#chat-txtarea").keypress(function(event){var keycode=(event.keyCode?event.keyCode:event.which);if(keycode=='13'){$("#chatForm").submit();return false}});$(".family-slct").change(function(){manager.changeFamily($(this).val()); var title = $(this).find(':selected').text(); title = $(this).val() == 0 ? title : 'عائلة ' + title; var type = $(this).val() == 0 ? 'all' : 'family';manager.openTab(new Tab(title, type, $(this).val()))});$(".member-filter").live('click',function(){var memberid=$(this).attr('id').replace('member','');manager.openTab(new Tab($(this).find('.name').html(),'member',memberid))});var closeTabClicked=false;$(".tab").live('click',function(){if(closeTabClicked)return;manager.selectTab(manager.getTabFromHtml($(this)))});$(".tab .close").live('click',function(){closeTabClicked=true;manager.closeTab(manager.getTabFromHtml($(this).parent()));setTimeout(function(){closeTabClicked=false},50)});setInterval('manager.getOnlineUsers(manager.getCurrentFamily())',7000);setInterval('manager.updateAllTabsMessages()',1000)});
</script>
@stop