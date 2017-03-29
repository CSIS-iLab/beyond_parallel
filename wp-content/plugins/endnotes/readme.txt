=== Endnotes ===
Contributors: heavyheavy, wearepixel8
Tags: footnotes, endnotes, bibliography, notes, references, reference notes, citations, attribution
Requires at least: 4.1
Compatible up to: 4.5.1
Tested up to: 4.5.1
Stable tag: 1.0.1
License: GPLv2

Easily add footnotes to your posts and pages.

== Description ==

Endnotes is a simple solution for adding footnotes to your WordPress posts or pages. The plugin originated as a fork of John Watson’s FD [Footnotes](https://wordpress.org/plugins/fd-footnotes/) but has been updated to use the WordPress Settings API. The original plugin’s usage and functionality has been retained.

= How to Use =

You can add footnotes to your posts or pages by adding numbered inline content within square brackets. Place the inline content where you would like the superscript numeral to appear.

`I am Jack's happy sentence that will contain a footnote[1. I am Jack's happy footnote] for calling out a reference.`

Each footnote must have a number, followed by a period and a space, and then the actual footnote. They don’t have to be unique but it is recommended. It doesn’t matter what the numbers are since the footnotes will be automatically renumbered when the post is displayed.

Footnotes can contain anything you’d like including links, images, etc. Footnotes are automatically linked back to the spot in the text where the note was made.

= Square Bracket Usage =

Do not include square brackets inside the footnotes themselves.

= Unique Footnote Numbers =

Footnote numbers don’t need to be unique but it is highly recommended, especially if the text is identical for multiple footnotes. If you have multiple footnotes with the exact same text and number, you may get undesirable results.

== Installation ==

You can install Endnotes either via the WordPress Dashboard or by uploading the extracted `endnotes` folder to your `/wp-content/plugins/` directory. Once the plugin has been successfully installed, simply activate the plugin through the Plugins menu in your WordPress Dashboard.

Once the plugin has been activated, visit the Settings page to customize the display of your footnotes.

== Frequently Asked Questions ==

= Why was this plugin developed? =
Though we loved the simplicity of the FD Footnotes plugin, we felt it was prudent to utilize the WordPress Settings API to prevent the occurrence of PHP errors we were encountering.

= Will the plugin style my footnotes? =
No. We felt it was important to leave the stylistic presentation of your footnotes up to you. The markup for the footnotes is pretty straightforward and should inherit your theme’s styles for `h3`, `a`, and `ol` elements. There are unique CSS class names you can hook into for further customization via your theme’s `style.css` file.

= I am using FD Footnotes. Can I migrate to Endnotes? =
If you would like to replace FD Footnotes with Endnotes, you will need to deactivate FD Footnotes **before** activating Endnotes. Because this plugin is using the WordPress Setting API, you will need to navigate to the **Endnotes Settings** page and save your settings.

= Is the plugin translatable? =
Yes. If you have translated the plugin into your language, please send the translation files to [hello@heavyheavy.com](hello@heavyheavy.com) for inclusion in future releases.

== Screenshots ==

1. Endnotes settings screen
2. Endnotes usage in TinyMCE editor
3. Endnotes output

== Changelog ==

= 1.0.0 =
* Initial release