<?php

class MY_ACF_NEWS extends MY_ACF {
  // use in acf_add_local_field_group() 
  public $acf_group_key = 'acfconst_' . MY_CPT_NEWS . '_group_key';

  public $active_acf_0;
  public $active_acf_0_title = 'Карточка поста';

  public $active_acf_1;
  public $active_acf_1_title = 'Информации страницы';

  public $location;

  public $acf;

  public $excluded_fields;

  public $unique_id_prefix = MY_CPT_NEWS;

  /**
   * @param Array $args
   *    @param Array $args['location'] - where to print this ACF
   *    @param Array $args['exclude_fields'] - array of field names that you want to exclude
   */
  public function __construct( $args=[] ) {
    $this->location = [
      [
        [
          'param' => 'post_type',
          'operator' => '==',
          'value' => MY_CPT_NEWS,
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
      $this->acf_group([
        'id' => $this->id( 'aa0', 100 ),
        'name' => 'card',
        'label' => 'Карточка товара',
        'layout' => 'block',
        'sub_fields' => [
          // Horisontal
          $this->acf_image([
            'id' => $this->id( 'aa0', 100, 100 ),
            'name' => 'avatar',
            'label' => 'Аватарка карточки горизонтальная (2:3)',
            'preview_size' => 'medium',
            'wrapper' => [ 'width' => 25 ],
          ]),
          $this->acf_true_false([
            'id' => $this->id( 'aa0', 100, 105 ),
            'name' => 'avatar_size_conatin',
            'label' => '',
            'message' => 'Вписать горизонтальную аватарку в рамку',
            'default_value' => false,
            'wrapper' => [ 'width' => 25 ],
          ]),
          // Vertical
          $this->acf_image([
            'id' => $this->id( 'aa0', 100, 120 ),
            'name' => 'vertical_avatar',
            'label' => 'Аватарка карточки вертикальная (3:4)',
            'preview_size' => 'medium',
            'wrapper' => [ 'width' => 25 ],
          ]),
          $this->acf_true_false([
            'id' => $this->id( 'aa0', 100, 125 ),
            'name' => 'vertical_avatar_size_conatin',
            'label' => '',
            'message' => 'Вписать вертиальную аватарку в рамку',
            'default_value' => false,
            'wrapper' => [ 'width' => 25 ],
          ]),
          
          $this->acf_text([
            'id' => $this->id( 'aa0', 100, 200 ),
            'name' => 'avatar_alt',
            'label' => 'alt-текст',
            'instructions' => '(если не подходит alt изображения)',
            'wrapper' => [ 'width' => 25 ],
          ]),
          $this->acf_textarea([
            'id' => $this->id( 'aa0', 100, 300 ),
            'name' => 'description',
            'label' => 'Краткое описание',
            'wrapper' => [ 'width' => 50 ],
          ]),
          $this->acf_text([
            'id' => $this->id( 'aa0', 100, 400 ),
            'name' => 'city',
            'label' => 'Город',
            'wrapper' => [ 'width' => 25 ],
          ]),
        ], // sub_fields
      ]), // $this->acf_group
      // description
    ]; // $this->active_acf_0



    $this->active_acf_1 = [
      $this->acf_image([
        'id' => $this->id( 'aa1', 100, 100 ),
        'name' => 'hs_bgr_img',
        'label' => 'Фоновое изображение новости (главная секция)',
        'preview_size' => 'medium',
        'wrapper' => [ 'width' => 50 ],
      ]),
    ]; // $this->active_acf_1

  }


  public function acf_init() {
    if( function_exists('acf_add_local_field_group') ) {
      $this->register_acf_group([
        'title' => $this->active_acf_0_title,
        'group_key' => $this->acf_group_key . '_aa0',
        'fields' => $this->active_acf_0,
        'location' => $this->location,
      ]);
      $this->register_acf_group([
        'title' => $this->active_acf_1_title,
        'group_key' => $this->acf_group_key . '_aa1',
        'fields' => $this->active_acf_1,
        'location' => $this->location,
      ]);
    };
  }
  
} // class:end