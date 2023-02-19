<?php

/***
  /wp-json/myrest/v1/get_products
***/
function REST__get_products($args=[]) {
  $page = 1;
  if (isset($args['_p'])) $page = $args['_p'];
  else if (isset($_GET['_p'])) $page = $_GET['_p'];
  if (!is_numeric($page)) $page = 1;

  $postsPerPage = 20;
  if (isset($args['_pp'])) $postsPerPage = $args['_pp'];
  else if (isset($_GET['_pp'])) $postsPerPage = $_GET['_pp'];
  if (!is_numeric($postsPerPage)) $postsPerPage = 20;

  $lang = null;
  if (isset($args['_lang'])) $lang = $args['_lang'];
  else if (isset($_GET['_lang'])) $lang = $_GET['_lang'];

  $industry_type_id = null;
  if (isset($args['industry_type_id'])) $industry_type_id = $args['industry_type_id'];
  else if (isset($_GET['industry_type_id'])) $industry_type_id = $_GET['industry_type_id'];

  $product_type_id = null;
  if (isset($args['product_type_id'])) $product_type_id = $args['product_type_id'];
  else if (isset($_GET['product_type_id'])) $product_type_id = $_GET['product_type_id'];


  $tax_query = [];
  if ($industry_type_id && $industry_type_id !== 'false' && $industry_type_id !== 'all') {
    $tax_query[] = [
      'taxonomy' => MY_TAX_PRODUCT_INDUSTRY_TYPE,
      'field'    => 'id',
      'terms'    => $industry_type_id      
    ];
  }
  if ($product_type_id && $product_type_id !== 'false' && $product_type_id !== 'all') {
    $tax_query[] = [
      'taxonomy' => MY_TAX_PRODUCT_TYPE,
      'field'    => 'id',
      'terms'    => $product_type_id      
    ];
  }

  // get posts
  wp_reset_query();
  $WP_Query = new WP_Query([
    'post_type' => MY_CPT_PRODUCT,
    'lang' => $lang,
    'posts_per_page' => $postsPerPage,
    'paged' => $page,
    'tax_query' => $tax_query,
    'orderby' => 'menu_order',
    'order' => 'ASC',
  ]);

  // if it is not 1st page and result count === 0 - get new result
  if ($WP_Query->post_count === 0 && $page != 1) {
    $WP_Query = new WP_Query([
      'post_type' => MY_CPT_PRODUCT,
      'posts_per_page' => $postsPerPage,
      'paged' => 1,
      'lang' => $lang, // use language slug in the query
      'tax_query' => $tax_query,
      'orderby' => 'menu_order',
      'order' => 'ASC',
    ]);
  }

  // add acf fields to posts
  foreach ($WP_Query->posts as $index => $WP_Post) {
    $WP_Query->posts[$index]->acf = [];
    $WP_Query->posts[$index]->acf = get_fields($WP_Post->ID);
    $WP_Query->posts[$index]->href = get_permalink($WP_Post->ID);
  }

  $posts = $WP_Query->posts;
  foreach ($posts as $i => $WP_Post) {
    $posts[$i]->page_url = get_permalink($WP_Post->ID);
  }

  return [
    'posts_per_page' => $WP_Query->query['posts_per_page'],
    'page' => $WP_Query->query['paged'],
    'post_type' => $WP_Query->query['post_type'],
    'industry_type_term_id' => $industry_type_id,
    'product_type_term_id' => $product_type_id,
    'max_num_pages' => $WP_Query->max_num_pages,
    'posts' => $posts,
  ];
}