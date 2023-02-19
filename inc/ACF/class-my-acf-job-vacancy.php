<?php

class MY_ACF_JOB_VACANCY extends MY_ACF {
  // use in acf_add_local_field_group() 
  public $acf_group_key = 'acfconst_' . MY_CPT_JOB_VACANCY . '_group_key';

  public $active_acf_1;
  public $active_acf_1_title = 'Настройка';

  // public $active_acf_2;
  // public $active_acf_2_title = 'Форма обратной связи';

  public $location;

  public $acf;

  public $excluded_fields;

  public $unique_id_prefix = MY_CPT_JOB_VACANCY;

  /**
   * @param Array $args
   *    @param Array $args['location'] - where to print this ACF
   *    @param Array $args['exclude_fields'] - array of field names that you want to exclude
   */
  public function __construct( $args=[] ) {
    $this->location = [
      [
        [
          'param' => 'post_type',
          'operator' => '==',
          'value' => MY_CPT_JOB_VACANCY,
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

    $this->active_acf_1 = [
      $this->acf_text([
        'id' => $this->id( 'aa1', 100 ),
        'name' => 'working_position',
        'label' => 'Должность',
        'wrapper' => [ 'width' => 33 ],
        'required' => true,
      ]),
      $this->acf_text([
        'id' => $this->id( 'aa1', 200 ),
        'name' => 'wage',
        'label' => 'з/п',
        'wrapper' => [ 'width' => 33 ],
        'required' => true,
      ]),
      $this->acf_text([
        'id' => $this->id( 'aa1', 300 ),
        'name' => 'city',
        'label' => 'Город',
        'wrapper' => [ 'width' => 33 ],
        'required' => true,
      ]),
    ]; // $this->active_acf_1

    // $this->active_acf_2 = $this->acf_post_form([
    //   'id' => 'aa2',
    //   'form_post_type' => MY_CPT_SITE_FORM,
    // ]); // active_acf_2

  }


  public function acf_init() {
    if( function_exists('acf_add_local_field_group') ) {
      $this->register_acf_group([
        'title' => $this->active_acf_1_title,
        'group_key' => $this->acf_group_key . '_aa1',
        'fields' => $this->active_acf_1,
        'location' => $this->location,
      ]);
      // $this->register_acf_group([
      //   'title' => $this->active_acf_2_title,
      //   'group_key' => $this->acf_group_key . '_aa2',
      //   'fields' => $this->active_acf_2,
      //   'location' => $this->location,
      // ]);
    };
  }
  
} // class:end