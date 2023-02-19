<?php

class MY_CPT_SITE_FORM {

  public function register() {
    add_action( 'init', [$this, 'cpt_init'] );
  }

  
  public function cpt_init(){
    register_post_type( MY_CPT_SITE_FORM, [
      'labels' => [
        'name'               => 'Настройка форм',
        'singular_name'      => 'Настройка форм',
        'add_new'            => 'Добавить форму',
        'add_new_item'       => 'Добавить форму',
        'edit_item'          => 'Редактировать форму',
        'new_item'           => 'Новая форма',
        'view_item'          => 'Посмотреть форму',
        'search_items'       => 'Найти форму',
        'not_found'          => 'Ничего не найдено',
        'not_found_in_trash' => 'В корзине ничего не найдено',
        'parent_item_colon'  => '',
        'menu_name'          => 'Настройка форм'
      ],

      // 'capability_type'    => ST_SCRIPT_ED_CAP_TYPE_NAME,
      // 'map_meta_cap'       => true,

      'public'             => true,
      'publicly_queryable' => false,
      'show_ui'            => true,
      'show_in_nav_menus'  => false,
      'show_in_menu'       => 'edit.php?post_type=' . MY_CPT_SETTINGS,
      'rewrite'            => true,
      'has_archive'        => false,
      'hierarchical'       => false,
      // 'menu_icon'          => 'dashicons-admin-generic',
      'menu_position'      => null,
      'supports'           => array('title'),
      'exclude_from_search'=> true,
    ]);
  }

}