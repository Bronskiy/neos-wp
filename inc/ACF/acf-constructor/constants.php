<?php
// Path to ACF folder from theme folder
$path_to_ACF_folder = '/inc/ACF';
define( '__ACF_FOLDER_PATH_FROM_THEME__', $path_to_ACF_folder );

define( '__ACf_CONSTUCTOR_ABSPATH__', get_template_directory() . $path_to_ACF_folder . '/acf-constructor' );

// Dev mode
// could be predefined by __IN_DEV__
$dev = null;
if ($dev === null) $dev = defined('__IN_DEV__')? __IN_DEV__ : false;
define( '__ACF_BASE_IS_IN_DEV__', $dev );

// Debug mode
// could be predefined by __ACF_DEBUG__
$debug = null;
if ($debug === null) $debug = defined('__ACF_DEBUG__')? __ACF_DEBUG__ : false;
define( '__ACF_BASE_DEBUG__', $debug );