<?php

class MY_TAXONOMY_PRODUCT_INDUSTRY_TYPE {

  public function register() {
    add_action( 'init', [$this, 'taxonomy_init'] );
  }
  
  public function taxonomy_init(){
    /* categories */
    register_taxonomy(
      MY_TAX_PRODUCT_INDUSTRY_TYPE,
      [
        MY_CPT_PRODUCT,
        MY_CPT_PRODUCT_INDUSTRY_TYPE_PAGE
      ],
      [ 
        'label' => '',
        'labels' => [
          'name'              => 'Тип отрасли',
          'singular_name'     => 'Тип отрасли',
          'search_items'      => 'Искать тип отрасли',
          'all_items'         => 'Все типы отрасли',
          'view_item '        => 'Смотреть тип отрасли',
          'parent_item'       => 'Род. тип отрасли',
          'parent_item_colon' => 'Род. тип отрасли',
          'edit_item'         => 'Ред. тип отрасли',
          'update_item'       => 'Обновить тип отрасли',
          'add_new_item'      => 'Добавить тип отрасли',
          'new_item_name'     => 'Новый тип отрасли',
          'menu_name'         => 'Типы отраслей',
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