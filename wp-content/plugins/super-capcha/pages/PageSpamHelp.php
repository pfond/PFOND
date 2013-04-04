<?php
	if (!is_super_admin( get_current_user_id() )) header("HTTP/1.1 403 Forbidden")&die('Direct access not allowed!');
	include_once('PageNav.php');
?>
<h3>Help Me!</h3>
<p><em>This page is a simple rescue and help guide for those being attacked by spam bots.  Hopefully with a 
few minuites of reading we can get your blog and website back to the point of operation without having to
remove a bunch of spam every few hours.</em></p>
<h4>Currently Under Attack</h4>
<p>If your website is currently under attack there is a few things this software can help with.  First of all
you need to know that this software can help stop a lot of spam instantly, but some bots are programmed to read
CAPTCHA images, in which case this software can only slow them down until it builds its memory!</p>
<p>Go ahead and enable this software.  If you do not have any custom login boxes, go to the configure page and
mark it so that the CAPTCHA image will show up on login. Simply check "Login Page".  This should instantly stop
most spam but you may have spammers pending registration or spammers that have registered and just haven't posted
anything yet. So for the next few days you will need to be attentitave to your website and ensure you mark any
users that are spamming as spammers!  <STRONG>VERY, VERY, VERY IMPORTANT:</STRONG> DO NOT DELETE A SPAMMER!  When
you delete a spammer this software will forget their IP address and browser/cookie information so that they may
be able to register again!  Simply edit the user, and tick the specail area at the bottom "Mark as Spammer".</p>
<p>Now that your blog has some relief, lets go ahead and make it so that all new registrations have to pass a
CAPTCHA test by ticking the box on the Configure page named "Registeration Page".  This will help prevent new bot
registrations as well as block any bot whos already been marked as a spammer from re-registering (as long as you
have not deleted their account).</p>
<p>If you are running Buddypress and are running the site in Multi-Site mode there is one other thing you can do
that truely makes this software "super".  Check the box that says, "Blog Creation Page".  This will force users
to again pass another CAPTCHA and banned user check every time they create a new blog.  This ensures that if they
manually registered they can't later sick their bots on your site with that username and login!</p>
<h4>Do I Need CAPTCHA Any More?</h4>
<p>Just because you seem to have bots under control, we wouldn't suggest you relaxing your security methods as most
bots out there have your site in memory and are most likely still trying to attack your site, so as soon as CAPTCHA
is turned off you will see hundreds if not thousands of registrations in a few moments of disabling Super CAPTCHA.</p>
<p>This software is designed to be as hands-free as it can possibly get without limiting legitimate users on your 
website, and therefor it does a lot of things behind the seems that you can't see.  But to get an idea of how Super
CAPTCHA is doing you can go to your network admin dashboard and simply look at the CAPTCHA stats there in the overview
box.</p>
<h4>Super CAPTCHA does not seem to be working!</h4>
<p>We assure you it works, in fact it works very well.  Most people whom do not see an immediate drop in spam
registrations usually have Super CAPTCHA improperly configured or not configured at all.  You will need to configure
Super CAPTCHA just after you install it, because if you are running in multi site mode, the configuration will apply
for all websites and all websites become "Locked-Down".  Also ensure that you do not have a ton of registrations
pending by checking your database and deleting ALL NEW RECORDS in the "wordpressprefix _signups" table.  Ensure you do
not delete any legitimate users that are already registered.</p>
<p>This table alone is the main culpret in allowing spam
registrations on your blog as before you secured your site, spam bots created thousands of registrations on your site
and have yet to activate those accounts.  All that needs to happen in order to activate an account and start posting
spam is to visit the URL sent to the bot when they registered.  Even though CAPTCHA is now protecting your site, these
accounts were created BEFORE your site was secured by Super CAPTCHA and therefor cannot protect against these accounts
even though you cannnot see or manage these accounts in your Wordpress Admin panel.</p>
<h4>Super CAPTCHA does not work!</h4>
<p>There are a few things you can do to verify a bug and that Super CAPTCHA is not working before contacting us.  First
of all try and create a new account on your website in this order:</p>
<ul>
<li>Create an account with bad CAPTCHA Test by intentionally entering the wrong CAPTCHA code -- if you are able to create
an account Super CAPTCHA is broken and we need to know ASAP.</li>
<li>Create an account with a scrambled CAPTCHA Test by intentionally re-arranging the CAPTCHA code when you submit a new
account -- if it passes and the account is created we need to know ASAP!</li>
<li>Create an account with the correct CAPTCHA code -- if you cannot create an account let us know!</li>
</ul>
<p>The above steps will tell you if CAPTCHA is working or not.  There is currently no known way to hack Super CAPTCHA
unless you are a Super Admin (as super admins have access to edit plugin files).  Each page in CAPTCHA (even this one) is 
locked to everyone but the super admins of the site.  But if you feel there is still a problem, please let us know!</p>
<h4>Reporting a Problem</h4>
<p>Simply follow <a href="http://www.mlwassociates.com/ticket/">This Link</a> to our support site and create a new ticket with the exact details of what you
have tested and what is not working.  We will need the following information from you, so for a faster support process, 
please provide the following information:</p>
<ul>
<li>Link to your website</li>
<li>Link to your registration page</li>
<li>Link to your admin panel</li>
<li>Super Admin username & password (NOT YOUR USERNAME AND PASSWORD) [delete these credentals when the support ticket is closed]</li>
</ul>
<p>If you have not donated to the open source project the support ticket may take up to a week to be answered, be patient as
the budget for free software isn't as large as we would like.  If you have donated, please provide the email address associated
with the account you used with the PayPal account and we will expedite your ticket.</p>