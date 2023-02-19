<?php

class ACF_CONSTRUCTOR_PRODUCTS extends ACF_CONSTRUCTOR {
  // use in acf_add_local_field_group() 
  public $acf_group_key = 'acfconst_' . 'products' . '_group_key';

  public $active_acf_1;
  public $active_acf_1_title = 'Настройка карточки продукта';

  public $location;

  public $acf;

  public $excluded_fields;

  public $unique_id_prefix = 'products';

  /**
   * @param Array $args
   *    @param Array $args['location'] - where to print this ACF
   *    @param Array $args['exclude_fields'] - array of field names that you want to exclude
   */
  public function __construct( $args=[] ) {
    // require  __ACf_CONSTUCTOR_ABSPATH__ . "/classes/functions/products.php";

    /* LOCATION */
    if (array_key_exists('location', $args)) {
      $this->location = $args['location'];
    }
    else {
      $this->location = [
        array(
          [
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'product',
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
      $this->acf_group([
        'id' => $this->id( 100 ),
        'name' => 'card',
        'label' => 'Карточка товара',
        'sub_fields' => [
          $this->acf_number([
            'id' => $this->id( 100, 100 ),
            'name' => 'post_order',
            'label' => 'Порядок карточки',
            'wrapper' => [ 'width' => 20 ],
          ]),
          $this->acf_image([
            'id' => $this->id( 100, 200 ),
            'name' => 'card_avatar',
            'label' => 'Аватар карточки',
            'wrapper' => [ 'width' => 40 ],
            'preview_size' => 'thumbnail',
          ]),
          $this->acf_text([
            'id' => $this->id( 100, 300 ),
            'name' => 'h2',
            'label' => 'Малый заголовок',
            'wrapper' => [ 'width' => 40 ],
          ]),
          $this->acf_text([
            'id' => $this->id( 100, 400 ),
            'name' => 'h1',
            'label' => 'Большой заголовок',
            'wrapper' => [ 'width' => 40 ],
          ]),
          $this->acf_wysiwyg_editor([
            'id' => $this->id( 100, 500 ),
            'name' => 'top_description',
            'label' => 'Верхнее описание',
            'wrapper' => [ 'width' => 100 ],
          ]),
          $this->acf_image([
            'id' => $this->id( 100, 550 ),
            'name' => 'extra_img',
            'label' => 'Доп. изображение',
            'wrapper' => [ 'width' => 50 ],
            'preview_size' => 'medium',
          ]),
          $this->acf_wysiwyg_editor([
            'id' => $this->id( 100, 600 ),
            'name' => 'bottom_description',
            'label' => 'Нижнее описание',
            'wrapper' => [ 'width' => 100 ],
          ]),
        ],
      ]),
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
  
} // class ACF_CONSTRUCTOR_PRODUCTS