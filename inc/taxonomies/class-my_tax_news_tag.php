<?php

class MY_TAXONOMY_NEWS_TAG {

  public function register() {
    add_action( 'init', [$this, 'taxonomy_init'] );
  }
  
  public function taxonomy_init(){
    /* tags */
    register_taxonomy( MY_TAX_NEWS_TAG, [ MY_CPT_NEWS ], [ 
      'label' => '', // определяется параметром $labels->name
      'labels' => [
        'name'              => 'Теги',
        'singular_name'     => 'Тег',
        'search_items'      => 'Искать тег',
        'all_items'         => 'Все теги',
        'view_item '        => 'Смотреть тег',
        'parent_item'       => 'Родительский тег',
        'parent_item_colon' => 'Родительский тег',
        'edit_item'         => 'Ред. тег',
        'update_item'       => 'Обновить тег',
        'add_new_item'      => 'Добавить тег',
        'new_item_name'     => 'Новый тег',
        'menu_name'         => 'Теги',
      ],
      'hierarchical'          => true, // true makes checkbox select
      'rewrite'               => true,
      'query_var'             => true,
      // 'meta_box_cb'           => 'post_categories_meta_box', // html метабокса. callback: `post_categories_meta_box` или `post_tags_meta_box`. false — метабокс отключен.
      'show_admin_column'     => true, // показывать таксономию в списке постов
      'show_in_rest'          => true, // добавить в REST API && show in side-menu
    ]);

    /* base tag terms */
    // // news
    // if (!term_exists( 'novelty')) {
    //   wp_insert_term( 'Новинки', MY_TAX_NEWS_TAG, [ 'slug' => 'novelty' ]);
    // }
    // if (!term_exists( 'Tech_advice')) {
    //   wp_insert_term( 'Советы технолога', MY_TAX_NEWS_TAG, [ 'slug' => 'Tech_advice' ]);
    // }

    // // events
    // if (!term_exists( 'announcement')) {
    //   wp_insert_term( 'Анонсы', MY_TAX_NEWS_TAG, [ 'slug' => 'announcement' ]);
    // }
    // if (!term_exists( 'past_event')) {
    //   wp_insert_term( 'Прошедшие мероприятия', MY_TAX_NEWS_TAG, [ 'slug' => 'past_event' ]);
    // }
    // if (!term_exists( 'bakery_project')) {
    //   wp_insert_term( 'Проект "Пекарня"', MY_TAX_NEWS_TAG, [ 'slug' => 'bakery_project' ]);
    // }
  }
}