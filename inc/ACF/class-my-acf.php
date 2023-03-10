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
      'front_page' => (object) [
        'require' => 'class-my-acf-front-page.php',
        'class' => 'MY_ACF_FRONT_PAGE',
      ],
      'about_us' => (object) [
        'require' => 'class-my-acf-about-us.php',
        'class' => 'MY_ACF_ABOUT_US',
      ],
      'job_vacancy' => (object) [
        'require' => 'class-my-acf-job-vacancy.php',
        'class' => 'MY_ACF_JOB_VACANCY',
      ],
      'page_of_vacancies' => (object) [
        'require' => 'class-my-acf-page-of-vacancies.php',
        'class' => 'MY_ACF_PAGE_OF_VACANCIES',
      ],
      'page_of_services' => (object) [
        'require' => 'class-my-acf-page-of-services.php',
        'class' => 'MY_ACF_PAGE_OF_SERVICES',
      ],

      /* <product> */
        'product' => (object) [
          'require' => 'class-my-acf-product.php',
          'class' => 'MY_ACF_PODUCT',
        ],
        'product_property' => (object) [
          'require' => 'class-my-acf-product-property.php',
          'class' => 'MY_ACF_PODUCT_PROPERTY',
        ],
        'product_industry_type_page' => (object) [
          'require' => 'class-my-acf-product-industry-type-page.php',
          'class' => 'MY_ACF_PRODUCT_INDUSTRY_TYPE_PAGE',
        ],
        'product_industry_type' => (object) [
          'require' => 'class-my-acf-product-industry-type.php',
          'class' => 'MY_ACF_PRODUCT_INDUSTRY_TYPE',
        ],
        'product_type_page' => (object) [
          'require' => 'class-my-acf-product-type-page.php',
          'class' => 'MY_ACF_PRODUCT_TYPE_PAGE',
        ],
        'product_type' => (object) [
          'require' => 'class-my-acf-product-type.php',
          'class' => 'MY_ACF_PRODUCT_TYPE',
        ],
        'product_archive_pages' => (object) [
          'require' => 'class-my-acf-product-archive-pages.php',
          'class' => 'MY_ACF_PRODUCT_ARCHIVE_PAGES',
        ],
        'product_single_page_settings' => (object) [
          'require' => 'class-my-acf-product-single-page-settings.php',
          'class' => 'MY_ACF_PRODUCT_SINGLE_PAGE_SETTINGS',
        ],
      /* </product> */

      'page_of_master_classes' => (object) [
        'require' => 'class-my-acf-page-of-master-classes.php',
        'class' => 'MY_ACF_PAGE_OF_MASTER_CLASSES',
      ],
      'master-class' => (object) [
        'require' => 'class-my-acf-master-class.php',
        'class' => 'MY_ACF_MASTER_CLASS',
      ],
      'my_icon' => (object) [
        'require' => 'class-my-acf-my-icon.php',
        'class' => 'MY_ACF_MY_ICON',
      ],
      'site_form' => (object) [
        'require' => 'class-my-acf-site-form.php',
        'class' => 'MY_ACF_SITE_FORM',
      ],
      'news' => (object) [
        'require' => 'class-my-acf-news.php',
        'class' => 'MY_ACF_NEWS',
      ],
      'contacts' => (object) [
        'require' => 'class-my-acf-contacts.php',
        'class' => 'MY_ACF_CONTACTS',
      ],
      'cookie_policy' => (object) [
        'require' => 'class-my-acf-cookie-policy.php',
        'class' => 'MY_ACF_COOKIE_POLICY',
      ],
      'contact_us_settings' => (object) [
        'require' => 'class-my-acf-contact-us-settings.php',
        'class' => 'MY_ACF_CONTACT_US_SETTINGS',
      ],
      'news_category' => (object) [
        'require' => 'class-my-acf-news-category.php',
        'class' => 'MY_ACF_NEWS_CATEGORY',
      ],
      'header_menu' => (object) [
        'require' => 'class-my-acf-my__header_menu.php',
        'class' => 'MY_ACF_MY__HEADER_MENU',
      ],
      'ad' => (object) [
        'require' => 'class-my-acf-ad.php',
        'class' => 'MY_ACF_AD',
      ],

      /* LANDING PAGES */
      'lp_dwl_files_after_form_fill' => (object) [
        'require' => 'class-my-acf-lp-dwl-files-after-form-fill.php',
        'class' => 'MY_ACF_LANDING_PAGE_DWL_FILES_AFTER_FORM_FILL',
      ],
      'landing_page' => (object) [
        'require' => 'class-my-acf-landing-page.php',
        'class' => 'MY_ACF_LANDING_PAGE',
      ],

      /* GUTENBERG */
      'gt_gallery_slider' => (object) [
        'require' => 'gutenberg-blocks/class-my-acf-gt-gallery-slider.php',
        'class' => 'MY_ACF_GT_GALLERY_SLIDER',
      ],
    ];

    $pluged_acf_templates = [
      'seo' => [
        'location' => [
          array(
            [ 'param' => 'post_type', 'operator' => '==', 'value' => 'page' ],
            [ 'param' => 'page', 'operator' => '!=', 'value' => get_option( 'wp_page_for_privacy_policy' ) ],
          ),
          array(
            [ 'param' => 'post_type', 'operator' => '==', 'value' => MY_CPT_PRODUCT ],
          ),
          array(
            [ 'param' => 'post_type', 'operator' => '==', 'value' => MY_CPT_PRODUCT_INDUSTRY_TYPE_PAGE ],
          ),
          array(
            [ 'param' => 'post_type', 'operator' => '==', 'value' => MY_CPT_PRODUCT_TYPE_PAGE ],
          ),
          array(
            [ 'param' => 'post_type', 'operator' => '==', 'value' => MY_CPT_NEWS ],
          ),
          array(
            [ 'param' => 'post_type', 'operator' => '==', 'value' => MY_CPT_MASTER_CLASS ],
          ),
        ] // location
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




















  /* CUSTOM FUNCTIONS */
  /**
   * id, name, label
   */
  function my_acf_infographics( $id_or_args=[], $args=[] ) {
    $args = $this->get_args( $id_or_args, $args, 'infographics');
    return $this->acf_repeater([
      'id' => $this->id( $args['id'] ),
      'name' => $args['name'],
      'label' => isset($args['label'])? $args['label'] : '??????????????????????',
      'layout' => 'block',
      'sub_fields' => [
        $this->acf_post_object([
          'id' => $this->id( $args['id'], 90 ),
          'name' => 'built_in_svg_icon',
          'label' => '???????????????????? ????????????',
          'instructions' => '<a href="https://petershaggynoble.github.io/MDI-Sandbox/" target="_blank">???????????????????? SVG ????????????</a>',
          'wrapper' => [ 'width' => 20 ],
          'post_type' => [ MY_CPT_MY_ICON ],
          'allow_null' => true,
        ]),
        $this->acf_textarea([
          'id' => $this->id( $args['id'], 100 ),
          'name' => 'svg_icon',
          'label' => 'SVG ?????? ????????????',
          'wrapper' => [ 'width' => 80 ],
          'rows' => 3,
          'new_lines' => '',
        ]),
        $this->acf_group([
          'id' => $this->id( $args['id'], 200 ),
          'name' => 'number_props',
          'label' => '?????????????????? ??????????',
          'wrapper' => [ 'width' => 100 ],
          'sub_fields' => [
            $this->acf_text([
              'id' => $this->id( $args['id'], 200, 100 ),
              'name' => 'prefix',
              'label' =>'?????????? ???? ??????????',
              'wrapper' => [ 'width' => 33 ],
            ]),
            $this->acf_text([
              'id' => $this->id( $args['id'], 200, 200 ),
              'name' => 'value',
              'label' =>'??????????',
              'type' => 'number',
              'required' => true,
              'wrapper' => [ 'width' => 33 ],
            ]),
            $this->acf_text([
              'id' => $this->id( $args['id'], 200, 300 ),
              'name' => 'suffix',
              'label' =>'?????????? ?????????? ??????????',
              'wrapper' => [ 'width' => 33 ],
            ]),
            $this->acf_text([
              'id' => $this->id( $args['id'], 200, 400 ),
              'name' => 'start_value',
              'label' =>'?????????????????? ?????????? ??????????????',
              'type' => 'number',
              'default_value' => 0,
              'wrapper' => [ 'width' => 33 ],
            ]),
            $this->acf_text([
              'id' => $this->id( $args['id'], 200, 500 ),
              'name' => 'duration',
              'label' =>'?????????? ???????????????? (??????)',
              'type' => 'number',
              'default_value' => 3,
              'wrapper' => [ 'width' => 33 ],
            ]),
            $this->acf_text([
              'id' => $this->id( $args['id'], 200, 600 ),
              'name' => 'decimal_places',
              'label' =>'??????-???? ???????????????????? ????????????',
              'type' => 'number',
              'default_value' => 0,
              'wrapper' => [ 'width' => 33 ],
            ]),
          ],
        ]),
        $this->acf_textarea([
          'id' => $this->id( $args['id'], 300 ),
          'name' => 'description',
          'label' => '????????????????',
          'wrapper' => [ 'width' => 100 ],
          'rows' => 2,
          'new_lines' => 'br',
        ]),
      ], // sub_fields
    ]); // acf_repeater
  }





  function my_acf_bgr_viedo_section( $id_or_args=[], $args=[] ) {
    $args = $this->get_args( $id_or_args, $args, 'bgr_video_block');
    return $this->acf_group([
      'id' => $args['id'],
      'name' => $args['name'],
      'label' => isset($args['label'])? $args['label'] : '???????????? ?? ???????? ???? ????????',
      'layout' => 'block',
      'sub_fields' => [
        $this->acf_text([
          'id' => $this->id( $args['id'], 100 ),
          'name' => 'title',
          'label' => '??????????????????',
          'wrapper' => [ 'width' => 25 ],
          'default_value' => '????????????-????????????',
        ]),
        $this->acf_file([
          'id' => $this->id( $args['id'], 150 ),
          'name' => 'bgr_video',
          'label' => '?????????????? ??????????',
          'return_format' => 'url',
          'wrapper' => [ 'width' => 25 ],
        ]),
        // $this->acf_text([
        //   'id' => $this->id( 'aa1', 100, 160 ),
        //   'name' => 'min_viedo_height',
        //   'label' => '?????????????????????? ???????????? ?????????? (px)',
        //   'type' => 'number',
        //   'wrapper' => [ 'width' => 25 ],
        //   'default_value' => '440',
        // ]),
        $this->acf_image([
          'id' => $this->id( $args['id'], 170 ),
          'name' => 'bgr_img',
          'label' => '?????????????? ??????????????????????',
          'instructions' => '????????????????????????, ???????? ?????????? ???? ???????????????????????? (?????????????????? ????????????)',
          'wrapper' => [ 'width' => 25 ],
        ]),
        $this->acf_wysiwyg_editor([
          'id' => $this->id( $args['id'], 200 ),
          'name' => 'text',
          'label' => '??????????',
        ]),
        $this->acf_text([
          'id' => $this->id( $args['id'], 300 ),
          'name' => 'btn_text',
          'label' => '?????????? ????????????',
          'wrapper' => [ 'width' => 50 ],
          'default_value' => '????????????????????',
        ]),
        $this->acf_event_js_code([
          'id' => $this->id( $args['id'], 400 ),
          'name' => 'btn_onclick_js_code',
          'label' => 'js, ?????????????????????????? ?????? ?????????? ???? ????????????',
          'wrapper' => [ 'width' => 50 ],
        ]),
      ], // sub_fields
    ]); // acf_repeater
  }




  function my_acf_feedbacks( $id_or_args=[], $args=[] ) {
    $args = $this->get_args( $id_or_args, $args, 'feedbacks');
    return $this->acf_repeater([
      'id' => $this->id( $args['id'] ),
      'name' => $args['name'],
      'label' => isset($args['label'])? $args['label'] : '????????????',
      'layout' => 'block',
      'button_label' => '????????????????',
      'sub_fields' => [
        $this->acf_image([
          'id' => $this->id( $args['id'], 100 ),
          'name' => 'img_logo',
          'label' => '????????',
          'wrapper' => [ 'width' => 25 ],
          'preview_size' => 'thumbnail',
        ]),
        $this->acf_true_false([
          'id' => $this->id( $args['id'], 150 ),
          'name' => 'img_logo_conatin',
          'label' => '',
          'message' => '?????????????? ??????????????????????',
          'default_value' => false,
          'wrapper' => [ 'width' => 25 ],
        ]),
        $this->acf_textarea([
          'id' => $this->id( $args['id'], 200 ),
          'name' => 'svg_logo',
          'label' =>'???????? SVG',
          'instructions' => '???????? ??????????????, ???????????????????????? ???????????? ??????????????????????',
          'wrapper' => [ 'width' => 25 ],
          'rows' => 3,
          'new_lines' => '',
        ]),
        $this->acf_text([
          'id' => $this->id( $args['id'], 300 ),
          'name' => 'alt',
          'label' =>'alt',
          'wrapper' => [ 'width' => 25 ],
        ]),
        $this->acf_text([
          'id' => $this->id( $args['id'], 400 ),
          'name' => 'author',
          'label' =>'??????????',
          'required' => false,
          'wrapper' => [ 'width' => 40 ],
        ]),
        $this->acf_textarea([
          'id' => $this->id( $args['id'], 500 ),
          'name' => 'text',
          'label' =>'??????????',
          'required' => true,
          'wrapper' => [ 'width' => 60 ],
        ]),
      ], // sub_fields
    ]);
  }




  function my_acf_prcie_cards( $id_or_args=[], $args=[] ) {
    $args = $this->get_args( $id_or_args, $args, 'price_cards');
    return $this->acf_repeater([
      'id' => $this->id( $args['id'] ),
      'name' => $args['name'],
      'label' => isset($args['label'])? $args['label'] : '???????????????? ?? ??????????',
      'layout' => 'block',
      'button_label' => '???????????????? ???????????????? ?? ??????????',
      'sub_fields' => [
        $this->acf_text([
          'id' => $this->id( $args['id'], 100, 100 ),
          'name' => 'title',
          'label' => '???????????????? ????????????????',
          'wrapper' => [ 'width' => 100 ],
        ]),
        $this->acf_wysiwyg_editor([
          'id' => $this->id( $args['id'], 100, 200 ),
          'name' => 'description',
          'label' => '????????????????',
          'wrapper' => [ 'width' => 100 ],
        ]),
        $this->acf_text([
          'id' => $this->id( $args['id'], 100, 300 ),
          'name' => 'price',
          'label' => '????????',
          'wrapper' => [ 'width' => 50 ],
        ]),
        $this->acf_text([
          'id' => $this->id( $args['id'], 100, 400 ),
          'name' => 'price_description',
          'label' => '?????????????? ?? ????????',
          'wrapper' => [ 'width' => 50 ],
        ]),
        // $this->acf_textarea([
        //   'id' => $this->id( $args['id'], 100, 500 ),
        //   'name' => 'form_cta',
        //   'label' => '???????????? ?? ???????????????? ??????????',
        //   'wrapper' => [ 'width' => 100 ],
        //   'rows' => 4,
        // ]),
      ], // sub_fields
    ]); // $this->acf_repeater
  }




  function my_acf_hero_section( $id_or_args=[], $args=[] ) {
    $args = $this->get_args( $id_or_args, $args, 'hero_section');
    return $this->acf_group([
      'id' => $this->id( $args['id'] ),
      'name' => $args['name'],
      'label' => isset($args['label'])? $args['label'] : 'Hero Section',
      'layout' => 'block',
      'sub_fields' => [
        $this->acf_image([
          'id' => $this->id( $args['id'], 100 ),
          'name' => 'bgr_img',
          'label' => '?????????????? ??????????????????????',
          'wrapper' => [ 'width' => 33 ],
          'preview_size' => 'thumbnail',
        ]),
        $this->acf_text([
          'id' => $this->id( $args['id'], 200 ),
          'name' => 'h1',
          'label' => '?????????????????? H1',
          'instructions' => '???????????????? ???????????????? ??????????, ???????? ?????????????????????? ????????????????',
          'wrapper' => [ 'width' => 66 ],
        ]),
        $this->acf_wysiwyg_editor([
          'id' => $this->id( $args['id'], 300 ),
          'name' => 'h2',
          'label' => '????????????????????????',
          'wrapper' => [ 'width' => 100 ],
        ]),
      ], // sub_fields
    ]); // $this->acf_group
  }



}