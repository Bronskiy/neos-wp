<?php
add_action( "wp_enqueue_scripts", function () {
  $themeDir = get_template_directory_uri();

// wp_deregister_script( 'jquery' );
  wp_enqueue_script('jquery');
    
  wp_enqueue_script("vendors", "$themeDir/assets/js/vendors.js", NULL, '1.0.12'/*microtime()*/, true /*in footer*/);
  
  // /* must be loaded before main.js nad etc. */
  wp_enqueue_script("common-script", "$themeDir/assets/js/common-script.js", NULL, '1.0.16'/*microtime()*/, true /*in footer*/);

  wp_enqueue_script("main", "$themeDir/assets/js/main.js", NULL, '1.0.17'/*microtime()*/, true /*in footer*/);

  // /* photoswipe */
  wp_enqueue_script( "photoswipe", "$themeDir/assets/lib/photoswipe/photoswipe.min.js", NULL, '1.0.1', true /*in footer*/);
  wp_enqueue_script( "photoswipe-ui-default", "$themeDir/assets/lib/photoswipe/photoswipe-ui-default.min.js", NULL, '1.0.1', true /*in footer*/);
  
	/* Create vars in passing js file */
  if (_current_POST_ID_) {
    $current_WP_Post = get_post( _current_POST_ID_ );
    $current_WP_Post->page_url = get_permalink($current_WP_Post->ID);
    $current_WP_Post->lang = pll_current_language();
  }
  else $current_WP_Post = (object) [];
  wp_localize_script("common-script", "_wp_",
    [
      "postId" => _current_POST_ID_,
      "themeDir" => $themeDir,
      'currentPage' => $current_WP_Post,
      "links" => [
        "currentPage" => get_permalink( _current_POST_ID_ ),
      ],
    ]
  );
});


// move jquery into footer
add_action( 'wp_default_scripts', 'move_jquery_into_footer' );
function move_jquery_into_footer( $wp_scripts ) {
  if( is_admin() ) return;
  $wp_scripts->add_data( 'jquery', 'group', 1 );
  $wp_scripts->add_data( 'jquery-core', 'group', 1 );
  $wp_scripts->add_data( 'jquery-migrate', 'group', 1 );
}


function add_defer_attribute_0000($tag, $handle) {
  if( !is_admin() ) {
    // add script handles to the array below
    $scripts_to_defer = array(
      'jquery', 'jquery-core', 'jquery-migrate',
      'wp-embed',
      'vendors',
      'common-script',
      'main',
      'photoswipe',
      'photoswipe-ui-default'
    );
  
    foreach($scripts_to_defer as $defer_script) {
       if ($defer_script === $handle) {
          return str_replace(' src', ' defer src', $tag);
       }
    }
  }
  return $tag;
}
add_filter('script_loader_tag', 'add_defer_attribute_0000', 10, 2);