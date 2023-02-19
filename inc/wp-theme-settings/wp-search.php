<?php

add_filter('pre_get_posts', function($query) {
  if ( $query->is_search ) {
    $query->query_vars['posts_per_page'] = 20;

    // where (post_type) does search? 
    $query->set( 'post_type', [
      'page',
      MY_CPT_PRODUCT,
      MY_CPT_PRODUCT_INDUSTRY_TYPE_PAGE,
      MY_CPT_PRODUCT_TYPE_PAGE,
      MY_CPT_NEWS,
      MY_CPT_JOB_VACANCY
    ]);
  }
  return $query; // Return our modified query variables
});