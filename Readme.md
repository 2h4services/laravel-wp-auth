## Laravel Wordpress Auth

This package allows you to use Wordpress users in your Laravel application.

## From

Much of the code and idea came from [this](https://github.com/Shelob9/laravel-wordpress-user-provider) package.

### Installation

#### Wordpress

- Install JWT Authentication for WP-API plugin
  - [https://wordpress.org/plugins/jwt-authentication-for-wp-rest-api/](https://wordpress.org/plugins/jwt-authentication-for-wp-rest-api/)
    - You need to follow the plugin directions carefully
      - Especially the part about adding the secret key to your wp-config.php file 
  - Enable the plugin

JWT Authentication for WP-API plugin no longer passes the user id in the data, so we need to add it

- Add the laravel-wp-auth folder under the wordpress directory in this repo to your plugins folder and activate it
  - Easiest way to .zip the laravel-wp-auth folder and upload it using the plugin uploader
  - It is called Laravel-WP-Auth JWT Data

#### Laravel

- Install the package
    - `composer require 2h4services/laravel-wp-auth`
- In your .env file add
  - `WP_AUTH_URL=http://your-wordpress-site.com/wp-json`

