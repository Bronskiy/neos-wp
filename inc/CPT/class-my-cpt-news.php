<?php

class MY_CPT_NEWS {

  public function register() {
    add_action( 'init', [$this, 'cpt_init'] );
  }

  
  public function cpt_init(){
    register_post_type( MY_CPT_NEWS, [
      'labels' => [
        'name'               => 'Новости',
        'singular_name'      => 'Новость',
        'add_new'            => 'Добавить новость',
        'add_new_item'       => 'Добавить новость',
        'edit_item'          => 'Ред. новость',
        'new_item'           => 'Новая новость',
        'view_item'          => 'Смотреть новость',
        'search_items'       => 'Искать новость',
        'not_found'          => 'Не найдено',
        'not_found_in_trash' => 'Корзина пуста',
        'parent_item_colon'  => '',
        'menu_name'          => '~Новости',
      ],
      'public'             => true,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'show_in_nav_menus'  => true,
      // 'show_in_menu'       => ST_PLUGIN_MENU_PAGE_SLUG_1,
      'rewrite'            => ['slug' => 'news', 'with_front' => FALSE],
      'has_archive'        => false,
      'hierarchical'       => false,
      'menu_icon'          => 'data:image/svg+xml;base64,PHN2ZyBoZWlnaHQ9IjI0IiB2aWV3Qm94PSIwIDAgMjQgMjQiIHdpZHRoPSIyNCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiBzdHlsZT0iZmlsbDojOWVhM2E4Ij48cGF0aCBkPSJNNCA3VjE5SDE5VjIxSDRDMiAyMSAyIDE5IDIgMTlWN0g0TTIxIDVWMTVIOFY1SDIxTTIxLjMgM0g3LjdDNi43NiAzIDYgMy43IDYgNC41NVYxNS40NUM2IDE2LjMxIDYuNzYgMTcgNy43IDE3SDIxLjNDMjIuMjQgMTcgMjMgMTYuMzEgMjMgMTUuNDVWNC41NUMyMyAzLjcgMjIuMjQgMyAyMS4zIDNNOSA2SDEyVjExSDlWNk0yMCAxNEg5VjEySDIwVjE0TTIwIDhIMTRWNkgyMFY4TTIwIDExSDE0VjlIMjBWMTFaIi8+PC9zdmc+',
      'menu_position'      => null,
      'show_in_rest'       => true, // enable Gutenberg editor
      'supports'           => array(
        'title',
        'editor',
        'thumbnail',
        // 'excerpt',
        // 'page-attributes',
      ),
      'taxonomies'         => [ MY_TAX_NEWS_TAG ],
    ]);
  }

}
