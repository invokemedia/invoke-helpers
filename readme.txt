=== Invoke Helpers ===
Contributors: invokemedia
Tags: invoke, media, helpers, alias
Requires at least: 4.5.0
Tested up to: 4.6
Stable tag: 4.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Helper functions and aliases for WordPress.

== Description ==

Helper functions and aliases for WordPress.

A full list of helpers can be found in the documentation for the plugin.

You can find that in the [website for the plugin](http://invokemedia.github.io/invoke-helpers).

The functions in this plugin are mostly wrappers or aliases to other functions
in wordpress. The main idea is that instead of calling something like
`get_permalink` or `site_url('/some-uri/')`, you can call `url($post)` or
`url('/some-uri/')` and then the function figures out which URL you actually
wanted.

There are also some nice snippets for limiting words, limiting characters,
checking the template, rendering partials, and debugging/dumping variables.

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload the plugin files to the `/wp-content/plugins/invoke-helpers` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress
1. Use the Settings->Invoke Helpers screen to configure the plugin
1. (Make your instructions match the desired user flow for activating and installing your plugin. Include any steps that might be needed for explanatory purposes)

== Changelog ==

= 1.0 =
* Initial release