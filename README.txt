=== Riloadr for WordPress ===  
Contributors: OleVik
Donate link: http://www.charitywater.org/donate/
Tags: images, responsive, riloadr
Requires at least: 3.0.0
Tested up to: 3.4.2
Stable tag: 1.2.1
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Riloadr for WordPress is a cross-browser responsive images loader for WordPress 3.0.0 and up.

== Description ==
Based on <a href="https://github.com/tubalmartin/riloadr">Riloadr</a>.

A cross-browser jQuery responsive images loader for WordPress: The goal of this library is to deliver optimized, 
contextual image sizes in responsive layouts that utilize dramatically different image sizes at different resolutions 
in order to improve page load time.

This modification is optimized for use with image sizes defined by WordPress via `add_image_size()`.

= Features =
* **jQuery Optimized**: Uses WordPress' built-in jQuery to integrate with Riloadr.
* **Easy to configure**: Optimize your templates and include the required files and you're done.
* **Limit application**: The technique will only be applied to images with the class *riloadr*
* **Mirrors the original**: The rest of the features are equivalent to the ones at <a href="https://github.com/tubalmartin/riloadr">https://github.com/tubalmartin/riloadr</a>

= Compatability =
This technique is tested to work with WordPress 3.3.2+, but should theoretically be backwards compatible to 3.0. Please note that any cache-plugins are likely to interfere with this plugin, and may require debugging.

As per [tubalmartin/riloadr](https://github.com/tubalmartin/riloadr) the following browsers have been tested:

**Mobile browsers**

* Webkit mobile (iOS and Android)
* Opera Mini (iOS and Android). Yes, it sounds incredible!!
* Opera Mobile (iOS and Android)
* Firefox mobile (Android)
* Netfront Life browser v2 (Android)
* Dolphin Browser HD (iOS and Android)
* UC Browser 8+ (Android)

**Desktop browsers**

* Internet Explorer 6+
* Firefox (Mac and Win)
* Google Chrome (Mac and Win)
* Safari (Mac and Win)
* Opera (Mac and Win)

== Installation ==
1. Upload the `riloadr-for-wordpress` folder to your plugins directory (ie. `/wp-content/plugins/`)
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Set options from the Settings->Riloadr menu
4. Make sure your stylesheet is set up with the following CSS:


	`img {max-width: 100%;}`
	
	`.lt-ie8 img{-ms-interpolation-mode: bicubic;}`
	
	`.lt-ie7 img{width: 100%;}`

== Changelog ==
Uses Semantic Versioning (http://semver.org/).
= 1.2.1 =
* Core script updated to Riloadr version 1.3.2.

= 1.2.0 =
* Plugin is now considered stable.
* Core script updated to Riloadr version 1.2.0.
* Script is now minified by default, see [GitHub/OleVik/riloadr-wordpress](https://github.com/OleVik/riloadr-wordpress) for uncompressed script.
* Introduces the experimental **ignoreLowBandwidth** feature.
* Bugfix for the *belowFold* option.

= 1.1.2 =
* Bug Fix Release:
* Core script updated to Riloadr version 1.1.0.
* Simplified sizing method.
* Horizontal and Vertical images should now both have Riloadr applied, **irrespective of captions**.

= 1.1.1 =
* Bug Fix Release:
* Riloadr is now applied to images outside of captions.
* Horizontal and Vertical images should now both have Riloadr applied.
* Added fallback to original size image, when all else fails.

= 1.1.0 =
* Public Beta

= 1.0.0 =
* Private Beta

= Pre 1.0.0 =
* Private Development