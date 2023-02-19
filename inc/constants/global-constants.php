<?php
define('CONTACTS_ALIAS', 'contacts');
define('SEO_ALIAS', 'seo');

define('MY_CPT_PRODUCT', '_product_');
define('MY_CPT_PRODUCT_INDUSTRY_TYPE_PAGE', 'prod_industry_type_p');
define('MY_CPT_PRODUCT_TYPE_PAGE', 'prod_type_p');
define('MY_CPT_PRODUCT_PROPERTY', 'product_property');
define('MY_CPT_PRODUCT_ARCHIVE_AND_PAGE_SETTINGS', 'product_a_p_settings');
define('MY_CPT_SETTINGS', '_site_settings_');
define('MY_CPT_SITE_FORM', '_site_form_');
define('MY_CPT_NEWS', '_news_');
define('MY_CPT_MASTER_CLASS', 'master_class');
define('MY_CPT_JOB_VACANCY', 'job_vacancy');
define('MY_CPT_MY_ICON', 'my_icon');
define('MY_CPT_LANDING_PAGE', '_landing_page_');
define('MY_CPT_AD', '_ad_');

define('POST_TYPE_TRANLSATIONS', [
  'page' => 'Страницы',
  MY_CPT_PRODUCT => 'Товары',
  MY_CPT_PRODUCT_INDUSTRY_TYPE_PAGE => 'Товары по типу отрасли',
  MY_CPT_PRODUCT_TYPE_PAGE => 'Товары по типу продукта',
  MY_CPT_NEWS => 'Новости',
  MY_CPT_JOB_VACANCY => 'Вакансии',
]);

define('MY_TAX_NEWS_CATEGORY', '_news_category_');
define('MY_TAX_NEWS_TAG', '_news_tag_');
define('MY_TAX_PRODUCT_INDUSTRY_TYPE', 'product_industry_type');
define('MY_TAX_PRODUCT_TYPE', 'product_type');

if ($_SERVER['SERVER_ADDR'] == '127.0.0.1') {
  define( '__IN_DEV__', true );
} else {
  define( '__IN_DEV__', false );
}
// REST_ENDPOINTS are set in class-rest-routes
define( 'ACF_debug', false );
