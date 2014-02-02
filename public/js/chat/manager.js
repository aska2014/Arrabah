function Manager( htmlHandler, routes )
{
	this.routes      = routes;
	this.htmlHandler = htmlHandler;
	this.allTabs     = [];
	this.currentTab  = null;
	this.currentFamily = 0;

	// First update all tabs messages event
	this.firstUpdateAllTabsMessages = true;
}


Manager.prototype.getTabFromHtml = function( htmlTab )
{
	for (var i = 0; i < this.allTabs.length; i++) {
		if(this.allTabs[i].getTargetId() == this.htmlHandler.getTargetId(htmlTab)) {

			return this.allTabs[i];
		}
	};
}


Manager.prototype.addTab = function( tab )
{
	this.allTabs.push(tab);
}



Manager.prototype.getTabKey = function( tab )
{

	for(var i = 0; i < this.allTabs.length; i++)
	{
		if(this.allTabs[i].equals(tab)) {

			return i;
		}
	}

	return -1;
}



Manager.prototype.removeTab = function( tab )
{
	this.allTabs.splice(this.getTabKey(tab), 1);

	this.htmlHandler.removeTab(tab);
}


Manager.prototype.changeFamily = function( family )
{
	this.currentFamily = family;

	this.htmlHandler.loadingMenuMembers();

	this.getOnlineUsers( family );
}



Manager.prototype.getOnlineUsers = function( family )
{
	var myThis = this;

	$.ajax({
		cache:false, 
		type: "GET",
		data: "family=" + family,
		url: this.routes.getOnlineUsers,
		success:function(data)
		{
			myThis.htmlHandler.syncronizeMenuMembers(data);
			
			myThis.htmlHandler.loadedMenuMembers();
		}
	});
}



// Manager.prototype.updateOnline = function()
// {
// 	$.ajax({cache:false, type:"GET", url: this.routes.updateOnline});
// }




Manager.prototype.updateAllTabsMessages = function()
{
	var types          = [];
	var ids            = [];
	var lastMessageIds = [];

	for (var i = 0; i < this.allTabs.length; i++)
	{
		var tab = this.allTabs[i];

		types.push(tab.type);
		ids.push(tab.id);
		lastMessageIds.push(tab.lastMessageId);
	}

	var myThis = this;

	$.ajax({
		cache:false,
		type:"GET",
		data: {
			"types" : types,
			"ids"   : ids,
			"lastMessageIds" : lastMessageIds
		},
		url:this.routes.requestChatMessages,
		success:function( data )
		{
			// Check if there were new tabs to open for this user
			if('newTabs' in data) {

				var newTabs = data.newTabs;
				var tab;

				for (var i = 0; i < newTabs.length; i++) {
					
					tab = new Tab(newTabs[i].name, newTabs[i].type, newTabs[i].id);

					myThis.openTab(tab, true);

					myThis.redify(tab);
				}
			}

			// Loop through all tabs and update them
			for (var i = 0; i < myThis.allTabs.length; i++)
			{
				var targetId = myThis.allTabs[i].getTargetId();

				if(targetId in data) {

					var messages = data[targetId].messages;

					var tab = myThis.allTabs[i];

					var canScroll = myThis.htmlHandler.canScrollDown(tab);

					for(var j = messages.length - 1; j >= 0; j--)
					{
						myThis.htmlHandler.addNewMessage(tab, messages[j], true);
					}

					myThis.allTabs[i].lastMessageId = data[targetId].lastMessageId;

					// If not current tab and there're new messages then redify this tab
					if(! tab.equals(myThis.getCurrentTab())) {

						if(messages.length > 0) myThis.redify(tab);
					}

					// Else if it equals the current tab and can scroll then scroll down to the target.
					else{

						if(canScroll && messages.length > 0) myThis.htmlHandler.scrollDownTarget(tab);
					}
				}
			}
		}
	});		
}





Manager.prototype.sendChatMessage = function(image, name, body)
{
	var tab = this.getCurrentTab();

	var tempId = this.htmlHandler.addNewMessage(tab, {
		'image' : image,
		'name'  : name,
		'body'  : body
	}, false);

	this.htmlHandler.scrollDownTarget(tab);

	var myThis = this;

	$.ajax({
		cache:false,
		type:"POST",
		url: this.routes.sendChat,
		data:"description=" + body + "&type=" + tab.type + "&id=" + tab.id,
		success:function(data)
		{
			if(data.message == 'success') {

				myThis.htmlHandler.setActive(tempId, data.messageId);
			}
		}
	});
}



Manager.prototype.openTab = function( tab, withoutSelect )
{
	// If it wasn't created before.
	if(! this.htmlHandler.tabExists(tab)) {

		// Let the html handler create new tab
		this.htmlHandler.createNewTab(tab);

		// Add it to the tabs
		this.addTab(tab);
	}

	if(! withoutSelect)
		// Select tab
		this.selectTab(tab);
}


Manager.prototype.selectTab = function( tab )
{
	this.currentTab = tab;

	this.htmlHandler.selectTab(tab);

	this.htmlHandler.scrollDownTarget(tab);
}


Manager.prototype.closeTab = function( tab )
{
	if(this.allTabs.length > 1) {

		this.removeTab( tab );

		// If the tab needed to be closed is the current tab then select another tab.
		if(this.isCurrentTab(tab)) {

			this.selectTab(this.allTabs[0]);
		}
	}
}



Manager.prototype.isCurrentTab = function( tab )
{
	return tab.equals(this.getCurrentTab());
}


Manager.prototype.redify = function( tab )
{
	this.htmlHandler.redify(tab);
}




Manager.prototype.getCurrentTab = function()
{
	return this.currentTab;
}


Manager.prototype.getCurrentFamily = function()
{
	return this.currentFamily;
}