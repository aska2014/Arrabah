$(document).ready(function()
{
	$(".family-slct").select2();

	// Initialize manager and htmlhandler.
	htmlHandler = new HtmlHandler();
	manager = new Manager(htmlHandler, {

		updateOnline: "{{ URL::route('update-online', Route::currentRouteName()) }}",
		getOnlineUsers: "{{ URL::route('get-online-users', Route::currentRouteName()) }}",
		requestChatMessages: "{{ URL::route('request-chat-messages') }}",
		sendChat: "{{ URL::route('send-chat') }}"

	});

	// Open new tab
	manager.openTab(new Tab('جميع العائلات', 'all'));

	// Submiting chat form
	$("#chatForm").submit(function()
	{
		var txtarea = $(this).find('textarea');

		if(txtarea.val() == '') return false;

		// Send chat message
		manager.sendChatMessage("{{ $authUser->profileImage->getUrl(40, 40) }}", "{{ $authUser->getTwoName2() }}", txtarea.val());

		txtarea.val('');

		return false;
	});


	$("#chat-txtarea").keypress(function(event)
	{
		var keycode = (event.keyCode ? event.keyCode : event.which);

		if(keycode == '13') {

			$("#chatForm").submit();

			return false;
		}
	});

	// Select family
	$(".family-slct").change(function()
	{
		manager.changeFamily($(this).val());
	});

	// Clicking on member from the right menu.
	$(".member-filter").live('click', function()
	{
		var memberid = $(this).attr('id').replace('member', '');

		// Open a new tab
		manager.openTab(new Tab($(this).find('.name').html(), 'member', memberid));
	});

	// If close tab is clicked then refuse clicking on tab.
	var closeTabClicked = false;

	// Select the clicked tab.
	$(".tab").live('click', function()
	{
		if(closeTabClicked) return;

		// Select the clicked html tab.
		manager.selectTab(manager.getTabFromHtml($(this)));
	});

	// Close the clicked tab.
	$(".tab .close").live('click', function()
	{
		closeTabClicked = true;

		// Close the clicked html tab.
		manager.closeTab(manager.getTabFromHtml($(this).parent()));

		setTimeout(function(){closeTabClicked = false;}, 50);
	});

	// Update Online users for the current selected family every 5 seconds
	setInterval('manager.getOnlineUsers(manager.getCurrentFamily())', 5000);

	// Update online every 3 seconds
	setInterval('manager.updateOnline()', 2000);

	// Update all tabs every 1 second
	setInterval('manager.updateAllTabsMessages()', 1000);
});