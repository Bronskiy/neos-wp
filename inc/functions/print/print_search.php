<?php

/**
 * @param Object $WP_Post. Must contains $WP_Post->acf['card']...
 * @param Array $args
 * @param Array $args['content_options']=['description'] // description | product_properties
 */
function print_search__img_item($WP_Post, $args=[]) {
  $content_options = isset($args['content_options'])? $args['content_options'] : ['description'];
  [ $avatar_is_set, , $vert_avatar, , $vertical_avatar_size_conatin ] = get__card_avatar_data($WP_Post);
?>

  <article class="search-result__img-item elevation-4 mb-3">
    <div class="search-result__img-item__img-wrp" <?php if (!$avatar_is_set) echo "style='background-color: #eee;'"; ?>>
      <?php if ($avatar_is_set) { ?>
        <a href="<?php the_permalink(); ?>">
          <img
            class="lazy u-img-<?php echo $vertical_avatar_size_conatin ?>"
            src="<?php echo $vert_avatar['sizes']['placeholder'] ?>"
            data-src="<?php echo $vert_avatar['sizes']['w240'] ?>"
            data-srcset="
              <?php echo $vert_avatar['sizes']['w240'] ?> 240w,
              <?php echo $vert_avatar['sizes']['medium'] ?> 300w,
              <?php echo $vert_avatar['sizes']['w400'] ?> 400w,
              <?php echo $vert_avatar['sizes']['w576'] ?> 576w,
              <?php echo $vert_avatar['sizes']['w640'] ?> 640w,
              <?php echo $vert_avatar['sizes']['medium_large'] ?> 768w,
            "
            data-sizes="150px"
            alt="<?php echo $WP_Post->acf['card']['avatar_alt']? $WP_Post->acf['card']['avatar_alt'] : $vert_avatar['alt'] ?>"
          />
        </a>
      <?php } ?>
    </div>


    <div class="search-result__img-item__content-wrp">
      <div class="search-result__img-item__content">
        <!-- TITLE -->
        <div class="mb-2">
          <a href="<?php the_permalink(); ?>"
              class="a-link t-16px text-fw-bold color--000-87"
          ><?php the_title(); ?></a>
        </div>

        <?php if (in_array('product_properties', $content_options)) { ?>
          <!-- PROPERTIES -->
          <?php print__property_list(['properties' => $WP_Post->acf['card']['properties']]) ?>
        <?php } ?>

        <?php if (in_array('description', $content_options)) { ?>
          <!-- DESCRIPTION -->
          <p><?php
            echo $WP_Post->acf['card']['description'];
          ?></p>
        <?php } ?>
      </div>

      <!-- LEARN MORE -->
      <div class="text-right">
        <a href="<?php the_permalink() ?>"
            class="mdc-button my__mdc-button--primary mr-n1"
        >
          <span class="mdc-button__ripple"></span>
          <span class="mdc-button__label"><?php
            _e('Подробнее', '_my_theme_');
          ?></span>
        </a>
      </div>
    </div>
  </article>
<?php }