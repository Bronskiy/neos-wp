<?php

class MY_ACF_MASTER_CLASS extends MY_ACF {
  // use in acf_add_local_field_group() 
  public $acf_group_key = 'acfconst_' . MY_CPT_MASTER_CLASS . '_group_key';

  public $active_acf_0;
  public $active_acf_0_title = 'Настройки события';

  public $active_acf_1;
  public $active_acf_1_title = 'Спикеры';

  public $active_acf_2;
  public $active_acf_2_title = 'Стоимость';

  public $active_acf_3;
  public $active_acf_3_title = 'Содержание';

  public $active_acf_4;
  public $active_acf_4_title = 'Программа';

  public $active_acf_5;
  public $active_acf_5_title = 'Партнеры/Спонсоры';

  public $active_acf_6;
  public $active_acf_6_title = 'Информационные партнеры';

  public $active_acf_7;
  public $active_acf_7_title = 'Как это было в том году';

  public $active_acf_8;
  public $active_acf_8_title = 'Настройка письма-ответа клиентам';

  public $location;

  public $acf;

  public $excluded_fields;

  public $unique_id_prefix = MY_CPT_MASTER_CLASS;

  public function __construct() {
    $this->location = [
      [
        [
          'param' => 'post_type',
          'operator' => '==',
          'value' => MY_CPT_MASTER_CLASS,
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
      $this->acf_group([
        'id' => $this->id( 'aa0', 100 ),
        'name' => 'event',
        'label' => 'Мероприятие',
        'layout' => 'block',
        'sub_fields' => [
          $this->acf_image([
            'id' => $this->id( 'aa0', 100, 50 ),
            'name' => 'city_bgr',
            'label' => 'Фон (город)',
            'wrapper' => [ 'width' => 25 ],
            'preview_size' => 'medium',
          ]),
          $this->acf_text([
            'id' => $this->id( 'aa0', 100, 100 ),
            'name' => 'city',
            'label' => 'Город',
            'wrapper' => [ 'width' => 25 ],
          ]),
          $this->acf_text([
            'id' => $this->id( 'aa0', 100, 200 ),
            'name' => 'address',
            'label' => 'Адрес',
            'wrapper' => [ 'width' => 50 ],
          ]),
          $this->acf_date_time([
            'id' => $this->id( 'aa1', 100, 300 ),
            'name' => 'date',
            'label' => 'Дата',
            'type' => 'date_picker',
            'display_format' => 'd.m.Y',
            'return_format' => 'd.m.Y',
            'required' => true,
            'wrapper' => [ 'width' => 50 ],
          ]),
          $this->acf_date_time([
            'id' => $this->id( 'aa1', 100, 400 ),
            'name' => 'time',
            'label' => 'Время',
            'type' => 'time_picker',
            'display_format' => 'H:i',
            'return_format' => 'H:i',
            'wrapper' => [ 'width' => 50 ],
          ]),
          // $this->acf_wysiwyg_editor([
          //   'id' => $this->id( 'aa1', 100, 500 ),
          //   'name' => 'card_description',
          //   'label' => 'Описание карточки события',
          //   'wrapper' => [ 'width' => 100 ],
          // ]),
        ], // sub_fields
      ]), // $this->acf_repeater
    ]; // $this->active_acf_0


    $this->active_acf_1 = [
      $this->acf_text([
        'id' => $this->id( 'aa1', 50 ),
        'name' => 'speaker_section_title',
        'label' => 'Заголовок блока "Спикеры"',
        'wrapper' => [ 'width' => 50 ],
        'default_value' => 'Спикеры',
      ]),
      $this->acf_repeater([
        'id' => $this->id( 'aa1', 100 ),
        'name' => 'speakers',
        'label' => 'Спикеры',
        'layout' => 'block',
        'button_label' => 'Добавить спикера',
        'sub_fields' => [
          $this->acf_image([
            'id' => $this->id( 'aa1', 100, 50 ),
            'name' => 'avatar',
            'label' => 'Аватарка',
            'wrapper' => [ 'width' => 25 ],
            'preview_size' => 'medium',
          ]),
          $this->acf_text([
            'id' => $this->id( 'aa1', 100, 100 ),
            'name' => 'name',
            'label' => 'Имя',
            'wrapper' => [ 'width' => 25 ],
          ]),
          $this->acf_textarea([
            'id' => $this->id( 'aa1', 100, 200 ),
            'name' => 'description',
            'label' => 'Описание',
            'wrapper' => [ 'width' => 50 ],
            'rows' => 4,
          ]),
        ], // sub_fields
      ]), // $this->acf_repeater
    ]; // $this->active_acf_1


    $this->active_acf_2 = [
      $this->acf_text([
        'id' => $this->id( 'aa2', 50 ),
        'name' => 'price_section_title',
        'label' => 'Заголовок блока "Стоимость"',
        'wrapper' => [ 'width' => 50 ],
        'default_value' => 'Стоиомость участия',
      ]),
      $this->acf_textarea([
        'id' => $this->id( 'aa2', 75 ),
        'name' => 'price_card_form_cta',
        'label' => 'Призыв к действию форм карточек с ценой',
        'wrapper' => [ 'width' => 50 ],
        'rows' => 4,
      ]),
      $this->acf_event_js_code([
        'id' => $this->id( 'aa2', 85 ),
        'name' => 'open_form_btn_onclick_js_code',
        'label' => 'js, выполняющийся при клике на раскрытие формы',
        'wrapper' => [ 'width' => 50 ],
      ]),
      $this->my_acf_prcie_cards([
        'id' => $this->id( 'aa2', 100 ),
        'name' => 'prices',
        'label' => 'Цена',
      ]),
    ]; // $this->active_acf_2


    $this->active_acf_3 = [
      $this->acf_text([
        'id' => $this->id( 'aa3', 50 ),
        'name' => 'master_class_content_title',
        'label' => 'Содержание мастер-класса',
        'wrapper' => [ 'width' => 50 ],
        'default_value' => 'Программа',
      ]),
      $this->acf_repeater([
        'id' => $this->id( 'aa3', 100 ),
        'name' => 'master_class_content',
        'label' => 'Программа',
        'layout' => 'block',
        'sub_fields' => [
          $this->acf_textarea([
            'id' => $this->id( 'aa3', 100, 100 ),
            'name' => 'title',
            'label' => 'Заголовок',
            'wrapper' => [ 'width' => 100 ],
            'rows' => 2,
          ]),
          $this->acf_wysiwyg_editor([
            'id' => $this->id( 'aa3', 100, 200 ),
            'name' => 'description',
            'label' => 'Описание',
            'wrapper' => [ 'width' => 100 ],
          ]),
        ], // sub_fields
      ]), // $this->acf_repeater
    ]; // $this->active_acf_3


    

    $this->active_acf_4 = [
      $this->acf_text([
        'id' => $this->id( 'aa4', 50 ),
        'name' => 'schedule_title',
        'label' => 'Заголовок блока "Программа"',
        'wrapper' => [ 'width' => 50 ],
        'default_value' => 'Программа',
      ]),
      $this->acf_repeater([
        'id' => $this->id( 'aa4', 100 ),
        'name' => 'schedule',
        'label' => 'Программа',
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
      $this->acf_textarea([
        'id' => $this->id( 'aa5', 50 ),
        'name' => 'our_partner_section_title',
        'label' =>'Заголовк секции "Партнеры"',
        'default_value' => 'Партнеры',
        'rows' => 2,
      ]),
      $this->acf_repeater([
        'id' => $this->id( 'aa5', 100 ),
        'name' => 'our_partners',
        'label' => 'Партнеры',
        // 'layout' => 'block',
        'button_label' => 'Добавить',
        'sub_fields' => [
          $this->acf_image([
            'id' => $this->id( 'aa5', 100, 100 ),
            'name' => 'img_logo',
            'label' => 'Лого',
            'wrapper' => [ 'width' => 25 ],
            'preview_size' => 'thumbnail',
          ]),
          $this->acf_textarea([
            'id' => $this->id( 'aa5', 100, 200 ),
            'name' => 'svg_logo',
            'label' =>'Лого SVG',
            'instructions' => 'Если указано, используется вместо изображения',
            'wrapper' => [ 'width' => 25 ],
            'rows' => 3,
            'new_lines' => '',
          ]),
          $this->acf_text([
            'id' => $this->id( 'aa5', 100, 300 ),
            'name' => 'alt',
            'label' =>'alt',
            'wrapper' => [ 'width' => 25 ],
          ]),
          $this->acf_link([
            'id' => $this->id( 'aa5', 100, 400 ),
            'name' => 'link',
            'label' => 'Ссылка',
            'wrapper' => [ 'width' => 25 ],
          ]),
        ], // sub_fields
      ]),
    ]; // $this->active_acf_5






    $this->active_acf_6 = [
      $this->acf_textarea([
        'id' => $this->id( 'aa6', 50 ),
        'name' => 'our_inf_partner_section_title',
        'label' =>'Заголовк секции "Информационные партнеры"',
        'default_value' => 'Информационные партнеры',
        'rows' => 2,
      ]),
      $this->acf_repeater([
        'id' => $this->id( 'aa6', 100 ),
        'name' => 'our_inf_partners',
        'label' => 'Наши партнеры',
        // 'layout' => 'block',
        'button_label' => 'Добавить',
        'sub_fields' => [
          $this->acf_image([
            'id' => $this->id( 'aa6', 100, 100 ),
            'name' => 'img_logo',
            'label' => 'Лого',
            'wrapper' => [ 'width' => 25 ],
            'preview_size' => 'thumbnail',
          ]),
          $this->acf_textarea([
            'id' => $this->id( 'aa6', 100, 200 ),
            'name' => 'svg_logo',
            'label' =>'Лого SVG',
            'instructions' => 'Если указано, используется вместо изображения',
            'wrapper' => [ 'width' => 25 ],
            'rows' => 3,
            'new_lines' => '',
          ]),
          $this->acf_text([
            'id' => $this->id( 'aa6', 100, 300 ),
            'name' => 'alt',
            'label' =>'alt',
            'wrapper' => [ 'width' => 25 ],
          ]),
          $this->acf_link([
            'id' => $this->id( 'aa6', 100, 400 ),
            'name' => 'link',
            'label' => 'Ссылка',
            'wrapper' => [ 'width' => 25 ],
          ]),
        ], // sub_fields
      ]),
    ]; // $this->active_acf_6






    $this->active_acf_7 = [
      $this->acf_textarea([
        'id' => $this->id( 'aa7', 50 ),
        'name' => 'how_it_was_section_title',
        'label' =>'Заголовк секции "Как это было"',
        'default_value' => 'Как это было в том году',
        'rows' => 2,
      ]),
      $this->acf_repeater([
        'id' => $this->id( 'aa7', 100 ),
        'name' => 'how_it_was_media',
        'label' => 'Наши партнеры',
        // 'layout' => 'block',
        'button_label' => 'Добавить',
        'sub_fields' => [
          $this->acf_text([
            'id' => $this->id( 'aa7', 100, 100 ),
            'name' => 'youtube_video_id',
            'label' =>'YoutTube-видео id',
            'instructions' => 'https://www.youtube.com/watch?v=<b style="color:red">bNfYUsDSrOs</b>&ab_channel=CGMeetup или https://youtu.be/<b style="color:red">bNfYUsDSrOs</b>',
            'wrapper' => [ 'width' => 100 ],
          ]),
        ], // sub_fields
      ]),
    ]; // $this->active_acf_7






    $this->active_acf_8 = [
      $this->acf_date_time([
        'id' => $this->id( 'aa8', 100 ),
        'name' => 'registration_close_date',
        'label' => 'Дата и время закрытия регистрации (по Москве)',
        'type' => 'date_time_picker',
        'required' => true,
        'wrapper' => [ 'width' => 100 ],
      ]),
      $this->acf_wysiwyg_editor([
        'id' => $this->id( 'aa8', 200 ),
        'name' => 'response_to_client__success',
        'label' => 'Ответ клиенту об успешной регистрации',
        'wrapper' => [ 'width' => 50 ],
        'default_value' => 'Вы успешно зарегистрировались!',
      ]),
      $this->acf_wysiwyg_editor([
        'id' => $this->id( 'aa8', 300 ),
        'name' => 'response_to_client__late',
        'label' => 'Ответ клиенту о закрытии регистрации',
        'wrapper' => [ 'width' => 50 ],
        'default_value' => 'Приносим свои извинения, но регистрация уже закрыта!',
      ]),
    ]; // $this->active_acf_7

  }// $this->register_acf





  


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
      $this->register_acf_group([
        'title' => $this->active_acf_8_title,
        'group_key' => $this->acf_group_key . '_aa8',
        'fields' => $this->active_acf_8,
        'location' => $this->location,
      ]);
    }
  }
  
} // class:end