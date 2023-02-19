<?php

class MY_CPT_MASTER_CLASS {

  public function register() {
    add_action( 'init', [$this, 'cpt_init'] );
  }

  
  public function cpt_init(){
    register_post_type( MY_CPT_MASTER_CLASS, [
      'labels' => [
        'name'               => 'Мастер-классы',
        'singular_name'      => 'Мастер-класс',
        'add_new'            => 'Добавить мастер-класс',
        'add_new_item'       => 'Добавить мастер-класс',
        'edit_item'          => 'Ред. мастер-класс',
        'new_item'           => 'Новый мастер-класс',
        'view_item'          => 'Смотреть мастер-класс',
        'search_items'       => 'Искать мастер-класс',
        'not_found'          => 'Не найдено',
        'not_found_in_trash' => 'Корзина пуста',
        'parent_item_colon'  => '',
        'menu_name'          => '~Мастер-классы',
      ],
      'public'             => true,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'show_in_nav_menus'  => true,
      // 'show_in_menu'       => ST_PLUGIN_MENU_PAGE_SLUG_1,
      'rewrite'            => ['slug' => 'master_classes','with_front' => FALSE],
      'has_archive'        => true,
      'hierarchical'       => false,
      'menu_icon'          => 'data:image/svg+xml;base64,PHN2ZyBoZWlnaHQ9IjI0IiB2aWV3Qm94PSIwIDAgMjQgMjQiIHdpZHRoPSIyNCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiBzdHlsZT0iZmlsbDojOWVhM2E4OyI+PHBhdGggZD0iTTIwLDE3QTIsMiAwIDAsMCAyMiwxNVY0QTIsMiAwIDAsMCAyMCwySDkuNDZDOS44MSwyLjYxIDEwLDMuMyAxMCw0SDIwVjE1SDExVjE3TTE1LDdWOUg5VjIySDdWMTZINVYyMkgzVjE0SDEuNVY5QTIsMiAwIDAsMSAzLjUsN0gxNU04LDRBMiwyIDAgMCwxIDYsNkEyLDIgMCAwLDEgNCw0QTIsMiAwIDAsMSA2LDJBMiwyIDAgMCwxIDgsNFoiLz48L3N2Zz4=',
      'menu_position'      => null,
      'show_in_rest'       => true, // enable Gutenberg editor
      'supports'           => array('title', 'editor'),
    ]);
  }

}
