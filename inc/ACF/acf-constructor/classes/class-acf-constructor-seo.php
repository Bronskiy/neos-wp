<?php

class ACF_CONSTRUCTOR_SEO extends ACF_CONSTRUCTOR {
  // use in acf_add_local_field_group() 
  public $acf_group_key = 'acfconst_' . 'seo' . '_group_key';

  public $active_acf_1;
  public $active_acf_1_title = 'Дополнительная SEO настройка';

  public $location;

  public $acf;

  public $unique_id_prefix = 'seo';

  public function __construct( $args=[] ) {
    require  __ACf_CONSTUCTOR_ABSPATH__ . "/classes/functions/seo.php";

    /* LOCATION */
    if (array_key_exists('location', $args)) {
      $this->location = $args['location'];
    }
    else {
      // default location
      $this->location = [
        array(
          [
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'page',
          ],
          [
            'param' => 'page',
            'operator' => '!=',
            'value' => get_option('wp_page_for_privacy_policy'),
          ],
        ),
      ];
    }
  }


  public function register() {
    $this->acf = (object) [];
    $this->register_acf();
    add_action( 'acf/init', [$this, 'acf_init'] );
  }


  public function register_acf() {
    $this->active_acf_1 = [
      $this->acf_group([
        'id' => $this->id( 'aa1', 100 ),
        'name' => 'seo',
        'label' => 'Настройка SEO',
        'sub_fields' => [
          // $this->acf_text([
          //   'id' => $this->id( 'aa1', 100, 100 ),
          //   'name' => 'title',
          //   'label' => 'Title',
          //   'instructions' => 'Писать нужно или в "Sentence case", или в "Title case".<br>Ориентируйтесь на ключевые слова. За основу возьмите одно ключевое слово',
          //   'prepend' => '50-60 символов',
          // ]),
          
          // $this->acf_text([
          //   'id' => $this->id( 'aa1', 100, 200 ),
          //   'name' => 'keywords',
          //   'label' => 'Ключевые слова (keywords)',
          //   'instructions' => 'Вводите слова без знаков препинания с маленькой буквы',
          //   'prepend' => '100-150 символов',
          // ]),
    
          // $this->acf_text([
          //   'id' => $this->id( 'aa1', 100, 300 ),
          //   'name' => 'description',
          //   'label' => 'Описание (description)',
          //   'instructions' => 'Описание появляется в поисковике под заголовком мелким текстом',
          //   'prepend' => '50-160 символов',
          // ]),
    
          // $this->acf_repeater([
          //   'id' => $this->id( 'aa1', 100, 400 ),
          //   'name' => 'meta_tags',
          //   'label' => 'Доп. мета-данные к &lt;head&gt;&lt;/head&gt;',
          //   'collapsed' => $this->id( 400, 10 ),
          //   'button_label' => 'Добавить мета-тег',
          //   'sub_fields' => [
          //     $this->acf_repeater([
          //       'id' => $this->id( 'aa1', 100, 400, 20 ),
          //       'name' => 'meta_props',
          //       'label' => '&lt;meta . . . &gt;',
          //       'instructions' => '&lt;meta свойство_1="значение_1" свойство_2="значение_2" ... &gt;',
          //       'button_label' => 'Добавить свойство',
          //       'sub_fields' => [
          //         $this->acf_text([
          //           'id' => $this->id( 'aa1', 100, 400, 20, 10 ),
          //           'name' => 'name',
          //           'label' =>'Название свойства',
          //           'required' => true,
          //           'wrapper' => [ 'width' => 30 ],
          //         ]),
          //         $this->acf_text([
          //           'id' => $this->id( 'aa1', 100, 400, 20, 20 ),
          //           'name' => 'value',
          //           'label' =>'Значение свойства',
          //           'required' => true,
          //           'wrapper' => [ 'width' => 70 ],
          //         ]),
          //       ],
          //     ]),
          //   ],
          // ]), // $this->acf_repeater

          $this->acf_textarea([
            'id' => $this->id( 'aa1', 100, 500 ),
            'name' => 'raw_head_code',
            'label' => 'Код в &lt;head&gt;...&lt;/head&gt;',
            'instructions' => 'Целиком вставляется в head',
            'rows' => 12,
            'new_lines' => '',
          ]),
        ] // sub_fields
      ]) // $this->acf_group
    ];
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
  
} // class ACF_CONSTRUCTOR_SEO