=== LCP Ajax Pagination ===
Contributors: zymeth25
Donate link: https://www.paypal.com/donate?hosted_button_id=BX4TN5Z4MSX52&source=url
Tags: ajax, ajax-pagination, list-category-posts
Requires at least: 4.7
Tested up to: 6.1
Requires PHP: 5.6
Stable tag: 0.1.5
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Ajax pagination add-on plugin for List Category Posts.

== Description ==

LCP Ajax Pagination is an add-on plugin for [List Category Posts](https://wordpress.org/plugins/list-category-posts/).
Many users have requested the AJAX pagination feature and it is now possible with this extension.

Two modes are currently supported:

* Ajax pagination
* Load more posts

**IMPORTANT**: Requires List Category Posts **version 0.84.1 or greater**.

## Ajax pagination ##

Usage: `[catlist ajax_pagination=yes]`

The result is as if you used `[catlist pagination=yes]` but clicking pagination links does not trigger page reloads.
Instead, new posts are fetched asynchronously and the list is updated without a reload.

No other features of [LCP pagination](https://github.com/picandocodigo/List-Category-Posts/wiki/Pagination) are modified,
you can apply your pagination CSS, or other customisations, same as you have before.

## Load more ##

Usage: `[catlist ajax_loadmore=yes]`

This transforms vanilla LCP pagination by replacing pagination links with a "Load more" link. Note that this
first release does not allow specifying how many posts to fetch and uses the `numberposts` shortcode parameter
same as [vanilla pagination](https://github.com/picandocodigo/List-Category-Posts/wiki/Pagination).
This will change in a future release.

You can customise the link's text using LCP's `pagination_next` parameter:
`[catlist ajax_loadmore=yes pagination_next="Show more posts"]`

## General notes ##

* **IMPORTANT**: If you have multiple shortcodes on a page, those using AJAX **must** have the `instance` parameter set
as per [the documentation](https://github.com/picandocodigo/List-Category-Posts/wiki/Pagination).
`[catlist ajax_loadmore=yes instance=1]`
* You do not have to use LCP's `pagination` parameter, using `ajax_loadmore` or `ajax_pagination` is enough.
* Make sure your shortcode contains only one option: `ajax_loadmore` or `ajax_pagination`, otherwise the plugin will not work.

## CSS customisations ##

The plugin uses the following CSS classes:

* AJAX pagination `<ul>` has the original `lcp_paginator` class, this plugin also adds `lcpax-pagination`.
* Wrapper around the load more link is: `<div class="lcpax-nextlink-wrapper">`, the link itself is left unchanged
as delivered by LCP, so it has the `lcp_nextlink` class.
* The SVG spinner displayed while waiting for 'load more' to finish has the `lcpax-spinner` class.

==Development==

LCP Ajax is open source software. You can find the
development version of the plugin on [Github](https://github.com/klemens-st/lcp-ajax-pagination).

All suggestions and contributions are welcome :) Fork it, read the respository's
readme and start helping with the development!

==Support the plugin==

If you have found this plugin useful and would like to support its further development please consider
[sponsoring it on GitHub](https://github.com/sponsors/klemens-st/) or [donating on PayPal](https://www.paypal.com/donate?hosted_button_id=BX4TN5Z4MSX52) :)

==User Support==

Please use the support forum for questions about **using** the plugin. Use Github issues for discussing **code changes** and **bugs**.

== Installation ==

Please note that this is an add-on plugin which requires [List Category Posts](https://wordpress.org/plugins/list-category-posts/) to be installed and activated.

== Changelog ==

= 0.1.5 =
* Updated dependencies.

= 0.1.4 =
* Updated dependencies.

= 0.1.3 =
* Updated dependencies.

= 0.1.2 =
* Fixed load more link remaining active before previous fetch is finished.

= 0.1.0 =
* Initial release

== Upgrade Notice ==
