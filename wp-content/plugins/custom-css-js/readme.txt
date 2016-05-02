=== Simple Custom CSS and JS ===
Created: 06/12/2015
Contributors: diana_burduja
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=diana.burduja@gmail.com&lc=AT&item_name=Diana%20Burduja&item_number=WP%2dImage%2dZoooom%2dplugin&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted
Email: diana@burduja.eu
Tags: CSS, JS, javascript, custom CSS, custom JS, custom style, site css, add style, customize theme, custom code, external css, css3, style, styles, stylesheet, theme, editor, design, admin
Requires at least: 3.0.1
Tested up to: 4.5
Stable tag: 2.1 
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Easily add Custom CSS or JS to your website with an awesome editor.

== Description ==

Customize your WordPress site's appearance by easily adding custom CSS and JS code without even having to modify your theme or plugin files. This is perfect for adding custom CSS tweaks to your site.

= Features =
* **Text editor** with syntax highlighting 
* Print the code **inline** or included into an **external file**
* Print the code in the **header** or the **footer**
* Add CSS or JS to the **frontend** or the **admin side**
* Add as many codes as you want
* Keep your changes also when you change the theme

= Frequently Asked Questions =
* **Can I recover the codes if I previous uninstalled the plugin?**
No, on the `Custom CSS and JS` plugin's uninstall all the added code will be removed. Before uninstalling make sure you don't need the codes anymore.

* **What if I want to add multiple external CSS codes?** 
If you write multiple codes of the same type (for example: two external CSS codes), then all of them will be printed one after another

* **Will this plugin affect the loading time?**
When you click the `Save` button the codes will be cached in files, so there are no tedious database queries.

* **Does the plugin modify the code I write in the editor?**
No, the code is printed exactly as in the editor. It is not modified/checked/validated in any way. You take the full responsability for what is written in there.

* **My code doesn't show on the website**
Try one of the following:
1. If you are using any caching plugin (like "W3 Total Cache" or "WP Fastest Cache"), then don't forget to delete the cache before seing the code printed on the website.
2. Make sure the code is in **Published** state (not **Draft** or **in Trash**).
3. Check if the `wp-content/uploads/custom-css-js` folder exists and is writable

* **Does it work with a Multisite Network?**
Yes.

* **What if I change the theme?**
The CSS and JS are independent of the theme and they will persist through a theme change. This is particularly useful if you apply CSS and JS for modifying a plugin's output. 

* **Can I use a CSS preprocesor like LESS or Sass?**
No, for the moment only plain CSS is supported.

* **Can I upload images for use with my CSS?**
Yes. You can upload an image to your Media Library, then refer to it by its direct URL from within the CSS stylesheet. For example:
`div#content {
    background-image: url('http://example.com/wp-content/uploads/2015/12/image.jpg');
}`

* **Can I use CSS rules like @import and @font-face?**
Yes.

* **CSS Help.**
If you are just starting with CSS, then here you'll find some resources:
* [codecademy.com - Learn HTML & CSS](https://www.codecademy.com/learn/web)
* [Wordpress.org - Finding Your CSS Styles](https://codex.wordpress.org/Finding_Your_CSS_Styles)

== Installation ==

* From the WP admin panel, click "Plugins" -> "Add new".
* In the browser input box, type "Simple Custom CSS and JS".
* Select the "Simple Custom CSS and JS" plugin and click "Install".
* Activate the plugin.

OR...

* Download the plugin from this page.
* Save the .zip file to a location on your computer.
* Open the WP admin panel, and click "Plugins" -> "Add new".
* Click "upload".. then browse to the .zip file downloaded from this page.
* Click "Install".. and then "Activate plugin".

OR...

* Download the plugin from this page.
* Extract the .zip file to a location on your computer.
* Use either FTP or your hosts cPanel to gain access to your website file directories.
* Browse to the `wp-content/plugins` directory.
* Upload the extracted `custom-css-js` folder to this directory location.
* Open the WP admin panel.. click the "Plugins" page.. and click "Activate" under the newly added "Simple Custom CSS and JS" plugin.

== Frequently Asked Questions ==

= Requirements =
PHP >= 5.3

= Browser requirements =
* Firefox - version 4 and up
* Chrome - any version
* Safari - version 5.2 and up
* Internet Explorer - version 8 and up
* Opera - version 9 and up

== Screenshots ==

1. Manage Custom Codes

2. Add/Edit Javascript

3. Add/Edit CSS

== Changelog ==

= 2.1 =
* 04/24/2016
* Fix: on multisite installs have to create the custom-css-js folder in the upload dir for each site

= 2.0 =
* 04/11/2016
* Feature: enable/disable codes
* Feature: add a GET parameter at the end of external files in order to over circumvent caching
* Fix: don't add the "<script>" tag from the code if already present. 

= 1.6 =
* 03/26/2016
* Fix: the number of codes were limited because query_posts is automatically inserting a limit 

= 1.5 =
* 10/03/2016
* Fix: solved a conflict with the `shortcoder` plugin.

= 1.4 =
* 04/01/2016
* Tweak: Do not enqueue scripts unless we are editing the a custom-css-js type post.
* Fix: The register_activation_hook was throwing a notice
* Fix: add window.onload when initializing the CodeMirror editor
* Tweak: Differentiated the option names for "Where on page" and "Where in site"
* Fix: set the correct language modes to CodeMirror object
* Tweak: remove the `slug` metabox
* Tweak: use the compressed version of CodeMirror

= 1.3 =
* 27/12/2015
* Tweak: changed the submenus to "Add Custom CSS" and "Add Custom JS" instead of "New Custom Code"
* Tweak: Use `admin_head` instead of `admin_enqueue_scripts` for external files in order to add priority to the code
* Fix: The javascript code was not shown
* Fix: For longer code the last line in the editor was hidding because of the CodeMirrorBefore div.

= 1.2 =
* 14/12/2015
* Fix: when a code was sent into Trash it still wasn't shown on the website

= 1.1 =
* 10/12/2015
* Tweak: for external files use wp_head and wp_footer instead of wp_enqueue_style. Otherwise the CSS and JS is inserted before all the other scripts and are overwritten.
* Tweak: Save all the codes in files in order to save on database queries
* Tweak: Rewrite the readme.txt in the form of FAQ for better explanations

= 1.0 =
* 06/12/2015
* Initial commit

== Upgrade Notice ==

Nothing at the moment
