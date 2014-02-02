function HtmlHandler()
{
	this.fakeId = 0;
}


HtmlHandler.prototype.loadingMenuMembers = function()
{
	$(".members-filter").fadeTo(200, 0.4);
}


HtmlHandler.prototype.loadedMenuMembers = function()
{
	$(".members-filter").fadeTo(200, 1);
}


HtmlHandler.prototype.removeAllMenuMembers = function()
{
	$(".members-filter").html('');
}


HtmlHandler.prototype.syncronizeMenuMembers = function( members )
{
	var ids = [];

	// Add menu members if they weren't already added
	for (var i = 0; i < members.length; i++) {

		ids.push(parseInt(members[i].id));

		if($("#member" + members[i].id).length == 0) {
			
			this.addMenuMember(members[i]);
		}
	};

	// Delete members if they are not in the ids array
	$(".member-filter").each(function()
	{
		if(ids.indexOf(parseInt($(this).attr('id').replace('member', ''))) < 0) {

			$(this).remove();
		}
	});
}


HtmlHandler.prototype.addMenuMember = function( member )
{
	$(".members-filter").append('<div class="member-filter" id="member' + member.id + '"><img src="' + member.image + '" /><div class="name">' + member.name + '</div></div>');
}


HtmlHandler.prototype.addNewMessage = function(tab, message, active, slide)
{
	if(active && $("#message" + message.id).length > 0) {

		return;
	}

	var htmlMessage = $('<div class="message"><div class="member"><img src="' + message.image + '" /><div class="name"><a href="' + message.url + '">' + message.name + '</a></div></div><div class="clr"></div><div class="message-body">' + message.body + '</div><div class="clr"></div></div>');

	this.getHtmlTarget(tab).find('.messages').append(htmlMessage);

	if(slide) {
		htmlMessage.css('display', 'none');
		htmlMessage.slideDown({'duration': 100, complete: scrollTop});
	}

	// If not active
	if(! active) {

		var fakeId = this.getFakeId();

		htmlMessage.fadeTo(0, '0.5');
		htmlMessage.attr('id', 'fakeMessage' + fakeId);

		return fakeId;
	}
	
	htmlMessage.attr('id', 'message' + message.id);
}


HtmlHandler.prototype.setActive = function( fakeId, realId )
{
	$("#fakeMessage" + fakeId).fadeTo(100, 1);
	$("#fakeMessage" + fakeId).attr('id', 'message' + realId);
}


HtmlHandler.prototype.scrollDownTarget = function( tab )
{
	var target = this.getHtmlTarget(tab).find('.messages');

	target.scrollTop(target[0].scrollHeight);
}

HtmlHandler.prototype.canScrollDown = function( tab )
{
	var target = this.getHtmlTarget(tab).find('.messages');

	return target[0].scrollHeight - target.scrollTop() <= target.outerHeight() + 50;
}



HtmlHandler.prototype.createNewTab = function(tab)
{
	var tabHtml     = $('<div class="tab" target="' + tab.getTargetId() + '">' + tab.name + '<span class="close">×</span></div>');
	var targetHtml  = $('<div class="chat-body" id="' + tab.getTargetId() + '"><div class="top-body">هذه المحادثة بينك وبين <span>' + tab.name +'</span>.</div><div class="clr"></div><div class="messages"></div></div>');

	$(".tabs").append(tabHtml);
	$(".all-tabs").append(targetHtml);
}


HtmlHandler.prototype.selectTab = function(tab)
{
	$(".chat-body").removeClass('active-tab-body');

	this.getHtmlTarget(tab).addClass('active-tab-body');

	$(".tab").removeClass('active-tab');

	this.getHtmlTab(tab).addClass('active-tab');

	// Remove the redify from the tab
	this.removeRedify(tab);
}


HtmlHandler.prototype.tabExists = function(tab)
{
	return this.getHtmlTarget(tab).length > 0;
}

HtmlHandler.prototype.tabSelected = function(tab)
{
	return this.getHtmlTab(tab).hasClass('active-tab');
}


HtmlHandler.prototype.removeTab = function(tab)
{
	// Remove the tab and the target.
	this.getHtmlTab(tab).remove();
	this.getHtmlTarget(tab).remove();
}


HtmlHandler.prototype.redify = function( tab )
{
	this.getHtmlTab(tab).addClass('new-tab');
}


HtmlHandler.prototype.removeRedify = function( tab )
{
	this.getHtmlTab(tab).removeClass('new-tab');
}



HtmlHandler.prototype.getHtmlTab = function(tab)
{
	return $(".tabs").find('[target="' + tab.getTargetId() + '"]');
}


HtmlHandler.prototype.getHtmlTarget = function(tab)
{
	return $("#" + tab.getTargetId());
}


HtmlHandler.prototype.getTargetId = function(htmlTab)
{
	return htmlTab.attr('target');
}


HtmlHandler.prototype.getFakeId = function()
{
	this.fakeId++;

	return this.fakeId;
}