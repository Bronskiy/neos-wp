<?php

class MY_ACF_PRODUCT_INDUSTRY_TYPE_PAGE extends MY_ACF {
  // use in acf_add_local_field_group() 
  public $acf_group_key = 'acfconst_' . MY_CPT_PRODUCT_INDUSTRY_TYPE_PAGE . '_group_key';

  public $active_acf_0;
  public $active_acf_0_title = 'Настройка';

  public $location;

  public $acf;

  public $excluded_fields;

  public $unique_id_prefix = MY_CPT_PRODUCT_INDUSTRY_TYPE_PAGE;

  public function __construct( $args=[] ) {
    $this->location = array(
      array(
        array(
          'param' => 'post_type',
          'operator' => '==',
          'value' => MY_CPT_PRODUCT_INDUSTRY_TYPE_PAGE,
        ),
      ),
    );
  }


  public function register() {
    $this->acf = (object) [];
    $this->register_acf();
    add_action( 'acf/init', [$this, 'acf_init'] );
  }


  public function register_acf() {
    $this->active_acf_0 = [
      $this->acf_taxonomy([
        'id' => $this->id( 'aa0', 100 ),
        'name' => 'attached_product_industry_type_id',
        'label' => 'Привязанная тип отрасли',
        'required' => true,
        'taxonomy' => MY_TAX_PRODUCT_INDUSTRY_TYPE,
        'field_type' => 'radio',
      ]),
      $this->my_acf_infographics([
        'id' => $this->id( 'aa0', 200 ),
        'name' => 'infographics',
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