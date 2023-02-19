<?php



class MY_CPT_AD {

  public function register() {
    add_action( 'init', [$this, 'cpt_init'] );
  }

  
  public function cpt_init(){
    register_post_type( MY_CPT_AD, [
      'labels' => [
        'name'               => 'Реклама',
        'singular_name'      => 'Реклама',
        'add_new'            => 'Добавить рекламу',
        'add_new_item'       => 'Добавить рекламу',
        'edit_item'          => 'Ред. рекламу',
        'new_item'           => 'Новая реклама',
        'view_item'          => 'Смотреть рекламу',
        'search_items'       => 'Искать рекламу',
        'not_found'          => 'Не найдено',
        'not_found_in_trash' => 'Корзина пуста',
        'parent_item_colon'  => '',
        'menu_name'          => '~Реклама',
      ],
      'public'             => true,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'show_in_nav_menus'  => true,
      'rewrite'            => ['slug' => 'lp', 'with_front' => FALSE],
      'has_archive'        => false,
      'hierarchical'       => false,
      'menu_icon'          => 'dashicons-megaphone',
      'menu_position'      => null,
      'show_in_rest'       => true, // enable Gutenberg editor
      'exclude_from_search'=> true,
      'supports'           => array('title', 'editor', 'page-attributes'),
    ]);
  }

}
