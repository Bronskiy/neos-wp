<?php

class MY_CPT_PRODUCT {

  public function register() {
    add_action( 'init', [$this, 'cpt_init'] );
  }

  
  public function cpt_init(){
    register_post_type( MY_CPT_PRODUCT, [
      'labels' => [
        'name'               => 'Продукты',
        'singular_name'      => 'Продукт',
        'add_new'            => 'Добавить продукт',
        'add_new_item'       => 'Добавить продукт',
        'edit_item'          => 'Ред. продукт',
        'new_item'           => 'Новый продукт',
        'view_item'          => 'Смотреть продукт',
        'search_items'       => 'Искать продукт',
        'not_found'          => 'Не найдено',
        'not_found_in_trash' => 'Корзина пуста',
        'parent_item_colon'  => '',
        'menu_name'          => '~Продукты',
      ],
      'public'             => true,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'show_in_nav_menus'  => true,
      // 'show_in_menu'       => ST_PLUGIN_MENU_PAGE_SLUG_1,
      'rewrite'            => ['slug' => 'product','with_front' => FALSE],
      'has_archive'        => true,
      'hierarchical'       => false,
      'menu_icon'          => 'dashicons-cart',
      'menu_position'      => null,
      'show_in_rest'       => true, // enable Gutenberg editor
      'supports'           => array('title', 'editor', 'page-attributes'),
      'taxonomies'         => [ MY_TAX_PRODUCT_INDUSTRY_TYPE ],
    ]);
  }

}
