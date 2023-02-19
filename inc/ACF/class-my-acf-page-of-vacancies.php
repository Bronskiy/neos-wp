<?php

class MY_ACF_PAGE_OF_VACANCIES extends MY_ACF {
  // use in acf_add_local_field_group() 
  public $acf_group_key = 'acfconst_' . 'page_of_vacancies' . '_group_key';

  public $active_acf_1;
  public $active_acf_1_title = 'Настройки';

  public $active_acf_2;
  public $active_acf_2_title = 'Форма обратной связи';

  public $location;

  public $acf;

  public $excluded_fields;

  public $unique_id_prefix = 'page_of_vacancies';

  public function __construct() {
    $lang_codes = pll_languages_list(); // [ru, en, ...]
    $post_id = get_option( '__vacancies_post_id__' );
    $location = [];

    foreach ($lang_codes as $index => $lang_code) {
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
      $this->acf_group([
        'id' => $this->id( 'aa1', 100 ),
        'name' => 'our_team',
        'label' => 'Наша команда',
        'sub_fields' => [
          $this->acf_image([
            'id' => $this->id( 'aa1', 100, 100 ),
            'name' => 'photo_0_400',
            'label' => 'Фото команды (экран: 0px - 400px)',
            'wrapper' => [ 'width' => 16.6 ],
            'preview_size' => 'w240',
          ]),
          $this->acf_image([
            'id' => $this->id( 'aa1', 100, 200 ),
            'name' => 'photo_400_576',
            'label' => 'Фото команды (экран: 400px - 576px)',
            'wrapper' => [ 'width' => 16.6 ],
            'preview_size' => 'w240',
          ]),
          $this->acf_image([
            'id' => $this->id( 'aa1', 100, 300 ),
            'name' => 'photo_576_768',
            'label' => 'Фото команды (экран: 576px - 768px)',
            'wrapper' => [ 'width' => 16.6 ],
            'preview_size' => 'w240',
          ]),
          $this->acf_image([
            'id' => $this->id( 'aa1', 100, 400 ),
            'name' => 'photo_768_960',
            'label' => 'Фото команды (экран: 768px - 960px)',
            'wrapper' => [ 'width' => 16.6 ],
            'preview_size' => 'w240',
          ]),
          $this->acf_image([
            'id' => $this->id( 'aa1', 100, 500 ),
            'name' => 'photo_960_1140',
            'label' => 'Фото команды (экран: 960px - 1140px)',
            'wrapper' => [ 'width' => 16.6 ],
            'preview_size' => 'w240',
          ]),
          $this->acf_image([
            'id' => $this->id( 'aa1', 100, 600 ),
            'name' => 'photo_from_1140',
            'label' => 'Фото команды (экран: 1140px - ...px)',
            'wrapper' => [ 'width' => 16.6 ],
            'preview_size' => 'w240',
          ]),
        ],
      ]),
    ]; // $this->active_acf_1


    $this->active_acf_2 = $this->acf_post_form([
      'id' => 'aa2',
      'form_post_type' => MY_CPT_SITE_FORM,
    ]); // active_acf_2
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
    };
  }
  
} // class:end