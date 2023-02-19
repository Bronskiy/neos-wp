<?php

class MY_CPT_JOB_VACANCY {

  public function register() {
    add_action( 'init', [$this, 'cpt_init'] );
  }

  
  public function cpt_init(){
    register_post_type( MY_CPT_JOB_VACANCY, [
      'labels' => [
        'name'               => 'Вакансии',
        'singular_name'      => 'Вакансия',
        'add_new'            => 'Добавить вакансию',
        'add_new_item'       => 'Добавить вакансию',
        'edit_item'          => 'Ред. вакансию',
        'new_item'           => 'Новая вакансия',
        'view_item'          => 'Смотреть вакансию',
        'search_items'       => 'Искать вакансию',
        'not_found'          => 'Не найдено',
        'not_found_in_trash' => 'Корзина пуста',
        'parent_item_colon'  => '',
        'menu_name'          => '~Вакансии',
      ],
      'public'             => true,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'show_in_nav_menus'  => true,
      // 'show_in_menu'       => ST_PLUGIN_MENU_PAGE_SLUG_1,
      // 'rewrite'            => ['slug' => 'services','with_front' => FALSE],
      'has_archive'        => false,
      'hierarchical'       => false,
      'menu_icon'          => 'dashicons-id',
      'menu_position'      => null,
      'show_in_rest'       => true, // enable Gutenberg editor
      'supports'           => array('title', 'editor'),
    ]);
  }

}
