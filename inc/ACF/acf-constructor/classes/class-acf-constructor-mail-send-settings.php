<?php

class ACF_CONSTRUCTOR_MAIL_SEND_SETTINGS extends ACF_CONSTRUCTOR {
  // use in acf_add_local_field_group() 
  public $acf_group_key = 'acfconst_' . 'mail_send_settings' . '_group_key';

  public $active_acf_1;
  public $active_acf_1_title = 'Настройка отправки почты';

  public $location;

  public $acf;

  public $excluded_fields;

  public $unique_id_prefix = 'mail_send_settings';

  /**
   * @param Array $args
   *    @param Array $args['location'] - where to print this ACF
   *    @param Array $args['exclude_fields'] - array of field names that you want to exclude
   */
  public function __construct( $args=[] ) {
    require  __ACf_CONSTUCTOR_ABSPATH__ . "/classes/functions/mail-send-settings.php";

    /* LOCATION */
    if (array_key_exists('location', $args)) {
      $this->location = $args['location'];
    }
    else {
      $this->location = [
        array(
          [
            'param' => 'page',
            'operator' => '==',
            'value' => get_option( '__mail_send_settings__' ),
          ],
        ),
      ];
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

      in_array('dev_emails', $this->excluded_fields)? [] : $this->acf_textarea([
        'id' => $this->id( 100 ),
        'name' => 'dev_emails',
        'label' => 'Почта разработчика',
        'instructions' => 'Разделители адресов: <span style="color:blue">«,»</span> <span style="color:blue">«;»</span> <span style="color:blue">« »</span> и <span style="color:blue">перенос строки</span>',
        'rows' => 6,
        'new_lines' => '',
      ]), // acf_group
      in_array('dev_emails', $this->excluded_fields)? [] : $this->acf_textarea([
        'id' => $this->id( 200 ),
        'name' => 'order_emails',
        'label' => 'Почта для получения заявок',
        'instructions' => 'Разделители адресов: <span style="color:blue">«,»</span> <span style="color:blue">«;»</span> <span style="color:blue">« »</span> и <span style="color:blue">перенос строки</span>',
        'rows' => 6,
        'new_lines' => '',
      ]), // acf_group

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
  
} // class ACF_CONSTRUCTOR_MAIL_SEND_SETTINGS