<?php

class MY_ACF_SITE_FORM extends MY_ACF {
  // use in acf_add_local_field_group() 
  public $acf_group_key = 'acfconst_' . MY_CPT_SITE_FORM . '_group_key';

  public $active_acf_0;
  public $active_acf_0_title = 'Настройка формы';

  // public $active_acf_1;
  // public $active_acf_1_title = 'Информации страницы';

  public $location;

  public $acf;

  public $excluded_fields;

  public $unique_id_prefix = MY_CPT_SITE_FORM;

  public $form_ids_with_description = [];

  public function __construct() {
    $this->location = [
      [
        [
          'param' => 'post_type',
          'operator' => '==',
          'value' => MY_CPT_SITE_FORM,
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
    $this->active_acf_0 = array_merge(
      [
        $this->acf_true_false([
          'id' =>  $this->id( 'aa0', 40 ),
          'name' => 'use_dialog_form_data',
          'label' => '',
          'message' => 'Доп. инф-ия для всплывающего окна формы',
          'default_value' => 0,
          'wrapper' => [ 'width' => 100 ],
        ]),
        $this->acf_group([
          'id' =>  $this->id( 'aa0', 50 ),
          'name' => 'dialog_data',
          'label' => 'Окно диалога',
          'layout' => 'block',
          'conditional_logic' => array(
            [
              'field' => $this->id( 'aa0', 40 ),
              'operator' => '==',
              'value' => 1,
            ],
          ),
          'sub_fields' => [
            $this->acf_text([
              'id' => $this->id( 'aa0', 50, 100 ),
              'name' => 'title',
              'label' => 'Заголовок карточки формы',
              'wrapper' => [ 'width' => 100 ],
            ]),
            $this->acf_wysiwyg_editor([
              'id' => $this->id( 'aa0', 50, 200 ),
              'name' => 'description',
              'label' => 'Описание',
              'wrapper' => [ 'width' => 100 ],
            ]),
          ] // sub_fields
        ])
      ],
      $this->acf_form([
        'id' => $this->id( 'aa0', 100 ),
        'name' => 'form',
      ])
    ); // $this->active_acf_0



    $this->active_acf_1 = [
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
      // $this->register_acf_group([
      //   'title' => $this->active_acf_1_title,
      //   'group_key' => $this->acf_group_key . '_aa1',
      //   'fields' => $this->active_acf_1,
      //   'location' => $this->location,
      // ]);
    };
  }
  
} // class:end