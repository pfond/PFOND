=== Plugin Name ===
Contributors: Qurl
Donate link:
Tags: widget, widgets, dynamic, sidebar, custom, rules, logic, admin, condition, conditional tags, hide, wpml, qtranslate, wpec, buddypress
Requires at least: 2.9.1
Tested up to: 3.2.1
Stable tag: 1.4.2

Dynamic Widgets gives you full control on which pages your widgets will appear. It lets you dynamicly show or hide widgets on WordPress pages.

== Description ==

Dynamic Widgets gives you full control on which pages your widgets will appear. It lets you dynamically hide or show widgets on WordPress pages by setting conditional logic rules with just a few mouse clicks. No knowledge of PHP required. No fiddling around with conditional tags. You can set conditional rules by Role, Dates, Browser, Language (WPML or QTranslate), for the Homepage, Single Posts, Attachments, Pages, Authors, Categories, Archives, Error Page, Search Page, Custom Post Types, Custom Post Type Archives, Custom Taxonomies in Custom Post Types, Custom Taxonomies Archives, WPEC/WPSC Categories, BuddyPress Components and BuddyPress Groups.

* Default widget display setting is supported for:
  - User roles
  - Dates
  - Browsers
  - Theme Templates
  - Languages (WPML or QTranslate)
  - Front page
  - Single post pages
  - Attachment pages
  - Pages
  - Author pages
  - Category pages
  - Archive pages
  - Error Page
  - Search Page
  - Custom Post Types
  - Custom Post Type Archive pages
  - Custom Taxonomy Archive pages
  - WP Shopping Cart / WP E-Commerce Categories
  - BuddyPress Components pages
  - BuddyPress Groups

* Exception rules can be created for:
  - User roles on role, including not logged in (anonymous) users
  - Dates on from, to or range
  - Browsers on browser name
  - Theme Templates on template name
  - Languages (WPML or QTranslate) on language
  - Single post pages on Author, Categories, Tags and/or Individual posts
  - Pages on Page Title, including inheritance from hierarchical parents
  - Author pages on Author
  - Category pages on Category name
  - Custom Posts Type on Custom Taxonomy and Custom Post Name, including inheritance from hierarchical parents
  - Custom Post Type Archive pages on Custom Post Type
  - Custom Taxonomy Archive pages on Custom Taxonomy Name, including inheritance from hierarchical parents
  - WP Shopping Cart / WP E-Commerce Categories on Category name
  - BuddyPress Component pages on Component
  - BuddyPress Groups on Group or Component

* Plugin support for:
	- BuddyPress
	- QTranslate
  - WP MultiLingual (WPML)
  - WP Shopping Cart / WP E-Commerce (WPSC / WPEC)

* Language files provided:
	- French (fr_FR) by Alexis Nomine
	- German (de_DE) by Daniel Bihler
	- Spanish (es_ES) by Eduardo Larequi

== Installation ==

Installation of this plugin is fairly easy:

1. Unpack `dynamic-widgets.zip`
2. Upload the whole directory and everything underneath to the `/wp-content/plugins/` directory.
3. Activate the plugin through the 'Plugins' menu in WordPress.
4. Visit the Dynamic Widgets Configuration page (settings link).
5. Edit the desired widgets.

== Frequently Asked Questions ==

For the latest FAQ, please visit the [online FAQ](http://www.qurl.nl/dynamic-widgets/faq/).

= What are the (system) requirements to use this plugin? =

1. A properly working WordPress site (doh!).
2. Your theme must have at least one dynamic sidebar.
3. Your theme must call `wp_head()`.
4. PHP5 is highly recommended. Read on if your host uses PHP4.

= My hoster is (still) using PHP4, so what? =

Start immediately looking for another hoster. YES, immediately! NOW! Pronto!  Starting with version 1.5 of Dynamic Widgets PHP4 will not be NOT SUPPORTED anymore.

= I'm not sure my theme is calling `wp_head()`. Can I check? =

Yes, you can. In the Dynamic Widgets Overview page, click the 'Advanced >' link at the bottom. You should see if `wp_head()` is called in your theme. It is possible Dynamic Widgets can't detect if the theme is calling `wp_head()`. Please contact the author of the theme to ask for it. You can also of course just try Dynamic Widgets to see if it works.

= Does the plugin work on WordPress 3.0 MU? =

Yes, but only if you activate the plugin on a per site base. Network Activation is not supported.
Extra note: It seems that sometimes for some reason DW does not show up on individual sites within a WP Network without a network activation. You can use [Multisite Plugin Manager](http://wordpress.org/extend/plugins/multisite-plugin-manager/) to overcome this problem.

= I checked the "Make exception rule available to individual posts and tags" option, but nothing happens. =

Did you save the options? If you did, you may try to hit the (i) icon a bit to the right and read the text which appears below.

= What do you mean with logical AND / OR? =

A logical AND means that ALL rules must be met before the action takes place.
A logical OR means that when ANY rule is met, the action takes place.

= According to the featurelist I should be able to use a hierarchical structure in static pages, but I don't see it. Where is it? =

You probably have more than 500 pages. Building a tree with so many pages slows down the performance of the plugin dramatically. To prevent time-out errors, the child-function has been automatically disabled. You can however raise this limit by clicking on the 'Advanced >' link at the bottom of the Widgets Overview page and raise the number next to the Page limit box.

= The plugin slows down the loading of a page dramatically. Can you do something about it? =

Try setting the plugin to the 'OLD' method. You can do this by clicking on the 'Advanced >' link at the bottom of the Widgets Overview page and check the box next to 'Use OLD method'. See if that helps. Setting the plugin using the 'OLD' method comes with a downside unfortunately. It may leave you behind with a visible empty sidebar.

= I want to check if the 'OLD' method suits me better, is there a way back if it doesn't? =

Yes! You can switch between FILTER and OLD method without any loss of widgets configuration or whatsoever.

= I want in Page X the sidebar becomes empty, but instead several widgets are shown in that sidebar. Am I doing something wrong? =

Your theme probably uses a 'default display widgets policy'. When a sidebar becomes empty, the theme detects this and places widgets by default in it. The plugin can't do anything about that. Ask the theme creator how to fix this.

= I'm using WPEC 3.8 or higher and I don't see the WPEC Categories option anymore. Where is it? =

Since version 3.8, WPEC uses the by WordPress provided Custom Post Types and Custom Taxonomies. Dynamic Widgets supports Custom Post Types and Custom Taxonomies. You'll find the WPEC Categories under the 'Categories (Products)' section.

= You asked me to create a dump. How do I do that? =

* Click at the bottom of the Widgets Overview page on the 'Advanced >' link.
* Now a button 'Create dump' appears a bit below.
* Click that button.
* Save the text file.
* Remember where you saved it.

= I have found a bug! Now what? =

Please check the [Issue Tracker](http://www.qurl.nl/dynamic-widgets/issue-tracker/) first. The bug might have been reported and even maybe already fixed.  When not, you can file a [bugreport](http://www.qurl.nl/dynamic-widgets/bugreport/). Please note the procedure how to create a dump in the previous answer. After you've filed the report, I'll get back to you asap.

= How do I completely remove Dynamic Widgets? =

* Click at the bottom of the Widgets Overview page on the 'Advanced >' link.
* Now a button 'Uninstall' appears a bit below.
* Click that button.
* Confirm you really want to uninstall the plugin. After the cleanup, the plugin is deactivated automaticly.
* Remove the directory 'dynamic-widgets' underneath to the `/wp-content/plugins/` directory.

== Changelog ==

= Version 1.4.2 =

* Added QTranslate support.
* Added hierarchical inheritance for Custom Taxonomies and Custom Post Types.
* Added same behaviour in the Author list for WP < 3.1 as in WP > 3.1
* Bugfix for PHP error in WPML module.
* Bugfix for not showing WPML languages in WPML module.
* Bugfix for PHP error in Single posts module when using WP < 3.1.
* Bugfix for possible PHP notice when a child does not exist in the hierarchical tree.
* Bugfix for wrong page count.
* Broadend the capability for changing DW configuration from 'switch_themes' to 'edit_theme_options'.
* Disabled 'WPSC Category' when using WPEC > 3.8 as it's now covered by Custom Taxonomies Archives.

= Version 1.4.1 =

* Added Custom Taxonomies support for Custom Post Types.
* Added WPML support to Custom Taxonomies.
* Added support for Custom Taxonomies Archives.
* Added support for Theme Templates.
* Added hierarchical structure overview for Categories.
* Added Component exceptions support in BuddyPress Groups.
* Added a Quick setting: 'Set all options to Off'.
* Added 'Internet Explorer 6' to the browser detection.
* Added advanced option setting for the page limit.
* Bugfix for not selecting the WPML main language ID for Custom Post Types.
* Bugfix for showing all WPML translated Custom Post Type titles
* Bugfix for not correct displaying of options string in the widget admin when having options set for Custom Post Type Archives, BuddyPress, BuddyPress Groups.
* Bugfix for losing exception rules for single posts and tags in rare cases.
* Bugfix for showing empty Custom Post Type Archives option in settings screen.
* Bugfix for unexptected behaviour when setting BP groups default to 'No'.
* Bugfix for only showing the last Custom Posts in the list.
* Limited the list of authors to users with user level > 0. (WP 3.1 and higher)
* Security fix in the usage of the returnURL.
* Workaround when using prototype theme.
* Workaround for certain themes claiming an invalid BP component confusing Dynamic Widgets.

= Version 1.4.0 =

* Added more l10n text strings
* Added support for browser options.
* Added support for attachments.
* Added support for Custom Post Type Archive pages (native in WordPress 3.1, via plugin in 3.0.x).
* Added support for BuddyPress Component pages.
* Added support for BuddyPress Group pages.
* Added German language files (locale: de_DE) - Vielen dank Daniel!
* Added Spanish language files (locale: es_ES) - Muchas gracias Eduardo!
* Bugfix for unexpected behavior when subsequent widgets are in opposite config for WPML.
* Bugfix for not correct displaying of options string in the widget admin when having options set for childs in Pages or Custom Post Types.
* Bugfix for an error 404 (file not found) when an error occurs while saving options.
* Bugfix for unnecessary double creation of the hierarchical tree in Static Pages and Custom Post Types.
* Modified admin UI for compatibility with WordPress 3.1.
* Upgrade for WP Shopping Cart / WP E-Commerce to support version 3.8 *** SEE RELEASE NOTES ***
* Workaround in admin UI when using (a child of) the default BuddyPress theme or the BP Template Pack plugin bombing the accordion.
* Modularized admin scripts
* Standarized the use of JavaScript (jQuery)

= Version 1.3.7 =

* Added more l10n text strings.
* Added French language files (locale: fr_FR) - Merci beaucoup Alexis!
* Added language (WPML) as an option.
* Added hierarchical inheritance support for Pages and Custom Post Types
* Bugfix for unexpected behavior when two widgets are in opposite config of eachother.
* Fixed a couple of l10n text strings
* Changed UI in edit options screen (Thanks Alexis for the help!).
* Speeded up the removing process in FILTER method.

= Version 1.3.6 =

* Added l10n support.
* Added Dutch language files (locale: nl)
* Added support for WP Shopping Cart / WP E-Commerce Categories.
* Bugfix for error 404 (file not found) when saving options.
* Bugfix for unexpected behavior in subsequent category pages.
* Bugfix for unexpected behavior in single post when using individual exception rules.
* Bugfix for unexpected behavior in Custom Post Types.
* Bugfix for incorrect use and display of Custom Post Types in Widget Edit Options screen.
* Removed several PHP notices.

= Version 1.3.5 =

* Added support for themes which use the WP function is_active_sidebar() when the method is set to FILTER (default).
* Bugfix by removing a possible unnecessary loop for dynamic widget options.

= Version 1.3.4 =

* Bugfix for minor flaw "Invalid argument supplied for foreach() in dynwid_admin_save.php on line 203"

= Version 1.3.3 =

* Added Custom Post Types support for WordPress 3.0.
* Added WPML support for static pages, category pages, category in single posts and custom post types.
* Bugfix for not resetting checked count when enabling individual posts with authors and/or category set.

= Version 1.3.2 =

* Added an internal filter when checking for widget options to make the plugin faster.

= Version 1.3.1 =

* Maintenance release for WordPress 3.0 support.

= Version 1.3 =

* Added support for dates functionality.

= Version 1.2.6 =

* Another bugfix try for nasty PHP warning "Cannot use a scalar value as an array".

= Version 1.2.5 =

* Bugfix for user role detection when using SPF.

= Version 1.2.4 =

* Bugfix(?) for PHP warning "Cannot use a scalar value as an array"

= Version 1.2.3 =

* Added default widget display setting option for Search Page.

= Version 1.2.2 =

* Added detection for posts page when front page display is set to static page (more or less a bugfix for 1.2.1).

= Version 1.2.1 =

* Added functionality when front page display is set to static page.

= Version 1.2 =

* Added support for PHP4 (not fully tested).
* Added Dynamic Widgets info and edit link in the widgets admin itself.
* Added support for widget display setting options for Author Pages.
* Added support for Single Posts exception rules for tags.
* Added support for Single Posts exception rules for individual posts.
* Bugfix for rare cases not selecting the right default option for single posts.
* Bugfix for wrong exception rules were applied in rare cases when rules are set for a page or archive page.
* Bugfix for displaying confusing success and error message.
* Bugfix for not displaying checked checkboxes in MS Internet Explorer.
* Workaround to stop showing invalid (not clean unregistered) widgets without a name.
* Some small textual changes.
* Moved general helpinfo to standard WordPress contextual help screen.

= Version 1.1.1 =

* Bugfix for unexpected default option values when using role options.

= Version 1.1 =

* Added support for widget display settings based on role, including not logged in (anonymous) users.

= Version 1.0.1 =

* Added default widget display setting option for 'Not Found' Error (404) Page.

== Release notes ==

WPEC 3.8 or higher user: Please note due to the use of Custom Posts and Custom Taxonomies, the 'WPEC Categories" section has been removed in Dynamic Widgets and replaced by "Categories (Products)". Copy over the settings you have in "WPEC Categories" to "Custom Taxonomy Archives: Categories" before updating to 1.4.2.

Change of requirements: The 1.4 branch of Dynamic Widgets will be the last branch to support WordPress < 3.0 and -Yes, it's really going to happen- also the last for PHP4. This 1.4.2 version will probably be the last in this branch. So, when you're still on a WordPress version lower than 3.0 you should really consider upgrading. When you see in the footer of the Dynamic Widgets pages after the version number "PHP4" you're going to be in big trouble when you don't take any action.

== Upgrade Notice ==

= 1.4.2 =
This version has 3 features added and 5 bugs fixed.
WPEC 3.8 or higher user: Please read the release notes before upgrading.

== Screenshots ==

1. Widgets overview page
2. Widget Options page
3. Widget with Dynamic Widgets info and link
