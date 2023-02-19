<?php

add_action('after_setup_theme', function() {
  register_nav_menus([
    'my__header_menu' => 'Меню в шапке',
  ]);
});