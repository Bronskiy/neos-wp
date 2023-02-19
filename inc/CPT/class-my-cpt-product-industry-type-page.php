<?php

class MY_CPT_PRODUCT_INDUSTRY_TYPE_PAGE {

  public function register() {
    add_action( 'init', [$this, 'cpt_init'] );
  }

  
  public function cpt_init(){
    register_post_type( MY_CPT_PRODUCT_INDUSTRY_TYPE_PAGE, [
      'labels' => [
        'name'               => 'Страницы типов отраслей',
        'singular_name'      => 'Страница типа отрасли',
        'add_new'            => 'Добавить страницу',
        'add_new_item'       => 'Добавить страницу типа отрасли',
        'edit_item'          => 'Ред. страницу типа отрасли',
        'new_item'           => 'Новая страница типа отрасли',
        'view_item'          => 'Смотреть страницу типа отрасли',
        'search_items'       => 'Искать страницы типов отраслей',
        'not_found'          => 'Не найдено',
        'not_found_in_trash' => 'Корзина пуста',
        'parent_item_colon'  => '',
        'menu_name'          => 'Страницы типов отраслей',
      ],
      'public'             => true,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'show_in_nav_menus'  => true,
      'show_in_menu'       => 'edit.php?post_type=' . MY_CPT_PRODUCT,
      'rewrite'            => ['slug' => 'industry-types', 'with_front' => false ],
      'has_archive'        => false,
      'hierarchical'       => false,
      // 'menu_icon'          => 'dashicons-cart',
      'show_in_rest'       => true, // enable Gutenberg editor
      'supports'           => array(
        'title',
        'editor',
        // 'page-attributes',
      ),
      'taxonomies'         => [ MY_TAX_PRODUCT_INDUSTRY_TYPE ],
    ]);
  }

}
