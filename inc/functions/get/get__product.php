<?php

function get__product__property_posts() {
  $product_prop_query = new WP_Query([
    'post_type' => MY_CPT_PRODUCT_PROPERTY,
    'posts_per_page' => -1,
  ]);
  $product_property_posts = [];
  
  foreach ($product_prop_query->posts as $index => $WP_Post) {
    $WP_Post->acf = get_fields($WP_Post);
    $WP_Post->post_title = __($WP_Post->post_title, '_my_theme_');
    $product_property_posts[$WP_Post->ID] = $WP_Post;
  }
  wp_reset_query();
  return $product_property_posts;
}

function get__product__product_industry_type_terms_data() {
  $post_ids = get_posts([
    'post_type' => MY_CPT_PRODUCT_INDUSTRY_TYPE_PAGE,
    'numberposts' => -1,
    'fields' => 'ids',
  ]);

  $term_posts = [];
  foreach ($post_ids as $post_id) {
    $term_id = get_field('attached_product_industry_type_id', $post_id);
    $term_posts[$term_id] = [
      'post_id' => $post_id,
      'page_url' => get_permalink($post_id),
      'attached_product_industry_type_id' => $term_id
    ];
  }

  $terms = get_terms([
    'taxonomy' => MY_TAX_PRODUCT_INDUSTRY_TYPE,
    'hide_empty' => false,
    'meta_key' => 'order',
    'order' => 'ASC',
    'orderby' => 'meta_value_num'
  ]);

  foreach ($terms as $i => $WP_Term) {
    $WP_Term->children = [];
    if (array_key_exists($WP_Term->term_id, $term_posts)) {
      $WP_Term->page_url = $term_posts[$WP_Term->term_id]['page_url'];
    }
    else {
      $WP_Term->page_url = '';
    }
    $WP_Term->acf = get_fields($WP_Term);
    $terms[$i] = (array) $WP_Term;
  }

  $prod_cat_term_tree = map__buildTree_with_props($terms, [
    'parent_id_prop_name' => 'parent',
    'id_prop_name' => 'term_id',
  ]);
  wp_reset_query();

  return [
    'map_tree' => $prod_cat_term_tree,
    'all_terms' => array__set_item_prop_val_as_item_key( 'term_id', $terms ),
  ];
}




function get__product__product_type_terms_data() {
  $post_ids = get_posts([
    'post_type' => MY_CPT_PRODUCT_TYPE_PAGE,
    'numberposts' => -1,
    'fields' => 'ids',
  ]);

  $term_posts = [];
  foreach ($post_ids as $post_id) {
    $term_id = get_field('attached_product_type_id', $post_id);
    $term_posts[$term_id] = [
      'post_id' => $post_id,
      'page_url' => get_permalink($post_id),
      'attached_product_type_id' => $term_id
    ];
  }

  $terms = get_terms([
    'taxonomy' => MY_TAX_PRODUCT_TYPE,
    'hide_empty' => false,
    'meta_key' => 'order',
    'order' => 'ASC',
    'orderby' => 'meta_value_num'
  ]);

  foreach ($terms as $i => $WP_Term) {
    $WP_Term->children = [];
    if (array_key_exists($WP_Term->term_id, $term_posts)) {
      $WP_Term->page_url = $term_posts[$WP_Term->term_id]['page_url'];
    }
    else {
      $WP_Term->page_url = '';
    }
    $WP_Term->acf = get_fields($WP_Term);
    $terms[$i] = (array) $WP_Term;
  }

  $prod_cat_term_tree = map__buildTree_with_props($terms, [
    'parent_id_prop_name' => 'parent',
    'id_prop_name' => 'term_id',
  ]);
  wp_reset_query();

  return [
    'map_tree' => $prod_cat_term_tree,
    'all_terms' => array__set_item_prop_val_as_item_key( 'term_id', $terms ),
  ];
}








/**
 * @param Array $args
 * @param Number $args['product_type_term_id']
 * @param String $args['lang'] (optional)
 */
function get__product__tax_industry_types_by_product_type($args=[]) {
  $product_type_term_id = $args['product_type_term_id'];
  $lang = isset($args['lang'])? $args['lang'] : pll_default_language();

  $industry_types = term__tags_of_category_by_category_id([
    'category_tax_name' => MY_TAX_PRODUCT_TYPE,
    'tag_tax_name' => MY_TAX_PRODUCT_INDUSTRY_TYPE,
    'category_ids' => [ $product_type_term_id ]
  ]);
  foreach ($industry_types as $key => $stdClass) {
    $industry_types[$key] = (array) get_term($stdClass->term_id, MY_TAX_PRODUCT_INDUSTRY_TYPE);
  }
  $industry_types = array__set_item_prop_val_as_item_key('term_id', $industry_types);

  // get a tree of industr_types
  $industry_type_map = map__buildTree_with_props($industry_types, [
    'parent_id_prop_name' => 'parent',
    'id_prop_name' => 'term_id',
  ]);

  $WP_Query = new WP_Query([
    'post_type' => MY_CPT_PRODUCT_INDUSTRY_TYPE_PAGE,
    'posts_per_page' =>-1,
    'lang' => $lang,
  ]);
  $industry_type_pages = $WP_Query->posts;
  wp_reset_query();

  foreach ($industry_type_pages as $key => $WP_Post) {
    $industry_type_pages[$key]->page_url = get_permalink($WP_Post->ID);
    $industry_type_pages[$key]->attached_product_industry_type_id = get_field('attached_product_industry_type_id', $WP_Post->ID);
  }
  /**
   * Array (
   *   [190] => WP_Post Object (
   *     [ID] => 262
   *     [attached_product_industry_type_id] => 190
   *     [page_url] => ...
   *     ...
   *   ),
   *   [192] => WP_Post Object (
   *     [ID] => 256
   *     [attached_product_industry_type_id] => 192
   *     [page_url] => ...
   *     ...
   *   ),
   *   ...
   * )
   */
  $industry_type_pages = array__set_item_prop_val_as_item_key('attached_product_industry_type_id', $industry_type_pages);


  $GLOBALS['___industry_type_pages___'] = $industry_type_pages;
  $industry_types = array__recursive_handler([
    'map' => $industry_type_map,
    'callback' => function($term) {
      if ( array_key_exists($term['term_id'], $GLOBALS['___industry_type_pages___']) ) {
        $term['page_url'] = $GLOBALS['___industry_type_pages___'][$term['term_id']]->page_url;
        $term['page_id'] = $GLOBALS['___industry_type_pages___'][$term['term_id']]->ID;
      }
      else {
        $term['page_url'] = null;
        $term['page_id'] = null;
      }
      return $term;
    }
  ]);
  unset($GLOBALS['___industry_type_pages___']);

  $industry_types = map__collapse_tree_to_1_lvl_array($industry_types);
  $industry_types = array_values($industry_types);

  return $industry_types;
}







/**
 * @param Array $args
 * @param Number $args['product_type_term_id']
 * @param Boolean $args['get_product_type_page_url']=false (optional)
 * @param String $args['lang'] (optional)
 */
function get__product__tax_product_types_by_industry_type($args=[]) {
  $industry_type_term_id = $args['industry_type_term_id'];
  $lang = isset($args['lang'])? $args['lang'] : pll_default_language();
  $get_product_type_page_url = isset($args['get_product_type_page_url'])? $args['get_product_type_page_url'] : false;

  $WP_Query = new WP_Query([
    'post_type' => MY_CPT_PRODUCT,
    'lang' => $lang,
    'posts_per_page' => -1,
    'fields' => 'id=>parent',
    'tax_query' => array(
      [
        'taxonomy' => MY_TAX_PRODUCT_INDUSTRY_TYPE,
        'field'    => 'id',
        'terms'    => $industry_type_term_id
      ]
    ),
  ]);
  wp_reset_query();

  $products_of_industry_type = $WP_Query->posts;
  $product_types = [];

  // get industr_types of products of set product_type
  foreach ($products_of_industry_type as $i => $WP_Post) {
    $terms = wp_get_post_terms( $WP_Post->ID, MY_TAX_PRODUCT_TYPE, 'ids' );
    // $WP_Post->product_industr_types = $terms;
    foreach ($terms as $i => $WP_Term) {
      if (!array_key_exists( $WP_Term->term_id, $product_types)) {
        $product_types[$WP_Term->term_id] = (array) $WP_Term;
      }
    }
  }

  // get a tree of industr_types
  $product_type_map = map__buildTree_with_props($product_types, [
    'parent_id_prop_name' => 'parent',
    'id_prop_name' => 'term_id',
  ]);

  // foreach ($product_type_map as $term_id => $term) {
  //   # code...
  // }

  if (!$get_product_type_page_url) {
    return [
      'term_map' => $product_type_map,
      'all_terms' => $product_types,
    ];
  }
  else {
    // get page_url ...
  }
}





/**
 *  @param Number $post_id 
 *  @param Strung $tasonomy MY_TAX_PRODUCT_TYPE | MY_TAX_PRODUCT_INDUSTRY_TYPE
 */
function get__product__product_or_industry_types_of_post( $post_id, $taxonomy ) {
  if ($taxonomy === MY_TAX_PRODUCT_TYPE) {
    $page_post_type = MY_CPT_PRODUCT_TYPE_PAGE;
    $acf_attach_id_field_name = 'attached_product_type_id';
  }
  else if ($taxonomy === MY_TAX_PRODUCT_INDUSTRY_TYPE) {
    $page_post_type = MY_CPT_PRODUCT_INDUSTRY_TYPE_PAGE;
    $acf_attach_id_field_name = 'attached_product_industry_type_id';
  }
  else {
    trigger_error( 'wrong tasonomy. Must be MY_TAX_PRODUCT_TYPE | MY_TAX_PRODUCT_INDUSTRY_TYPE', E_USER_ERROR );
  }
  
  $WP_Query = new WP_Query([
    'post_type' => $page_post_type,
    // 'lang' => $lang,
    'posts_per_page' => -1,
    'fields' => 'id=>parent',
  ]);
  wp_reset_query();
  $tax_page_posts = $WP_Query->posts;
  $arr = [];
  foreach ($tax_page_posts as $i => $WP_Post) {
    $WP_Post->{$acf_attach_id_field_name} = get_field($acf_attach_id_field_name, $WP_Post->ID);
    $arr[ $WP_Post->{$acf_attach_id_field_name} ] = $WP_Post;
  }
  $tax_page_posts = $arr;

  $GLOBALS['__xXxXx__'] = $tax_page_posts;

  $terms_raw = wp_get_post_terms( $post_id, $taxonomy );
  $arr = []; foreach ($terms_raw as $i => $WP_Term) $arr[$WP_Term->term_id] = (array) $WP_Term; $terms_raw = $arr; // set term_id as key
  $term_map = map__buildTree_with_props( $terms_raw, [
    'id_prop_name' => 'term_id',
    'parent_id_prop_name' => 'parent',
    'callback' => function($element) {
      $element['page_url'] = '';
      if (array_key_exists($element['term_id'], $GLOBALS['__xXxXx__'])) {
        $element['page_url'] = get_permalink($GLOBALS['__xXxXx__'][$element['term_id']]->ID);
      }
      return $element;
    }
  ]);
  unset($GLOBALS['__xXxXx__']);
  $terms = map__collapse_tree_to_1_lvl_array( $term_map );
  $arr = []; foreach ($terms as $i => $term) $arr[$term['term_id']] = $term; $terms = $arr; // set term_id as key
  return [
    'map' => $term_map,
    'ordered_terms' => $terms
  ];
}







function get__product__category_drawer_bgr_img($active_id_path) {
  $drawer_bgr_img = null;
  $arr = array_reverse($active_id_path);
  for ($i=0; $i < count($arr); $i++) { 
    $term_id = $arr[$i];
    $postBgrImg = get_field( 'category_avatar', "term_$term_id" );
    if ( isset($postBgrImg) && $postBgrImg ) {
      $drawer_bgr_img = $postBgrImg;
      break;
    }
  }
  return $drawer_bgr_img;
}