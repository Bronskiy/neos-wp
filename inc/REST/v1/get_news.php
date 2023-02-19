<?php

/***
  /wp-json/myrest/v1/get_news
***/
function REST__get_news($args=[]) {
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

  // $tag_ids = null;
  // if (isset($args['tag_ids'])) $tag_ids = $args['tag_ids'];
  // else if (isset($_GET['tag_ids'])) $tag_ids = $_GET['tag_ids'];
  // if ($tag_ids) {
  //   // "1,x,3" => [1,3]
  //   $tag_ids = explode(',', $tag_ids);
  //   $tag_ids = array_filter($tag_ids, function($id) {
  //     return is_numeric($id)? 1 : 0;
  //   });
  // }
  $tag_id = null;
  if (isset($args['tag_id'])) $tag_id = $args['tag_id'];
  else if (isset($_GET['tag_id'])) $tag_id = $_GET['tag_id'];
  if (!$tag_id || !is_numeric($tag_id)) {
    $tag_id = null;
  }

  $category = null;
  /* validation is checked in template */
  if (isset($args['_category'])) $category = $args['_category'];
  else if (isset($_GET['_category'])) $category = $_GET['_category'];


  $tax_query = [];
  // if ($tag_ids && count($tag_ids)) {
  //   $tax_query[] = [
  //     'taxonomy' => MY_TAX_NEWS_TAG,
  //     'field'    => 'id',
  //     'terms'    => $tag_ids      
  //   ];
  // }
  if ($tag_id) {
    $tax_query[] = [
      'taxonomy' => MY_TAX_NEWS_TAG,
      'field'    => 'id',
      'terms'    => $tag_id
    ];
  }
  if ($category) {
    $tax_query[] = [
      'taxonomy' => MY_TAX_NEWS_CATEGORY,
      'field'    => 'slug',
      'terms'    => $category      
    ];
  }

  // get posts
  wp_reset_query();
  $WP_Query = new WP_Query([
    'post_type' => MY_CPT_NEWS,
    'posts_per_page' => $postsPerPage,
    'paged' => $page,
    'lang' => $lang,
    'tax_query' => $tax_query,
  ]);
  // if it is not 1st page and result count === 0 - get new result
  if ($WP_Query->post_count === 0 && $page != 1) {
    $WP_Query = new WP_Query([
      'post_type' => MY_CPT_NEWS,
      'posts_per_page' => $postsPerPage,
      'paged' => 1,
      'lang' => $lang,
      'tax_query' => $tax_query,
    ]);
  }

  // add acf fields to posts
  foreach ($WP_Query->posts as $index => $WP_Post) {
    $WP_Query->posts[$index]->acf = [];
    $WP_Query->posts[$index]->acf = get_fields($WP_Post->ID);
    $WP_Query->posts[$index]->page_url = get_permalink($WP_Post->ID);
  }
  $posts = $WP_Query->posts;

  return [
    'posts_per_page' => $WP_Query->query['posts_per_page'],
    'query' => $WP_Query->query,
    'page' => $WP_Query->query['paged'],
    'found_posts' => $WP_Query->found_posts,
    'post_type' => $WP_Query->query['post_type'],
    'max_num_pages' => $WP_Query->max_num_pages,
    'posts' => $posts,
    // 'tag_ids' => $tag_ids,
    'tag_id' => $tag_id,
    'category_slug' => $category,
  ];
}