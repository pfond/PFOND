=== Elastic Theme Editor ===
Contributors: koopersmith
Tags: elastic, theme, editor, engine, framework, elastictheme, wysiwyg, gsoc
Requires at least: 2.9
Tested up to: 3.0-alpha
Stable tag: 0.0.3

A interactive theme editor and theme engine for WordPress.

== Description ==

Elastic is a theme engine and interactive theme editor for WordPress.

= IMPORTANT =
**Elastic is still in development and we do not recommend that you use Elastic themes on live websites.** We try and keep Elastic as bug free as possible, but if you encounter any errors, let us know!

Developers, please note that Elastic has an evolving API that is *not backwards compatible* with previous versions.

= Features For Users =

* **Infinite theme arrangements:** Drag-and-drop makes themes easy to customize.
* **Custom fonts:** Preview your selections with the detailed typography editor.
* **Grid-based** for easy organization. **Custom grids** for flexibility.
* **Portable:** Share your themes with anyone! Elastic creates a standard WordPress theme.
* *Many more coming soon!*

= Features For Developers =
* **Theme Engine:** For theme developers, the editor is just the beginning—Elastic themes are based on the powerful Elastic theme engine.

== Installation ==

= Install =

1. Unzip the `elastic.zip` file
1. Upload the folder to your `/wp-content/plugins/` directory
1. Activate the Elastic Theme Editor on the 'Plugins' page.
1. A subpage for Elastic will appear in the Themes menu.

= Use an Elastic theme =

1. Create a theme using the editor.
1. Your theme will appear on the 'Themes' page.
1. Activate your theme!

== Frequently Asked Questions ==

= How do I use a theme? =
Using an Elastic theme is just like using any other theme:

1. Create a theme using the editor.
1. Your theme will appear on the 'Themes' page.
1. Activate your theme!

= How do I remove a theme? =

* On the 'Themes' page, click the 'Delete' link next to your theme.

= I'm having trouble saving a theme! Help! =

* Some web hosts restrict the current method we're using to save themes. We're working on a new method that avoids those problems, but in the meantime please let us know if you have a problem!

= I'm a developer! I have questions! What's a theme engine? =

* Please see the "Developer F.A.Q." page.


== Developer F.A.Q. ==

= IMPORTANT =
**Elastic is still in development and we do not recommend that you use Elastic themes on live websites.** We try and keep Elastic as bug free as possible, but if you encounter any errors, let us know!

Please note that Elastic has an evolving API that is *not backwards compatible* with previous versions.

= What's a theme engine? =

* A theme engine is a theme or plugin that changes the way WordPress renders themes. The difference is that the theme engine controls how the page is loaded, not how it looks.
* The default theme engine consists of the [template heirarchy](http://codex.wordpress.org/Template_Hierarchy "Default WordPress template hierarchy"), header.php, footer.php, comments.php, and more. The Elastic theme engine is **very similar to the default WordPress theme engine**, with the major exception that templates are based on modules instead of pages.

= What are the goals of the Elastic theme engine? =

* **Write less code.** The Elastic theme engine is more flexible and concise than the WordPress theme engine. The Elastic engine is focused on eliminating code repetition within themes and providing useful tools for theme developers.
* **Easy to learn, easy to use.** The Elastic theme engine is designed to make writing and adapting WP themes simple. Adapting a theme is mostly cut and paste.

= How do I adapt my theme to the Elastic engine? =

* Tutorial coming soon!

= Can I use the Elastic editor with my theme? =

* An API to include and edit your theme inside the editor is in the works.


== Changelog ==
= 0.0.3 =
* Elastic now divided into engine, editor, and themes
* Theme file structure rewritten
 * `/library` now known as `/engine`, no longer part of themes
 * `/custom` merged with `/framework` directory, now known as `/themes/default`
* Bug fixes
 * Fixed JSON bug
 * Fixed path bug that caused problems with Windows Server

= 0.0.2.9 =
* Small fixes to version compatibility
* Fixed JavaScript loading error

= 0.0.2.8 =
* WordPress 2.9 and 3.0-alpha compatible
* Minor API changes

= 0.0.2.7 =
* Typography panel now accurately depicts typography in theme
* Default theme now em-based
* Hooks API made more robust
* PHP warnings from framework removed
* Workflow changes to editor
* Added default CSS reset (based on tripoli)

= 0.0.2.6 =
* Typography still renders incorrectly. Will be fixed in next release.
* New framework file structure implemented. Designed to be developer friendly—tutorial coming soon!
* Modules improved: added hooks API.
* Bug fixes: widget admin.

= 0.0.2.5 =
* PHP4 bugs fixed.
* Load theme bug fixed.
* Positioning bug fixed.
* Framework in transition to new file structure.

= 0.0.2.4 =
* Typography loads from saved themes.

= 0.0.2.3 =
* Typography panel saves to theme. Theme not optimized for em and % font-sizes.

= 0.0.2.2 =
* Added typography panel. It's not positioned correctly in the workflow yet, and does not output to a theme.
* Improved button logic.

= 0.0.2.1 =
* Fixed bug where the javascript for the editor wouldn't load.

= 0.0.2 =
* Framework and editor both operational