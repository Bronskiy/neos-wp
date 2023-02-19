<?php

class MY_TAXONOMY_PRODUCT_TYPE {

  public function register() {
    add_action( 'init', [$this, 'taxonomy_init'] );
  }
  
  public function taxonomy_init(){
    /* categories */
    register_taxonomy(
      MY_TAX_PRODUCT_TYPE,
      [
        MY_CPT_PRODUCT,
        MY_CPT_PRODUCT_TYPE_PAGE
      ],
      [ 
        'label' => '',
        'labels' => [
          'name'              => 'Тип продукта',
          'singular_name'     => 'Тип продукта',
          'search_items'      => 'Искать тип',
          'all_items'         => 'Все типы продуктов',
          'view_item '        => 'Смотреть тип',
          'parent_item'       => 'Родительский тип',
          'parent_item_colon' => 'Родительский тип',
          'edit_item'         => 'Ред. тип',
          'update_item'       => 'Обновить тип',
          'add_new_item'      => 'Добавить тип',
          'new_item_name'     => 'Новый тип продукта',
          'menu_name'         => 'Типы продуктов',
        ],
        'hierarchical'          => true, // true makes checkbox select
        'rewrite'               => true,
        'query_var'             => true,
        // 'meta_box_cb'           => 'post_categories_meta_box', // html метабокса. callback: `post_categories_meta_box` или `post_tags_meta_box`. false — метабокс отключен.
        'show_admin_column'     => true, // показывать таксономию в списке постов
        'show_in_rest'          => true, // добавить в REST API && show in side-menu
      ]
    );
  }
}