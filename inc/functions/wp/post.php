<?php

function wp_post__get_lang_post_id( $post_id, $lang_code=null ) {
  // if polylang plugin is pluged in
  if (function_exists('pll_current_language')) {
    if (!$lang_code) $lang_code = pll_current_language();
    return pll_get_post( $post_id, $lang_code );
  }
  else return $post_id;
}

function wp_post__get_lang_post( $post_id, $lang_code=null ) {
  if (!$lang_code) $lang_code = pll_current_language();
  return get_post( wp_post__get_lang_post_id($post_id, $lang_code) );
}