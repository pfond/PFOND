/*
dom_tooltip.js

DOM Tooltip by Chris Roberts
columcille@gmail.com
http://www.musterion.net/
*/

// Initialize Tippy object
var Tippy = new Tippy();

function Tippy()
{
	// Initialize variables
	
	// The following variables track page/mouse position, etc
	this.curPageX = 0;
	this.curPageY = 0;
	this.scrollPageX = 0;
	this.scrollPageY = 0;
	this.viewPageX = 0;
	this.viewPageY = 0;
	this.viewScreenX = 0;
	this.viewScreenY = 0;
	
	// The position and height of the tippy link
	this.tipLinkX = 0;
	this.tipLinkY = 0;
	this.tipLinkHeight = 0;
	
	// Where to position the tooltip
	this.tipPosition = "mouse";
	this.tipOffsetX = 0;
	this.tipOffsetY = 0;
	
	// Do we fade in and out?
	this.fadeRate = 300;
	this.timer;
	this.hiding = false;
	this.allowFreeze = true;
	
	this.sticky = false;
	this.showClose = true;
	
	this.tipId = "";
	
	this.tipBox = "";
	this.tipHeader;
	this.tipBody;
	
	this.jQuery = jQuery.noConflict();

	// Initialize functions
	this.setupTip = domTip_setupTip;
	this.initializeTip = domTip_initializeTip;
	this.setPositions = domTip_setPositions;
	this.fadeTippyOut = domTip_fadeTippyOut;
	this.fadeTippyFromClose = domTip_fadeTippyFromClose;
	this.fadeTippyIn = domTip_fadeTippyIn;
	this.loadTipInfo = domTip_loadTipInfo;
	this.populateTip = domTip_populateTip;
	this.moveTip = domTip_moveTip;
	this.freeze = domTip_freeze;
}

// Load tooltip settings
function domTip_setupTip(domTip_setFadeTip, domTip_setTipPosition, domTip_setTipOffsetX, domTip_setTipOffsetY)
{
	this.tipPosition = domTip_setTipPosition;
	this.tipOffsetX = domTip_setTipOffsetX;
	this.tipOffsetY = domTip_setTipOffsetY;
	
	if (domTip_setFadeTip == "fade")
	{
		this.fadeRate = 300;
	} else {
		this.fadeRate = 0;
	}
}

function domTip_initializeTip()
{
	// Initialize the tooltip singleton
	this.tipBox = this.jQuery('<div></div>')
		.hide()
		.css("display", "none")
		.css("position", "absolute")
		.css("height", "auto")
		.addClass("domTip_Tip")
		.attr("id", "domTip_tipBox")
		.mouseover(function() { Tippy.freeze(); })
		.appendTo('body');
	
	if (this.sticky == false)
	{
		this.tipBox.mouseout(function() { Tippy.fadeTippyOut(); })
	}
	
	this.tipHeader = this.jQuery("<div></div>")
		.css("height", "auto")
		.addClass("domTip_tipHeader")
		.attr("id", "this.tipHeader")
		.appendTo(this.tipBox);
	
	this.tipBody = this.jQuery("<div></div>")
		.css("height", "auto")
		.addClass("domTip_tipBody")
		.attr("id", "this.tipBody")
		.appendTo(this.tipBox);
}

// Initialize all position data
function domTip_setPositions(domTip_tipElement, domTip_event)
{
	if (!domTip_event)
		var domTip_event = window.event;
		
	this.scrollPageX = this.jQuery(window).scrollLeft();
	this.scrollPageY = this.jQuery(window).scrollTop();
	
	this.viewScreenX = this.jQuery(window).width();
	this.viewScreenY = this.jQuery(window).height();
	
	this.curPageX = domTip_event.clientX + this.scrollPageX;
	this.curPageY = domTip_event.clientY + this.scrollPageY;

	this.viewPageX = domTip_event.clientX;
	this.viewPageY = domTip_event.clientY;
	
	this.tipLinkHeight = this.jQuery("#" + domTip_tipElement).height();
	this.tipLinkX = this.jQuery("#" + domTip_tipElement).offset().left;
	this.tipLinkY = this.jQuery("#" + domTip_tipElement).offset().top;
}

// domTip_fadeTipOut() provides compatibility with older hard-coded Tippy links
function domTip_fadeTipOut()
{
	Tippy.fadeTippyOut();
}

function domTip_fadeTippyOut()
{
	clearTimeout(this.timer);
	this.tipId = "";
	this.hiding = true;
	
	this.timer = setTimeout("Tippy.tipBox.fadeOut(" + this.fadeRate + ", 'swing', function() { Tippy.hiding = false; })", 900);
}

function domTip_fadeTippyFromClose()
{
	this.tipId = "";
	this.hiding = true;
	this.allowFreeze = false;
	
	Tippy.tipBox.fadeOut(" + this.fadeRate + ", 'swing', function() { Tippy.hiding = false; Tippy.allowFreeze = true; });
}

function domTip_fadeTippyIn()
{
	clearTimeout(this.timer);
	this.timer = setTimeout("Tippy.tipBox.fadeIn(" + this.fadeRate + ")", 50);
}

// domTip_toolText() provides compatibility with older hard-coded Tippy links
function domTip_toolText(domTip_newTipId, domTip_tipText, domTip_headerText, domTip_headerLink, domTip_tipWidth, domTip_tipHeight, domTip_tipElement, domTip_event)
{
	if (domTip_headerText != "")
	{
		this.jQuery("#" + domTip_tipElement).attr('tippyTitle', domTip_headerText);
	}
	
	Tippy.loadTipInfo(domTip_tipText, domTip_tipWidth, domTip_tipHeight, domTip_tipElement, domTip_event);
}

function domTip_loadTipInfo(domTip_tipText, domTip_tipWidth, domTip_tipHeight, domTip_tipId, domTip_event, domTip_tipTitle)
{
	if (this.tipBox == "")
	{
		this.initializeTip();
	}
	
	this.tippyLinkId = domTip_tipId;
	domTip_newTipId = "tippy_" + domTip_tipId;
	
	if (this.tipId != domTip_newTipId)
	{
		// If we have a this.tipId then a tooltip is currently showing
		if (this.tipId != "" || this.hiding == true)
		{
			this.tipBox.hide();
			this.freeze();
			this.tipId = "";
			this.hiding = false;
		}
		
		// Update location info
		this.setPositions(domTip_tipId, domTip_event);
		
		// Change size
		
		// First, get calculated difference
		this.tipElementDifferenceHeader = this.tipBox.width() - this.tipHeader.width();
		this.tipElementDifferenceBody = this.tipBox.width() - this.tipBody.width();
		
		if (domTip_tipHeight != 0)
		{
			this.tipBody.css("height", domTip_tipHeight + "px");
			this.tipBody.css("min-height", domTip_tipHeight + "px");
			this.tipBody.css("max-height", domTip_tipHeight + "px");
		} else {
			this.tipBody.css("height", "auto");
			this.tipBody.css("min-height", "");
			this.tipBody.css("max-height", "");
		}

		if (domTip_tipWidth != 0)
		{
			this.tipBox.css("width", domTip_tipWidth + "px");
			this.tipHeader.css("width", domTip_tipWidth - this.tipElementDifferenceHeader + "px");
			this.tipBody.css("width", domTip_tipWidth - this.tipElementDifferenceBody + "px");
		} else {
			this.tipBox.css("width", "");
			this.tipHeader.css("width", "");
			this.tipBody.css("width", "");
		}
		
		this.tipId = domTip_newTipId;
		
		// domTip_headerText = this.jQuery("#" + domTip_tipId).attr('title');
		if (domTip_tipTitle != undefined)
		{
			domTip_headerText = domTip_tipTitle;
		} else if (this.jQuery("#" + domTip_tipId).attr('title') !== undefined) {
			domTip_headerText = this.jQuery("#" + domTip_tipId).attr('title');
		} else if (this.jQuery("#" + domTip_tipId).attr('tippyTitle') !== undefined) {
			domTip_headerText = this.jQuery("#" + domTip_tipId).attr('tippyTitle');
		} else {
			domTip_headerText = this.jQuery("#" + domTip_tipId).text();
		}
		
		domTip_headerLink = this.jQuery("#" + domTip_tipId).attr('href');
		
		this.populateTip(domTip_tipText, domTip_headerText, domTip_headerLink);		
	} else {
		this.freeze();
	}
}

function domTip_populateTip(domTip_tipText, domTip_headerText, domTip_headerLink)
{
	// Build the tip header
	if (domTip_headerText != "")
	{
		this.tipHeader.show();
		
		var headerHTML = domTip_headerText;
		
		if (domTip_headerLink != undefined && domTip_headerLink != "")
		{
			// See if the Tippy link has a target
			domTip_target = this.jQuery("#" + this.tippyLinkId).attr('target');
			
			if (domTip_target != "")
			{
				headerTarget = ' target="_blank"';
			} else {
				headerTarget = '';
			}
			
			headerHTML = '<a href="' + domTip_headerLink + '"' + headerTarget + '>' + domTip_headerText + '</a>';
		}
		
		if (this.showClose)
		{
			headerClose = '<div class="domTip_tipCloseLink" onClick="Tippy.fadeTippyFromClose();">Close</div>';
			
			headerHTML = headerHTML + headerClose;
		}
		
		this.tipHeader.html(headerHTML);
	} else {
		this.tipHeader.hide();
		
		if (this.showClose)
		{
			bodyClose = '<div class="domTip_tipCloseLink" onClick="Tippy.fadeTippyFromClose();">Close</div>';
			
			domTip_tipText = bodyClose + domTip_tipText;
		}
	}
	
	this.tipBody.html(domTip_tipText);
		
	this.moveTip();
	
	this.fadeTippyIn();
}

function domTip_moveTip()
{
	// Specify the location of the tooltip.
	
	// Get the height and width of the tooltip container. Will use this when
	// calculating tooltip position.
	this.tipHeight = this.tipBox.height();
	this.tipWidth = this.tipBox.width();
	
	// this.tipXloc and this.tipYloc specify where the tooltip should appear.
	// By default, it is just below and to the right of the mouse pointer.
	if (this.tipPosition == "mouse")
	{
		// Position below the mouse cursor
		this.tipXloc = this.curPageX + this.tipOffsetX;
		this.tipYloc = this.curPageY + this.tipOffsetY;
	} else if (this.tipPosition == "link") {
		// Position below the link
		this.tipXloc = this.tipLinkX + this.tipOffsetX;
		this.tipYloc = this.tipLinkY + this.tipOffsetY + this.tipLinkHeight;
	}
	
	// If the tooltip extends off the right side, pull it over
	if ((this.tipXloc - this.scrollPageX) + 5 + this.tipWidth > this.viewScreenX)
	{
		this.pageXDiff = ((this.tipXloc - this.scrollPageX) + 5 + this.tipWidth) - this.viewScreenX;
		this.tipXloc -= this.pageXDiff;
	}
	
	// If the tooltip will extend off the bottom of the screen, pull it back up.
	// alert(this.tipYloc + " " + this.viewScreenY + " " + this.tipHeight);
	if ((this.tipYloc - this.scrollPageY) + 5 + this.tipHeight > this.viewScreenY)
	{
		this.pageYDiff = ((this.tipYloc - this.scrollPageY) + 5 + this.tipHeight - this.viewScreenY);
		this.tipYloc -= this.pageYDiff;
	}

	// If the tooltip extends off the bottom and the top, line up the top of
	// the tooltip with the top of the page
	if (this.tipHeight > this.viewScreenY)
	{
		this.tipYloc = this.scrollPageY + 5;
	}
	
	// Set the position in pixels.
	this.tipBox.css("left", this.tipXloc + "px");
	this.tipBox.css("top", this.tipYloc + "px");
}

function domTip_freeze()
{
	if (this.allowFreeze == true)
	{
		clearTimeout(this.timer);
		this.tipBox.stop();
		this.tipBox.css("opacity", 100);
	}
}
