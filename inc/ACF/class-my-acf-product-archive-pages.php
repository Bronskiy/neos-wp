<?php

class MY_ACF_PRODUCT_ARCHIVE_PAGES extends MY_ACF {
  public $acf_group_key = 'acfconst_' . 'product_archive_pages' . '_group_key';

  public $active_acf_0;
  public $active_acf_0_title = 'Настройки страницы';

  public $location;

  public $acf;

  public $excluded_fields;

  public $unique_id_prefix = 'product_archive_pages';

  public function __construct() {
    $lang_codes = pll_languages_list(); // [ru, en, ...]
    $post_id = get_option( '__product_archive_pages__settings_id__' );
    $location = [];

    foreach ($lang_codes as $index => $lang_code) {
      $location[] = [
        [
          'param' => 'post_type',
          'operator' => '==',
          'value' => MY_CPT_PRODUCT_ARCHIVE_AND_PAGE_SETTINGS,
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
        'name' => 'upload_docs_btn',
        'label' => 'Кнопка "Загрузить документы"',
        'layout' => 'block',
        'sub_fields' => [
          $this->acf_text([
            'id' => $this->id( 'aa0', 100, 100 ),
            'name' => 'text',
            'label' => 'Текст',
            'default_value' => 'Загрузить документы',
            'wrapper' => [ 'width' => 50 ],
          ]),
          $this->acf_event_js_code([
            'id' => $this->id( 'aa0', 100, 200 ),
            'name' => 'onclick_js_code',
            'label' => 'js, выполняющийся при клике на кнопку',
            'wrapper' => [ 'width' => 50 ],
          ]),
        ], // sub_fields
      ]), // $this->acf_group

      $this->acf_group([
        'id' => $this->id( 'aa0', 200 ),
        'name' => 'show_form_btn',
        'label' => 'Кнопка, отсылающая к форме',
        'layout' => 'block',
        'sub_fields' => [
          $this->acf_text([
            'id' => $this->id( 'aa0', 200, 100 ),
            'name' => 'text',
            'label' => 'Текст',
            'default_value' => 'Задать вопрос',
            'wrapper' => [ 'width' => 50 ],
          ]),
          $this->acf_event_js_code([
            'id' => $this->id( 'aa0', 200, 200 ),
            'name' => 'onclick_js_code',
            'label' => 'js, выполняющийся при клике на кнопку',
            'wrapper' => [ 'width' => 50 ],
          ]),
        ], // sub_fields
      ]), // $this->acf_group
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