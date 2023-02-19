<?php

class MY_ACF_PODUCT_PROPERTY extends MY_ACF {
  // use in acf_add_local_field_group() 
  public $acf_group_key = 'acfconst_' . MY_CPT_PRODUCT_PROPERTY . '_group_key';

  public $active_acf_0;
  public $active_acf_0_title = 'Настройка характеристики';

  // public $active_acf_1;
  // public $active_acf_1_title = 'Настройка';

  public $location;

  public $acf;

  public $excluded_fields;

  public $unique_id_prefix = MY_CPT_PRODUCT_PROPERTY;

  public function __construct( $args=[] ) {
    $this->location = [
      [
        [
          'param' => 'post_type',
          'operator' => '==',
          'value' => MY_CPT_PRODUCT_PROPERTY,
        ]
      ]
    ];
  }


  public function register() {
    $this->acf = (object) [];
    $this->register_acf();
    add_action( 'acf/init', [$this, 'acf_init'] );
  }


  public function register_acf() {
    $this->active_acf_0 = [
      $this->acf_textarea([
        'id' => $this->id( 'aa0', 100 ),
        'name' => 'svg_icon',
        'label' => 'SVG код иконки',
        'instructions' => '<a href="https://petershaggynoble.github.io/MDI-Sandbox/" target="_blank">Библиотека SVG иконок</a>',
        'default_value' => '',
        'rows' => 3,
        'new_lines' => '',
      ]),
      // $this->acf_RGBA_color_picker([
      //   'id' => $this->id( 'aa0', 200 ),
      //   'name' => 'icon_color',
      //   'label' => 'Цвет иконки',
      // ]),
    ]; // $this->active_acf_0



    // $this->active_acf_1 = [
    // ]; // $this->active_acf_1

  }


  public function acf_init() {
    if( function_exists('acf_add_local_field_group') ) {
      $this->register_acf_group([
        'title' => $this->active_acf_0_title,
        'group_key' => $this->acf_group_key . '_aa0',
        'fields' => $this->active_acf_0,
        'location' => $this->location,
      ]);
      // $this->register_acf_group([
      //   'title' => $this->active_acf_1_title,
      //   'group_key' => $this->acf_group_key . '_aa1',
      //   'fields' => $this->active_acf_1,
      //   'location' => $this->location,
      // ]);
    };
  }
  
} // class:end