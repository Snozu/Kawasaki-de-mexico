<?php
/*
Plugin Name: Woodmart Core
Description: Woodmart Core needed for Woodmart theme
Version: 1.1.2
Text Domain: woodmart-core
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

define( 'WOODMART_CORE_PLUGIN_VERSION', '1.1.2' );

require_once 'vendor/opauth/twitteroauth/twitteroauth.php';
require_once 'inc/auth.php';
require_once 'class-post-types.php';
require_once 'post-types.php';
require_once 'inc/shortcodes.php';
