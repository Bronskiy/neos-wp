<?php
if (!defined( 'ABSPATH' )) exit;

/* add translations */
add_action( 'after_setup_theme', function(){
  // https://wp-kama.ru/handbook/codex/translations
	load_theme_textdomain( '_my_theme_', get_template_directory() . '/languages' );
});


/* 1 */ require 'inc/constants/global-constants.php';
/* 2 */ require 'inc/wp-theme-settings/_functions_.php';
/* 3 */ require 'inc/pages-in-wp-admin/register-menu-items.php';
/* 4 */ require 'inc/functions/_functions_.php';
/* 5 composer */ require_once 'vendor/autoload.php';
/* 5.1 */ require 'inc/set-geo-location.php';

require 'inc/REST/class-rest-routes.php';
$REST = new MY_REST_ROUTES();
$REST->register();

require 'inc/ACF/class-my-acf.php';
$ACF = new MY_ACF();
$ACF->register();

require 'inc/CPT/class-my-cpt.php';
$CPT = new MY_CPT();
$CPT->register();

require 'inc/taxonomies/class-my_taxonomies.php';
$TAX = new MY_TAXONOMIES();
$TAX->register();



// add_filter( 'rest_enabled', '__return_false' );
remove_action( 'xmlrpc_rsd_apis', 'rest_output_rsd' );
remove_action( 'wp_head', 'rest_output_link_wp_head', 10, 0 );
remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );
remove_action( 'auth_cookie_malformed', 'rest_cookie_collect_status' );
remove_action( 'auth_cookie_expired', 'rest_cookie_collect_status' );
remove_action( 'auth_cookie_bad_username', 'rest_cookie_collect_status' );
remove_action( 'auth_cookie_bad_hash', 'rest_cookie_collect_status' );
remove_action( 'auth_cookie_valid', 'rest_cookie_collect_status' );
remove_filter( 'rest_authentication_errors', 'rest_cookie_check_errors', 100 );
remove_action( 'init', 'rest_api_init' );
remove_action( 'rest_api_init', 'rest_api_default_filters', 10, 1 );
remove_action( 'parse_request', 'rest_api_loaded' );
remove_action( 'rest_api_init', 'wp_oembed_register_route' );
remove_filter( 'rest_pre_serve_request', '_oembed_rest_pre_serve_request', 10, 4 );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
remove_action( 'wp_head', 'wp_oembed_add_host_js' );




// function _remove_script_version( $src ){
//   $parts = explode( '?ver', $src );
//   return $parts[0];
// }
// add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
// add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );