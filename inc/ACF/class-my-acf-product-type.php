<?php

class MY_ACF_PRODUCT_TYPE extends MY_ACF {
  // use in acf_add_local_field_group() 
  public $acf_group_key = 'acfconst_' . MY_TAX_PRODUCT_TYPE . '_group_key';

  public $active_acf_0;
  public $active_acf_0_title = 'Доп. информация';

  public $location;

  public $acf;

  public $excluded_fields;

  public $unique_id_prefix = MY_TAX_PRODUCT_TYPE;

  public function __construct( $args=[] ) {
    $this->location = array(
      array(
        array(
          'param' => 'taxonomy',
          'operator' => '==',
          'value' => MY_TAX_PRODUCT_TYPE,
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
      $this->acf_image([
        'id' => $this->id( 'aa0', 100 ),
        'name' => 'category_avatar',
        'label' => 'Аватарка категории',
        'wrapper' => [ 'width' => 50 ],
        'preview_size' => 'medium',
      ]),
      $this->acf_text([
        'id' => $this->id( 'aa0', 200 ),
        'name' => 'order',
        'label' => 'Порядок категорий',
        'type' => 'number',
        'default_value' => 99999,
        'wrapper' => [ 'width' => 50 ],
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