<?php

class MY_CPT {
  
  public function register() {
    global $my_cpt;
    if ( empty((array) $my_cpt) ){
      $my_cpt = (object) [];
      $my_cpt->post_types = (object) [];
    }
    
    /* <product> */
      require_once 'class-my-cpt-product.php';
      $x = new MY_CPT_PRODUCT;
      $x->register();
      $my_cpt->post_types->products = MY_CPT_PRODUCT;
      
      require_once 'class-my-cpt-product-settings.php';
      $x = new MY_CPT_PRODUCT_ARCHIVE_AND_PAGE_SETTINGS;
      $x->register();
      $my_cpt->post_types->product_type = MY_CPT_PRODUCT_ARCHIVE_AND_PAGE_SETTINGS;
      
      require_once 'class-my-cpt-product-property.php';
      $x = new MY_CPT_PRODUCT_PROPERTY;
      $x->register();
      $my_cpt->post_types->products = MY_CPT_PRODUCT_PROPERTY;

      require_once 'class-my-cpt-product-industry-type-page.php';
      $x = new MY_CPT_PRODUCT_INDUSTRY_TYPE_PAGE;
      $x->register();
      $my_cpt->post_types->product_industry_type = MY_CPT_PRODUCT_INDUSTRY_TYPE_PAGE;
      
      require_once 'class-my-cpt-product-type-page.php';
      $x = new MY_CPT_PRODUCT_TYPE_PAGE;
      $x->register();
      $my_cpt->post_types->product_type = MY_CPT_PRODUCT_TYPE_PAGE;
    /* </product> */

    require_once 'class-my-cpt-job-vacancy.php';
    $x = new MY_CPT_JOB_VACANCY;
    $x->register();
    $my_cpt->post_types->job_vacancy = MY_CPT_JOB_VACANCY;

    require_once 'class-my-cpt-my-icon.php';
    $x = new MY_CPT_MY_ICON;
    $x->register();
    $my_cpt->post_types->my_icon = MY_CPT_MY_ICON;

    require_once 'class-my-cpt-settings.php';
    $x = new MY_CPT_SETTINGS;
    $x->register();
    $my_cpt->post_types->settings = MY_CPT_SETTINGS;

    require_once 'class-my-cpt-site-form.php';
    $x = new MY_CPT_SITE_FORM;
    $x->register();
    $my_cpt->post_types->site_form = MY_CPT_SITE_FORM;

    require_once 'class-my-cpt-news.php';
    $x = new MY_CPT_NEWS;
    $x->register();
    $my_cpt->post_types->news = MY_CPT_NEWS;

    require_once 'class-my-cpt-master_class.php';
    $x = new MY_CPT_MASTER_CLASS;
    $x->register();
    $my_cpt->post_types->master_class = MY_CPT_MASTER_CLASS;

    require_once 'class-my-cpt-landing-page.php';
    $x = new MY_CPT_LANDING_PAGE;
    $x->register();
    $my_cpt->post_types->landing_page = MY_CPT_LANDING_PAGE;

    require_once 'class-my-cpt-ad.php';
    $x = new MY_CPT_AD;
    $x->register();
    $my_cpt->post_types->ad = MY_CPT_AD;


    $this->add_post_status( get_option('page_on_front'), '(Главная странциа)', true );
    $this->add_post_status( get_option('__page_of_services_id__'), 'Услуги', true );
    $this->add_post_status( get_option('__about_us_post_id__'), 'О компании', true );
    $this->add_post_status( get_option('__vacancies_post_id__'), 'Вакансии', true );
    $this->add_post_status( get_option('__news_archive_post_id__'), 'Новости', true );
    $this->add_post_status( get_option('__page_of_master_classes_id__'), 'Мастер-классы', true );
    $this->add_post_status( get_option('__contact_page_id__'), 'Контакты', true );
    $this->add_post_status( get_option('__dwl_files_after_form_fill__landing_page_id_1__'), 'Целевая страница скачивания файлов после заполнения формы №1', true );

    $this->add_custom_sortable_columns__sort_taxonomies_by_ACF_order([
      MY_TAX_PRODUCT_TYPE,
      MY_TAX_PRODUCT_INDUSTRY_TYPE,
      MY_TAX_NEWS_CATEGORY
    ]);
    $this->add_custom_sortable_columns__sort_posts_by_menu_order([
      MY_CPT_PRODUCT
    ]);

    add_filter( 'display_post_states', function($post_states, $post) {
      // if (__IN_DEV__) echo " <i style='color:#00b9eb; font-weight:400;'>(id: {$post->ID})</i> ";
      return $post_states;
    }, 10, 2 );
  }





  public function add_post_status( $post_id, $status_name, $multilang=false) {
    add_filter( 'display_post_states', function($post_states, $post) use ($post_id, $status_name, $multilang) {
      if (function_exists('pll_languages_list') && $multilang) {
        // get post ids
        $lang_codes = pll_languages_list(); // [ru, en, ...]
        $post_lang_ids = [];
        foreach ($lang_codes as $lang_code) {
          $post_lang_ids[] = pll_get_post( $post_id, $lang_code );
        }
        // apply post_state
        if( in_array($post->ID, $post_lang_ids) ) {
          $post_states[] = $status_name;
        }
      }

      else {
        if ($post->ID == $post_id) $post_states[] = $status_name;
      }
      return $post_states;
    }, 10, 2 );
  }




  /**
   * @param Array $taxonomy_names - [ taxonomy_name_1, ... ]
   */
  public function add_custom_sortable_columns__sort_taxonomies_by_ACF_order( $taxonomy_names=[] ) {
    if (is_admin()) {
      foreach ($taxonomy_names as $tax_name) {
        // 1. Add new column
        add_filter( 'manage_edit-'. $tax_name .'_columns', function($columns) {
          $columns['order'] = 'Порядок';
          return $columns;
        });
        
        // 2. Display value there
        add_filter('manage_'. $tax_name .'_custom_column', function($content, $column_name, $term_id) use ($tax_name) {
          $term= get_term($term_id, $tax_name);
          $order = get_field('order', $tax_name ."_". $term->term_id);
          switch ($column_name) {
            case 'order':
              $content = $order;
              break;
            default:
              break;
          }
          return $content;
        }, 10, 3);
        
        // 3. Add sortable opportunity
        add_filter( 'manage_edit-'. $tax_name .'_sortable_columns', function($columns) {
          $columns['order'] = 'order';
          return $columns;
        });
        
        // 4. Set how to sort
        add_action( 'pre_get_posts', function($query) {
          $orderby = $query->get( 'orderby');
          if( 'order' == $orderby ) {
            // TODO: false order
            $query->set('orderby', 'meta_value');
            $query->set('meta_key', 'order');
            $query->set('meta_type', 'NUMERIC');
          }
          return $query;
        });
      }
    }
  }



  /**
   * @param Array $post_types - [ taxonomy_name_1, ... ]
   */
  public function add_custom_sortable_columns__sort_posts_by_menu_order( $post_types=[] ) {
    if (is_admin()) {
      foreach ($post_types as $post_type) {

        // manage colunms
        add_filter( "manage_". $post_type ."_posts_columns", function( $columns ) {
            // add your column as new array element and give it table header text
            $columns['menu_order'] = 'Порядок';
            return $columns;
        });

        // make columns sortable
        add_filter( "manage_edit-". $post_type ."_sortable_columns", function( $columns ) {
            $columns['menu_order'] = 'menu_order';
            return $columns;
        });

        // populate column cells
        add_action( "manage_". $post_type ."_posts_custom_column", function( $column, $post_id ) {
          switch ( $column ) {
            case 'menu_order':
              echo get_post_field( 'menu_order', $post_id);
              break;
            case 'MAYBE_ANOTHER_CUSTOM_COLUMN':
              // additional code
              break;
            default:
              break;
          }
        }, 10, 2 );

        // set query to sort
        add_action( 'pre_get_posts', function( $query ) {
            $orderby = $query->get( 'orderby' );
            if ( 'menu_order' == $orderby ) {        
              // $query->set( 'orderby', 'menu_order' );
            }
        });

      } // foreach
    }
  }
}