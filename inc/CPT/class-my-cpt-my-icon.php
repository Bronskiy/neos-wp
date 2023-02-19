<?php

class MY_CPT_MY_ICON {

  public function register() {
    add_action( 'init', [$this, 'cpt_init'] );
  }

  
  public function cpt_init(){
    register_post_type( MY_CPT_MY_ICON, [
      'labels' => [
        'name'               => 'SVG иконки',
        'singular_name'      => 'SVG иконка',
        'add_new'            => 'Добавить иконку',
        'add_new_item'       => 'Добавить иконку',
        'edit_item'          => 'Ред. иконку',
        'new_item'           => 'Новая иконка',
        'view_item'          => 'Смотреть иконку',
        'search_items'       => 'Искать иконку',
        'not_found'          => 'Не найдено',
        'not_found_in_trash' => 'Корзина пуста',
        'parent_item_colon'  => '',
        'menu_name'          => '~SVG иконки',
      ],
      'public'             => true,
      'publicly_queryable' => false,
      'show_ui'            => true,
      'show_in_nav_menus'  => true,
      // 'show_in_menu'       => 'edit.php?post_type=' . MY_CPT_PRODUCT,
      'rewrite'            => false,
      'has_archive'        => false,
      'hierarchical'       => false,
      'menu_icon'          => 'data:image/svg+xml;base64,PHN2ZyB2aWV3Qm94PSIwIDAgMjQgMjQiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHBhdGggZD0iTTEwLDRWOEgxNFY0SDEwTTE2LDRWOEgyMFY0SDE2TTE2LDEwVjE0SDIwVjEwSDE2TTE2LDE2VjIwSDIwVjE2SDE2TTE0LDIwVjE2SDEwVjIwSDE0TTgsMjBWMTZINFYyMEg4TTgsMTRWMTBINFYxNEg4TTgsOFY0SDRWOEg4TTEwLDE0SDE0VjEwSDEwVjE0TTQsMkgyMEEyLDIgMCAwLDEgMjIsNFYyMEEyLDIgMCAwLDEgMjAsMjJINEMyLjkyLDIyIDIsMjEuMSAyLDIwVjRBMiwyIDAgMCwxIDQsMloiLz48L3N2Zz4=',
      'show_in_rest'       => false, // enable Gutenberg editor
      'supports'           => array( 'title'),
      'exclude_from_search'=> true,
    ]);
  }

}
