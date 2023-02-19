<?php

class MY_ACF_PAGE_OF_MASTER_CLASSES extends MY_ACF {
  // use in acf_add_local_field_group() 
  public $acf_group_key = 'acfconst_' . 'page_of_master_classes' . '_group_key';

  public $active_acf_1;
  public $active_acf_1_title = 'Общее';

  public $active_acf_2;
  public $active_acf_2_title = 'Отзывы';

  public $active_acf_3;
  public $active_acf_3_title = 'Форма обратной связи';

  public $active_acf_4;
  public $active_acf_4_title = 'Остальное';

  public $location;

  public $acf;

  public $excluded_fields;

  public $unique_id_prefix = 'page_of_master_classes';

  public function __construct() {
    $lang_codes = pll_languages_list(); // [ru, en, ...]
    $post_id = get_option( '__page_of_master_classes_id__' );
    $location = [];

    foreach ($lang_codes as $lang_code) {
      $location[] = [
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
    $this->active_acf_1 = [
      $this->my_acf_bgr_viedo_section([
        'id' => $this->id( 'aa1', 100 ),
        'name' => 'hs_video_block',
        'label' => 'Первый блок с видео',
      ]),
    ]; // $this->active_acf_1


    $this->active_acf_2 = [
      $this->acf_text([
        'id' => $this->id( 'aa2', 50 ),
        'name' => 'feedback_section_title',
        'label' =>'Заголовк секции "Отзывы"',
        'default_value' => 'Отзывы',
      ]),
      $this->my_acf_feedbacks([
        'id' => $this->id( 'aa2', 100 ),
        'name' => 'feedbacks',
      ]),
    ]; // $this->active_acf_2


    $this->active_acf_3 = $this->acf_post_form([
      'id' => 'aa3',
      'form_post_type' => MY_CPT_SITE_FORM,
    ]); // active_acf_3


    $this->active_acf_4 = [
      $this->acf_text([
        'id' => $this->id( 'aa4', 100 ),
        'name' => 'master_class_section_title',
        'label' => 'Название секции "Мастер-классы"',
        'wrapper' => [ 'width' => 50 ],
        'default_value' => 'Мастер-классы',
      ]),
      $this->acf_text([
        'id' => $this->id( 'aa4', 200 ),
        'name' => 'past_master_class_section_title',
        'label' => 'Название секции "Прошедшие мастер-классы"',
        'wrapper' => [ 'width' => 50 ],
        'default_value' => 'Прошедшие мастер-классы',
      ]),
    ]; // $this->active_acf_4

  }


  public function acf_init() {
    if( function_exists('acf_add_local_field_group') ) {
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
      $this->register_acf_group([
        'title' => $this->active_acf_3_title,
        'group_key' => $this->acf_group_key . '_aa3',
        'fields' => $this->active_acf_3,
        'location' => $this->location,
      ]);
      $this->register_acf_group([
        'title' => $this->active_acf_4_title,
        'group_key' => $this->acf_group_key . '_aa4',
        'fields' => $this->active_acf_4,
        'location' => $this->location,
      ]);
    };
  }
  
} // class:end