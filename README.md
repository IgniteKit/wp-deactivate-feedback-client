# WP Deactivate Feedback Client

Easy to use WordPress package for collecting feedback on plugin deactivation.

The library allows toe developers to set up feedback form that shows on plugin deactivation on the Plugins page.

## Quick Start

### 1. How to install

```
composer require ignitekit/wp-deactivate-feedback-client
```

### 2. How to use

Basically in your plugin files you need to create instance of the library as follows:

```php
try {
	new \IgniteKit\WP\DeactivateFeedbackClient\Main( [
		'name'        => 'Digital License Manager',
		'slug'        => 'digital-license-manager',
		'version'     => YOUR_PLUGIN_VERSION,
		'prefix'      => 'dlm_',
		'public_path' => str_replace( '/', DIRECTORY_SEPARATOR, dirname( __FILE__ ) . '/vendor/ignitekit/wp-deactivate-feedback-client/public/' ),
		'public_url'  => rtrim( plugin_dir_url( __FILE__ ), '/' ) . '/vendor/ignitekit/wp-deactivate-feedback-client/public/',
		'api_url'     => 'https://yoursite.com/wp-json/deactivate-feedback/v1/feedback',
		'data'        => [ 'website', 'system', 'contact' ],
	] );
} catch ( \Exception $e ) {

}
```

### 3. Collecting data

To collect data, you can use our plugin **WP Deactivate Feedback**.

[[Get Started]](https://github.com/ignitekit/wp-deactivate-feedback/)

## License

```
Copyright (C) 2024  Darko Gjorgjijoski. All Rights Reserved.
Copyright (C) 2024  IDEOLOGIX MEDIA DOOEL. All Rights Reserved.
Copyright (C) 2024  IgniteKit. All Rights Reserved.

WP Deactivate Feedback is free software; you can redistribute it
and/or modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

WP Deactivate Feedback program is distributed in the hope that it
will be useful,but WITHOUT ANY WARRANTY; without even the implied
warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License v3
along with this program;

If not, see: https://www.gnu.org/licenses/gpl-3.0.en.html

Code written, maintained by Darko Gjorgjijoski (https://darkog.com)
```
