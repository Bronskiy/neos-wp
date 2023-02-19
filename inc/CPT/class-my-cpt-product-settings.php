<?php

class MY_CPT_PRODUCT_ARCHIVE_AND_PAGE_SETTINGS {

  public function register() {
    add_action( 'init', [$this, 'cpt_init'] );
  }

  
  public function cpt_init(){
    register_post_type( MY_CPT_PRODUCT_ARCHIVE_AND_PAGE_SETTINGS, [
      'labels' => [
        'name'               => 'Настройка архивов и страниц продуктов',
        'singular_name'      => 'Настройка архивов и страниц продуктов',
        'add_new'            => 'Добавить настройку',
        'add_new_item'       => 'Добавить настройку',
        'edit_item'          => 'Ред. настройку',
        'new_item'           => 'Новая настройка',
        'view_item'          => 'Смотреть настройку',
        'search_items'       => 'Искать настройку',
        'not_found'          => 'Не найдено',
        'not_found_in_trash' => 'Корзина пуста',
        'parent_item_colon'  => '',
        'menu_name'          => 'Настройка архивов и страниц продуктов',
      ],
      'public'             => true,
      'publicly_queryable' => false,
      'show_ui'            => true,
      'show_in_nav_menus'  => true,
      'show_in_menu'       => 'edit.php?post_type=' . MY_CPT_PRODUCT,
      'rewrite'            => false,
      'has_archive'        => false,
      'hierarchical'       => true,
      'show_in_rest'       => false, // enable Gutenberg editor
      'supports'           => array( 'title'),
      'exclude_from_search'=> true,
    ]);
  }

}
