<?php
require_once 'constants.php';
require_once 'functions/utilities.php';

class ACF_CONSTRUCTOR {

  public $acf_classes;

  public $acf_class_set;

  public $uniqueId = 0;


/******************** REGISTRATION:start ********************/
  public function register_acf_base() {
    global $MY_ACf; $MY_ACf = $this;
    $this->add_acf_css_to_admin();
    $this->register_acf_class_set();
  }


  public function register_acf_class_set() {
    $this->acf_classes = (object) $this->acf_class_set = (object) [
      'seo' => (object) [
        'require' => 'classes/class-acf-constructor-seo.php',
        'class' => 'ACF_CONSTRUCTOR_SEO',
      ],
      'contacts' => (object) [
        'require' => 'classes/class-acf-constructor-contacts.php',
        'class' => 'ACF_CONSTRUCTOR_CONTACTS',
      ],
      'front-page' => (object) [
        'require' => 'classes/class-acf-constructor-front-page.php',
        'class' => 'ACF_CONSTRUCTOR_FRONT_PAGE',
      ],
      'products' => (object) [
        'require' => 'classes/class-acf-constructor-products.php',
        'class' => 'ACF_CONSTRUCTOR_PRODUCTS',
      ],
      'mail-send-settings' => (object) [
        'require' => 'classes/class-acf-constructor-mail-send-settings.php',
        'class' => 'ACF_CONSTRUCTOR_MAIL_SEND_SETTINGS',
      ],
    ];
  }


  public function register_acf_classes() {
    foreach ($this->acf_classes as $k => $v) {
      require_once $v->require;
      $class = new $v->class;
      $class->register();
      $this->{$k} = $class;
    }
  }


  public function plug_base_acf_class_template( $key_names ) {
    foreach ($key_names as $key_name => $v) {
      if (array_key_exists($key_name, (array) $this->acf_class_set)) {
        $classObj = (object) $this->acf_class_set->{$key_name};
        $classObj->require = 'acf-constructor/' . $classObj->require;
        if ($v) $classObj->constructor_args = $v;
        $this->acf_classes->{$key_name} = $classObj;
      }
    }
  }
  /******************** REGISTRATION:end ********************/


  public function id( $idArray ) {
    if (!is_array($idArray)) $idArray = func_get_args();
    $id = array_shift($idArray);
    foreach ($idArray as $subId) $id .= "_$subId";
    return $this->unique_id_prefix . '_' . $id;
  }

  
  public function remove_acf_from_admin() {
    add_filter('acf/settings/show_admin', '__return_false');
  }


  /**
   * Set default ACF name & return $args from $id_or_args and $args
   * @param Array $args - $args of parent function
   */
  public function get_args( $id_or_args=[], $args=[], $acfDefaultName='' ) {
    if (is_int($id_or_args) || is_string($id_or_args)) $args['id'] = $id_or_args;
    else if (is_array($id_or_args)) $args = $id_or_args;

    if ($acfDefaultName) {
      if (!isset($args['name'])) $args['name'] = $acfDefaultName;
      $this->acf->{$args['name']} = $args['name'];
    }

    if (!isset($args['id']) || !$args['id']) trigger_error("Не указан 'id' для ACF ({$this->acf_group_key})", E_USER_ERROR);
    return $args;
  }


  public function add_acf_css_to_admin() {
    add_action( 'admin_enqueue_scripts', function() {
      wp_enqueue_style( 'admin_acf_css', get_template_directory_uri() . __ACF_FOLDER_PATH_FROM_THEME__ . '/acf-constructor/css/admin-acf-styles.css', false, '1.0.1' );
    });
  }


  public function label($string, $acf_name) {
    return __ACF_BASE_IS_IN_DEV__?
      $string . " <i class='acf_field_name'>($acf_name)</i>"
      : $string
    ;
  }


  public function register_acf_group($args) {
    acf_add_local_field_group([
      'key' => isset($args['group_key'])? $args['group_key'] : trigger_error('group_key is not set!!!', E_USER_ERROR),
      'title' => isset($args['title'])? $args['title'] : trigger_error('title is not set!!!', E_USER_ERROR),
      'fields' => isset($args['fields'])? $args['fields'] : trigger_error('fields is not set!!!', E_USER_ERROR),
      'location' => isset($args['location'])? $args['location'] : trigger_error('location is not set!!!', E_USER_ERROR),
      'label_placement' => 'top',
      'instruction_placement' => 'label',
      'active' => true,
    ]);
  }

  /* add field_name: Fields label (field_name) */
  public function set_label_to_acf_fields_arr($arr) {
    foreach ($arr as $key => $v) {
      if (array_key_exists('label', $v)) {
        $arr[$key]['label'] = $this->label($v['label'], $v['name']);
      }
    }
    return $arr;
  }




































  /******************** MAIN BASE TEMPLATES:start ********************/

  /********************************/
  /********** The Basic ***********/
  /********************************/

  function acf_text( $id_or_args=[], $args=[] ) {
    $args = $this->get_args( $id_or_args, $args, 'text');
    return [
      'key' => $args['id'],
      'label' => $this->label(isset($args['label']) ? $args['label'] : 'Text', $args['name']),
      'name' => $args['name'],
      'type' => isset($args['type']) ? $args['type'] : 'text',
      'instructions' => isset($args['instructions']) ? $args['instructions'] : '',
      'required' => isset($args['required'])? $args['required'] : 0,
      'conditional_logic' => isset($args['conditional_logic'])? $args['conditional_logic'] : 0,
      'wrapper' => isset($args['wrapper'])? $args['wrapper'] : array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'default_value' => isset($args['default_value'])? $args['default_value'] : '',
      'placeholder' => isset($args['placeholder'])? $args['placeholder'] : '',
      'prepend' => isset($args['prepend'])? $args['prepend'] : '',
      'append' => isset($args['append'])? $args['append'] : '',
      'maxlength' => isset($args['maxlength'])? $args['maxlength'] : '',
    ];
  }

  function acf_textarea( $id_or_args=[], $args=[] ) {
    $args = $this->get_args( $id_or_args, $args, 'textarea');
    return [
      'key' => $args['id'],
      'label' => $this->label(isset($args['label']) ? $args['label'] : 'Textarea', $args['name']),
      'name' => $args['name'],
      'type' => 'textarea',
      'instructions' => isset($args['instructions']) ? $args['instructions'] : '',
      'required' => isset($args['required'])? $args['required'] : 0,
      'conditional_logic' => isset($args['conditional_logic'])? $args['conditional_logic'] : 0,
      'wrapper' => isset($args['wrapper'])? $args['wrapper'] : array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'default_value' => isset($args['default_value'])? $args['default_value'] : '',
      'placeholder' => isset($args['placeholder'])? $args['placeholder'] : '',
      'maxlength' => isset($args['maxlength'])? $args['maxlength'] : '',
      'rows' => isset($args['rows'])? $args['rows'] : 4,
      'new_lines' => isset($args['new_lines'])? $args['new_lines'] : 'br', // 'wpautop' | '' | 'br'
    ];
  }

  function acf_number( $id_or_args=[], $args=[] ) {
    $args = $this->get_args( $id_or_args, $args, 'text');
    return [
      'key' => $args['id'],
      'label' => $this->label(isset($args['label']) ? $args['label'] : 'Text', $args['name']),
      'name' => $args['name'],
      'type' => 'number',
      'instructions' => isset($args['instructions']) ? $args['instructions'] : '',
      'required' => isset($args['required'])? $args['required'] : 0,
      'conditional_logic' => isset($args['conditional_logic'])? $args['conditional_logic'] : 0,
      'wrapper' => isset($args['wrapper'])? $args['wrapper'] : array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'default_value' => isset($args['default_value'])? $args['default_value'] : '',
      'placeholder' => isset($args['placeholder'])? $args['placeholder'] : '',
      'prepend' => isset($args['prepend'])? $args['prepend'] : '',
			'min' => isset($args['min'])? $args['min'] : '',
			'max' => isset($args['max'])? $args['max'] : '',
			'step' => isset($args['step'])? $args['step'] : '',
    ];
  }





  
  /********************************/
  /********** The Content *********/
  /********************************/

  function acf_image( $id_or_args=[], $args=[] ) {
    $args = $this->get_args( $id_or_args, $args, 'image');
    return [
      'key' => $args['id'],
      'label' => $this->label(isset($args['label']) ? $args['label'] : 'Image', $args['name']),
      'name' => $args['name'],
			'type' => 'image',
      'instructions' => isset($args['instructions']) ? $args['instructions'] : '',
      'required' => isset($args['required'])? $args['required'] : 0,
      'conditional_logic' => isset($args['conditional_logic'])? $args['conditional_logic'] : 0,
      'wrapper' => isset($args['wrapper'])? $args['wrapper'] : array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
			'return_format' =>  isset($args['return_format']) ? $args['return_format'] : 'array', // array | ...
			'preview_size' =>  isset($args['preview_size']) ? $args['preview_size'] : 'large', // medium | thumbnail | large | ...
			'library' =>  isset($args['library']) ? $args['library'] : 'all',
			'min_width' => isset($args['min_width']) ? $args['min_width'] : '',
			'min_height' => isset($args['min_height']) ? $args['min_height'] : '',
			'min_size' => isset($args['min_size']) ? $args['min_size'] : '',
			'max_width' => isset($args['max_width']) ? $args['max_width'] : '',
			'max_height' => isset($args['max_height']) ? $args['max_height'] : '',
			'max_size' => isset($args['max_size']) ? $args['max_size'] : '',
			'mime_types' => isset($args['mime_types']) ? $args['mime_types'] : '',
    ];
  }

  function acf_file( $id_or_args=[], $args=[] ) {
    $args = $this->get_args( $id_or_args, $args, 'image');
    return [
      'key' => $args['id'],
      'label' => $this->label(isset($args['label']) ? $args['label'] : 'Image', $args['name']),
      'name' => $args['name'],
			'type' => 'file',
      'instructions' => isset($args['instructions']) ? $args['instructions'] : '',
      'required' => isset($args['required'])? $args['required'] : 0,
      'conditional_logic' => isset($args['conditional_logic'])? $args['conditional_logic'] : 0,
      'wrapper' => isset($args['wrapper'])? $args['wrapper'] : array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
			'return_format' =>  isset($args['return_format']) ? $args['return_format'] : 'array', // array | url | ...
			'library' =>  isset($args['library']) ? $args['library'] : 'all',
			'min_size' => isset($args['min_size']) ? $args['min_size'] : '',
			'max_size' => isset($args['max_size']) ? $args['max_size'] : '',
      'mime_types' => isset($args['mime_types']) ? $args['mime_types'] : '',
    ];
  }

  function acf_wysiwyg_editor( $id_or_args=[], $args=[] ) {
    $args = $this->get_args( $id_or_args, $args, 'wysiwyg');
    return [
      'key' => $args['id'],
      'label' => $this->label(isset($args['label']) ? $args['label'] : 'wysiwyg', $args['name']),
      'name' => $args['name'],
			'type' => 'wysiwyg',
			'instructions' => isset($args['instructions']) ? $args['instructions'] : '',
			'required' => isset($args['required']) ? $args['required'] : 0,
			'conditional_logic' => isset($args['conditional_logic']) ? $args['conditional_logic'] : 0,
      'wrapper' => isset($args['wrapper'])? $args['wrapper'] : array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => isset($args['default_value']) ? $args['default_value'] : '',
			'tabs' => isset($args['tabs']) ? $args['tabs'] : 'all',
			'toolbar' => isset($args['toolbar']) ? $args['toolbar'] : 'full', // full | basic
			'media_upload' => isset($args['media_upload']) ? $args['media_upload'] : 0,
			'delay' => isset($args['delay']) ? $args['delay'] : 0,
    ];
  }


  function acf_gallery( $id_or_args=[], $args=[] ) {
    $args = $this->get_args( $id_or_args, $args, 'gallery');

    return [
      'key' => $args['id'],
      'label' => $this->label(isset($args['label']) ? $args['label'] : 'Gallery', $args['name']),
      'name' => $args['name'],
      'type' => 'gallery',
			'instructions' => isset($args['instructions']) ? $args['instructions'] : 0,
			'return_format' => isset($args['return_format']) ? $args['return_format'] : 'array', // array | url? | id?
      'required' => isset($args['required']) ? $args['required'] : 0,
      'conditional_logic' => isset($args['conditional_logic']) ? $args['conditional_logic'] : 0,
      'preview_size' => isset($args['preview_size']) ? $args['preview_size'] : 'medium',
      'insert' => isset($args['insert']) ? $args['insert'] : 'append',
      'library' => isset($args['library']) ? $args['library'] : 'all',
			'min' => isset($args['min']) ? $args['min'] : '',
			'max' => isset($args['max']) ? $args['max'] : '',
			'min_width' => isset($args['min_width']) ? $args['min_width'] : '',
			'min_height' => isset($args['min_height']) ? $args['min_height'] : '',
			'min_size' => isset($args['min_size']) ? $args['min_size'] : '',
			'max_width' => isset($args['max_width']) ? $args['max_width'] : '',
			'max_height' => isset($args['max_height']) ? $args['max_height'] : '',
			'max_size' => isset($args['max_size']) ? $args['max_size'] : '',
      'mime_types' => isset($args['mime_types']) ? $args['mime_types'] : '',
      'wrapper' => isset($args['wrapper'])? $args['wrapper'] : array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
    ];
  }





  
  /********************************/
  /********** The Choice **********/
  /********************************/

  function acf_select( $id_or_args=[], $args=[] ) {
    $args = $this->get_args( $id_or_args, $args, 'select');
    return array(
      'key' => $args['id'],
      'label' => $this->label(isset($args['label']) ? $args['label'] : 'Select', $args['name']),
			'name' => $args['name'],
			'type' => 'select',
			'instructions' => isset($args['instructions'])? $args['instructions'] : '',
      'required' => isset($args['required'])? $args['required'] : 0,
      'conditional_logic' => isset($args['conditional_logic'])? $args['conditional_logic'] : 0,
      'wrapper' => isset($args['wrapper'])? $args['wrapper'] : array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'choices' => isset($args['choices']) ? $args['choices'] : [
        // 'red' => 'red',
				// 'blue' => 'blue',
				// 'green' => 'green',
      ],
      'default_value' => isset($args['default_value']) ? $args['default_value'] : [
        // 0 => 'red',
      ],
			'allow_null' => isset($args['allow_null'])? $args['allow_null'] : 0,
			'multiple' => isset($args['multiple'])? $args['multiple'] : 0,
			'ui' => isset($args['ui'])? $args['ui'] : 0,
			'return_format' => isset($args['return_format'])? $args['return_format'] : 'value', // value | label | array
			'ajax' => isset($args['ajax'])? $args['ajax'] : 0,
			'placeholder' => isset($args['placeholder'])? $args['placeholder'] : '',
    );
  }

  function acf_radio( $id_or_args=[], $args=[] ) {
    $args = $this->get_args( $id_or_args, $args, 'radio');
    return array(
      'key' => $args['id'],
      'label' => $this->label(isset($args['label']) ? $args['label'] : 'Radio', $args['name']),
			'name' => $args['name'],
			'type' => 'radio',
			'instructions' => isset($args['instr'])? $args['instr'] : '',
      'required' => isset($args['required'])? $args['required'] : 0,
      'choices' => isset($args['choices']) ? $args['choices'] : [1 => 'Yes'], // value => label
      'layout' => isset($args['layout']) ? $args['layout'] : 'horizontal', // vertical | horizontal
      'default_value' => isset($args['default_value']) ? $args['default_value'] : [],
      'return_format' => isset($args['return_format']) ? $args['return_format'] : 'value', // value | label | array
      'conditional_logic' => isset($args['conditional_logic']) ? $args['conditional_logic'] : [],
      'wrapper' => isset($args['wrapper'])? $args['wrapper'] : array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
			'allow_null' => isset($args['allow_null'])? $args['allow_null'] : 0,
      'other_choice' => isset($args['other_choice']) ? $args['other_choice'] : 0,
      'save_other_choice' => isset($args['save_other_choice']) ? $args['save_other_choice'] : 0,
		);
  }

  function acf_true_false( $id_or_args=[], $args=[] ) {
    $args = $this->get_args( $id_or_args, $args, 'true_false');
    return [
      'key' => $args['id'],
      'label' => $this->label(isset($args['label']) ? $args['label'] : 'true_false', $args['name']),
      'name' => $args['name'],
      'instructions' => isset($args['instr']) ? $args['instr'] : '',
      'type' => 'true_false',
      'required' => isset($args['required'])? $args['required'] : 0,
      'default_value' => isset($args['default_value'])? $args['default_value'] : 1,
      'message' => isset($args['message'])? $args['message'] : 'message is here',
      'conditional_logic' => isset($args['conditional_logic'])? $args['conditional_logic'] : 0,
      'wrapper' => isset($args['wrapper'])? $args['wrapper'] : array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
			'ui' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
    ];
  }
  





  /********************************/
  /********** The Relation ********/
  /********************************/

  function acf_link( $id_or_args=[], $args=[] ) {
    $args = $this->get_args( $id_or_args, $args, 'Link');
    return [
      'key' => $args['id'],
      'label' => $this->label(isset($args['label']) ? $args['label'] : 'Link', $args['name']),
      'name' => $args['name'],
			'type' => 'link',
      'instructions' => isset($args['instructions']) ? $args['instructions'] : '',
      'required' => isset($args['required'])? $args['required'] : 0,
      'conditional_logic' => isset($args['conditional_logic'])? $args['conditional_logic'] : 0,
      'wrapper' => isset($args['wrapper'])? $args['wrapper'] : array(
				'width' => '',
				'class' => '',
				'id' => '',
      ),
      // url | array
			'return_format' => isset($args['return_format'])? $args['return_format'] : 'array',
    ];
  }


  function acf_post_object( $id_or_args=[], $args=[] ) {
    $args = $this->get_args( $id_or_args, $args, 'Link');
    return [
      'key' => $args['id'],
      'label' => $this->label(isset($args['label']) ? $args['label'] : 'Post Object', $args['name']),
      'name' => $args['name'],
			'type' => 'post_object',
			'instructions' => isset($args['instructions'])? $args['instructions'] : '',
			'required' => isset($args['required'])? $args['required'] : 0,
			'conditional_logic' => isset($args['conditional_logic'])? $args['conditional_logic'] : 0,
      'wrapper' => isset($args['wrapper'])? $args['wrapper'] : array(
				'width' => '',
				'class' => '',
				'id' => '',
      ),
			'post_type' => isset($args['post_type'])? $args['post_type'] : [], // aray of post_type's. Example: [ 'scheme_data' ]
			'taxonomy' => isset($args['taxonomy'])? $args['taxonomy'] : '',
			'allow_null' => isset($args['allow_null'])? $args['allow_null'] : 0,
			'multiple' => isset($args['multiple'])? $args['multiple'] : 0,
			'return_format' => isset($args['return_format'])? $args['return_format'] : 'id', // object || id
			'ui' => isset($args['ui'])? $args['ui'] : 1,
    ];
  }


  function acf_taxonomy( $id_or_args=[], $args=[] ) {
    $args = $this->get_args( $id_or_args, $args, 'taxonomy');
    return [
      'key' => $args['id'],
      'label' => $this->label(isset($args['label']) ? $args['label'] : 'Post Object', $args['name']),
      'name' => $args['name'],
			'type' => 'taxonomy',
			'instructions' => isset($args['instructions'])? $args['instructions'] : '',
			'required' => isset($args['required'])? $args['required'] : 0,
			'conditional_logic' => isset($args['conditional_logic'])? $args['conditional_logic'] : 0,
      'wrapper' => isset($args['wrapper'])? $args['wrapper'] : array(
				'width' => '',
				'class' => '',
				'id' => '',
      ),
      'taxonomy' => isset($args['taxonomy'])? $args['taxonomy'] : '',
      'field_type' => isset($args['field_type'])? $args['field_type'] : 'radio', // radio | select
      'allow_null' => isset($args['allow_null'])? $args['allow_null'] : 0,
			'multiple' => isset($args['multiple'])? $args['multiple'] : 0,
			'return_format' => isset($args['return_format'])? $args['return_format'] : 'id', // object || id
      'add_term' => isset($args['add_term'])? $args['add_term'] : 1,
      'save_terms' => isset($args['save_terms'])? $args['save_terms'] : 0,
      'load_terms' => isset($args['load_terms'])? $args['load_terms'] : 0,
    ];

  }





  /********************************/
  /************ JQuery ************/
  /********************************/

  // "ACF RGBA Color Picker" plugin is demanded (https://wordpress.org/plugins/acf-rgba-color-picker/#description)
  function acf_RGBA_color_picker( $id_or_args=[], $args=[] ) {
    $args = $this->get_args( $id_or_args, $args, 'image');
    return [
      'key' => $args['id'],
      'label' => $this->label(isset($args['label']) ? $args['label'] : 'Image', $args['name']),
      'name' => $args['name'],
			'type' => 'extended-color-picker',
      'instructions' => isset($args['instructions']) ? $args['instructions'] : '',
      'required' => isset($args['required'])? $args['required'] : 0,
      'conditional_logic' => isset($args['conditional_logic'])? $args['conditional_logic'] : 0,
      'wrapper' => isset($args['wrapper'])? $args['wrapper'] : array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'default_value' =>  isset($args['default_value']) ? $args['default_value'] : '',
      'color_palette' => isset($args['color_palette']) ?
        $args['color_palette'] :
        '#f9f9f9; #d6d6d6; #aaa; #f15a29; #0645ad; #0a58ca; #384c7e; #151313;',
      'hide_palette' =>  isset($args['hide_palette']) ? $args['hide_palette'] : 0,
    ];
  }

  function acf_date_time( $id_or_args=[], $args=[] ) {
    $args = $this->get_args( $id_or_args, $args, 'date_time_picker');
    return [
      'key' => $args['id'],
      'label' => $this->label(isset($args['label']) ? $args['label'] : 'Дата', $args['name']),
      'name' => $args['name'],
      'instructions' => isset($args['instr']) ? $args['instr'] : '',
      'type' => isset($args['type']) ? $args['type'] : 'date_time_picker', // time_picker | date_picker | time_picker
      'required' => isset($args['required'])? $args['required'] : 0,
      'conditional_logic' => isset($args['conditional_logic'])? $args['conditional_logic'] : 0,
      'display_format' => isset($args['display_format']) ? $args['display_format'] : 'd.m.Y H:i',
      'return_format' => isset($args['return_format']) ? $args['return_format'] : 'd.m.Y H:i',
			'first_day' => isset($args['return_format']) ? $args['return_format'] : 1,
      'wrapper' => isset($args['wrapper'])? $args['wrapper'] : array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
    ];
  }





  /********************************/
  /********** The Layout **********/
  /********************************/

  function acf_message( $id_or_args=[], $args=[] ) {
    $args = $this->get_args( $id_or_args, $args, 'Message');
    return [
      'key' => $args['id'],
      'label' => $this->label(isset($args['label']) ? $args['label'] : 'Message', $args['name']),
      'name' => $args['name'],
      'type' => 'message',
      'instructions' => isset($args['instructions']) ? $args['instructions'] : '',
      'required' => isset($args['required'])? $args['required'] : 0,
      'conditional_logic' => isset($args['conditional_logic'])? $args['conditional_logic'] : 0,
      'wrapper' => isset($args['wrapper'])? $args['wrapper'] : array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'message' => isset($args['message'])? $args['message'] : 'Message is here...',
      // 'wpautop' - automatically add <p></p>
      // '' - no foramting
      // 'br' - add <br/>
      'new_lines' => isset($args['new_lines'])? $args['new_lines'] :  'wpautop',
      'esc_html' => isset($args['esc_html'])? $args['esc_html'] :  0,
    ];
  }


  function acf_group( $id_or_args=[], $args=[] ) {
    $args = $this->get_args( $id_or_args, $args, 'Group');
    return [
      'key' => $args['id'],
      'label' => $this->label(isset($args['label']) ? $args['label'] : 'Group', $args['name']),
      'name' => $args['name'],
      'instructions' => isset($args['instructions']) ? $args['instructions'] : '',
      'type' => 'group',
      'required' => isset($args['required'])? $args['required'] : 0,
      'conditional_logic' => isset($args['conditional_logic'])? $args['conditional_logic'] : 0,
      'layout' => isset($args['layout']) ? $args['layout'] : 'block', // table || block || row
      'sub_fields' => isset($args['sub_fields']) ? $args['sub_fields'] : [],
      'wrapper' => isset($args['wrapper'])? $args['wrapper'] : array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
    ];
  }
  

  function acf_repeater( $id_or_args=[], $args=[] ) {
    $args = $this->get_args( $id_or_args, $args, 'Repeater');
    return [
      'key' => $args['id'],
      'label' => $this->label(isset($args['label']) ? $args['label'] : 'Repeater', $args['name']),
      'name' => $args['name'],
      'type' => 'repeater',
      'instructions' => isset($args['instructions']) ? $args['instructions'] : '',
      'required' => isset($args['required'])? $args['required'] : 0,
      'conditional_logic' => isset($args['conditional_logic']) ? $args['conditional_logic'] : [],
      'wrapper' => isset($args['wrapper'])? $args['wrapper'] : array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      // what field to display on collapse? $args['collapsed'] === field_key
      'collapsed' => isset($args['collapsed']) ? $args['collapsed'] : 0,
      'min' => isset($args['min']) ? $args['min'] : 0,
      'max' => isset($args['max']) ? $args['max'] : 0,
      'layout' => isset($args['layout']) ? $args['layout'] : 'table', // table || block || row
      // add button label
      'button_label' => isset($args['button_label']) ? $args['button_label'] : 'Добавить',
      'sub_fields' => isset($args['sub_fields']) ? $args['sub_fields'] : [],
    ];
  }

  function acf_flexible_content( $id_or_args=[], $args=[] ) {
    $args = $this->get_args( $id_or_args, $args, 'flexible_content');
    return [
      'key' => $args['id'],
      'label' => $this->label(isset($args['label']) ? $args['label'] : 'Flexible_content', $args['name']),
      'name' => $args['name'],
      'type' => 'flexible_content',
      'instructions' => isset($args['instructions']) ? $args['instructions'] : '',
      'required' => isset($args['required'])? $args['required'] : 0,
      'conditional_logic' => isset($args['conditional_logic'])? $args['conditional_logic'] : 0,
      'wrapper' => isset($args['wrapper'])? $args['wrapper'] : array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'layouts' => isset($args['layouts']) ? $this->set_label_to_acf_fields_arr($args['layouts']) : [
        //  'key' => String,
        //  'name' => String,
        //  'label' => String,
        //  'display' => String, // table || block || row
        //  'sub_fields' => Array,
        //  'min' => String,
        //  'max' => String,
      ],
      'button_label' => isset($args['button_label'])? $args['button_label'] : 'Добавить',
      'min' => isset($args['min'])? $args['min'] : '',
      'max' => isset($args['max'])? $args['max'] : '',
    ];
  }
  /******************** MAIN BASE TEMPLATES:end ********************/




















  /******************** COMPLEX TEMPLATES:start ********************/
  function acf_event_js_code( $id_or_args=[], $args=[] ) {
    $args = $this->get_args( $id_or_args, $args, 'js_code');
    return $this->acf_textarea([
      'id' => $this->id( $args['id'] ),
      'name' => $args['name'],
      'label' => isset($args['label'])? $args['label'] : 'js, выполняющийся при вызове события',
      'instructions' => isset($args['instructions'])? $args['instructions'] : 'Передает параметр "e" === event',
      'default_value' => '',
      'rows' => isset($args['rows'])? $args['rows'] : 3,
      'wrapper' => isset($args['wrapper'])? $args['wrapper'] : array(
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'new_lines' => '',
    ]);
  }

  function acf_link_set( $id_or_args=[], $args=[] ) {
    $args = $this->get_args( $id_or_args, $args, 'link_set' );
    return array(
      $this->acf_icon_name([
        'id' => $this->id( $args['id'], 0 ),
        'wrapper' => [ 'width' => 15 ],
        ]),
      $this->acf_text([
        'id' => $this->id( $args['id'], 10 ),
        'name' => 'prefix',
        'label' => 'Префикс',
        'wrapper' => [ 'width' => 25 ],
      ]),
      $this->acf_link([
        'id' => $this->id( $args['id'], 20 ),
        'name' => 'link',
        'label' => 'Ссылка',
        'instructions' => '<a href="https://bitbucket.org/evgeny_ms_/acf-constructor/src/master/guide/links.md" target="_blank">Как создавать URL-ссылки</a>',
        'wrapper' => [ 'width' => 35 ],
      ]),
      $this->acf_text([
        'id' => $this->id( $args['id'], 30 ),
        'name' => 'postfix',
        'label' => 'Постфикс',
        'wrapper' => [ 'width' => 25 ],
      ]),
      $this->acf_textarea([
        'id' => $this->id( $args['id'], 40 ),
        'name' => 'link_attributes',
        'label' => 'Атрибуты тега &lt;а&gt;&lt;/a&gt; (продвинутая настройка)',
        'instructions' => 'Текст напрямую подставлять в тег. Пишите, соблюдая все правила написания html кода, например, <code>data-id="23" target=\'hidden-iframe\'</code>',
        'wrapper' => [ 'width' => 100 ],
        'placeholder' => '',
        'rows' => 2,
        'new_lines' => '',
      ]),
    );
  }



  /* acf form for post */
  function acf_post_form( $id_or_args=[], $args=[] ) {
    $args = $this->get_args( $id_or_args, $args );
    $useTemplateForm = [
      array(
        [
          'field' => $this->id( $args['id'], 100 ),
          'operator' => '==',
          'value' => '0',
        ],
      ),
    ];
    return array_merge(
      [
        $this->acf_true_false([
          'id' => $this->id( $args['id'], 100 ),
          'name' => 'use_custom_form',
          'label' => '',
          'message' => 'Использовать уникальную форму для страницы/поста',
          'default_value' => 0,
          'wrapper' => [ 'width' => 100 ],
        ]),
        $this->acf_group([
          'id' => $this->id( $args['id'], 150 ),
          'name' => 'form_options',
          'label' => 'Опции формы',
          'sub_fields' => $this->acf_form_options([
            'id' => $this->id( $args['id'], 150 )
          ]),
          'conditional_logic' => $useTemplateForm,
        ]),
        $this->acf_post_object([
          'id' => $this->id( $args['id'], 200 ),
          'name' => 'form_template_id',
          'label' => 'Шаблон формы',
          'wrapper' => [ 'width' => 100 ],
          'post_type' => [ $args['form_post_type'] ],
          'allow_null' => false,
          'return_format' => 'id',
          'conditional_logic' => $useTemplateForm,
        ]),
      ],
      $this->acf_form([
        'id' => $this->id( $args['id'], 300 ),
        'name' => 'custom_form',
        'conditional_logic' => [
          array(
            [
              'field' => $this->id( $args['id'], 100 ),
              'operator' => '==',
              'value' => '1',
            ],
          ),
        ],
      ])
    );
  }

  /* acf bare for form */
  function acf_form( $id_or_args=[], $args=[] ) {
    $args = $this->get_args( $id_or_args, $args, 'form' );
    return array(
      $this->acf_group([
        'id' => $this->id( $args['id'] ),
        'name' => $args['name'],
        'label' => 'Настройка формы',
        'sub_fields' => array_merge(
          $this->acf_form_options([ 'id' => $this->id( $args['id'] ) ]),
          [
            $this->acf_flexible_content([
              'id' => $this->id( $args['id'], 300 ),
              'name' => 'fields',
              'label' => 'Поля формы',
              'button_label' => 'Добавить поле формы',
              'layouts' => [
                array(
                  'key' => $this->id( $args['id'], 300, 100 ),
                  'name' => 'textfield',
                  'label' => 'Текст',
                  'display' => 'block',
                  'sub_fields' => [
                    $this->acf_text([
                      'id' => $this->id( $args['id'], 300, 100, 100 ),
                      'name' => 'label',
                      'label' => 'Ярлык поля',
                      'required' => true,
                      'wrapper' => [ 'width' => 33 ],
                    ]),
                    $this->acf_text([
                      'id' => $this->id( $args['id'], 300, 100, 150 ),
                      'name' => 'name',
                      'label' => 'Имя поля',
                      'required' => false,
                      'wrapper' => [ 'width' => 33 ],
                    ]),
                    $this->acf_true_false([
                      'id' => $this->id( $args['id'], 300, 100, 200 ),
                      'name' => 'required',
                      'label' => '',
                      'message' => 'Поле обязательное',
                      'wrapper' => [ 'width' => 33 ],
                    ]),
                    $this->acf_text([
                      'id' => $this->id( $args['id'], 300, 100, 300 ),
                      'name' => 'input_type',
                      'label' => 'Тип поля',
                      'instructions' => '<a href="https://developer.mozilla.org/ru/docs/Web/HTML/Element/Input" target="_blank">Подробнее, атрибут "type"</a>',
                      'required' => false,
                      'wrapper' => [ 'width' => 20 ],
                    ]),
                  ],
                ),
                array(
                  'key' => $this->id( $args['id'], 300, 200 ),
                  'name' => 'textarea',
                  'label' => 'Текст (большое поле)',
                  'display' => 'block',
                  'sub_fields' => [
                    $this->acf_text([
                      'id' => $this->id( $args['id'], 300, 200, 100 ),
                      'name' => 'label',
                      'label' => 'Ярлык поля',
                      'required' => true,
                      'wrapper' => [ 'width' => 33 ],
                    ]),
                    $this->acf_text([
                      'id' => $this->id( $args['id'], 300, 200, 150 ),
                      'name' => 'name',
                      'label' => 'Имя поля',
                      'required' => false,
                      'wrapper' => [ 'width' => 33 ],
                    ]),
                    $this->acf_true_false([
                      'id' => $this->id( $args['id'], 300, 200, 200 ),
                      'name' => 'required',
                      'label' => '',
                      'message' => 'Поле обязательное',
                      'wrapper' => [ 'width' => 33 ],
                    ]),
                    $this->acf_text([
                      'id' => $this->id( $args['id'], 300, 200, 300 ),
                      'name' => 'rows',
                      'label' => 'Строк в поле',
                      'default_value' => 6,
                      'wrapper' => [ 'width' => 20 ],
                    ]),
                  ],
                ),
                array(
                  'key' => $this->id( $args['id'], 300, 300 ),
                  'name' => 'checkbox',
                  'label' => 'Чекбокс',
                  'display' => 'block',
                  'sub_fields' => [
                    $this->acf_true_false([
                      'id' => $this->id( $args['id'], 300, 300, 100 ),
                      'name' => 'required',
                      'label' => '',
                      'message' => 'Поле обязательное',
                      'wrapper' => [ 'width' => 20 ],
                    ]),
                    $this->acf_text([
                      'id' => $this->id( $args['id'], 300, 300, 150 ),
                      'name' => 'name',
                      'label' => 'Имя поля',
                      'required' => false,
                      'wrapper' => [ 'width' => 15 ],
                      'default_value' => 'agreement',
                    ]),
                    $this->acf_textarea([
                      'id' => $this->id( $args['id'], 300, 300, 200 ),
                      'name' => 'label',
                      'label' => 'Текст',
                      'required' => true,
                      'wrapper' => [ 'width' => 65 ],
                      'default_value' => 'Согласие на обработку персональных данных ([privacy_policy_page_link]Читать[/privacy_policy_page_link])',
                      'rows' => 2,
                    ]),
                  ],
                ),
                array(
                  'key' => $this->id( $args['id'], 400, 100 ),
                  'name' => 'fileinput',
                  'label' => 'Файл',
                  'display' => 'block',
                  'sub_fields' => [
                    $this->acf_text([
                      'id' => $this->id( $args['id'], 400, 100, 100 ),
                      'name' => 'label',
                      'label' => 'Ярлык поля',
                      'required' => true,
                      'wrapper' => [ 'width' => 25 ],
                    ]),
                    $this->acf_text([
                      'id' => $this->id( $args['id'], 400, 100, 150 ),
                      'name' => 'name',
                      'label' => 'Имя поля',
                      'required' => false,
                      'wrapper' => [ 'width' => 25 ],
                    ]),
                    $this->acf_true_false([
                      'id' => $this->id( $args['id'], 400, 100, 200 ),
                      'name' => 'required',
                      'label' => '',
                      'message' => 'Поле обязательное',
                      'wrapper' => [ 'width' => 50 ],
                      'default_value' => false,
                    ]),
                    $this->acf_true_false([
                      'id' => $this->id( $args['id'], 400, 100, 300 ),
                      'name' => 'multiple',
                      'label' => '',
                      'message' => 'Можно выбрать несколько файлов',
                      'wrapper' => [ 'width' => 50 ],
                      'default_value' => false,
                    ]),
                    $this->acf_text([
                      'id' => $this->id( $args['id'], 400, 100, 400 ),
                      'name' => 'max_file_size',
                      'label' => 'Max размер файлов (Мб)',
                      'type' => 'number',
                      'required' => false,
                      'default_value' => 50,
                      'wrapper' => [ 'width' => 50 ],
                    ]),
                  ],
                ),
                $this->acf_form_chbx_or_radio_group(
                  $this->id( $args['id'], 500, 100 ),
                  'radio_group',
                  'Набор радио-кнопок',
                  'Можно выбрать только 1 значение',
                  'Добавить радио-кнопку',
                  'radio_btns',
                ),
                $this->acf_form_chbx_or_radio_group(
                  $this->id( $args['id'], 600, 100 ),
                  'checkbox_group',
                  'Набор чекбоксов',
                  'Можно выбрать несколько',
                  'Добавить чекбокс',
                  'items',
                ),
              ],
            ]),// $this->acf_flexible_content
          ]
        ),
        'conditional_logic' => isset($args['conditional_logic']) ? $args['conditional_logic'] : [],
      ])
    ); // array
  }

  function acf_form_chbx_or_radio_group( $id, $name, $group_label, $instructions, $add_btn_text, $itemsName ) {
    return array(
      'key' => $this->id( $id ),
      'name' => $name,
      'label' => $group_label,
      'instructions' => $instructions,
      'display' => 'block',
      'sub_fields' => [
        $this->acf_text([
          'id' => $this->id( $id, 100 ),
          'name' => 'label',
          'label' => 'Ярлык поля',
          'required' => true,
          'wrapper' => [ 'width' => 25 ],
        ]),
        $this->acf_text([
          'id' => $this->id( $id, 200 ),
          'name' => 'name',
          'label' => 'Имя поля',
          'required' => false,
          'wrapper' => [ 'width' => 25 ],
        ]),
        $this->acf_true_false([
          'id' => $this->id( $id, 300 ),
          'name' => 'required',
          'label' => '',
          'message' => 'Поле обязательное',
          'wrapper' => [ 'width' => 25 ],
          'default_value' => false,
        ]),
        $this->acf_radio([
          'id' => $this->id( $id, 320 ),
          'name' => 'layout',
          'label' => 'Разметка',
          'type' => 'radio',
          'required' => false,
          'wrapper' => [ 'width' => 25 ],
          'choices' => [ 'horizontal' => 'Горизонтально', 'vertical' => 'Вертикально' ],
          'default_value' => 'horizontal',
        ]),
        
        $this->acf_repeater([
          'id' => $this->id( $id, 400 ),
          'name' => $itemsName,
          'label' => 'Радио-кнопки',
          'layout' => 'block',
          'button_label' => $add_btn_text,
          'sub_fields' => [
            $this->acf_text([
              'id' => $this->id( $id, 400, 100 ),
              'name' => 'label',
              'label' => 'Ярлык поля',
              'wrapper' => [ 'width' => 33.332 ],
              'required' => true,
              'preview_size' => 'medium',
            ]),
            $this->acf_text([
              'id' => $this->id( $id, 400, 200 ),
              'name' => 'value',
              'label' => 'Значение',
              'wrapper' => [ 'width' => 33.332 ],
              'preview_size' => 'medium',
            ]),
            $this->acf_true_false([
              'id' => $this->id( $id, 400, 300 ),
              'name' => 'default_selected',
              'label' => 'Изначально выделено',
              'message' => 'Да',
              'wrapper' => [ 'width' => 33.332 ],
              'default_value' => false,
            ]),
          ], // sub_fields
        ]), // $this->acf_repeater
      ],
    );
  }

  /* acf for form options */
  function acf_form_options( $id_or_args=[], $args=[] ) {
    $args = $this->get_args( $id_or_args, $args, 'form_options' );
    return [
      $this->acf_group([
        'id' => $this->id( $args['id'], 100 ),
        'name' => 'cta',
        'label' => 'Настройка призыва к действию',
        'sub_fields' => [
          $this->acf_textarea([
            'id' => $this->id( $args['id'], 100, 100 ),
            'name' => 'text',
            'label' =>'Текст',
            'rows' => 4,
          ]),
        ],
        'wrapper' => [ 'width' => 50 ],
      ]),
      $this->acf_group([
        'id' => $this->id( $args['id'], 200 ),
        'name' => 'confirm_btn',
        'label' => 'Настройка кнопки отправки',
        'sub_fields' => [
          $this->acf_text([
            'id' => $this->id( $args['id'], 200, 100 ),
            'name' => 'text',
            'label' => 'Текст',
            'required' => false,
            'default_value' => '',
          ]),
          $this->acf_event_js_code([
            'id' => $this->id( $args['id'], 200, 200 ),
            'name' => 'onsumbit_js_code',
            'label' => 'js, выполняющийся при отправке формы',
            'wrapper' => [ 'width' => 100 ],
          ]),
        ],
        'wrapper' => [ 'width' => 50 ],
      ]),
    ];
  }
  /******************** COMPLEX TEMPLATES:end ********************/




















  /******************** PRIMITIVE TEMPLATES:start ********************/

  /********************************/
  /********** The Basic ***********/
  /********************************/

  // text
  function acf_icon_name( $id_or_args=[], $args=[] ) {
    $args = $this->get_args( $id_or_args, $args, 'icon_name' );
    return $this->acf_text([
      'id' => $args['id'],
      'name' => isset($args['name'])? $args['name'] : 'icon_name',
      'label' => isset($args['label'])? $args['label'] : 'Имя иконки',
      'required' => isset($args['required'])? $args['required'] : 0,
      'placeholder' => isset($args['placeholder'])? $args['placeholder'] : '',
      'wrapper' => isset($args['wrapper'])? $args['wrapper'] : [ 'width' => 15 ],
    ]);
  }

  /******************** PRIMITIVE TEMPLATES:end ********************/

} // class ACF_CONSTRUCTOR