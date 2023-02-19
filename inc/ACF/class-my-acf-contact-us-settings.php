<?php

class MY_ACF_CONTACT_US_SETTINGS extends MY_ACF {
  // use in acf_add_local_field_group() 
  public $acf_group_key = 'acfconst_' . 'contacts_us_settings' . '_group_key';

  public $active_acf_0;
  public $active_acf_0_title = 'Куда отправлять письма';

  public $active_acf_1;
  public $active_acf_1_title = 'Куда звонить';

  public $active_acf_2;
  public $active_acf_2_title = 'Привязка филиалов к регионам/областям/странам';

  public $active_acf_3;
  public $active_acf_3_title = 'WhatsApp';

  public $location;

  public $acf;

  public $excluded_fields;

  public $unique_id_prefix = 'contacts_us_settings';

  public function __construct( $args=[] ) {
    $lang_codes = pll_languages_list(); // [ru, en, ...]
    $post_id = get_option( '__contact_us_settings__' );
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
        'id' => $this->id( 'aa0', 100 ),
        'name' => 'email_settings',
        'label' => 'Настройка почты',
        'layout' => 'block',
        'sub_fields' => [
          $this->acf_textarea([
            'id' => $this->id( 'aa0', 100, 100 ),
            'name' => 'get_all_letters_emails',
            'label' => 'Почта для получения ВСЕХ заявок',
            'instructions' => 'Разделители адресов: <span style="color:blue">«,»</span> <span style="color:blue">«;»</span> <span style="color:blue">« »</span> и <span style="color:blue">перенос строки</span>',
            'rows' => 6,
            'new_lines' => '',
          ]),
          $this->acf_text([
            'id' => $this->id( 'aa0', 100, 200 ),
            'name' => 'manager_email',
            'label' => 'E-mail менеджера',
            'instructions' => 'Куда писать из раздела "Поиск продуктов"',
            'wrapper' => [ 'width' => 100 ],
          ]),
        ], // sub_fields
      ]),
    ]; // $this->active_acf_0



    $this->active_acf_1 = [
      $this->acf_group([
        'id' => $this->id( 'aa1', 100 ),
        'name' => 'tel_settings',
        'label' => 'Настройка телефона',
        'layout' => 'block',
        'sub_fields' => [
          $this->acf_text([
            'id' => $this->id( 'aa1', 100, 100 ),
            'name' => 'manager_tel',
            'label' => 'Телефон менеджера',
            'instructions' => 'Звонят из раздела "Поиск продуктов"',
            'wrapper' => [ 'width' => 100 ],
          ]),
        ], // sub_fields
      ]), // $this->acf_group
    ]; // $this->active_acf_1



    $this->active_acf_2 = [
      $this->acf_repeater([
        'id' => $this->id( 'aa2', 100 ),
        'name' => 'rus_region_location_binding',
        'label' => 'Привязка филиалов к регионам РФ',
        'layout' => 'block',
        'instructions' => '<a href="https://ru.wikipedia.org/wiki/ISO_3166-2:RU" target="_blank">Коды регионов</a> брать без приставки "RU-", например, код Новосибирска - просто "NVS"',
        'sub_fields' => [
          $this->acf_text([
            'id' => $this->id( 'aa2', 100, 100 ),
            'name' => 'targer_region_code',
            'label' => 'Код регоина офиса (<a href="https://ru.wikipedia.org/wiki/ISO_3166-2:RU" target="_blank">ISO_3166-2</a>)',
          ]),
          $this->acf_textarea([
            'id' => $this->id( 'aa2', 100, 200 ),
            'name' => 'bound_region_codes',
            'label' => 'Привязанные коды регионов (<a href="https://ru.wikipedia.org/wiki/ISO_3166-2:RU" target="_blank">ISO_3166-2</a>)',
            'rows' => 4,
          ]),
        ], // sub_fields
      ]), // $this->acf_repeater
    ]; // $this->active_acf_2




    $this->active_acf_3 = [
      $this->acf_group([
        'id' => $this->id( 'aa3', 100 ),
        'name' => 'whatsapp',
        'label' => 'Настройка WhatsApp',
        'layout' => 'block',
        'sub_fields' => [
          $this->acf_text([
            'id' => $this->id( 'aa3', 100, 100 ),
            'name' => 'tel',
            'label' => 'Телефон',
            'instructions' => 'Только цифры. Например: 79998887755',
            'wrapper' => [ 'width' => 100 ],
          ]),
        ], // sub_fields
      ]), // $this->acf_group
    ]; // $this->active_acf_3
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
    };
  }
  
} // class:end