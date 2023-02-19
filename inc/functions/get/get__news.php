<?php
/**
 * @param Array $args
 *   @param String $args['lang']
 * 
 *   @param String $args['category_id_option_name']
 *   OR @param String $args['category_slug']
 * 
 *   @param String $args['tag_id_option_name']
 *   OR @param String $args['tag_id']
 */
function get__news__cat_tag_url( $args ) {
  $lang = isset($args['lang'])? $args['lang'] : pll_current_language();
  $nap_post_id = wp_post__get_lang_post_id( get_option('__news_archive_post_id__'), $lang );
  $url = get_permalink( $nap_post_id );
  $first = 1;

  if (isset($args['category_id_option_name'])) {
    $category = get_term( get_option( $args['category_id_option_name'] ), MY_TAX_NEWS_CATEGORY );
    $url .= ($first?'?':'&') . "_category=" . $category->slug;
    $first = 0;
  }
  else if (isset($args['category_slug'])) {
    $url .= ($first?'?':'&') . "_category=" . $args['category_slug'];
    $first = 0;
  }

  if (isset($args['tag_id_option_name'])) {
    $tag_id = get_option( $args['tag_id_option_name'] );
    $url .= ($first?'?':'&') . "tag_id=" . $tag_id;
    $first = 0;
  }
  else if (isset($args['tag_id'])) {
    $url .= ($first?'?':'&') . "tag_id=" . $args['tag_id'];
    $first = 0;
  }
  return $url;
}