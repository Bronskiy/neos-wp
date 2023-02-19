<?php // http://neos-ingredients.job/wp-content/themes/custom-theme/inc/taxonomies/default-data/add_terms_to_product_industry_types.php
exit;

// if (!defined( 'ABSPATH' )) exit;
require_once("../../../../../../wp-load.php");
if (!__IN_DEV__) exit;

function update_acf_on_create___( $term_id ) {
  $id = MY_TAX_PRODUCT_TYPE . "_$term_id";
  update_field('order', 999998, $id);
}

function create_term___($args) {
  if (!term_exists( $args['slug'], MY_TAX_PRODUCT_INDUSTRY_TYPE )) {
    $res = wp_insert_term( $args['title'], MY_TAX_PRODUCT_INDUSTRY_TYPE, [
      'slug' => $args['slug'],
      'parent' => $args['parent_id']
    ]);
    update_acf_on_create___($res['term_id']);
  }
}


/* Монокомпоненты */
// $parent_id = term_exists( 'monocomponents', MY_TAX_PRODUCT_INDUSTRY_TYPE )['term_id'];
// if (!$parent_id) {
//   $parent_id = wp_insert_term( 'Монокомпоненты', MY_TAX_PRODUCT_INDUSTRY_TYPE, [ 'slug' => 'monocomponents' ])['term_id'];
//   update_acf_on_create___($parent_id);
// }
// create_term___([
//   'title' => 'Пропиленгликоль',
//   'slug' => 'propylene-glycol',
//   'parent_id' => $parent_id  
// ]);
// create_term___([
//   'title' => 'Глицерин',
//   'slug' => 'glycerol',
//   'parent_id' => $parent_id  
// ]);



echo 'done';