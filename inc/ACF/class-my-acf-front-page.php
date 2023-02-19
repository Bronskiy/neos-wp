<?php

class MY_ACF_FRONT_PAGE extends MY_ACF {
  // use in acf_add_local_field_group() 
  public $acf_group_key = 'acfconst_' . 'front_page' . '_group_key';

  public $active_acf_0;
  public $active_acf_0_title = 'Блок с призывом подписаться на соц. сети';

  public $active_acf_1;
  public $active_acf_1_title = 'Тестирование';

  public $active_acf_2;
  public $active_acf_2_title = 'Новости';

  public $location;

  public $acf;

  public $excluded_fields;

  public $unique_id_prefix = 'front_page';

  /**
   * @param Array $args
   *    @param Array $args['location'] - where to print this ACF
   *    @param Array $args['exclude_fields'] - array of field names that you want to exclude
   */
  public function __construct( $args=[] ) {
    $lang_codes = pll_languages_list(); // [ru, en, ...]
    $post_id = get_option( '__contact_post_id__' );
    $location = [];

    foreach ($lang_codes as $index => $lang_code) {
      $location[] = [
        [
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'page',
        ],
        [
          'param' => 'page',
          'operator' => '==',
          'value' => get_option( 'page_on_front' ),
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
        'name' => 'social_cta',
        'label' => 'Призыв к дейстивию',
        'layout' => 'block',
        'sub_fields' => [
          $this->acf_text([
            'id' => $this->id( 'aa0', 100, 50 ),
            'name' => 'title',
            'label' => 'Заголовок',
            'wrapper' => [ 'width' => 50 ],
            ]),
          $this->acf_image([
            'id' => $this->id( 'aa0', 100, 60 ),
            'name' => 'screen_img',
            'label' => 'Изображение на телефоне',
            'instructions' => 'Соотношение сторон w/h = 1670/3481',
            'wrapper' => [ 'width' => 50 ],
            'preview_size' => 'medium',
          ]),
          $this->acf_wysiwyg_editor([
            'id' => $this->id( 'aa0', 100, 80 ),
            'name' => 'text',
            'label' => 'Текст',
          ]),
          $this->acf_repeater([
            'id' => $this->id( 'aa0', 100, 100 ),
            'name' => 'socials',
            'label' => 'Соц. сети',
            'layout' => 'block',
            'button_label' => 'Добавить элемент',
            'sub_fields' => [
              $this->acf_textarea([
                'id' => $this->id( 'aa0', 100, 100, 100 ),
                'name' => 'svg_or_icon_name',
                'label' => 'Имя иконки или SVG код',
                'wrapper' => [ 'width' => 50 ],
                'rows' => 3,
                'new_lines' => '',
              ]),
              $this->acf_text([
                'id' => $this->id( 'aa0', 100, 100, 200 ),
                'name' => 'icon_size',
                'label' => 'Размер иконки (px)',
                'type' => 'number',
                'wrapper' => [ 'width' => 25 ],
                'rows' => 3,
              ]),
              $this->acf_RGBA_color_picker([
                'id' => $this->id( 'aa0', 100, 100, 300 ),
                'name' => 'icon_color',
                'label' => 'Цвет иконки',
                'wrapper' => [ 'width' => 25 ],
              ]),
              $this->acf_link([
                'id' => $this->id( 'aa0', 100, 100, 400 ),
                'name' => 'link',
                'label' => 'Ссылка',
                'wrapper' => [ 'width' => 100 ],
              ]),
            ], // sub_fields
          ]), // $this->acf_repeater
        ], // sub_fields
      ]), // $this->acf_group
    ]; // $this->active_acf_0



    $this->active_acf_1 = [
      $this->my_acf_bgr_viedo_section([
        'id' => $this->id( 'aa1', 100 ),
        'name' => 'testing_section',
        'label' => 'Секция "Тестирование"',
      ]),
    ]; // $this->active_acf_1



    $this->active_acf_2 = [
      $this->acf_group([
        'id' => $this->id( 'aa2', 100 ),
        'name' => 'news_section',
        'label' => 'Секция "Новости"',
        'layout' => 'block',
        'sub_fields' => [
          $this->acf_text([
            'id' => $this->id( 'aa2', 100, 100 ),
            'name' => 'title',
            'label' => 'Заголовок',
            'wrapper' => [ 'width' => 50 ],
            'default_value' => 'Новости',
          ]),
        ], // sub_fields
      ]), // $this->acf_group
    ]; // $this->active_acf_2
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