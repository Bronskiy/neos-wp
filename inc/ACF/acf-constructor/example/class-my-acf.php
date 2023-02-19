<?php
require_once 'acf-constructor/class-acf-constructor.php';

class MY_ACF extends ACF_CONSTRUCTOR {

  // public $acf_classes; (inherited)

  // public $acf_class_set; (inherited)

  // public $uniqueId; (inherited)

  public function register() {
    if (false) $this->remove_acf_from_admin();
    $this->register_acf_base(); // from ACF_CONSTRUCTOR class
    $this->register_acf_classes();
  }

  public function register_acf_classes() {

    /*1*/ $this->acf_classes = (object) [
      // 'contacts' => (object) [
      //   'require' => 'class-my-acf-contacts.php', // path/to/classFile
      //   'class' => 'MY_ACF_CONTACTS', // class name
      // ],
    ];

    $pluged_acf_templates = [
      'seo' => [
        'location' => [
          array(
            [
              'param' => 'post_type',
              'operator' => '==',
              'value' => 'post',
            ],
            [
              'param' => 'page',
              'operator' => '!=',
              'value' => get_option( 'wp_page_for_privacy_policy' ),
            ],
          ),
          array(
            [
              'param' => 'post_type',
              'operator' => '==',
              'value' => 'post',
            ],
          ),
        ] // location
      ],
      'contacts' => [
        'location' => [
          array(
            [
              'param' => 'post_type',
              'operator' => '==',
              'value' => MY_CPT_SETTINGS, // __settings
            ],
            [
              'param' => 'page',
              'operator' => '==',
              'value' => get_option( '__contact_post_id__' ),
            ],
          ),
        ], // location
        'exclude_fields' => [ 'requisites' ],
      ],
      'front-page' => [],
      'mail-send-settings' => [],
      'products' => [
        'location' => [
          array(
            [
              'param' => 'post_type',
              'operator' => '==',
              'value' => MY_CPT_PRODUCT, // __product
            ],
          ),
        ]
      ],
    ];
    /*2*/ $this->plug_base_acf_class_template( $pluged_acf_templates );

    foreach ($this->acf_classes as $k => $v) {
      require_once $v->require;
      $args = array_key_exists('constructor_args', (array) $v)? $v->constructor_args : [];
      $class = new $v->class($args);
      $class->register();
      $this->{$k} = $class;
    }
  }
}