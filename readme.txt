=== Google Doc to RSS ===
Contributors: (this should be a list of wordpress.org userid's)
Tags: comments, spam
Requires at least: 4.5
Tested up to: 6.3
Requires PHP: 7.0
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Create a RSS feed using each line of text from a Google Doc as the description field of RSS entry.

== Description ==
A plugin that reads the text version of a shared Google Doc and creates a RSS feed of the lines of text.

This plugin expects the google doc id to connect to the doc.

== Installation ==
1. Upload Plugin files to `wp-content/plugins`.
2. Activate the plugin.
3. Go to Setting > Google Doc to RSS in the Dashboard.
4. Set Google doc id.
5. Optionally set the slug to use for feed link. 

== Changelog ==

= 1.0 =
* Renamed plugin.
* Make all class functions public.

= 0.6 =
* Add do not cache to page template

= 0.5 =
* Create class and template for RSS feed.

== Upgrade Notice ==

= 1.0 =
Upgrade notices describe the reason a user should upgrade.  No more than 300 characters.

= 0.6 =
Turns caching off for RSS feed

= 0.5 =
First working version of plugin.
