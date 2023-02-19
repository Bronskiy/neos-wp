<?php

class MY_CPT_SETTINGS {

  public function register() {
    add_action( 'init', [$this, 'cpt_init'] );
  }

  
  public function cpt_init(){
    register_post_type( MY_CPT_SETTINGS, [
      'labels' => [
        'name'               => 'Настройки сайта',
        'singular_name'      => 'Настройка сайта',
        'add_new'            => 'Добавить настройку',
        'add_new_item'       => 'Добавить настройку',
        'edit_item'          => 'Редактировать настройку',
        'new_item'           => 'Новая настройка',
        'view_item'          => 'Посмотреть настройку',
        'search_items'       => 'Найти настройку',
        'not_found'          => 'Ничего не найдено',
        'not_found_in_trash' => 'В корзине ничего не найдено',
        'parent_item_colon'  => '',
        'menu_name'          => '~Настройки сайта'
      ],

      // 'capability_type'    => ST_SCRIPT_ED_CAP_TYPE_NAME,
      // 'map_meta_cap'       => true,

      'public'             => true,
      'publicly_queryable' => false,
      'show_ui'            => true,
      'show_in_nav_menus'  => false,
      // 'show_in_menu'       => ST_PLUGIN_MENU_PAGE_SLUG_1,
      'rewrite'            => true,
      'has_archive'        => false,
      'hierarchical'       => false,
      'menu_icon'          => 'dashicons-admin-generic',
      'menu_position'      => null,
      'supports'           => array('title'),
      'exclude_from_search'=> true,
    ]);
  }

}