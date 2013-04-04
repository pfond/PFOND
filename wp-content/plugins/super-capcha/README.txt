=== (NOW 3D!) Super CAPTCHA Security Suite ===
Contributors: leewells
Donate link: http://goldsborowebdevelopment.com/product/super-captcha/
Tags: CAPTCHA, anti-spam, spam, bots, security, protection, buddypress, 3-D CAPTCHA
Requires at least: 3.0.0
Tested up to: 3.3
Stable tag: 2.4.2

Not just an anti-spam system, its an entire security suite! Stop spam and brute-force attacks with dynamic CAPTCHA images and intelligent automagic IP/browser/session banning.

== Description ==

THE VERY FIRST (AND CURRENTLY, ONLY!!!) 3-D CAPTCHA FOR WORDPRESS!  What makes this diffrent from other CAPTCHA's you ask?  OCR software CANNOT READ IT but the human brain can easily read it.  This uses technology that you were taught in high-school trig classes, applied to the GD library this forces the human brain to interpret each letter by use of 3-D vectors.  We have tested this software against 37 diffrent OCR (some very expensive) and none so far has even been 20% correct in guessing the answer!

When we sparked the idea of this software, we were like you -- we had tried using every CAPTCHA out there including Google's reCAPTCHA to no end and no real results.  We then started with a 2-D CAPTCHA that let each site customize its own type of CAPTCHA making OCR a hard task by having to be pre-programmed for each site, and then we took it to the next level 3-D. We didn't stop there.  When we first developed Super CAPTCHA we were like you, absolutely fed up with spamers and having to invest more time with cleaning up their virtual grafitti than concentrating on building our community.  With this plugin, you can finally get back to doing what it is you do in building your community and know that if you get any spamers through this system, they wilfully and intentionally created the account by hand which is why we added a comprehensive suite of security tools and logs to help you pin-point people whom may be using a combination of OCR and human submissions to "get in" and spam your site.

TIP: Clear your wp-registrations table after installing this plugin.

FEATURES:

*	The one and only 3-D CAPTCHA for Wordpress
*	Programmed with security as a #1 priority; "it may not look good, but it sure as hell works" ~ Eastern Medical.  We have taken extra measures to ensure that our system cannot be by-passed, hacked, or cracked.
*	IP Filtering and cross-linking stopping repeat spammers from attacking your blog AUTOMATICALLY!
*	One-Click mass-spaming from the Logs Admin page.
*	Know exactly who is trying to access your site with a comprehensive logs view page.
*	Pluggable with Hooks -- open for other developers to create their own hooks inside the software.
*   Confirmation box is placed automagically on the login page, and the registration pages.
*	Dashboard heads-up display on the blocked attempts to your site.
*	Buddypress Compatable (but not required)!
*	FULLY CONFIGURABLE DISPLAY and YOU CONTROL where and when the CAPTCHA is displayed by checking a box.
*	Want more features?  LET US KNOW! www.goldsborowebdevelopment.com
*	Automatically detects and FIXES common database problems and incompatability issues with older versions!

SERVER REQUIREMENTS:

*	PHP -- 4.3.0 or greater, PHP5 compatible
*	GD support in PHP. FreeType required for TTF fonts (Can be configured in version 2.0). Version 2.0.33 required for gif output. GD is bundled with PHP since version 4.3
*	Session Support (WARNING:  If your server has session auto start enabled you will see warnings and errors.  It is good pratice to disable this.)
*   Tested on CURRENT latest versions (and beta versions) of WordPress 3.1.

== Installation ==

1. Upload the `super-captcha` folder and ALL its contents to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
4. Configure the plugin (if you are running a multi-site install, you must do this from the network administration panel).
5. When you are done with your configurations and the image is visible in the configuration area, check the enable registration and login options to your liking and save.
6. Call the CAPTCHA image on any custom login form by using this code (optional): 
`&lt;?php
if ( function_exists ( &array ( 'RandomCaptchaSpam', 'wpmulogin_form' ) ) ) :
echo( $RandomCaptchaSpam->wpmulogin_form( ) );
endif;
?&gt;`

== Frequently Asked Questions ==
= I enabled Super CAPTCHA and now I can't login? =

This happens when you're not following directions.  Always make sure that you can see the CAPTCHA image in the control panel before locking down your login page.  Once you have been locked out like this you must delete Super CAPTCH or rename it to force WordPress to uninnitialize it.

= I can't get SEF working? =

This is because you're most likely runing in MultiSite mode.  Running in this mode makes it difficult to use mod-rewrite on a local file.  Turnning this option off for multi-site installs is the best option right now.

= How do I configure this? =

Login to your administration area - yoursite/wp-admin generally - and click on SCAPTCHA on the left menu.  If you are running in MultiSite mode, you will need to configure this as the network admin so that all logins and registration pages are secured.

= I can't get the CAPTCHA image to show up and I am not using SEF =

You need to check to make sure your server supports GD.  If you still can't see the image and you know your server supports GD, right-click on the "broken" image icon (or area for FireFox) and get the URL of that image and send it to our support staff at http://goldsborowebdevelopment.com/support/

= Do you guys offer any other plugins? =

Yes, but not all are GPL or GNU, they're licensed through a proprietary licnese, though you'll get full access to the source code, the other software took loads of time to create so they're for sale.

== Screenshots ==

1. Display of the 3-D captcha protecting BuddyPress signup forms.
2. Display of the 3-D captcha protecting BuddyPress blog creation forms.

== Changelog ==
= 2.4.2 =
* ::M A J O R BUG-FIX:: Thanks to some help from a few of our users, we have found the issue causing the get_var error on wordpress installs where it is not the site root.  Because we call the SCAPTCHA image from the literal location in your wp-content/plugins directory, if your install differs from this default structure, you MUST open the config.php file in this plugin's folder and specify the actual path to the plugin.

= 2.4.1 =
* ::FEATURE:: Backgrounds now available for 3D Captcha
* ::FEATURE:: Distortion now available for 3D Captcha

= 2.4.0 =
* ::BUG-FIX:: Issues regarding file not found errors while including the TTF fonts has been fixed with a new configuration option.
* ::INFO:: All 2-D CAPTCHAing has been removed from this major version.  To get stable 2-D CAPTCHA support please see version 2.2.x

= 2.3.3 =
* ::BUG-FIX:: issues with the captchas not letting "anyone" through has been fixed.  This was a session issue in trying to pass session back and forth from the image rendering to the code checking.  This should be fixed now.
* ::MISC:: Some of the features not working as part of the switch from the 2-D Captchas to 3-D, we have notated them in the configuration as they do still work on some systems and setups.  We are still unsure as to what is making this behave so irraticly between Wordpress installs.
* ::TESTED:: This has been tested with the latest version of Buddypress (as of 12-19-2011), Latest Version of Wordpress with both multisite disabled and enabled.
* ::MISC:: Added a warning to IP filtering.  If you are running cloud services like Cloud Flare, you will need to disable this and trust them with the IP filtering as IP addresses aren't passed to your server from these systems as they act as proxies.

= 2.3.2 =
* ::MISC:: Added option to disable the new image URL system if your image is broken or does not display properly.

= 2.3.1 =
* ::MISC:: Better image url mapping. The image is now called by WordPress's ModRewrite library instead of a direct /wp-content/plugins/ call.  This should add better security, and a wider compatability with login forms.
* ::BUG-FIX:: Minor bugs fixed (image displaying bugs)
* ::ALERT:: YOU MUST RUN THE UPDATER WHEN UPGRADING OR PRESS THE "Restore Defaults" BUTTON OR YOU WILL BE LOCKED OUT OF YOUR SITE or change the Font Path from ./includes/ to includes/!

= 2.3.0 =
* ::MAJOR-FEATURE:: [MikeW] 3-D CAPTCHA added.  This is out of beta but has little controlable features.  Planned to add more features over the next few releases.
* ::MISC:: [MikeW] Update for Buddypress
* ::MISC:: [WaltE] Registration layout for Buddypress looks much better.

= 2.2.5 =
* ::SECURITY:: A SQL injection vonerability in the Logs no longer exists.  This security risk was rated as a low security risk as you have to be logged in as site-wide administrator in order to exploit it.

= 2.2.4 =
* ::FEATURE:: Help area added to better educate people to how to use Super CAPTCHA as well as an added support link.

= 2.2.3 =
* ::BUG-FIX:: Words.txt was damaged during previous version commit.  It has now been fixed for this version.
* ::BUG-FIX:: Dashboard overview now displays properly on the network admin dashboard and will not display on admin dashboard if in multi-site mode.

= 2.2.2 =
* ::BUG-FIX:: Now installs flawlessly and automatically fixes many database errors that it may come across.
* ::FEATURE:: Intelligent sanity detection - prompts to fix errors in the database automagicly.

= 2.2.1 =
* ::FEATURE:: [MikeW] Super CAPTCHA menu only available in the Network Admin interface if running in multi-site mode.
* ::FEATURE:: [WaltE] You can now disable the copyright by-line.
* ::BUG-FIX:: [MikeW] Fixed very old bug that causes some pages in some versions of wordpress not to display properly.
* ::MISC:: [MikeW] Removed unessecary pages from the admin panel.
* ::MISC:: [MikeW] Combined the Readme and Home page into one page (only 3 admin pages now are loaded)
* ::MISC:: [WaltE] Changed the readme.
* ::MISC:: [MikeW] Donation link fixed!
* ::SECURITY:: [WaltE] No admin pages can be accessed by non-authenticated or users without proper access levels.

= 2.2.0 =
* ::FEATURE:: IP Filtering and Cross-Linking
* ::FEATURE:: One-Click IP Banning
* ::FEATURE:: SECURED Blog Creation Page (even after login!)
* ::BUG-FIX:: Can now mark users as spam from the main wordpress profile page
* ::MISC:: Entire program reworked for speed and security as well as easier co-development

= 2.1.5 =
* ::BUG-FIX:: Super CAPTCHA now works with single WordPress installs.
* ::FEATURE:: Now have the ability to clear the logs.
* ::FEATURE:: NEW!!! Upgrade script added so this should fix all the problems with WordPress not creating all the tables when you upgrade..
* ::MISC:: We have tested this on a Wordpress 2.9.2 MU (with Buddy Press) and Wordpress 2.9.2 single blog install.  We have not yet tested it on Wordpress 2.9.2 MU (without buddypress) and earlier versions.

= 2.1.4 =
* ::BUG-FIX:: Log sorting has been fixed.  Had some sloppy code that was causing the GROUP BY and SORT BY statements to run a muck.
* ::FEATURE:: Auto-Ban Added (will now stop any attemps for 24 hours when a user failes more than 5 CAPTCHA tests in a 15 min timeframe)
* ::MISC:: Logging is now prettier and better sorted.
* ::FEATURE:: Logging now automagically associates the IP address of someone blocked by the CAPTCHA system to any IP's matching registered users for your examination.
* ::FEATURE:: Thickboxed IP-Whois added to the logging feature.  Clicking on the DNS Name of the host will result in a thickboxed lookup of spam records on that IP.  Hovering over the DNS name and clicking the IP address will innitate a thickbox of the IP-Whois information for quick access to abuse.
* ::NOTIFICATION:: Bug identified:  Please do not use version 2.1.0 and later on single-WP installs for registration bot security.  Currently the CAPTCHA system is not setup to handle the single-version registration displays.  You may still use it for brute force login security.

= 2.1.3 =
* ::FEATURE:: Some hardening features were added.

= 2.1.2 =
* ::BUG-FIX:: SQL Statement on setup has been fixed.
* ::BUG-FIX:: Better page navigation for logging.
* ::BUG-FIX:: Bot detection fixed to include all bots, even those that make themselves appear to be legitimate bots.

= 2.1.1 =
* ::FEATURE:: Logging added. (leewells)
* ::SECURITY-FIX:: All Dashboard widgets now working (leewells)
* ::NOTES:: 2.1.0 removed from repository.

= 2.1.0 =
* ::FEATURE:: Compatible with Buddypress!
* ::FEATURE:: Auto-blocking of known bots.
* ::BUG-FIX:: All Dashboard widgets now working (affinityx)

= 2.0.6 =
* ::BUG:: "Refresh only works once" bug has been resolved for both the login and registration CAPTCHAs.
* ::PRESENTATION:: The login CAPTCHA form has been drastically improved to "fit" with the flow of your Admin theme (sorry this should have been distributed with the last update).
* ::FEATURE:: Licensing violators are added to the "Wall of Shame" that is viewable in everyone's Admin Panel after clicking on the plugin's page.

= 2.0.5 =
* ::FEATURE:: Super CAPTCHA now displays its statistics in the Administrative Dashboard's "Right Now" widget.
* ::FEATURE:: Super CAPTCHA will now add an Administrative Dashboard widget with the latest news relating to Super CAPTCHA.
* ::FEATURE:: Added navigation to the plugin home, configuration, README, and LICENSE pages.
* ::FEATURE:: Plugin home page will not read from a dynamic page keeping you informed on the latest changes LIVE.

= 2.0.4 =
* ::BUG:: Fixed validation errors in the credits.  Your site should now validate with the http://validator.w3.org/ .

= 2.0.3 =
* ::FEATURE:: Donate links added.
* ::FEATURE:: Added feature to remove copyrights legitimately from the bottom of your site.
* ::FEATURE:: Added some AJax capabilities.
* ::SECURITY:: Fixed some audible bugs and added more static to background.

= 2.0.2 =
* There is a bug where the audiable read-out is not in sync with the CAPTCHA image -- Image, audio, and Verification are in sync now.

= 2.0.1 =
* Fixed the issue where the sign-up captcha was not being displayed entirely.
* Fixed image path issue on the sign-up captcha.
* Fixed image path issue on the login captcha.
* Fixed/Tweaked session handling for more security and stability.

= 2.0.0 =
* New release, featured a fully configurable CAPTCHA system!
* Intergrated the image into the plugin file itself for better security!
* Option added to allow the admin to control where and when the plugin is displayed.
* Default Permissions should now be fixed (for the 500 error for those folks running mod_security on Apache).

= 1.2 =
* Package updated for Wordpress.org "Extend" site.

= 1.1 =
* Bug "Registration Loop" fixed.
* Bug "Login Not Locked Down" fixed.

= 1.0 =
* Innitial Release