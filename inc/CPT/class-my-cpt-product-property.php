<?php

class MY_CPT_PRODUCT_PROPERTY {

  public function register() {
    add_action( 'init', [$this, 'cpt_init'] );
  }

  
  public function cpt_init(){
    register_post_type( MY_CPT_PRODUCT_PROPERTY, [
      'labels' => [
        'name'               => 'Настройка характеристик продуктов',
        'singular_name'      => 'Настройка характеристики продукта',
        'add_new'            => 'Добавить характеристику',
        'add_new_item'       => 'Добавить характеристику',
        'edit_item'          => 'Ред. характеристику',
        'new_item'           => 'Новая характеристика',
        'view_item'          => 'Смотреть характеристику',
        'search_items'       => 'Искать характеристику',
        'not_found'          => 'Не найдено',
        'not_found_in_trash' => 'Корзина пуста',
        'parent_item_colon'  => '',
        'menu_name'          => 'Настройка характеристик продуктов',
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
