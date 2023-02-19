<?php

class MY_ACF_MY__HEADER_MENU extends MY_ACF {
  // use in acf_add_local_field_group() 
  public $acf_group_key = 'acfconst_' . 'my__header_menu' . '_group_key';

  public $active_acf_0;
  public $active_acf_0_title = 'Свойства меню';

  public $location;

  public $acf;

  public $excluded_fields;

  public $unique_id_prefix = 'my__header_menu';

  public function __construct( $args=[] ) {
    $lang_codes = pll_languages_list(); // [ru, en, ...]
    $menu_name = "my__header_menu";
    $location = [];

    foreach ($lang_codes as $index => $lang_code) {
      $polylang_options = get_option( 'polylang' );
      $menu_id = $polylang_options['nav_menus'][ 'custom-theme' ][ $menu_name ][ $lang_code ];

      $location[] = [
        [
          'param' => 'nav_menu',
          'operator' => '==',
          'value' => $menu_id,
        ],
      ];
    }

    $this->location = $location;
  }


  public function register() {
    $this->acf = (object) [];
    $this->register_acf();
    add_action( 'acf/init', [$this, 'acf_init'] );
  }


  public function register_acf() {
    $this->active_acf_0 = [
      $this->acf_text([
        'id' => $this->id( 'aa0', 100 ),
        'name' => 'display_menu_from',
        'label' => 'Размер',
        'type' => 'number',
        'wrapper' => [ 'width' => 0 ],
      ]),

    ]; // $this->active_acf_0
  }


  public function acf_init() {
    if( function_exists('acf_add_local_field_group') ) {
      $this->register_acf_group([
        'title' => $this->active_acf_0_title,
        'group_key' => $this->acf_group_key . '_aa0',
        'fields' => $this->active_acf_0,
        'location' => $this->location,
      ]);
    };
  }
  
} // class:end