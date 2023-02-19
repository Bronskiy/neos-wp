<?php get_header() ?>
<?php
  $current_WP_Post = get_post( _current_POST_ID_ );
  $currentLangCode = $GLOBALS['_CURRENT_LANG'];
?>

<div class="cg-container common-page__flex-grid-container">
  <!-- BREADCRUMBS -->
  <div class="common-page__breadcrumbs-wrp" style="padding-right:52px">
    <?php print_ui__breadcrumbs([
      [
        'title' => __('Главная', '_my_theme_'),
        'href' => pll_home_url( $currentLangCode )
      ],
      [
        'title' => $current_WP_Post->post_title,
        'disabled' => true,
      ],
    ]) ?>
  </div>
  <!-- Title -->
  <div class="text-center mb-4">
    <h1 class="h-36px h-36px--underlined"><?php echo $current_WP_Post->post_title ?></h1>
  </div>
</div>


<section>
  <div class="cg-container">
    <div style="height:24px"></div>
    <?php  print_gb_content( $current_WP_Post ) ?>
    <div style="height:60px"></div>
  </div>
</section>



<?php get_footer() ?>