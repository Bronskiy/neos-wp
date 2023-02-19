<?php

// Protection
defined( 'ABSPATH' ) or die( 'Hey, you cant\'t access this file!' );

// Define CONSTANTS
require_once get_template_directory() . '/inc/constants/constants__pages-in-wp-admin.php';
// require_once 'inc/constants.php';

require_once 'inc/class-init.php';
if ( class_exists( 'Init' ) ) {
  Init::register_services();
}