<?php

add_shortcode( 'privacy_policy_page_link', function( $attrs, $content ) {
  $page = wp_post__get_lang_post_id( get_option( 'wp_page_for_privacy_policy' ) );
  return "<a href='" . get_permalink($page) . "'>$content</a>";
});