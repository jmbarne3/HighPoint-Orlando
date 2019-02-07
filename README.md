Welcome to the HighPoint-Orlando theme. This theme has been developed for the [HighPoint Church in Orlando, FL](http://highpointorlando.com).

## Depedencies

### Required Plugins

* Advanced Custom Fields 5 ([Free](https://wordpress.org/plugins/advanced-custom-fields/) or [Pro](https://www.advancedcustomfields.com/pro/))
* [Advanced Custom Fields: Font Awesome](https://wordpress.org/plugins/advanced-custom-fields-font-awesome/)
* [Classic Editor](https://wordpress.org/plugins/classic-editor/) (Gutenburg comptibility has not been tested)

### Recommended Plugins

* [Events Manager](https://wordpress.org/plugins/events-manager/)
* [Ministry Custom Post Type](https://github.com/jmbarne3/ministries-cpt-plugin)
* [People Custom Post Type](https://github.com/jmbarne3/people-cpt-plugin)
* [WP Bootstrap Shortcodes](https://github.com/jmbarne3/wp-bootstrap-shortcodes/)

## Development Installation

1. Install [required plugins](#required-plugins)
2. Clone the theme into the WordPress `themes/` directory: `git clone https://github.com/jmbarne3/HighPoint-Orlando.git`
3. `cd` into the new `HighPoint-Orlando` theme directory and run `npm install` to install required packages for development.
4. Run `gulp default` to process front-end assets. If gulp is not installed globally, run `npm install -g gulp` then rerun `gulp default`.
5. Set "HighPoint Orlando Theme" as the active theme on the site you wish to develop.
6. Run `gulp watch` to continuously watch changes to scss and js files.
