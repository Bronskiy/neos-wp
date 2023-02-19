<?php

class MY_ACF_AD extends MY_ACF {
  // use in acf_add_local_field_group() 
  public $acf_group_key = 'acfconst_' . 'ad' . '_group_key';

  public $active_acf_0;
  public $active_acf_0_title = 'Реклама';

  public $active_acf_1;
  public $active_acf_1_title = 'Изображение (банер)';

  public $active_acf_2;
  public $active_acf_2_title = 'Форма обратной связи';

  public $location;

  public $acf;

  public $excluded_fields;

  public $unique_id_prefix = 'ad';

  public function __construct() {
    $this->location = [
      [
        [
          'param' => 'post_type',
          'operator' => '==',
          'value' => MY_CPT_AD,
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
      $this->acf_true_false([
        'id' => $this->id( 'aa0', 50 ),
        'name' => 'use_ad',
        'label' => 'Статус рекламы',
        'default_value' => 1,
        'message' => 'Активна',
        'wrapper' => [ 'width' => 50 ],
      ]),
      $this->acf_text([
        'id' => $this->id( 'aa0', 200 ),
        'name' => 'cookie_name',
        'label' => 'Название куки',
        'instructions' => 'Чтобы реклама снова у всех появилась до истечения срока след. показа. Нужно изменить куку. (одно слово)',
        'default_value' => '1stAd',
        'wrapper' => [ 'width' => 50 ],
      ]),
      $this->acf_text([
        'id' => $this->id( 'aa0', 300 ),
        'name' => 'delay',
        'type' => 'number',
        'label' => 'Задержка',
        'instructions' => 'Через какое время после загрузки страницы откроется реклама (мс)',
        'default_value' => 850,
        'wrapper' => [ 'width' => 50 ],
      ]),
      $this->acf_text([
        'id' => $this->id( 'aa0', 400 ),
        'name' => 'expire',
        'type' => 'number',
        'label' => 'Периодичность показа',
        'instructions' => 'Через какое время после просмотра рекламы она появится снова (дни)',
        'default_value' => 30,
        'wrapper' => [ 'width' => 50 ],
      ]),
      $this->acf_text([
        'id' => $this->id( 'aa0', 500 ),
        'name' => 'max_width',
        'type' => 'number',
        'label' => 'Максимальная ширина окна рекламы (px)',
        'default_value' => 744,
        'wrapper' => [ 'width' => 50 ],
      ]),
    ]; // $this->active_acf_0


    $this->active_acf_1 = [
      $this->acf_group([
        'id' => $this->id( 'aa1', 100 ),
        'name' => 'banner',
        'label' => 'Изображение (Банер)',
        'sub_fields' => [
          // см. inc/ACF/class-my-acf-page-of-vacancies.php
          $this->acf_image([
            'id' => $this->id( 'aa1', 100, 100 ),
            'name' => 'main',
            'label' => 'Изображение',
            'wrapper' => [ 'width' => 50 ],
            'preview_size' => 'w640',
          ]),
        ],
      ]),
    ]; // $this->active_acf_1



    $this->active_acf_2 = $this->acf_post_form([
      'id' => 'aa2',
      'form_post_type' => MY_CPT_SITE_FORM,
    ]); // active_acf_3
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
      $this->register_acf_group([
        'title' => $this->active_acf_2_title,
        'group_key' => $this->acf_group_key . '_aa2',
        'fields' => $this->active_acf_2,
        'location' => $this->location,
      ]);
    };
  }
  
} // class:end