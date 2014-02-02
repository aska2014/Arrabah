function Tab( name, type, id, lastMessageId )
{
	this.name = name;
	this.type = type;
	this.id   = id || 0;
	// Default value for lastMessageId
	this.lastMessageId = lastMessageId || 0;
}

Tab.prototype.getTargetId = function()
{
	return this.type + '-' + this.id;
}

Tab.prototype.equals = function( tab )
{
	return this.type == tab.type && this.id == tab.id;
}