=== ThumbSniper ===
Contributors: CupRacer
Donate link: http://www.mynakedgirlfriend.de/donate-spenden/
Tags: screenshot, image, plugin, thumbshot, preview, tooltip, thumbnail, hyperlink, link, url, fade, 3D, reflection
Requires at least: 2.9
Tested up to: 3.2.1
Stable tag: 0.9.9

This plugin dynamically shows preview screenshots of hyperlinks as tooltips on your WordPress site.



== Description ==

This plugin dynamically shows preview screenshots of hyperlinks as tooltips on your WordPress site.
It's configurable whether you'd like to preview all, only external or specially marked hyperlinks.

For the tooltip effect a jQuery plugin called "qTip2" is used internally.
Find more about it here: http://craigsworks.com/projects/qtip2/

This is the next-generation of my previously developed plugin "FadeOut-ThumbShots".
ThumbSniper looks sexier than the old plugin, has better features and should be much faster (I hope)!

Please let me know about your oppinion and spend me a backlink. Thanks. :-)



== Installation ==

1. Upload the directory 'thumbsniper' to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Make your settings through the 'Settings' menu in WordPress



== Frequently Asked Questions ==

= Why does it take a couple of hovers to get the link image to appear? =

It's not a bug - it's a mechanism.
The plugin doesn't generate the thumbnails directly. The script sends a request for the thumbnail to the central ThumbSniper server. If the URL is requested for the first time, it'll be put in a queue - and you see a dummy image. After a few moments the thumbnail is created, so if you hover the link again, the requested image is served and shown correctly.

= How exactly does this work? =

The shown tooltips contain a HTML "img" tag. The source URL of this tag points to the ThumbSniper service. The chosen image size and the URL of the current hyperlink are sent as parameters. The ThumbSniper service stores this data in a database a redirects the tooltip img to a dummy image. Then a thumbnail generator gets the order to generate a thumbnail for the stored URL. After successfully generating the image, the ThumbSniper service gets the image. The process of generating the image should take about 3 to 10 seconds. When the tooltip is shown again (by another mouse hover) the ThumbSniper service redirects to the correct thumbnail url and - here it is!

= Is the TumbSniper service free? =
The ThumbSniper service is free of cost.

= Who's the owner the ThumbSniper service? =
It is written, operated and maintained by myself.


== Screenshots ==

1. This screenshot shows a tooltip preview which is shown while holding the mouse cursor over the WordPress.org hyperlink.



== Changelog ==

= 0.9.9 =
* jQuery update to version 1.6.4
* qTip2 update to version "nightly-daba4a5790f9d1f19a87f95ddbf6a7411317572541"
  Please keep in mind that the qTip2 site describes this version as not suitable for production sites. I don't really care about that. :-)
* I use ajax to get the thumbnail urls as jsonp results now. That's cool because we get a nice gui-wait feedback while the thumbnails are loaded.
* added some more styles - the default from now on is "jtools", you should give it a try!
* minor code changes

= 0.9.7 =
* Fixed a bug which might have caused some problems with Firefox/Mozilla.

= 0.9.6 =
* Changed the method to load the required jQuery library.
* The plugin uses plugins_url() instead of a hard-coded path now.
* Changed jQuery namespace to ThumbSniper to avoid conflicts.

= 0.9.5 =
* removed redundant code in the admin menu

= 0.9.4 =
* Changed the way jQuery() is called to avoid conflicts with other site scripts.

= 0.9.3 =
* Excluded urls were ignored. The missing code should do it's work now.

= 0.9.2 =
* Added CSS attributes for the tooltip image to avoid disturbances with site-wide img-styles that might exist on a site.

= 0.9.1 =
* This is the first released version.



== Upgrade Notice ==

= 0.9.6 =
* None.

= 0.9.5 =
* None.

= 0.9.4 =
* None.

= 0.9.3 =
* None.

= 0.9.2 =
* None.

= 0.9.1 =
* None.

