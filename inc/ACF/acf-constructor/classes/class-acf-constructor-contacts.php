<?php

class ACF_CONSTRUCTOR_CONTACTS extends ACF_CONSTRUCTOR {
  // use in acf_add_local_field_group() 
  public $acf_group_key = 'acfconst_' . 'contacts' . '_group_key';

  public $active_acf_1;
  public $active_acf_1_title = 'Настройка контактов';

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
    require  __ACf_CONSTUCTOR_ABSPATH__ . "/classes/functions/contacts.php";

    /* LOCATION */
    if (array_key_exists('location', $args)) {
      $this->location = $args['location'];
    }
    else {
      trigger_error('You must pass <b style="color:#77b4ef">location</b> in $args to <b style="color:#4abb4a">ACF_CONSTRUCTOR_CONTACTS</b> __construct', E_USER_WARNING);
      $this->location = [];
    }

    /* FIELDS */
    if (array_key_exists('exclude_fields', $args)) {
      $this->excluded_fields = $args['exclude_fields'];
    }
    else $this->excluded_fields = [];
  }


  public function register() {
    $this->acf = (object) [];
    $this->register_acf();
    add_action( 'acf/init', [$this, 'acf_init'] );
  }


  public function register_acf() {
    $this->active_acf_1 = [

      in_array('footer_top_string', $this->excluded_fields)? [] : $this->acf_textarea([
        'id' => $this->id( 90 ),
        'name' => 'footer_top_string',
        'label' => 'Первая верхняя строка футера',
        'rows' => 2,
      ]), // acf_textarea

      in_array('emails', $this->excluded_fields)? [] : $this->acf_repeater([
        'id' => $this->id( 100 ),
        'name' => 'emails',
        'label' => 'Настройка почты',
        'button_label' => 'Добавить почту',
        'sub_fields' => [
          $this->acf_icon_name([
            'id' => $this->id( 100, 100),
            'wrapper' => [ 'width' => 15 ],
            ]),
          $this->acf_text([
            'id' => $this->id( 100, 150 ),
            'name' => 'prefix',
            'label' => 'Префикс',
            'wrapper' => [ 'width' => 25 ],
          ]),
          $this->acf_text([
            'id' => $this->id( 100, 200 ),
            'name' => 'email',
            'label' => 'Email',
            'required' => 1,
            'placeholder' => 'example@gmail.com',
            'wrapper' => [ 'width' => 40 ],
          ]),
          $this->acf_text([
            'id' => $this->id( 100, 300 ),
            'name' => 'postfix',
            'label' => 'Постфикс',
            'wrapper' => [ 'width' => 25 ],
          ]),
        ],
      ]), // acf_repeater

      in_array('telephones', $this->excluded_fields)? [] : $this->acf_repeater([
        'id' => $this->id( 200 ),
        'name' => 'telephones',
        'label' => 'Настройка телефонов',
        'button_label' => 'Добавить тел.',
        'sub_fields' => [
          $this->acf_icon_name([
            'id' => $this->id( 200, 100),
            'wrapper' => [ 'width' => 15 ],
          ]),
          $this->acf_text([
            'id' => $this->id( 200, 150 ),
            'name' => 'prefix',
            'label' => 'Префикс',
            'wrapper' => [ 'width' => 25 ],
          ]),
          $this->acf_text([
            'id' => $this->id( 200, 200 ),
            'name' => 'telephone',
            'label' => 'Телефон',
            'required' => 1,
            'placeholder' => '+7 (383) 000 0000',
            'wrapper' => [ 'width' => 40 ],
          ]),
          $this->acf_text([
            'id' => $this->id( 200, 300 ),
            'name' => 'postfix',
            'label' => 'Постфикс',
            'wrapper' => [ 'width' => 25 ],
          ]),
        ],
      ]), // acf_repeater

      in_array('requisites', $this->excluded_fields)? [] : $this->acf_repeater([
        'id' => $this->id( 300 ),
        'name' => 'requisites',
        'label' => 'Настройка реквизитов',
        'button_label' => 'Добавить реквизит',
        'sub_fields' => [
          $this->acf_icon_name([
            'id' => $this->id( 300, 50),
          ]),
          $this->acf_text([
            'id' => $this->id( 300, 100 ),
            'name' => 'requisite',
            'label' => 'Реквизит',
            'required' => 1,
          ]),
        ],
      ]), // acf_repeater
      
      in_array('social_networks', $this->excluded_fields)? [] : $this->acf_repeater([
        'id' => $this->id( 400 ),
        'name' => 'social_networks',
        'label' => 'Настройка соц.сетей',
        'button_label' => 'Добавить соц.сеть',
        'layout' => 'block',
        'sub_fields' => $this->acf_link_set( $this->id( 400 ) ),
      ]), // acf_repeater

      in_array('contact_columns', $this->excluded_fields)? [] : $this->acf_repeater([
        'id' =>  $this->id( 500 ),
        'name' => 'contact_columns',
        'label' => 'Колонки с контактами',
        'layout' => 'block',
        'button_label' => 'Добавить <b>колонку</b>',
        'sub_fields' => [
          $this->acf_flexible_content([
            'id' => $this->id( 500, 10 ),
            'name' => 'column',
            'label' => 'Колонка с контактами',
            'button_label' => 'Добавить <b>строку</b> в колонке',
            'layouts' => [
              array(
                'key' => $this->id( 500, 10, 100 ),
                'name' => 'string',
                'label' => 'Текст в одну строку',
                'display' => 'table',
                'sub_fields' => [
                  $this->acf_icon_name([
                    'id' => $this->id( 500, 10, 100, 10 ),
                    'wrapper' => [ 'width' => 15 ],
                  ]),
                  $this->acf_text([
                    'id' => $this->id( 500, 10, 100, 20 ),
                    'name' => 'string',
                    'label' => 'Строка',
                    'required' => 1,
                    'wrapper' => [ 'width' => 85 ],
                  ]),
                ],
              ),
              array(
                'key' => $this->id( 500, 10, 200 ),
                'name' => 'textarea',
                'label' => 'Многострочный текст',
                'display' => 'table',
                'sub_fields' => [
                  $this->acf_icon_name([
                    'id' => $this->id( 500, 10, 200, 10 ),
                    'wrapper' => [ 'width' => 15 ],
                  ]),
                  $this->acf_textarea([
                    'id' => $this->id( 500, 10, 200, 20 ),
                    'name' => 'textarea',
                    'label' => 'Текст',
                    'wrapper' => [ 'width' => 85 ],
                    'rows' => 3,
                  ]),
                ],
              ),
              array(
                'key' => $this->id( 500, 10, 300 ),
                'name' => 'link_string',
                'label' => 'Простая ссылка',
                'display' => 'block',
                'sub_fields' => $this->acf_link_set( $this->id( 500, 10, 300 ) ),
              ),
              array(
                'key' => $this->id( 500, 10, 400 ),
                'name' => 'map',
                'label' => 'Карта (одна строка, ссылка)',
                'display' => 'block',
                'sub_fields' => [
                  $this->acf_icon_name([
                    'id' => $this->id( 500, 10, 400, 10 ),
                    'wrapper' => [ 'width' => 15 ],
                    ]),
                  $this->acf_text([
                    'id' => $this->id( 500, 10, 400, 20 ),
                    'name' => 'prefix',
                    'label' => 'Префикс',
                    'wrapper' => [ 'width' => 25 ],
                  ]),
                  $this->acf_textarea([
                    'id' => $this->id( 500, 10, 400, 30 ),
                    'name' => 'address',
                    'label' => 'Адрес / Название места',
                    'required' => 1,
                    'wrapper' => [ 'width' => 33 ],
                    'rows' => 3,
                  ]),
                  $this->acf_text([
                    'id' => $this->id( 500, 10, 400, 40 ),
                    'name' => 'postfix',
                    'label' => 'Постфикс',
                    'wrapper' => [ 'width' => 25 ],
                  ]),
                  $this->acf_text([
                    'id' => $this->id( 500, 10, 400, 50 ),
                    'name' => 'coordinates',
                    'label' => 'Координаты',
                    'instructions' => 'Пример: <b>41.413674, 2.150720</b>',
                    'wrapper' => [ 'width' => 100 ],
                  ]),
                ],
              ),
            ],
          ]), // $this->acf_flexible_content
        ],
      ]), // $this->acf_repeater

    ]; // $this->active_acf_1
  }


  public function acf_init() {
    if( function_exists('acf_add_local_field_group') ) {
      $this->register_acf_group([
        'title' => $this->active_acf_1_title,
        'group_key' => $this->acf_group_key,
        'fields' => $this->active_acf_1,
        'location' => $this->location,
      ]);
    };
  }
  
} // class ACF_CONSTRUCTOR_CONTACTS