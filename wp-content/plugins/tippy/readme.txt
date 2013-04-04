=== Tippy ===
Contributors: Columcille
Tags: tooltip, popup
Requires at least: 2.1.5
Tested up to: 3.1.3
Stable tag: 3.7.0

Allows users to turn text into a tooltip or popup using a special [tippy] tag.

== Description ==

This plugin allows users to create custom popups or tooltips in their posts. The style and behavior of the tooltip are highly configurable through CSS and through the WordPress dashboard.

== Installation ==

Upload the plugin into your wp-content/plugins directory
Activate the plugin through the dashboard
Visit the Tippy Options page under the Settings section of your dashboard. This will set up all of the initial settings.

To customize the tooltip CSS, under plugins/tippy copy dom_tooltip.factory.css to dom_tooltip.css and make your modifications to dom_tooltip.css. You are advised not to change dom_tooltip.factory.css or you will lose any changes whenever you update the plugin. If the plugin finds dom_tooltip.css, it will use that instead of dom_tooltip.factory.css.

To use Tippy, just place Tippy tags wherever you want in your post. All of the attributes are optional except for title:
[tippy title="I am a tooltip!" class="myclass" header="on" reference="http://www.musterion.net/" width="450" height="200"]When you hover over a Tippy link, you will get a popup.[/tippy]

== Screenshots ==

1. Tippy in action!

== Changelog ==

= 3.7.0 =
* Added a new parameter to Tippy.loadTipInfo() for passing in a title
* Added the ability to generate the tooltip title from a manually coded title attribute

= 3.6.4 =
* Tweak to fix title for older hard coded links

= 3.6.3 =
* Some tweaks for Glossy compatibility

= 3.6.2 =
* Loads Tippy settings in admin dashboard
 
= 3.6.1 =
* Fixed a bug causing the tooltip not to work.

= 3.6.0 = 
* Added new attribute for a custom class on the tooltip links
* Minor glitches fixed
 
= 3.5.2 = 
* Fixed a backwards-compatibility issue
* Fixed a glitch with the close link on tooltips that don't have a header
 
= 3.5.1 =
* Fixed a glitch that caused an issue with Firefox
* Added option to make tooltips sticky
* Added option to make tooltip links and header links open in a new window
* A few refinements on the Close link
 
= 3.5.0 = 
* Several internal changes making Tippy more accessible to other plugins
* New optional Close link, giving mobile users a way to dismiss the tooltip

= 3.4.1 =
Make use of jQuery.noConflict() to avoid some errors

= 3.4.0 =
Fixed a glitch when a tooltip has headers off

Added height and width attributes to allow per-tooltip size customization.

= 3.3.3 =
Renamed dom_tooltip.css to dom_tooltip.factory.css, using dom_tooltip.css for user customized stylesheets which will not be overwritten when the tooltip is updated.

= 3.3.2 = 
Internally, Tippy now relies on jQuery to calculate positioning data and to manipulate the tooltip.

Added options to give blog administrator greater control over where the tooltip will be positioned.