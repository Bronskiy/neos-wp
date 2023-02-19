<?php

class MY_ACF_CONTACTS extends MY_ACF {
  // use in acf_add_local_field_group() 
  public $acf_group_key = 'acfconst_' . 'contacts' . '_group_key';

  public $active_acf_0;
  public $active_acf_0_title = 'Адреса';

  public $active_acf_1;
  public $active_acf_1_title = 'Соц. сети';

  public $location;

  public $acf;

  public $excluded_fields;

  public $unique_id_prefix = 'contacts';

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
          'value' => MY_CPT_SETTINGS,
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
        'id' => $this->id( 'aa0', 40 ),
        'name' => 'map_center',
        'label' => 'Центр карты',
        'layout' => 'block',
        'sub_fields' => [
          $this->acf_text([
            'id' => $this->id( 'aa0', 40, 100 ),
            'name' => 'lat',
            'label' => 'Широта (координаты места)',
            'type' => 'number',
            'wrapper' => [ 'width' => 40 ],
          ]),
          $this->acf_text([
            'id' => $this->id( 'aa0', 40, 200 ),
            'name' => 'lng',
            'label' =>'Долгота (координаты места)',
            'type' => 'number',
            'wrapper' => [ 'width' => 40 ],
          ]),
        ], // sub_fields
      ]),
      $this->acf_group([
        'id' => $this->id( 'aa0', 10 ),
        'name' => 'map_contact_card',
        'label' => 'Контактная карточка адреса на карте',
        'layout' => 'block',
        'sub_fields' => [
          $this->acf_textarea([
            'id' => $this->id( 'aa0', 10, 100 ),
            'name' => 'logo_title',
            'label' => 'Подпись к логотипу',
            'rows' => 3,
            'wrapper' => [ 'width' => 50 ],
          ]),
          $this->acf_text([
            'id' => $this->id( 'aa0', 10, 200 ),
            'name' => 'btn_text',
            'label' =>'Текст кнопки',
            'wrapper' => [ 'width' => 50 ],
          ]),
          $this->acf_event_js_code([
            'id' => $this->id( 'aa0', 10, 300 ),
            'name' => 'btn_onclick_js_code',
            'label' => 'js, выполняющийся при клике на кнопку',
            'wrapper' => [ 'width' => 50 ],
          ]),
        ], // sub_fields
      ]),
      $this->acf_group([
        'id' => $this->id( 'aa0', 50 ),
        'name' => 'head_office_address',
        'label' => 'Адрес головного офиса',
        'layout' => 'block',
        'sub_fields' => [
          $this->acf_text([
            'id' => $this->id( 'aa0', 50, 100 ),
            'name' => 'address',
            'label' => 'Адрес',
            'wrapper' => [ 'width' => 50 ],
          ]),
          $this->acf_text([
            'id' => $this->id( 'aa0', 100, 120 ),
            'name' => 'country_code',
            'label' => '<a href="https://ru.wikipedia.org/wiki/ISO_3166-1" target="_blank">Код страны</a> (2 символа)',
            'wrapper' => [ 'width' => 25 ],
          ]),
          $this->acf_text([
            'id' => $this->id( 'aa0', 100, 130 ),
            'name' => 'region_code',
            'label' => '<a href="https://ru.wikipedia.org/wiki/ISO_3166-2:RU" target="_blank">Код региона</a> (3 символа)',
            'wrapper' => [ 'width' => 25 ],
          ]),
          $this->acf_text([
            'id' => $this->id( 'aa0', 50, 150 ),
            'name' => 'caption',
            'label' => 'Подпись',
            'wrapper' => [ 'width' => 50 ],
          ]),
          $this->acf_text([
            'id' => $this->id( 'aa0', 50, 200 ),
            'name' => 'lat',
            'label' => 'Широта (координаты места)',
            'type' => 'number',
            'wrapper' => [ 'width' => 50 ],
          ]),
          $this->acf_text([
            'id' => $this->id( 'aa0', 50, 300 ),
            'name' => 'lng',
            'label' =>'Долгота (координаты места)',
            'type' => 'number',
            'wrapper' => [ 'width' => 50 ],
          ]),
          $this->acf_text([
            'id' => $this->id( 'aa0', 50, 400 ),
            'name' => 'phone',
            'label' => 'Телефон',
            'wrapper' => [ 'width' => 50 ],
          ]),
          $this->acf_text([
            'id' => $this->id( 'aa0', 50, 500 ),
            'name' => 'email',
            'label' =>'E-mail',
            'wrapper' => [ 'width' => 50 ],
          ]),
        ], // sub_fields
      ]),
      $this->acf_repeater([
        'id' => $this->id( 'aa0', 100 ),
        'name' => 'addresses',
        'label' => 'Остальные адреса',
        'layout' => 'block',
        'button_label' => 'Добавить адрес',
        'sub_fields' => [
          $this->acf_text([
            'id' => $this->id( 'aa0', 100, 100 ),
            'name' => 'address',
            'label' => 'Адрес',
            'wrapper' => [ 'width' => 100 ],
          ]),
          $this->acf_text([
            'id' => $this->id( 'aa0', 100, 100 ),
            'name' => 'address',
            'label' => 'Адрес',
            'wrapper' => [ 'width' => 50 ],
          ]),
          $this->acf_text([
            'id' => $this->id( 'aa0', 100, 150 ),
            'name' => 'country_code',
            'label' => '<a href="https://ru.wikipedia.org/wiki/ISO_3166-1" target="_blank">Код страны</a> (2 символа)',
            'wrapper' => [ 'width' => 25 ],
          ]),
          $this->acf_text([
            'id' => $this->id( 'aa0', 100, 160 ),
            'name' => 'region_code',
            'label' => '<a href="https://ru.wikipedia.org/wiki/ISO_3166-2:RU" target="_blank">Код региона</a> (3 символа)',
            'wrapper' => [ 'width' => 25 ],
          ]),
          $this->acf_text([
            'id' => $this->id( 'aa0', 100, 200 ),
            'name' => 'lat',
            'label' => 'Широта (координаты места)',
            'type' => 'number',
            'wrapper' => [ 'width' => 50 ],
          ]),
          $this->acf_text([
            'id' => $this->id( 'aa0', 100, 300 ),
            'name' => 'lng',
            'label' =>'Долгота (координаты места)',
            'type' => 'number',
            'wrapper' => [ 'width' => 50 ],
          ]),
          $this->acf_text([
            'id' => $this->id( 'aa0', 100, 400 ),
            'name' => 'phone',
            'label' => 'Телефон',
            'wrapper' => [ 'width' => 50 ],
          ]),
          $this->acf_text([
            'id' => $this->id( 'aa0', 100, 500 ),
            'name' => 'email',
            'label' =>'E-mail',
            'wrapper' => [ 'width' => 50 ],
          ]),
        ], // sub_fields
      ]),
    ]; // $this->active_acf_0



    $this->active_acf_1 = [
      // $this->acf_group([
      //   'id' => $this->id( 'aa1', 50 ),
      //   'name' => 'main_contact_tel',
      //   'label' => 'Телефон для звонка с сайта',
      //   'layout' => 'block',
      //   'sub_fields' => [
      //     // $this->acf_text([
      //     //   'id' => $this->id( 'aa1', 50, 100 ),
      //     //   'name' => 'icon_name',
      //     //   'label' => 'Имя иконки',
      //     //   'wrapper' => [ 'width' => 25 ],
      //     // ]),
      //     $this->acf_text([
      //       'id' => $this->id( 'aa1', 50, 200 ),
      //       'name' => 'number',
      //       'label' => 'Телефон',
      //       'wrapper' => [ 'width' => 75 ],
      //     ]),
      //   ], // sub_fields
      // ]), // $this->acf_group
      $this->acf_repeater([
        'id' => $this->id( 'aa1', 100 ),
        'name' => 'socials',
        'label' => 'Соц. сети',
        'layout' => 'block',
        'button_label' => 'Добавить элемент',
        'sub_fields' => [
          $this->acf_textarea([
            'id' => $this->id( 'aa1', 100, 100 ),
            'name' => 'svg_or_icon_name',
            'label' => 'Имя иконки или SVG код',
            'wrapper' => [ 'width' => 50 ],
            'rows' => 3,
            'new_lines' => '',
          ]),
          $this->acf_text([
            'id' => $this->id( 'aa1', 100, 200 ),
            'name' => 'icon_size',
            'label' => 'Размер иконки (px)',
            'type' => 'number',
            'wrapper' => [ 'width' => 25 ],
            'rows' => 3,
          ]),
          $this->acf_RGBA_color_picker([
            'id' => $this->id( 'aa1', 100, 300 ),
            'name' => 'icon_color',
            'label' => 'Цвет иконки',
            'wrapper' => [ 'width' => 25 ],
          ]),
          $this->acf_link([
            'id' => $this->id( 'aa1', 100, 400 ),
            'name' => 'link',
            'label' => 'Ссылка',
            'wrapper' => [ 'width' => 100 ],
          ]),
        ], // sub_fields
      ]), // $this->acf_repeater
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