<?php
/**
 * @param Array $seo_acf
 * @param Array $args
 *   @param String $args[tel] - is used for default description
 *   @param String $args[email] - is used for default description
 */
function acf_constructor__seo__print_meta_tags($seo_acf=[], $args=[]) {
  wp_reset_query();
  if (!$seo_acf) {
    $seo_acf = get_fields(get_post());
    if (!$seo_acf) return;
  };

  foreach ($seo_acf as $key => $v) {
    // title
    if ($key == 'title') {
      if (!$v) $v = get_the_title(_current_POST_ID_);
      echo "<title>$v</title>\n";
    }

    // description
    else if ($key == 'description') {
      if (get_post_meta(_current_POST_ID_, '_yoast_wpseo_metadesc', true)) return;
      $description = $v? $v
      : get_the_title(_current_POST_ID_) .'. '. get_option('blogdescription')
      . ((isset($args['tel']) && $args['tel'])? '. '. $args['tel'] : '')
      . ((isset($args['email']) && $args['email'])? '. Email: '. $args['email'] : '')
      ;
      
      echo "<meta name='description' content='$description'>\n";
    }

    // keywords
    else if ($key == 'keywords') {
      if ($v) echo "<meta name='keywords' content='$v'>\n";
    }

    // meta tags
    else if ($key == 'meta_tags' && isset($seo_acf['meta_props']) && $seo_acf['meta_props']){
      if (!is_array($seo_acf[$key]) || !isset($seo_acf[$key]) || count($seo_acf[$key]) == 0 ) return;
      foreach ($seo_acf[$key] as $tag) {
        echo '<meta';
        foreach ($tag['meta_props'] as $prop) {
          echo " " . $prop['name'] . '="' . $prop['value'] . '"';
        }
        echo ">\n";
      }
    }
  }
  echo "\n";
}