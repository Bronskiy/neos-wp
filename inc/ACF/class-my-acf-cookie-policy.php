<?php

class MY_ACF_COOKIE_POLICY extends MY_ACF {
  // use in acf_add_local_field_group() 
  public $acf_group_key = 'acfconst_' . 'cookie_policy' . '_group_key';

  public $active_acf_0;
  public $active_acf_0_title = 'Настройка';

  public $location;

  public $acf;

  public $excluded_fields;

  public $unique_id_prefix = 'cookie_policy';

  /**
   * @param Array $args
   *    @param Array $args['location'] - where to print this ACF
   *    @param Array $args['exclude_fields'] - array of field names that you want to exclude
   */
  public function __construct( $args=[] ) {
    $lang_codes = pll_languages_list(); // [ru, en, ...]
    $post_id = get_option( '__cookie_policy_post_id__' );
    $location = [];

    foreach ($lang_codes as $index => $lang_code) {
      $location[] = [
        [
          'param' => 'post_type',
          'operator' => '==',
          'value' => MY_CPT_SETTINGS,
        ],
        [
          'param' => 'page',
          'operator' => '==',
          'value' => pll_get_post($post_id, $lang_code),
        ]
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
      $this->acf_group([
        'id' => $this->id( 'aa0', 100 ),
        'name' => 'cookie_usage_confirmation_dialog',
        'label' => 'Окно подтверждения использования cookie',
        'sub_fields' => [
          $this->acf_wysiwyg_editor([
            'id' => $this->id( 'aa0', 100, 200 ),
            'name' => 'text',
            'label' => 'Текст',
            'wrapper' => [ 'width' => 100 ],
          ]),
        ],
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