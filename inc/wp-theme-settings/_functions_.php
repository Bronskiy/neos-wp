<?php

require 'register-css.php';
require 'register-js.php';
require 'register-wp-menu.php';
require 'register-image-sizes.php';
require 'remove-admin-menu-items.php';
require 'theme-colors.php';
require 'wp-search.php';

remove_action('wp_head', 'wp_shortlink_wp_head');

add_theme_support('html5', ['search-form']);