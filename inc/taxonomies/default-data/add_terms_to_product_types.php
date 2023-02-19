<?php // http://neos-ingredients.job/wp-content/themes/custom-theme/inc/taxonomies/default-data/add_terms_to_product_types.php
exit;

// if (!defined( 'ABSPATH' )) exit;
require_once("../../../../../../wp-load.php");
if (!__IN_DEV__) exit;

function update_acf_on_create___( $term_id ) {
  $id = MY_TAX_PRODUCT_TYPE . "_$term_id";
  update_field('order', 999998, $id);
}

function create_term___($args) {
  if (!term_exists( $args['slug'], MY_TAX_PRODUCT_TYPE )) {
    $res = wp_insert_term( $args['title'], MY_TAX_PRODUCT_TYPE, [
      'slug' => $args['slug'],
      'parent' => isset($args['parent_id'])? $args['parent_id'] : null,
    ]);
    update_acf_on_create___($res['term_id']);
  }
}




$terms = get_terms([
  'taxonomy' => MY_TAX_PRODUCT_TYPE,
  'hide_empty' => false,
]);
foreach ($terms as $i => $term) {
  update_acf_on_create___($term->term_id);
  $id = MY_TAX_PRODUCT_TYPE . "_" . $term->term_id;
  echo "$id ";
  update_field('order', 999998, $id);
}


// create_term___([
//   'title' => 'Монокомпоненты',
//   'slug' => 'monocomponents',
// ]);

// // wp_delete_term( 216, MY_TAX_PRODUCT_TYPE );

// /* Оборудование */
// $parent_id = term_exists( 'equipments', MY_TAX_PRODUCT_TYPE )['term_id'];
// if (!$parent_id) {
//   $parent_id = wp_insert_term( 'Монокомпоненты', MY_TAX_PRODUCT_TYPE, [ 'slug' => 'Оборудование' ])['term_id'];
//   update_acf_on_create___($parent_id);
// }
// create_term___([
//   'title' => 'Для нанесения смазок',
//   'slug' => 'dlya_naneseniya_smazok',
//   'parent_id' => $parent_id  
// ]);





echo 'done';