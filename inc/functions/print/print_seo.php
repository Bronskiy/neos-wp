<?php
/**
 * @param Array $seo_acf
 * @param Array $args
 *   @param String $args[tel] - is used for default description
 *   @param String $args[email] - is used for default description
 */
function print_seo__meta_tags($seo_acf=[], $args=[]) {
  wp_reset_query();
  if (!$seo_acf) {
    $seo_acf = get_fields(get_post());
    if (!$seo_acf) return;
  };

  foreach ($seo_acf as $key => $v) {

    // title
    if ($key == 'title') {
      if ($v) $seo_title = $v;
      if (!$v) {
        if (pll_current_language() === 'ru') {
          if ($args['seo_title_descr_type'] === 'products_and_their_taxonomies') {
            $title = get_the_title(_current_POST_ID_);
            $seo_title = "$title — купить оптом в Москве у производителя «НЕОС Ингредиентс»";
          }
          else if ($args['seo_title_descr_type'] === 'pages') {
            $title = get_the_title(_current_POST_ID_);
            $seo_title = "$title | «НЕОС Ингредиентс»";
          }
          else if ($args['seo_title_descr_type'] === 'single_news') {
            $title = get_the_title(_current_POST_ID_);
            $seo_title = "$title | «НЕОС Ингредиентс»";
          }
          else if ($args['seo_title_descr_type'] === 'single_master_classe') {
            $title = get_the_title(_current_POST_ID_);
            $seo_title = "$title | «НЕОС Ингредиентс»";
          }
          else {
            $seo_title = get_the_title(_current_POST_ID_);
          }
        }
      }
      echo "<title>$seo_title</title>\n";
    }


    // description
    else if ($key == 'description') {
      // set in yoast
      if (get_post_meta(_current_POST_ID_, '_yoast_wpseo_metadesc', true)) return;
      // set in description
      if ($v) $description = $v;
      // did not set
      else {
        if (pll_current_language() === 'ru') {
          if ($args['seo_title_descr_type'] === 'products_and_their_taxonomies') {
            $title = get_the_title(_current_POST_ID_);
            $description =  "$title. Поставки любых объемов. Собственное производство. Консультации, разработка рецептур.";
          }
          else if ($args['seo_title_descr_type'] === 'pages') {
            $title = get_the_title(_current_POST_ID_);
            $description =  "$title — оптовый производитель пищевых ингредиентов.";
          }
          else if ($args['seo_title_descr_type'] === 'single_news') {
            $title = get_the_title(_current_POST_ID_);
            $description =  "$title — новость в блоге «НЕОС Ингредиентс»";
          }
          else if ($args['seo_title_descr_type'] === 'single_master_classe') {
            $title = get_the_title(_current_POST_ID_);
            $description =  "$title — мастер-класс компании «НЕОС Ингредиентс»";
          }
          else {
            $description = get_the_title(_current_POST_ID_) .'. '. get_option('blogdescription')
            . ((isset($args['tel']) && $args['tel'])? '. '. $args['tel'] : '')
            . ((isset($args['email']) && $args['email'])? '. Email: '. $args['email'] : '')
            ;
          }
        }
      }
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