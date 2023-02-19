<?php

class MY_CPT_LANDING_PAGE {

  public function register() {
    add_action( 'init', [$this, 'cpt_init'] );
  }

  
  public function cpt_init(){
    register_post_type( MY_CPT_LANDING_PAGE, [
      'labels' => [
        'name'               => 'Отдельные страницы',
        'singular_name'      => 'Отдельная страницы',
        'add_new'            => 'Добавить страницу',
        'add_new_item'       => 'Добавить страницу',
        'edit_item'          => 'Ред. страницу',
        'new_item'           => 'Новая страница',
        'view_item'          => 'Смотреть страницу',
        'search_items'       => 'Искать страницу',
        'not_found'          => 'Не найдено',
        'not_found_in_trash' => 'Корзина пуста',
        'parent_item_colon'  => '',
        'menu_name'          => '~Отдельные страницы',
      ],
      'public'             => true,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'show_in_nav_menus'  => true,
      'rewrite'            => ['slug' => 'lp','with_front' => FALSE],
      'has_archive'        => false,
      'hierarchical'       => false,
      'menu_icon'          => 'dashicons-admin-page',
      'menu_position'      => null,
      'show_in_rest'       => true, // enable Gutenberg editor
      'exclude_from_search'=> true,
      'supports'           => array('title', 'editor', 'page-attributes'),
    ]);
  }

}
