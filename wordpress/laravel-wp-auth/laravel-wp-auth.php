<?php
/**
 * @wordpress-plugin
 * Plugin Name:       Laravel-WP-Auth JWT Data
 * Plugin URI:        https://github.com/2h4services/laravel-wp-auth
 * Description:       Updates the JWT Auth plugin with more data.
 * Version:           1.0.0
 * Author:            2h4services
 * Author URI:        https://2h4services.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

add_action('jwt_auth_token_before_dispatch', function ($data, $user) {
    $data['ID'] = $user->ID;

    return $data;
}, 10, 2);