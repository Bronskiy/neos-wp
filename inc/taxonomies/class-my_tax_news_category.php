<?php

class MY_TAXONOMY_NEWS_CATEGORY {

  public function register() {
    add_action( 'init', [$this, 'taxonomy_init'] );
  }
  
  public function taxonomy_init(){
    /* categories */
    register_taxonomy( MY_TAX_NEWS_CATEGORY, [ MY_CPT_NEWS ], [ 
      'label' => '', // определяется параметром $labels->name
      'labels' => [
        'name'              => 'Категории',
        'singular_name'     => 'Категория',
        'search_items'      => 'Искать категорию',
        'all_items'         => 'Все категории',
        'view_item '        => 'Смотреть категорию',
        'parent_item'       => 'Родительская категория',
        'parent_item_colon' => 'Родительская категория',
        'edit_item'         => 'Ред. категорию',
        'update_item'       => 'Обновить категорию',
        'add_new_item'      => 'Добавить категорию',
        'new_item_name'     => 'Новая категория',
        'menu_name'         => 'Категории',
      ],
      'has_archive'           => true,
      'hierarchical'          => true, // true makes checkbox select
      'rewrite'               => ['slug' => 'news-сategory'],
      'query_var'             => true,
      // 'meta_box_cb'           => 'post_categories_meta_box', // html метабокса. callback: `post_categories_meta_box` или `post_tags_meta_box`. false — метабокс отключен.
      'show_admin_column'     => true, // показывать таксономию в списке постов
      'show_in_rest'          => true, // добавить в REST API && show in side-menu
    ]);

    /* base category terms */
    // if (!term_exists( 'event')) {
    //   wp_insert_term( 'Мероприятия', MY_TAX_NEWS_CATEGORY, [ 'slug' => 'event' ]);
    // }
    // if (!term_exists( 'news')) {
    //   wp_insert_term( 'Новости', MY_TAX_NEWS_CATEGORY, [ 'slug' => 'news' ]);
    // }
    // if (!term_exists( 'recipe')) {
    //   wp_insert_term( 'Рецептуры', MY_TAX_NEWS_CATEGORY, [ 'slug' => 'recipe' ]);
    // }
  }
}