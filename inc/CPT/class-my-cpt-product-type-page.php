<?php

class MY_CPT_PRODUCT_TYPE_PAGE {

  public function register() {
    add_action( 'init', [$this, 'cpt_init'] );
  }

  
  public function cpt_init(){
    register_post_type( MY_CPT_PRODUCT_TYPE_PAGE, [
      'labels' => [
        'name'               => 'Страницы типов продуктов',
        'singular_name'      => 'Страница типа продукта',
        'add_new'            => 'Добавить страницу типа продукта',
        'add_new_item'       => 'Добавить страницу типа продукта',
        'edit_item'          => 'Ред. страницу типа продукта',
        'new_item'           => 'Новая страница типа продуктов',
        'view_item'          => 'Смотреть страницу типа продукта',
        'search_items'       => 'Искать страницы типов продукта',
        'not_found'          => 'Не найдено',
        'not_found_in_trash' => 'Корзина пуста',
        'parent_item_colon'  => '',
        'menu_name'          => 'Страницы типов продуктов',
      ],
      'public'             => true,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'show_in_nav_menus'  => true,
      'show_in_menu'       => 'edit.php?post_type=' . MY_CPT_PRODUCT,
      'rewrite'            => ['slug' => 'product-types','with_front' => false],
      'has_archive'        => false,
      'hierarchical'       => false,
      // 'menu_icon'          => 'dashicons-cart',
      'show_in_rest'       => true, // enable Gutenberg editor
      'supports'           => array(
        'title',
        'editor',
        // 'page-attributes',
      ),
      'taxonomies'         => [ MY_TAX_PRODUCT_TYPE ],
    ]);
  }

}
