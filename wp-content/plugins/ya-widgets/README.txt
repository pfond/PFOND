/*  
	Copyright 2010  Darrell Schauss (email : drale@drale.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*
	Yahoo! Answers brand is only mentioned to state what this plugin is for. There is no affiliation of this plugin or its author with Yahoo! Inc.
	Yahoo! Answers is trademark of Yahoo! Inc.
*/

/*
	Plugin Name: YA Widgets
	Plugin URI: http://www.drale.com/
	Description: Display RSS from Yahoo! Answers with display options that can be toggled
	Author: Darrell Schauss
	Version: 1.0
	Author URI: http://www.drale.com/
*/

***Installation***

1. Upload the /ya-widgets/ folder into /wp-content/plugins/
2. In Wordpress Admin, Plugins > Installed
3. Activate "YA Widgets"

***Setup and Requirements***

Your Questions and Favorites must be public for the RSS feeds.
1. Login to Yahoo! Answers http://answers.yahoo.com/
2. Go to "My Activity" > "Edit My Preferences"
3. Under "Yahoo! Answers Network" 
	uncheck "On my public profile, hide my Q&A from people who are not my contacts"
4. "Preview" then "OK"

To get your Yahoo! Answers ID
1. Login to Yahoo! Answers http://answers.yahoo.com/
2. "My Acivity" > "My Q&A"
3. Click "Questions" tab. Then, click RSS to the right.
4. Look in address http://answers.yahoo.com/rss/userq?kid=YOURIDHERE

***Features***

"YA My Favorites" Widget:
Pulls the RSS feed for your Starred/Favorites
Toggle display of question category
Toggle display of question status

"YA My Questions" Widget:
Pulls the RSS feed for your Questions
Toggle display of question status
Toggle display of answer count
Toggle display of comment count