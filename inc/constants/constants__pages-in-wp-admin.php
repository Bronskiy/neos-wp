<?php

define( 'PAGES_IN_WP_ADMIN_ABSPATH', get_template_directory() . '/inc/pages-in-wp-admin/' );

// CUSTOM FIELDS
#POST_IDS
define( 'POST_IDS_SLUG', 'page_ids' );
define( 'POST_IDS__OPTION_GROUP', "cf_pi_og" );
define( 'POST_IDS__SECTION_ID', "cf_pi_si" );
/* option names (define in /inc/pages-in-wp-admin/inc/pages/class-admin.php)
  __about_us_post_id__
  __news_archive_post_id__
  __vacancies_post_id__
  __page_of_master_classes_id__
  __page_of_services_id__
  __contact_page_id__
*/


#POST_IDS (part 2)
define( 'POST_IDS__OPTION_GROUP_2', "cf_pi_2_og" );
define( 'POST_IDS__SECTION_ID_2', "cf_pi_2_si" );
/* option names (define in /inc/pages-in-wp-admin/inc/pages/class-admin.php)
  __contact_post_id__
  __site_settings_post_id__ 
  __contact_us_settings__
  __cookie_policy_post_id__
  __product_archive_pages__settings_id__
  __single_product_page__settings_id__
*/


#TERM_IDS (part3)
define( 'TERM_IDS__OPTION_GROUP', "cf_tu_og" );
define( 'TERM_IDS__SECTION', "cf_ti_si" );
/* option names (define in /inc/pages-in-wp-admin/inc/pages/class-admin.php)
__news_past_master_classes_tag_id__
__news_past_master_class_category_id__
__news_completed_projects_tag_id__
__news_completed_project_category_id__
*/


#FORM_POST_IDS
define( 'FORM_POST_IDS__OPTION_GROUP_3', "cf_fpi_3_og" );
define( 'FORM_POST_IDS__SECTION_ID_3', "cf_fpi_3_si" );
/* option names (define in /inc/pages-in-wp-admin/inc/pages/class-admin.php)
  __default_from_template_id__
  __master_class_from_template_id__
  __sign_up_for_testing_from_template_id__
  __contact_us_from_template_id__
  __vacancy_from_template_id__
  __pbs_upload_files_from_template_id__
  __become_a_partner_from_template_id__
  __page_of_master_classes_hs_from_template_id__
*/


#POST_IDS (4)
define( 'POST_IDS__OPTION_GROUP_4', "cf_pi_4_og" );
define( 'POST_IDS__SECTION_ID_4', "cf_pi_4_si" );
/* option names (define in /inc/pages-in-wp-admin/inc/pages/class-admin.php)
  __dwl_files_after_form_fill__landing_page_id_1__
  
*/