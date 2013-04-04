=== Plugin Name ===
Contributors: rduffy
Tags: glossary, posts, pages, definitions
Stable tag: trunk

Given a collection of glossary definition pages, automatically creates links in your page and post content for the words in your glossary. Is smart enough not to create illegal nested links.  Works with php 4 and 5. Only tested on version 2.7.1 (although may work on other versions).

== Description ==

Given a collection of glossary definition pages, automatically creates links in your page and post content for the words in your glossary.

Is smart enough not to create illegal nested links.  

Works with php 4 and 5 (check out the FAQ for more info on using it with php 4). 

Only tested on WordPress version 2.7.1 (although will most likely work on other versions).

A good example of the glossary in action is at [this page](http://www.alaskaedu.net/2009/02/17/alaska-charter-schools/).  All of the "charter school" links were added dynamically by the glossary plugin.

== Installation ==

1. Upload `glossary.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Create a main glossary page (example "Glossary") with no body content
1. In the plugin's dashboard preferences, enter the main glossary page's id#
1. Create child pages of the main glossary page for each term you wish to define.  The title of the page should be the term.  The body content should be the definition.
1. There are a handful of optional preferences available in the dashboard
1. If you are using php 4, be sure to read teh FAQ.

== Frequently Asked Questions ==

= Does my main glossary page need to be titled "Glossary"? =

No.  It can be called anything.  Just be sure to enter the page's id into the plugin's preference dashboard.

= Do I need to manually type in an unordered list of my glossary terms on the glossary page? =

No.  Just leave that page blank.  The plugin creates the unordered list of terms automatically.

= How do I add glossary terms? =

Simply add a child page to your main glossary page.  Title it the glossary term (ex. "WordPress") and put the term's definition into the body (ex. "A neato Blogging Platform").

= What if I need to add or change a glossary term? =

Just add it or change it.  The links for your glossary terms are added to your page and post content on the fly so your glossary links will always be up to date.

= I use php 4 and I get all sorts of fatal errors.  What gives? =

You need to edit the glossary.php file.  You will see a big chunk of commented out code that says it is for php 4.  You need to uncomment that.  Additionally, you will see a large chunk of code that says it is for php 5.  You need to comment that out.

== Screenshots ==

1. A dynamically created link to one of the glossary terms


