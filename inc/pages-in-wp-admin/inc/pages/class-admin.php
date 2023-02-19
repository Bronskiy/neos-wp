<?php

require_once PAGES_IN_WP_ADMIN_ABSPATH . 'inc/api/class-settings_api.php';
require_once PAGES_IN_WP_ADMIN_ABSPATH . 'inc/api/callbacks/class-admin_callbacks.php';

class Admin {

  public $settings;

  public $pages = [];

  public $subpages = [];


  public function register() {
    $this->settings = new Settings_Api();
    $this->callbacks = new Admin_Callbacks();
    
    // register custom fields
    $this->set_settings();
    $this->set_sections();
    $this->set_fields();
    
    // register all pages (+subpages) (after custom fields register!!!)
    $this->set_pages();
    $this->set_subpages();
    $this->settings->add_pages( $this->pages )->with_subpage()->add_subpages( $this->subpages)->register();
  }


  public function set_pages() {
    $this->pages = [
      [
        'page_title' => 'ID постов',
        'menu_title' => '~ID постов',
        'menu_slug'  => POST_IDS_SLUG,
        // 'capability' => '',
        'callback'   => [ $this->callbacks, 'admin_post_ids' ],
        'icon_url'   => 'dashicons-flag',
        'position'   => 30
      ],
      [
        'page_title' => 'Данные форм',
        'menu_title' => '~Данные форм',
        'menu_slug'  => 'my_form_data_page',
        // 'capability' => '',
        'callback'   => [ $this->callbacks, 'admin_my_form_data_page' ],
        'icon_url'   => 'dashicons-database',
        'position'   => 40
      ],
    ];
  }

  
  public function set_subpages() {
    $this->subpages = [
      // [
      //   'parent_slug' => POST_IDS_SLUG,
      //   'page_title'  => 'Инструменты',
      //   'menu_title'  => 'Инструменты',
      //   'menu_slug'   => 'ts_tools',
      //   'callback'    => [ $this->callbacks, 'admin_tools_page' ]
      // ]
    ];
  }










  
  public function set_settings() {
    $args = [
      #POST_IDS
      [
        'option_group' => POST_IDS__OPTION_GROUP,
        'option_name' =>  '__about_us_post_id__',
        'callback' => [ $this->callbacks, 'menu_cf_settings_cb' ]
      ],
      [
        'option_group' => POST_IDS__OPTION_GROUP,
        'option_name' =>  '__news_archive_post_id__',
        'callback' => [ $this->callbacks, 'menu_cf_settings_cb' ]
      ],
      [
        'option_group' => POST_IDS__OPTION_GROUP,
        'option_name' =>  '__vacancies_post_id__',
        'callback' => [ $this->callbacks, 'menu_cf_settings_cb' ]
      ],
      [
        'option_group' => POST_IDS__OPTION_GROUP,
        'option_name' =>  '__page_of_master_classes_id__',
        'callback' => [ $this->callbacks, 'menu_cf_settings_cb' ]
      ],
      [
        'option_group' => POST_IDS__OPTION_GROUP,
        'option_name' =>  '__page_of_services_id__',
        'callback' => [ $this->callbacks, 'menu_cf_settings_cb' ]
      ],
      [
        'option_group' => POST_IDS__OPTION_GROUP,
        'option_name' =>  '__contact_page_id__',
        'callback' => [ $this->callbacks, 'menu_cf_settings_cb' ]
      ],

      
      #POST_IDS (2)
      [
        'option_group' => POST_IDS__OPTION_GROUP_2,
        'option_name' =>  '__contact_post_id__',
        'callback' => [ $this->callbacks, 'menu_cf_settings_cb' ]
      ],
      [
        'option_group' => POST_IDS__OPTION_GROUP_2,
        'option_name' =>  '__site_settings_post_id__',
        'callback' => [ $this->callbacks, 'menu_cf_settings_cb' ]
      ],
      [
        'option_group' => POST_IDS__OPTION_GROUP_2,
        'option_name' =>  '__contact_us_settings__',
        'callback' => [ $this->callbacks, 'menu_cf_settings_cb' ]
      ],
      [
        'option_group' => POST_IDS__OPTION_GROUP_2,
        'option_name' =>  '__cookie_policy_post_id__',
        'callback' => [ $this->callbacks, 'menu_cf_settings_cb' ]
      ],
      [
        'option_group' => POST_IDS__OPTION_GROUP_2,
        'option_name' =>  '__product_archive_pages__settings_id__',
        'callback' => [ $this->callbacks, 'menu_cf_settings_cb' ]
      ],
      [
        'option_group' => POST_IDS__OPTION_GROUP_2,
        'option_name' =>  '__single_product_page__settings_id__',
        'callback' => [ $this->callbacks, 'menu_cf_settings_cb' ]
      ],

      
      #TERM_IDS
      [
        'option_group' => TERM_IDS__OPTION_GROUP,
        'option_name' =>  '__news_past_master_classes_tag_id__',
        'callback' => [ $this->callbacks, 'menu_cf_settings_cb' ]
      ],
      [
        'option_group' => TERM_IDS__OPTION_GROUP,
        'option_name' =>  '__news_past_master_class_category_id__',
        'callback' => [ $this->callbacks, 'menu_cf_settings_cb' ]
      ],
      [
        'option_group' => TERM_IDS__OPTION_GROUP,
        'option_name' =>  '__news_completed_projects_tag_id__',
        'callback' => [ $this->callbacks, 'menu_cf_settings_cb' ]
      ],
      [
        'option_group' => TERM_IDS__OPTION_GROUP,
        'option_name' =>  '__news_completed_project_category_id__',
        'callback' => [ $this->callbacks, 'menu_cf_settings_cb' ]
      ],


      #FORM_POST_IDS
      [
        'option_group' => FORM_POST_IDS__OPTION_GROUP_3,
        'option_name' =>  '__default_from_template_id__',
        'callback' => [ $this->callbacks, 'menu_cf_settings_cb' ]
      ],
      
      [
        'option_group' => FORM_POST_IDS__OPTION_GROUP_3,
        'option_name' =>  '__master_class_from_template_id__',
        'callback' => [ $this->callbacks, 'menu_cf_settings_cb' ]
      ],
      [
        'option_group' => FORM_POST_IDS__OPTION_GROUP_3,
        'option_name' =>  '__sign_up_for_testing_from_template_id__',
        'callback' => [ $this->callbacks, 'menu_cf_settings_cb' ]
      ],
      [
        'option_group' => FORM_POST_IDS__OPTION_GROUP_3,
        'option_name' =>  '__contact_us_from_template_id__',
        'callback' => [ $this->callbacks, 'menu_cf_settings_cb' ]
      ],
      [
        'option_group' => FORM_POST_IDS__OPTION_GROUP_3,
        'option_name' =>  '__vacancy_from_template_id__',
        'callback' => [ $this->callbacks, 'menu_cf_settings_cb' ]
      ],
      [
        'option_group' => FORM_POST_IDS__OPTION_GROUP_3,
        'option_name' =>  '__pbs_upload_files_from_template_id__',
        'callback' => [ $this->callbacks, 'menu_cf_settings_cb' ]
      ],
      [
        'option_group' => FORM_POST_IDS__OPTION_GROUP_3,
        'option_name' =>  '__become_a_partner_from_template_id__',
        'callback' => [ $this->callbacks, 'menu_cf_settings_cb' ]
      ],
      [
        'option_group' => FORM_POST_IDS__OPTION_GROUP_3,
        'option_name' =>  '__page_of_master_classes_hs_from_template_id__',
        'callback' => [ $this->callbacks, 'menu_cf_settings_cb' ]
      ],


      #POST_IDS (4)
      [
        'option_group' => POST_IDS__OPTION_GROUP_4,
        'option_name' =>  '__dwl_files_after_form_fill__landing_page_id_1__',
        'callback' => [ $this->callbacks, 'menu_cf_settings_cb' ]
      ],
    ];
    $this->settings->set_settings( $args );
  }














  public function set_sections() {
    $args = [
      [ #POST_IDS
        "id" => POST_IDS__SECTION_ID,
        "title" => 'Настройка ID постов',
        "page" => POST_IDS_SLUG // page slug
      ],

      [ #POST_IDS (2)
        "id" => POST_IDS__SECTION_ID_2,
        "title" => 'Обшая настройка сайта',
        "page" => POST_IDS_SLUG // page slug
      ],

      [ #TERM_IDS
        "id" => TERM_IDS__SECTION,
        "title" => 'Настройка таксономий (категории/теги)',
        "page" => POST_IDS_SLUG // page slug
      ],

      [ #FORM_POST_IDS
        "id" => FORM_POST_IDS__SECTION_ID_3,
        "title" => 'ID форм',
        "page" => POST_IDS_SLUG // page slug
      ],

      [ #POST_IDS (4)
        "id" => POST_IDS__SECTION_ID_4,
        "title" => 'ID "целевых" страниц',
        "page" => POST_IDS_SLUG // page slug
      ],
    ];
    $this->settings->set_sections( $args );
  }














  public function set_fields() {
    $args = [
      #POST_IDS
      [
        "id" => '__about_us_post_id__', // settings['option_name']
        "title" => '<span><b>О компании</b> post ID:</span>' . (__IN_DEV__? ' ( option: __about_us_post_id__ )' : '') . '<br>',
        "callback" => [ $this->callbacks, 'menu_cf_about_us_post_id_cb' ],
        "page" => POST_IDS_SLUG, // page slug
        "section" => POST_IDS__SECTION_ID, // sections['id']
      ],
      [
        "id" => '__news_archive_post_id__',
        "title" => '<br><br><span><b>Новости</b> post ID:</span>' . (__IN_DEV__? ' ( option: __news_archive_post_id__ )' : '') . '<br>',
        "callback" => [ $this->callbacks, 'menu_cf_news_archive_post_id_cb' ],
        "page" => POST_IDS_SLUG,
        "section" => POST_IDS__SECTION_ID,
      ],
      [
        "id" => '__vacancies_post_id__',
        "title" => '<br><br><span><b>Страница с вакансиями</b> post ID:</span>' . (__IN_DEV__? ' ( option: __vacancies_post_id__ )' : '') . '<br>',
        "callback" => [ $this->callbacks, 'menu_cf_vacancies_post_id_cb' ],
        "page" => POST_IDS_SLUG,
        "section" => POST_IDS__SECTION_ID,
      ],
      [
        "id" => '__page_of_master_classes_id__',
        "title" => '<br><br><span><b>Страница с мастер-классами</b> post ID:</span>' . (__IN_DEV__? ' ( option: __page_of_master_classes_id__ )' : '') . '<br>',
        "callback" => [ $this->callbacks, 'menu_cf_page_of_master_classes_id_cb' ],
        "page" => POST_IDS_SLUG,
        "section" => POST_IDS__SECTION_ID,
      ],
      [
        "id" => '__page_of_services_id__',
        "title" => '<br><br><span><b>Страница с услугами</b> post ID:</span>' . (__IN_DEV__? ' ( option: __page_of_services_id__ )' : '') . '<br>',
        "callback" => [ $this->callbacks, 'menu_cf__page_of_services_id__cb' ],
        "page" => POST_IDS_SLUG,
        "section" => POST_IDS__SECTION_ID,
      ],
      [
        "id" => '__contact_page_id__',
        "title" => '<br><br><span><b>Страница с контактами</b> post ID:</span>' . (__IN_DEV__? ' ( option: __contact_page_id__ )' : '') . '<br>',
        "callback" => [ $this->callbacks, 'menu_cf__contact_page_id__cb' ],
        "page" => POST_IDS_SLUG,
        "section" => POST_IDS__SECTION_ID,
      ],


      #POST_IDS (2)
      [
        "id" => '__contact_post_id__',
        "title" => '<span><b>Контакты</b> post ID:</span>' . (__IN_DEV__? ' ( option: __contact_post_id__ )' : '') . '<br>',
        "callback" => [ $this->callbacks, 'menu_cf_contacts_post_id_cb' ],
        "page" => POST_IDS_SLUG,
        "section" => POST_IDS__SECTION_ID_2,
      ],
      [
        "id" => '__site_settings_post_id__',
        "title" => '<br><br><span><b> Страница с общими настройками (в настройках сайта) </b> post ID:</span>' . (__IN_DEV__? ' ( option: __site_settings_post_id__ )' : '') . '<br>',
        "callback" => [ $this->callbacks, 'menu_cf_global_s_settings_post_id_cb' ],
        "page" => POST_IDS_SLUG,
        "section" => POST_IDS__SECTION_ID_2, 
      ],
      [
        "id" => '__contact_us_settings__',
        "title" => '<br><br><span><b> Страница с настройками обратной связи (в настройках сайта) </b> post ID:</span>' . (__IN_DEV__? ' ( option: __contact_us_settings__ )' : '') . '<br>',
        "callback" => [ $this->callbacks, 'menu_cf__contact_us_settings__cb' ],
        "page" => POST_IDS_SLUG,
        "section" => POST_IDS__SECTION_ID_2, 
      ],
      [
        "id" => '__cookie_policy_post_id__',
        "title" => '<br><br><span><b> Страница с настройками политики cookie (в настройках сайта) </b> post ID:</span>' . (__IN_DEV__? ' ( option: __cookie_policy_post_id__ )' : '') . '<br>',
        "callback" => [ $this->callbacks, 'menu_cf__cookie_policy_post_id__cb' ],
        "page" => POST_IDS_SLUG,
        "section" => POST_IDS__SECTION_ID_2, 
      ],
      [
        "id" => '__product_archive_pages__settings_id__',
        "title" => '<br><br><span><b>Страница с настройками архива с продуктами (В разделе "~Продукты") </b> post ID:</span>' . (__IN_DEV__? ' ( option: __product_archive_pages__settings_id__ )' : '') . '<br>',
        "callback" => [ $this->callbacks, 'menu_cf__product_archive_pages__settings_id__cb' ],
        "page" => POST_IDS_SLUG,
        "section" => POST_IDS__SECTION_ID_2, 
      ],
      [
        "id" => '__single_product_page__settings_id__',
        "title" => '<br><br><span><b>Настройки страницы конкретного продукта (В разделе "~Продукты") </b> post ID:</span>' . (__IN_DEV__? ' ( option: __single_product_page__settings_id__ )' : '') . '<br>',
        "callback" => [ $this->callbacks, 'menu_cf__single_product_page__settings_id__cb' ],
        "page" => POST_IDS_SLUG,
        "section" => POST_IDS__SECTION_ID_2, 
      ],

      
      #TERM_IDS
      [
        "id" => '__news_past_master_classes_tag_id__',
        "title" => '<span><b>ID тега "Прошедшие мастер-классы"</b>:</span>' . (__IN_DEV__? ' ( option: __news_past_master_classes_tag_id__ )' : '') . '<br>',
        "callback" => [ $this->callbacks, 'menu_cf__news_past_master_classes_tag_id__cb' ],
        "page" => POST_IDS_SLUG,
        "section" => TERM_IDS__SECTION,
      ],
      [
        "id" => '__news_past_master_class_category_id__',
        "title" => '<br><span><b>ID категории, в которой показываются "Прошедшие мастер-классы"</b>:</span>' . (__IN_DEV__? ' ( option: __news_past_master_class_category_id__ )' : '') . '<br>',
        "callback" => [ $this->callbacks, 'menu_cf__news_past_master_class_category_id__cb' ],
        "page" => POST_IDS_SLUG,
        "section" => TERM_IDS__SECTION,
      ],
      [
        "id" => '__news_completed_projects_tag_id__',
        "title" => '<br><br><span><b>ID тега, "Реализованные проекты"</b>:</span>' . (__IN_DEV__? ' ( option: __news_completed_projects_tag_id__ )' : '') . '<br>',
        "callback" => [ $this->callbacks, 'menu_cf__news_completed_projects_tag_id__cb' ],
        "page" => POST_IDS_SLUG,
        "section" => TERM_IDS__SECTION,
      ],
      [
        "id" => '__news_completed_project_category_id__',
        "title" => '<br><span><b>ID категории, в которой показываются "Реализованные проекты"</b>:</span>' . (__IN_DEV__? ' ( option: __news_completed_project_category_id__ )' : '') . '<br>',
        "callback" => [ $this->callbacks, 'menu_cf__news_completed_project_category_id__cb' ],
        "page" => POST_IDS_SLUG,
        "section" => TERM_IDS__SECTION,
      ],


      #FORM_POST_IDS
      [
        "id" => '__default_from_template_id__',
        "title" => '<span><b> ID стандартной формы свзяи</b></span>' . (__IN_DEV__? ' ( option: __default_from_template_id__ )' : '') . '<br>',
        "callback" => [ $this->callbacks, 'menu_cf_default_from_template_id_post_id_cb' ],
        "page" => POST_IDS_SLUG,
        "section" => FORM_POST_IDS__SECTION_ID_3, 
      ],
      [
        "id" => '__master_class_from_template_id__',
        "title" => '<br><br><span><b> ID стандартной формы для мастер-класса</b></span>' . (__IN_DEV__? ' ( option: __master_class_from_template_id__ )' : '') . '<br>',
        "callback" => [ $this->callbacks, 'menu_cf_master_class_from_template_id_post_id_cb' ],
        "page" => POST_IDS_SLUG,
        "section" => FORM_POST_IDS__SECTION_ID_3, 
      ],
      [
        "id" => '__sign_up_for_testing_from_template_id__',
        "title" => '<br><br><span><b>ID формы в секции "Тестирование"</b>:</span>' . (__IN_DEV__? ' ( option: __sign_up_for_testing_from_template_id__ )' : '') . '<br>',
        "callback" => [ $this->callbacks, 'menu_cf__sign_up_for_testing_from_template_id__cb' ],
        "page" => POST_IDS_SLUG,
        "section" => FORM_POST_IDS__SECTION_ID_3,
      ],
      [
        "id" => '__contact_us_from_template_id__',
        "title" => '<br><br><span><b>ID формы "Связаться с нами"</b>:</span>' . (__IN_DEV__? ' ( option: __contact_us_from_template_id__ )' : '') . '<br>',
        "callback" => [ $this->callbacks, 'menu_cf__contact_us_from_template_id__cb' ],
        "page" => POST_IDS_SLUG,
        "section" => FORM_POST_IDS__SECTION_ID_3,
      ],
      [
        "id" => '__vacancy_from_template_id__',
        "title" => '<br><br><span><b>ID формы "Подать резюму"</b>:</span>' . (__IN_DEV__? ' ( option: __vacancy_from_template_id__ )' : '') . '<br>',
        "callback" => [ $this->callbacks, 'menu_cf__vacancy_from_template_id__cb' ],
        "page" => POST_IDS_SLUG,
        "section" => FORM_POST_IDS__SECTION_ID_3,
      ],
      [
        "id" => '__pbs_upload_files_from_template_id__',
        "title" => '<br><br><span><b>ID формы "Загрузить документы" в поиске продуктов</b>:</span>' . (__IN_DEV__? ' ( option: __pbs_upload_files_from_template_id__ )' : '') . '<br>',
        "callback" => [ $this->callbacks, 'menu_cf__pbs_upload_files_from_template_id__cb' ],
        "page" => POST_IDS_SLUG,
        "section" => FORM_POST_IDS__SECTION_ID_3,
      ],
      [
        "id" => '__become_a_partner_from_template_id__',
        "title" => '<br><br><span><b>ID формы "Стать партнером"</b>:</span>' . (__IN_DEV__? ' ( option: __become_a_partner_from_template_id__ )' : '') . '<br>',
        "callback" => [ $this->callbacks, 'menu_cf__become_a_partner_from_template_id__cb' ],
        "page" => POST_IDS_SLUG,
        "section" => FORM_POST_IDS__SECTION_ID_3,
      ],
      [
        "id" => '__page_of_master_classes_hs_from_template_id__',
        "title" => '<br><br><span><b>ID формы "Записаться" на странице мастер-классов </b>:</span>' . (__IN_DEV__? ' ( option: __page_of_master_classes_hs_from_template_id__ )' : '') . '<br>',
        "callback" => [ $this->callbacks, 'menu_cf__page_of_master_classes_hs_from_template_id__cb' ],
        "page" => POST_IDS_SLUG,
        "section" => FORM_POST_IDS__SECTION_ID_3,
      ],


      #POST_IDS (4)
      [
        "id" => '__dwl_files_after_form_fill__landing_page_id_1__',
        "title" => '<span><b>Страница скаичвания файлов после заполнения формы (№1)</b> post ID:</span>' . (__IN_DEV__? ' ( option: __dwl_files_after_form_fill__landing_page_id_1__ )' : '') . '<br>',
        "callback" => [ $this->callbacks, 'menu_cf__dwl_files_after_form_fill__landing_page_id_1__cb' ],
        "page" => POST_IDS_SLUG,
        "section" => POST_IDS__SECTION_ID_4,
      ],
    ];
    $this->settings->set_fields( $args );
  }

}