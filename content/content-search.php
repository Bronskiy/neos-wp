<?php
  $post->page_url = get_permalink(); 
  $post_index = $wp_query->current_post;
  $prev_post = $post_index === 0? null : $posts[$post_index - 1];
  $next_post = isset($posts[$post_index + 1])? $posts[$post_index + 1] : null;

  $_1st_el_of_current_post_type = !$prev_post || ($prev_post->post_type !== $post->post_type);
  $_last_el_of_current_post_type = !$next_post || ($next_post->post_type !== $post->post_type);

  if ($_1st_el_of_current_post_type) { ?>
    <div class="cg-row">
      <div class="cg-col-12 mt-12">
        <h2><?php _e(POST_TYPE_TRANLSATIONS[$post->post_type], '_my_theme_') ?></h2>  
      </div>
  <?php }
?>



<?php /* PRODUCT */ ?>
<?php if ($post->post_type === MY_CPT_PRODUCT) { 
  $post->acf = get_fields($post);
?>
  <div class="cg-col-12 cg-col-mt768-6">
    <?php print_search__img_item($post, [
      'content_options' => ['description', 'product_properties']
    ]) ?>
  </div>
<?php



/* NEWS */
} else if ($post->post_type === MY_CPT_NEWS) { 
  $post->acf = get_fields($post);
?>
  <div class="cg-col-12 cg-col-mt768-6">
    <?php print_search__img_item($post) ?>
  </div>
<?php



/* OTHER */
} else { ?>
  <div class="cg-col-12">
    <div class="search-result__str-item">
      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </div>
  </div>
<?php } ?>




<?php 
  if ($_last_el_of_current_post_type){ ?>
    </div><!-- .cg-row -->
  <?php }
?>