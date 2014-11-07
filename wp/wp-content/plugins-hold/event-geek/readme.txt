=== Event Geek ===
Contributors: graphicgeek
Donate link: http://graphicgeek.net/donations/
Tags: events, calendar, calendar widget, ajax, free calendar, simple event calendar, sidebar, event calendar
Requires at least: 3.5
Tested up to: 3.5.2
Stable tag: 1.7
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

An easy to use events plugin built with jQuery UI and AJAX.

== Description ==

An easy to use events plugin built with [jQuery UI](http://jqueryui.com/ "jQuery UI") and AJAX. The philosophy behind this plugin is to keep it simple.

Features Includes:

* Events content added with standard WordPress editor as a custom post type
* jQuery UI based calendar widget
* Display events in a pop-up box with AJAX
* Shortcode to display a list of events on a post or page
* Several calendar styles to choose from, or you can use your own
* Easily customize the event info fields
* Several hooks included for even more customization

== Installation ==

1. Download the zip file and extract the files
1. Upload all the files to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Once activated, you will be able to add events through the "Events" section of the dashboard.
1. Events can be displayed with the Event Geek Widget, or with the '[event_geek_list]' shortcode

== Frequently Asked Questions ==

= How can I use Event Geek in my theme files? =

* You can display the list of events using the following: &lt;?php event_geek_list(); ?&gt;

= How can I customize Event Geek? =

* You can choose a theme for the calendar widget under Events > Options
* You can also specify the url to your own them CSS file

* To create your own CSS file for the calendar see [jQuery UI Themeroller](http://jqueryui.com/themeroller/ "Roll your own theme")
* For even more customization options, see [graphicgeek.net/event-geek](http://graphicgeek.net/event-geek#hooks "list of Event Geek Hooks")

= I have a suggestion, who do I contact? =

* If you have questions, comments, or feature requests, you can contact [Graphic Geek](http://graphicgeek.net/contact/ "Contact Graphic Geek"), or [leave a comment](http://graphicgeek.net/geek-events/ "Event Geek Page on graphicgeek.net")

== Screenshots ==

1. Set the start and end dates, as well as other event info
2. Select a theme for the calendar widget, and choose the colors for highlighting event days. You can also put in the location of your own css file to style the calendar.
3. The calendar widget on the front end of the site
4. Easily add, remove and arange event info fields, with drag and drop sorting

== Changelog ==

= 1.7 =
* Added mouse wheel scrolling in the pop-up window with jquery.mousewheel.js
* Added customization options for event info
* Improved responsive styling
* Fixed yet another foreign language bug
* Event info is now retrieved with a seperate function
* Added css to make the widget 95% the width of the parent div
* Added donation and support info to the options page
* Added plugin version to global javascript variable to help with future troubleshooting
* New screenshots for current version

= 1.6 =
* Added a template tag for use in themes (makes a paginated events list possible)
* One more multi-language conversion fix using date_i18n function

= 1.5.2 =
* Fixed error that prevented content from appearing in ajax pop up

= 1.5.1 =
* More multi-language bug fixes

= 1.5 =
* Fixed misc sorting bugs
* Store date ranges in standardized format
* More universal php to javascript date conversion function 

= 1.4.1 =
* fixed bug that broke calendar if date format isn't set or isn't recognized

= 1.4 =
* Replaced farbtastic color picker with wp-color-picker
* Added internationalization options to work with WordPress installs in other languages
* Fixed some sorting issues
* Match the date formatting set in WordPress settings
* Store date ranges with wp_localize_script function

= 1.3 =
* Fixed farbtastic javascript error
* Fixed issue with theme thumbs  not appearing on some development sites

= 1.2 =
* Fixed 'modify header' bug

= 1.1 =
* Fixed bug in Javascript that may have broken the AJAX on some development sites* Added Shortcode* Added Readme file and screenshots= 1.0 =* Testing version

== Upgrade Notice ==

= 1.7 =
* Added mouse wheel scrolling in the pop-up window
* Added customization options for event info
* Tweaks to improve responsive styling
* Fixed yet another foreign language bug, hopefully the last
* Added css to make the widget 95% the width of the parent div
* Added donation and support info to the options page

= 1.6 =
* Added a template tag for use in themes (makes a paginated events list possible)
* One more multi-language conversion fix

= 1.5.2 =
* Fixed error that prevented content from appearing in ajax pop up

= 1.5.1 =
* More multi-language bug fixes

= 1.5 =
* Fixed misc sorting bugs
* More universal php to javascript date conversion function

= 1.4.1 =
* fixed bug that broke calendar if date format isn't set or isn't recognized

= 1.4 =
* Replaced farbtastic color picker with wp-color-picker
* Added internationalization options to work with WordPress installs in other languages
* Fixed some sorting issues
* Match the date formatting set in WordPress settings

= 1.3 =
* Fixed farbtastic javascript error
* Fixed issue with theme thumbs  not appearing on some development sites

= 1.2 =
* Fixed 'modify header' bug