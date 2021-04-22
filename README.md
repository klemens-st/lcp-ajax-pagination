# LCP Ajax Pagination

This WordPress plugin is an add-on for the [List Category Posts](https://wordpress.org/plugins/list-category-posts/)
plugin. It extends LCP's pagination with the following features:
* transform LCP pagination into ajax pagination,
* transform LCP pagination into ajax 'load more'.

**IMPORTANT**: Requires LCP v0.84.1 or greater.

Usage: `[catlist ajax_pagination=yes]` or `[catlist ajax_loadmore=yes]`.

This repository contains a development version of the plugin.
If you just download this repository and add it to your WordPress installation it *won't work*.
Production releases are available on the [plugin's page in WordPress.org plugin directory](https://wordpress.org/plugins/lcp-ajax-pagination).

## Documentation
User documentation can be found on the [plugin's WordPress.org page](https://wordpress.org/plugins/lcp-ajax-pagination).

## Support

Please use the [WordPress support forum](https://wordpress.org/support/plugin/lcp-ajax-pagination/)
for **user support** and any **questions about how to use the plugin**.
[Github issues](https://github.com/klemens-st/lcp-ajax-pagination/issues) should only be used for **bug reports**,
**feature requests** and other code-related topics.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

The build (JS and CSS) is run by npm, for all its tasks to work you need to have [Node.js](https://nodejs.org/en/) installed:

I recommend using [VVV](https://github.com/Varying-Vagrant-Vagrants/VVV) for local testing and development.

### Installing
If you are using VVV, clone this repo into the `plugins` directory of a WP install you created with VVV and `cd` into its root directory.

#### Install dependencies.

```
npm install
```

## Testing and developing

To avoid running build scripts manually every time you change SCSS or JS files, a watch task has been set up.
```
npm run watch
```
This will automatically compile CSS files and bundle JS whenever you change the source.
Files generates by this task are not fit for production, however.

#### Build for production

```
npm run build
```

### Automated tests

Automated tests have not been added yet. I am planning to add PHPCS and PHPUnit.

## Versioning

I use [SemVer](http://semver.org/) for versioning. For the versions available, see the [releases on this repository](https://github.com/klemens-st/lcp-ajax-pagination/releases).

## License

This project is licensed under the GPL-3.0 License - see the [LICENSE.txt](LICENSE.txt) file for details
