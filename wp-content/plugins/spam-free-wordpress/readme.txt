=== Spam Free WordPress ===
Contributors: toddlahman
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=SFVH6PCCC6TLG
Tags: spam, antispam, anti-spam, comments, comment, comment spam, rbl, remote proxy, blacklist, blocklist, spam free wordpress, Akismet, WP-SpamFree, Mollom, AVH First Defense, CAPTCHA, Defensio, block spam, spam free, Growmap, spambot, bot, NoSpamNX, Spammer Blocker, recaptcha, Bad Behavior, Antispam Bee, Block Spam By Math Reloaded, block spam, Sabre, ajax, W3 Total Cache, WP Super Cache, pingbacks, trackbacks, security, SI CAPTCHA Anti-Spam, comment love, comment luv, commentlove, commentluv
Tested up to: 3.6
Stable tag: 1.7.8.6
Requires at least: 3.1

Todd Lahman's comment spam blocking plugin that blocks 100% of the automated spam with zero false positives.

== Description ==

Support is provided at the [Spam Free WordPress](http://www.toddlahman.com/spam-free-wordpress/) homepage.

Spam Free WordPress is a comment spam blocking plugin that blocks 100% of the automated spam with zero false positives. 

This plugin was born out of necessity in September of 2007. A comment spam fighting plugin was needed that could handle huge visitor traffic, and huge spam attacks. Today the plugin can scale to handle any amount of traffic or spam.

It is my goal for Spam Free WordPress to help WordPress become the world's first and only comment spam free blogging platform. This goal can only be met if you activate the link on the plugin settings page back to the plugin homepage, and tell others about the plugin.

= Spam Free WordPress Features =

 1. Automatically blocks 100% of automated comment spam
 2. Local manual spam and ban policy set with local IP address blocklist
 3. Global manual spam and ban policy set with remote IP address blocklist
 4. Virtually zero database load under the heaviest spam conditions.
 5. Zero false positives
 6. Option to strip HTML from comments
 7. No CAPTCHA
 8. Saves time and money by eliminating the need to empty the comment spam folder
 9. Over 192,000 Spam Free Blogs and Counting!

Comment spam damages a blog's SEO ranking. This plugin preserves your SEO.

The comment form can be secured with an invisible password, a clickable password field, or a click password button. There is other security also built-in that works automatically.

With the invisible password turned on, the reader doesn't even know there are security checks being performed. The reader just leaves a comment, and spam bots are blocked.

Read about how Spam Free WordPress works in detail on the [Spam Free WordPress](http://www.toddlahman.com/spam-free-wordpress/) homepage.

= About the Author =

Todd Lahman is a [WordPress Consultant](http://www.toddlahman.com/hire-todd-lahman/), and a [Search Engine Optimization expert](http://www.toddlahman.com/hire-todd-lahman/).

= Languages Supported =

* English
* German - (de_DE)
* French - fr_FR)
* Hebrew - (he_IL)
* Japanese - (ja)
* Chinese - (zh_CN)
* Hong Kong - (zh_HK)
* Taiwan - (zh_TW)

== Installation ==

Support is provided at the [Spam Free WordPress](http://www.toddlahman.com/spam-free-wordpress/) homepage.


= WordPress 3.1 and Above =

1. Upload to the /wp-content/plugins directory
2. Activate
3. Turn on the Spam Stats, and try to leave a comment to make sure it is working.

= Troubleshooting =

See the [Spam Free Wordpress Support page](http://www.toddlahman.com/spam-free-wordpress/#troubleshooting) for troubleshooting information.

== Frequently Asked Questions ==

Support is provided at the [Spam Free WordPress](http://www.toddlahman.com/spam-free-wordpress/) homepage.

= Is Spam Free Wordpress compatible with other comment spam plugins? =

Yes, however, other comment spam plugins will cause false positives, so it is best to disable all of them, including Akismet.

= Does this plugin work on WordPress Multisite? =

Yes.

= Do readers need to have Javascript enabled? =

Yes.

== Screenshots ==

1. The invisible password secures the comment form without bothering the reader.

2. A clickable field can secure the comment form if you want a visual password.

3. A password button can secure the comment form if you want a visual password.

4. Spam Free Wordpress in action.

== Upgrade Notice ==

= 1.7.8.6 =

Upgrade immediately to keep your blog comment spam free.

== Changelog ==

= 1.7.8.6 =

* Option to display message, or an ad, above comment text area now displays even if Automatically Generate Comment Form is set to Off.
* Check for, and enforce, a minimum version of jQuery
* Removed option to use old jQuery scripts from plugin and database

= 1.7.8.5 =

* HTML5 "required" form field web browser validation check for name and email only active if "Comment author must fill out name and e-mail" is selected on the Discussion screen.

= 1.7.8.3 =

* Fixed very old versions of JetPack causing a fatal error when Spam Free Wordpress activated, or vice versa.
* Added HTML5 "required" form field web browser validation check for name, email, and comment textarea.

= 1.7.8.2 =

* HTML5 removed from automatically generated comment form. Some current web browsers like Chrome 21.0.1180.75 m mangled the form. Will add later.

= 1.7.8.1 =

* Fixed comment form not being generated automatically for every theme.
* Added HTML5 types for email and url form fields to allow modern web browsers to do RFC-compliant form field validation in the browser when the form is submitted. These new form field types will also cause the iPhone to alter the on-screen keyboard to match the form field.
* Added HTML5 required form field web browser check for email and comment textarea.

= 1.7.8 =

* Set Use Old jQuery Scripts as the default setting to assist poorly written themes that load old versions of jQuery
* Fix - Created legacy reference to old function that was removed with no reference in 1.7.7
* wp_enqueue_script URL for jQuery scripts with SFW version number rather than filetime, since W3 Total Cache will otherwise break the URL - Thanks Steve

= 1.7.7 =

* Automatically loads jQuery scripts compatible with WordPress 3.3 or less that loads a version of jQuery before 1.7.
* Added option to load older jQuery scripts when WordPress is 3.3 or greater, but poorly written theme loads a version of jQuery older than 1.7.

= 1.7.6 =

* Added the option to secure the comment form with an invisible password, a clickable password field, or a click password button.

= 1.7.5 =

* Fixed automatic comment form generation not turning off due to code error
* Added full Thematic comment form support
* Added full Genesis comment form support
* Added full PageLines comment form support
* Added full Graphene comment form support
* Added full Atahualpa comment form support
* Added full Suffusion comment form support
* Added full Picture Perfect comment form support
* Thesis only allows password and no tags message on comment form
* Replaced German translation - Thanks Marco
* Turn mouse cursor into a pointer when over password field - Thanks Joe

= 1.7.4 =

* Removed password button
* Password field automatically generates password when clicked
* Added notice for non-JavaScript readers to turn it on to leave a comment
* Added readonly attribute to password field - Thanks Thomas

= 1.7.3 =

* Automatically disable JetPack Comments module since it takes over the comment form, and won't play nice with other plugins
* Automatically cleanup Post Meta Custom Fields since transients are now used
* German translation updated - Thanks Thomas
* Earlier versions have been removed

= 1.7.2 =

* Corrected jQuery file loading twice

= 1.7.1 =

* Automatic cache flush of W3TC and WP Super Cache when settings updated and on install
* Password fields replaced with a one-click AJAX button and password field
* Comment form is now automatically generated
* Same hooks available to other plugins and themes as are in the comment_form function
* Added autocomplete comment form for Chrome 15 and above
* Passwords are now stored as transients to scale to extremely high traffic blogs
* AJAX now used to obtain client IP address to bypass cached pages
* Added backlink to rejected comment error page
* Made rejected comment error message more friendly
* Added option to display message, or an ad, above comment text area
* Nonce field added to comment form
* Language translations added
* Added German translation
* Added French translation
* Added Hebrew translation
* Added Japanese translation
* Added Chinese translation
* Added Hong Kong translation
* Added Taiwan translation

= 1.6.7 =

* Added option to open or close pingbacks
* Pingbacks are closed automatically when plugin installed

= 1.6.6 =

* Updated install routine to preserve existing settings

= 1.6.5 =

* Pingbacks now closed automatically by default
* Translation support coming soon ...

= 1.6.4 =

* More secure SQL query
* Minor admin page change
* WordPress version 3.1 or above now required

= 1.6.3 =

* add_option function caused activation error
* had to use update_option to fix

= 1.6.2 =

* Arrrg. Forgot to bump the version.

= 1.6.1 =

* Upgrade procedure didn't work as expected first time

= 1.6 =

* Added disable pingback/trackback
* Added disable user registration
* Added settings link to plugin row menu
* Added remove url form field
* Added remove comment author clickable link
* Admin page has a new look
* Fixed donation link
* Added uninstall to cleanup database on deletion
* Made invalid or empty password error more clear
* Added automatic theme support for popular themes
* Minor code changes

= 1.5.1 =

* Fix for number_format error
* Ability to turn blocklists on or off
* Easier Admin page
* Backend improvements

= 1.5.0 =

* Number localization fix.

= 1.4.9 =

* Added global remote blocklist after code rewrite
* Added more plugin security features
* Added plugin to close pingbacks and trackbacks
* Cleaned up code and admin page a bit

= 1.4.8 =

* Initial release. In development since September 2007.
* Global remote blocklist left out pending code rewrite.