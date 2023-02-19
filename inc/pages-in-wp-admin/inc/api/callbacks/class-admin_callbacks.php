<?php
/**
 * Trading-Scripts plugin
 */
class Admin_Callbacks {

  public function admin_post_ids() {
    return require_once PAGES_IN_WP_ADMIN_ABSPATH . "templates/admin_post_ids.php";
  }

  public function admin_my_form_data_page() {
    return require_once PAGES_IN_WP_ADMIN_ABSPATH . "templates/admin_my_form_data_page.php";
  }

  public function menu_cf_settings_cb( $input ) {
    return $input;
  }

  public function print_number_input( $option_name ) {
    /* name == fields['id'] */
    /* name = '__contact_post_id__' */
    $val = esc_attr( get_option( $option_name ));
    echo "<input 
      type='number'
      class='regular-text'
      name='" . $option_name . "'
      value='$val'
      placeholder=''
    >";
  }

  ############################
  ///       PAGE IDs       ///
  ############################
  public function menu_cf_about_us_post_id_cb() {
    $this->print_number_input( '__about_us_post_id__' );
  }
  public function menu_cf_news_archive_post_id_cb() {
    $this->print_number_input( '__news_archive_post_id__' );
  }
  public function menu_cf_vacancies_post_id_cb() {
    $this->print_number_input( '__vacancies_post_id__' );
  }
  public function menu_cf_page_of_master_classes_id_cb() {
    $this->print_number_input( '__page_of_master_classes_id__' );
  }
  public function menu_cf__page_of_services_id__cb() {
    $this->print_number_input( '__page_of_services_id__' );
  }
  public function menu_cf__contact_page_id__cb() {
    $this->print_number_input( '__contact_page_id__' );
  }

  ############################
  ///      PAGE IDs 2      ///
  ############################
  public function menu_cf_contacts_post_id_cb() {
    $this->print_number_input( '__contact_post_id__' );
  }
  public function menu_cf_global_s_settings_post_id_cb() {
    $this->print_number_input( '__site_settings_post_id__' );
  }
  public function menu_cf__contact_us_settings__cb() {
    $this->print_number_input( '__contact_us_settings__' );
  }
  public function menu_cf__cookie_policy_post_id__cb() {
    $this->print_number_input( '__cookie_policy_post_id__' );
  }
  public function menu_cf__product_archive_pages__settings_id__cb() {
    $this->print_number_input( '__product_archive_pages__settings_id__' );
  }
  public function menu_cf__single_product_page__settings_id__cb() {
    $this->print_number_input( '__single_product_page__settings_id__' );
  }


  ############################
  ///       TERM IDS       ///
  ############################
  public function menu_cf__news_past_master_classes_tag_id__cb() {
    $this->print_number_input( '__news_past_master_classes_tag_id__' );
  }
  public function menu_cf__news_past_master_class_category_id__cb() {
    $this->print_number_input( '__news_past_master_class_category_id__' );
  }
  public function menu_cf__news_completed_projects_tag_id__cb() {
    $this->print_number_input( '__news_completed_projects_tag_id__' );
  }
  public function menu_cf__news_completed_project_category_id__cb() {
    $this->print_number_input( '__news_completed_project_category_id__' );
  }



  ############################
  ///    FORM_POST_IDS     ///
  ############################
  public function menu_cf_default_from_template_id_post_id_cb() {
    $this->print_number_input( '__default_from_template_id__' );
  }
  public function menu_cf_master_class_from_template_id_post_id_cb() {
    $this->print_number_input( '__master_class_from_template_id__' );
  }
  public function menu_cf__sign_up_for_testing_from_template_id__cb() {
    $this->print_number_input( '__sign_up_for_testing_from_template_id__' );
  }
  public function menu_cf__contact_us_from_template_id__cb() {
    $this->print_number_input( '__contact_us_from_template_id__' );
  }
  public function menu_cf__vacancy_from_template_id__cb() {
    $this->print_number_input( '__vacancy_from_template_id__' );
  }
  public function menu_cf__pbs_upload_files_from_template_id__cb() {
    $this->print_number_input( '__pbs_upload_files_from_template_id__' );
  }
  public function menu_cf__become_a_partner_from_template_id__cb() {
    $this->print_number_input( '__become_a_partner_from_template_id__' );
  }
  public function menu_cf__page_of_master_classes_hs_from_template_id__cb() {
    $this->print_number_input( '__page_of_master_classes_hs_from_template_id__' );
  }



  ############################
  ///    POST_IDS 4     ///
  ############################
  public function menu_cf__dwl_files_after_form_fill__landing_page_id_1__cb() {
    $this->print_number_input( '__dwl_files_after_form_fill__landing_page_id_1__' );
  }

}
