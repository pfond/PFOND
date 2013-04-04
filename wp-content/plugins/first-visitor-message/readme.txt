=== Plugin Name ===
Contributors: Thijmen1992
Donate link: http://www.thijmenstavenuiter.nl/
Tags: first visit, message, popup, jquery
Requires at least: 3.0.0
Tested up to: 3.0.1
Stable tag: 0.6.4

Shows up a simple but nice message when a visitor visits your weblog for the first time.

== Description ==

This plugin shows a message on your weblog when a visitor visits your site for the first time. 
They can either click the message away, or push the button 'Do not show this again'. After pushing the button, there will be added an entry to the database which
makes sure that the message won't show up anymore to the visitor with that IP-address.

Everything is fully configurable via the WordPress backend.

**Found a bug? Please report it to thijmenstavenuiter@gmail.com**

== Installation ==

Installing this plugin is very easy. Just upload the plugin, and activate it.

To change the title, message and buttons, simple go to the WordPress backend, and go to *First Visit Settings*.
You can change aspects of this plugin up there.

== Frequently Asked Questions ==

= My message-box won't shop up! =

Did you activate the plugin, and did you configure it?

= The bar shows up, but there is no text in it! =

Ah, then you have to setup the text first. Simple go to *First Visit Settings* in the WordPress backend, and set up the variables.

= I think I have found a bug! =

Please email me the details of your bug, email them to **thijmenstavenuiter@gmail.com**. Thanks!
== Screenshots ==

1. Preview of the popup box.

== Changelog ==

= 0.6.4 =
* Fixed: Closed <script> tag for popup_cookies.php, might fixed IEx problems.

= 0.6.3 =
* Removed: Stupid message when Cookies are selected.

= 0.6.2 =
* Added: Checking if url_close does exist.

= 0.6.1 =
* Fixed: Function url_close() fixed.

= 0.6 =
* Added: No more messing with themes! Popup will automaticly show up.

= 0.5.5.3 = 
* Fixed: Another PHP error. *sigh*

= 0.5.5.2 =
* Removed: replacements for cURL (might be added in the future)

= 0.5.5.1 =
* Fixed: PHP error.

= 0.5.5 = 
* Fixed: PHP error.

= 0.5.4 = 
* Added: replacements for cURL

= 0.5.3 = 
* Fixed: cURL error.

= 0.5 = 
* Added: Cookie option (Visitors will be veriefied by cookie, not by IP)
* Added: Option to switch bitween DB/Cookie


= 0.2.2 =
* Update SVN, plugin now updateable via the WordPress Backend

= 0.2 =
* Update SVN

= 0.1.1 =
* Update WordPress Plugin URL. Please update.

= 0.1 =
* Initial Release


