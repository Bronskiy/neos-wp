<?php

class ACF_CONSTRUCTOR_FRONT_PAGE extends ACF_CONSTRUCTOR {
  // use in acf_add_local_field_group() 
  public $acf_group_key = 'acfconst_' . 'fp' . '_group_key';

  public $active_acf_1;
  public $active_acf_1_title = 'Настройка главной страницы';

  public $location;

  public $acf;

  public $excluded_fields;

  public $unique_id_prefix = 'fp';

  /**
   * @param Array $args
   *    @param Array $args['location'] - where to print this ACF
   *    @param Array $args['exclude_fields'] - array of field names that you want to exclude
   */
  public function __construct( $args=[] ) {
    // require  __ACf_CONSTUCTOR_ABSPATH__ . "/classes/functions/front-page.php";

    /* LOCATION */
    if (array_key_exists('location', $args)) {
      $this->location = $args['location'];
    }
    else {
      $this->location = [
        array(
          [
            'param' => 'page',
            'operator' => '==',
            'value' => get_option( 'page_on_front' ),
          ],
        ),
      ];
    }

    /* FIELDS */
    if (array_key_exists('exclude_fields', $args)) {
      $this->excluded_fields = $args['exclude_fields'];
    }
    else $this->excluded_fields = [];
  }


  public function register() {
    $this->acf = (object) [];
    $this->register_acf();
    add_action( 'acf/init', [$this, 'acf_init'] );
  }


  public function register_acf() {
    $this->active_acf_1 = [

      in_array('hero-section', $this->excluded_fields)? [] : $this->acf_group([
        'id' => $this->id( 100 ),
        'name' => 'hero_section',
        'label' => 'HERO-SECTION',
        'sub_fields' => [
          $this->acf_image([
            'id' => $this->id( 100, 100 ),
            'name' => 'main_img',
            'label' => 'Основное изображение',
          ])
        ],
      ]), // acf_group

    ]; // $this->active_acf_1
  }


  public function acf_init() {
    if( function_exists('acf_add_local_field_group') ) {
      $this->register_acf_group([
        'title' => $this->active_acf_1_title,
        'group_key' => $this->acf_group_key,
        'fields' => $this->active_acf_1,
        'location' => $this->location,
      ]);
    };
  }
  
} // class ACF_CONSTRUCTOR_FRONT_PAGE