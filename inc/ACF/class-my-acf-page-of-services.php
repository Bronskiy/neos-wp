<?php

class MY_ACF_PAGE_OF_SERVICES extends MY_ACF {
  // use in acf_add_local_field_group() 
  public $acf_group_key = 'acfconst_' . 'page_of_services' . '_group_key';

  public $active_acf_1;
  public $active_acf_1_title = 'Прмяая речь';

  public $active_acf_2;
  public $active_acf_2_title = 'Консультанты';

  public $active_acf_3;
  public $active_acf_3_title = 'Форма обратной связи';

  public $active_acf_4;
  public $active_acf_4_title = 'Описание услуг';

  public $active_acf_5;
  public $active_acf_5_title = 'Стоимость';

  public $active_acf_6;
  public $active_acf_6_title = 'Остальное';

  public $location;

  public $acf;

  public $excluded_fields;

  public $unique_id_prefix = 'page_of_services';

  public function __construct( $args=[] ) {
    $lang_codes = pll_languages_list(); // [ru, en, ...]
    $post_id = get_option( '__page_of_services_id__' );
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
        'id' => $this->id( 'aa1', 200 ),
        'name' => 'hs_direct_speech',
        'label' => 'Прямая речь',
        'sub_fields' => [
          $this->acf_image([
            'id' => $this->id( 'aa1', 200, 100 ),
            'name' => 'avatar',
            'label' => 'Аватарка',
            'wrapper' => [ 'width' => 20 ],
            'preview_size' => 'thumbnail',
          ]),
          $this->acf_wysiwyg_editor([
            'id' => $this->id( 'aa1', 200, 200 ),
            'name' => 'direct_speech',
            'label' => 'Речь',
            'wrapper' => [ 'width' => 80 ],
          ]),
          $this->acf_textarea([
            'id' => $this->id( 'aa1', 200, 300 ),
            'name' => 'signature',
            'label' =>'Подпись',
            'wrapper' => [ 'width' => 100 ],
            'rows' => 2,
          ]),
        ],
      ]),
    ]; // $this->active_acf_1



    $this->active_acf_2 = [
      $this->acf_text([
        'id' => $this->id( 'aa2', 50 ),
        'name' => 'consultant_section_title',
        'label' =>'Заголовк секции "Консультанты"',
        'default_value' => 'Консультанты',
      ]),
      $this->my_acf_feedbacks([
        'id' => $this->id( 'aa2', 100 ),
        'name' => 'consultants',
      ]),
    ]; // $this->active_acf_2



    $this->active_acf_3 = array_merge(
      [
        $this->acf_wysiwyg_editor([
          'id' => $this->id( 'aa3', 100 ),
          'label' => 'Текст перед формой',
          'name' => 'bottom_form_cta',
        ])
      ],
      $this->acf_post_form([
        'id' => $this->id( 'aa3', 200 ),
        'form_post_type' => MY_CPT_SITE_FORM,
      ])
    ); // active_acf_3



    $this->active_acf_4 = [
      // $this->acf_text([
      //   'id' => $this->id( 'aa4', 50 ),
      //   'name' => 'title_of_description_of_services',
      //   'label' => 'Заголовок блока "Программа"',
      //   'wrapper' => [ 'width' => 50 ],
      //   'default_value' => 'Программа',
      // ]),
      $this->acf_repeater([
        'id' => $this->id( 'aa4', 100 ),
        'name' => 'description_of_services',
        'label' => 'Описание услуг',
        'layout' => 'block',
        'sub_fields' => [
          $this->acf_text([
            'id' => $this->id( 'aa4', 100, 100 ),
            'name' => 'topic_title',
            'label' => 'Тема',
            'wrapper' => [ 'width' => 100 ],
          ]),
          $this->acf_wysiwyg_editor([
            'id' => $this->id( 'aa4', 100, 200 ),
            'name' => 'description',
            'label' => 'Описание',
            'wrapper' => [ 'width' => 100 ],
          ]),
        ], // sub_fields
      ]), // $this->acf_repeater
    ]; // $this->active_acf_4


    $this->active_acf_5 = [
      $this->acf_text([
        'id' => $this->id( 'aa5', 100 ),
        'name' => 'price_section_title',
        'label' => 'Заголовок блока "Стоимость"',
        'wrapper' => [ 'width' => 50 ],
        'default_value' => 'Стоиомость',
      ]),
      $this->acf_textarea([
        'id' => $this->id( 'aa5', 150 ),
        'name' => 'price_card_form_cta',
        'label' => 'Призыв к действию форм карточек с ценой',
        'wrapper' => [ 'width' => 50 ],
        'rows' => 4,
      ]),
      $this->acf_event_js_code([
        'id' => $this->id( 'aa5', 175 ),
        'name' => 'open_form_btn_onclick_js_code',
        'label' => 'js, выполняющийся при клике на раскрытия формы',
        'wrapper' => [ 'width' => 50 ],
      ]),
      $this->my_acf_prcie_cards([
        'id' => $this->id( 'aa5', 200 ),
        'name' => 'prices',
        'label' => 'Цена',
      ]),
    ]; // $this->active_acf_5



    $this->active_acf_6 = [
      $this->my_acf_hero_section([
        'id' => $this->id( 'aa6', 50 ),
        'name' => 'hero_section',
      ]),
      $this->acf_text([
        'id' => $this->id( 'aa6', 100 ),
        'name' => 'completed_projects_section_title',
        'label' =>'Заголовк секции "Реализованные проекты"',
        'default_value' => 'Реализованные проекты',
      ]),
    ]; // $this->active_acf_6
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
      $this->register_acf_group([
        'title' => $this->active_acf_5_title,
        'group_key' => $this->acf_group_key . '_aa5',
        'fields' => $this->active_acf_5,
        'location' => $this->location,
      ]);
      $this->register_acf_group([
        'title' => $this->active_acf_6_title,
        'group_key' => $this->acf_group_key . '_aa6',
        'fields' => $this->active_acf_6,
        'location' => $this->location,
      ]);
    };
  }
  
} // class:end