<?php

class MY_ACF_ABOUT_US extends MY_ACF {
  // use in acf_add_local_field_group() 
  public $acf_group_key = 'acfconst_' . 'about_us' . '_group_key';

  public $active_acf_0;
  public $active_acf_0_title = 'Секция с особенностями компании';

  public $active_acf_1;
  public $active_acf_1_title = 'О компании';

  public $active_acf_2;
  public $active_acf_2_title = 'История компании';

  public $active_acf_3;
  public $active_acf_3_title = 'Сертификаты';

  public $active_acf_4;
  public $active_acf_4_title = 'Наши клиенты';

  public $active_acf_5;
  public $active_acf_5_title = 'Отзывы';

  public $active_acf_6;
  public $active_acf_6_title = 'Форма обратной связи';

  public $active_acf_7;
  public $active_acf_7_title = 'Наше производство';
	
  public $active_acf_8;
  public $active_acf_8_title = 'Лаборатория';

  public $location;

  public $acf;

  public $excluded_fields;

  public $unique_id_prefix = 'about_us';

  public function __construct( $args=[] ) {
    $lang_codes = pll_languages_list(); // [ru, en, ...]
    $post_id = get_option( '__about_us_post_id__' );
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
    $this->active_acf_0 = [
      $this->acf_text([
        'id' => $this->id( 'aa0', 80 ),
        'name' => 'fp_feature_section_title',
        'label' => 'Заголовок секции особенностей на главной странице',
        'default_value' => 'О компании',
      ]),
      $this->acf_text([
        'id' => $this->id( 'aa0', 90 ),
        'name' => 'au_feature_section_title',
        'label' => 'Заголовок секции особенностей на странице "О нас"',
        'default_value' => 'Факты о нас',
      ]),
      $this->acf_repeater([
        'id' => $this->id( 'aa0', 100 ),
        'name' => 'company_features',
        'label' => 'Особенности компании',
        'layout' => 'block',
        'button_label' => 'Добавить элемент',
        'sub_fields' => [
          $this->acf_textarea([
            'id' => $this->id( 'aa0', 100, 100 ),
            'name' => 'svg',
            'label' => 'SVG код иконки',
            'wrapper' => [ 'width' => 50 ],
            'rows' => 3,
            'new_lines' => '',
          ]),
          $this->acf_textarea([
            'id' => $this->id( 'aa0', 100, 200 ),
            'name' => 'title',
            'label' => 'Заголовок',
            'wrapper' => [ 'width' => 50 ],
            'rows' => 3,
            'required' => true,
          ]),
          $this->acf_textarea([
            'id' => $this->id( 'aa0', 100, 300 ),
            'name' => 'description',
            'label' =>'Описание',
            'wrapper' => [ 'width' => 100 ],
            'rows' => 4,
          ]),
          $this->acf_link([
            'id' => $this->id( 'aa0', 100, 400 ),
            'name' => 'link',
            'label' => 'Кнопка',
            'wrapper' => [ 'width' => 20 ],
          ]),
          $this->acf_group([
            'id' => $this->id( 'aa0', 100, 400 ),
            'name' => 'btn',
            'label' => 'Настройка кнопки',
            'sub_fields' => [
              $this->acf_link([
                'id' => $this->id( 'aa0', 100, 400, 100 ),
                'name' => 'link',
                'label' => 'Ссылка',
                'instructions' => 'Название кнопки устанавливается здесь же',
                'wrapper' => [ 'width' => 25 ],
              ]),
              $this->acf_textarea([
                'id' => $this->id( 'aa0', 100, 400, 200 ),
                'name' => 'link_attributes',
                'label' => 'Атрибуты тега &lt;а&gt;&lt;/a&gt; (продвинутая настройка)',
                'instructions' => 'Текст напрямую подставлять в тег. Пишите, соблюдая все правила написания html кода, например, <code>data-id="23" target=\'hidden-iframe\'</code>',
                'wrapper' => [ 'width' => 75 ],
                'placeholder' => '',
                'rows' => 2,
                'new_lines' => '',
              ]),
            ],
          ]),
        ], // sub_fields
      ]),
    ]; // $this->active_acf_0



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
        'name' => 'company_history_section_title',
        'label' =>'Заголовк секции "История компании"',
        'default_value' => 'История компании',
        'wrapper' => [ 'width' => 50 ],
      ]),
      $this->acf_repeater([
        'id' => $this->id( 'aa2', 100 ),
        'name' => 'company_history',
        'label' => 'История компании',
        'layout' => 'block',
        'button_label' => 'Добавить элемент',
        'sub_fields' => [
          $this->acf_text([
            'id' => $this->id( 'aa2', 100, 100 ),
            'name' => 'year',
            'label' => 'Год',
            'wrapper' => [ 'width' => 25 ],
            'required' => true,
          ]),
          $this->acf_text([
            'id' => $this->id( 'aa2', 100, 200 ),
            'name' => 'title',
            'label' => 'Название события',
            'wrapper' => [ 'width' => 75 ],
            'required' => true,
          ]),
          $this->acf_textarea([
            'id' => $this->id( 'aa2', 100, 300 ),
            'name' => 'description',
            'label' =>'Описание',
            'required' => true,
            'wrapper' => [ 'width' => 100 ],
            'rows' => 4,
          ]),
        ], // sub_fields
      ]),
    ]; // $this->active_acf_2



    $this->active_acf_3 = [
      $this->acf_repeater([
        'id' => $this->id( 'aa3', 100 ),
        'name' => 'certificates',
        'label' => 'Сертификаты',
        // 'layout' => 'block',
        'button_label' => 'Добавить сертификат',
        'sub_fields' => [
          $this->acf_image([
            'id' => $this->id( 'aa3', 100, 100 ),
            'name' => 'image',
            'label' => 'Изображение сертификатк',
            'wrapper' => [ 'width' => 20 ],
            'preview_size' => 'thumbnail',
          ]),
          $this->acf_textarea([
            'id' => $this->id( 'aa3', 100, 200 ),
            'name' => 'description',
            'label' =>'Описание',
            'required' => false,
            'wrapper' => [ 'width' => 800 ],
            'rows' => 3,
          ]),
        ], // sub_fields
      ]),
    ]; // $this->active_acf_3



    $this->active_acf_4 = [
      $this->acf_textarea([
        'id' => $this->id( 'aa4', 50 ),
        'name' => 'our_client_section_title',
        'label' =>'Заголовк секции "Наши клиенты"',
        'default_value' => 'Наши клиенты',
        'rows' => 2,
      ]),
      $this->acf_repeater([
        'id' => $this->id( 'aa4', 100 ),
        'name' => 'our_clients',
        'label' => 'Наши клиенты',
        // 'layout' => 'block',
        'button_label' => 'Добавить',
        'sub_fields' => [
          $this->acf_image([
            'id' => $this->id( 'aa4', 100, 100 ),
            'name' => 'img_logo',
            'label' => 'Лого',
            'wrapper' => [ 'width' => 33 ],
            'preview_size' => 'thumbnail',
          ]),
          $this->acf_textarea([
            'id' => $this->id( 'aa4', 100, 200 ),
            'name' => 'svg_logo',
            'label' =>'Лого SVG',
            'instructions' => 'Если указано, используется вместо изображения',
            'wrapper' => [ 'width' => 33 ],
            'rows' => 3,
            'new_lines' => '',
          ]),
          $this->acf_text([
            'id' => $this->id( 'aa4', 100, 300 ),
            'name' => 'alt',
            'label' =>'alt',
            'wrapper' => [ 'width' => 33 ],
          ]),
        ], // sub_fields
      ]),
    ]; // $this->active_acf_4


    $this->active_acf_5 = [
      $this->acf_text([
        'id' => $this->id( 'aa5', 50 ),
        'name' => 'feedback_section_title',
        'label' =>'Заголовк секции "Отзывы"',
        'default_value' => 'Отзывы',
      ]),
      $this->my_acf_feedbacks([
        'id' => $this->id( 'aa5', 100 ),
        'name' => 'feedbacks',
      ]),
    ]; // $this->active_acf_5



    $this->active_acf_6 = $this->acf_post_form([
      'id' => 'aa6',
      'form_post_type' => MY_CPT_SITE_FORM,
    ]); // active_acf_6



    $this->active_acf_7 = [
      $this->acf_group([
        'id' => $this->id( 'aa7', 100 ),
        'name' => 'our_production',
        'label' => 'Производство',
        'sub_fields' => [
          $this->acf_text([
            'id' => $this->id( 'aa7', 100, 100 ),
            'name' => 'title',
            'label' =>'Заголовок секции',
            'required' => false,
            'wrapper' => [ 'width' => 100 ],
          ]),
          $this->acf_gallery([
            'id' => $this->id(['aa7', 100, 200]),
            'name' => 'gallery',
            'label' => __('Галерея', '_my_theme_'),
            'wrapper' => [ 'width' => 100 ],
          ]),
          $this->acf_wysiwyg_editor([
            'id' => $this->id( 'aa7', 100, 300 ),
            'name' => 'text',
            'label' => 'Текст',
            'wrapper' => [ 'width' => 100 ],
          ]),
        ],
      ]),
    ]; // $this->active_acf_1
	  
	  $this->active_acf_8 = [
      $this->acf_group([
        'id' => $this->id( 'aa8', 100 ),
        'name' => 'our_labs',
        'label' => 'Лаборатория',
        'sub_fields' => [
          $this->acf_text([
            'id' => $this->id( 'aa8', 100, 100 ),
            'name' => 'title_lab',
            'label' =>'Заголовок секции',
            'required' => false,
            'wrapper' => [ 'width' => 100 ],
          ]),
          $this->acf_text([
            'id' => $this->id( 'aa8', 100, 100 ),
            'name' => 'title_id',
            'label' =>'ID видео с Youtube',
            'required' => false,
            'wrapper' => [ 'width' => 100 ],
          ]),
          $this->acf_wysiwyg_editor([
            'id' => $this->id( 'aa8', 100, 300 ),
            'name' => 'text_lab',
            'label' => 'Текст',
            'wrapper' => [ 'width' => 100 ],
          ]),
        ],
      ]),
    ]; // $this->active_acf_8
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
      $this->register_acf_group([
        'title' => $this->active_acf_7_title,
        'group_key' => $this->acf_group_key . '_aa7',
        'fields' => $this->active_acf_7,
        'location' => $this->location,
      ]);
    };
  }
  
} // class:end