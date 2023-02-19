<?php

/***
  /wp-json/myrest/v1/get_post_cards
***/
function REST__get_post_cards() {
  $page = 1;
  if (isset($_GET['page'])) $page = $_GET['page'];

  $postsPerPage = 20;
  if (isset($_GET['posts_per_page'])) $postsPerPage = $_GET['posts_per_page'];

  if (isset($_GET['post_type'])) $posttype = $_GET['post_type'];
  else trigger_error("post_type is not set!", E_USER_ERROR);

  $lang = $_GET['lang'];

  // get posts
  $WP_Query = new WP_Query([
    'post_type' => $posttype,
    'posts_per_page' => $postsPerPage,
    'paged' => $page,
    'lang' => $lang, // use language slug in the query
  ]);

  // if it is not 1st page and result count === 0 - get new result
  if ($WP_Query->post_count === 0 && $page != 1) {
    $WP_Query = new WP_Query([
      'post_type' => $posttype,
      'posts_per_page' => $postsPerPage,
      'paged' => 1,
      'lang' => $lang, // use language slug in the query
    ]);
  }

  // add acf fields to posts
  foreach ($WP_Query->posts as $index => $WP_Post) {
    $WP_Query->posts[$index]->acf = [];
    $WP_Query->posts[$index]->acf['card_avatar'] = get_field('card_avatar', $WP_Post->ID );
    $WP_Query->posts[$index]->href = get_permalink($WP_Post->ID);
  }

  return [
    'posts_per_page' => $WP_Query->query['posts_per_page'],
    'page' => $WP_Query->query['paged'],
    'post_type' => $WP_Query->query['post_type'],
    'max_num_pages' => $WP_Query->max_num_pages,
    'posts' => $WP_Query->posts,
  ];
}