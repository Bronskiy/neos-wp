<?php

class MY_ACF_LANDING_PAGE_DWL_FILES_AFTER_FORM_FILL extends MY_ACF {
  // use in acf_add_local_field_group() 
  public $acf_group_key = 'acfconst_' . 'lp__dwl_files_after_form_fill' . '_group_key';

  public $active_acf_1;
  public $active_acf_1_title = 'Данные';

  public $active_acf_2;
  public $active_acf_2_title = 'Форма обратной связи';

  public $location;

  public $acf;

  public $excluded_fields;

  public $unique_id_prefix = 'lp__dwl_files_after_form_fill';

  public function __construct() {
    $lang_codes = pll_languages_list(); // [ru, en, ...]
    $post_id = get_option( '__dwl_files_after_form_fill__landing_page_id_1__' );
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
      $this->acf_repeater([
        'id' => $this->id( 'aa1', 100 ),
        'name' => 'files_for_dwl',
        'label' => 'Файлы для скачивания',
        'layout' => 'block',
        'button_label' => 'Добавить элемент',
        'sub_fields' => [
          $this->acf_file([
            'id' => $this->id( 'aa1', 100, 100 ),
            'name' => 'file',
            'label' => 'Файл',
            // 'return_format' => 'url',
            'wrapper' => [ 'width' => 100 ],
          ]),
        ], // sub_fields
      ]),
    ]; // $this->active_acf_1


    $this->active_acf_2 = array_merge(
      [
        $this->acf_group([
          'id' => $this->id( 'aa2', 100 ),
          'name' => 'dwl_btn',
          'label' => 'Настройка кнопки загрузки',
          'wrapper' => [ 'width' => 50 ],
          'sub_fields' => [
            $this->acf_text([
              'id' => $this->id( 'aa2', 100, 100 ),
              'name' => 'text',
              'label' => 'Текст',
              'default_value' => 'Скачать'
            ]),
          ],
        ]),
      ],
      $this->acf_post_form([
        'id' => $this->id( 'aa2', 200 ),
        'form_post_type' => MY_CPT_SITE_FORM,
      ])
    ); // active_acf_2
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