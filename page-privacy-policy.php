<?php
/**
 * Template Name: Privacy-policy-page
 */

add_action( 'wp_head', function() { ?>
  <style type="text/css">
    .my-ui-wp-content ul {
      padding-left: 40px;
    }
    .my-ui-wp-content ul li {
      margin-bottom: 8px;
    }
  </style>
<?php });
  get_header(null, ['seo_title_descr_type' => 'pages']);
?>
<input id="wpPageNameInput" type="hidden" value="privacy-policy-page">
<?php
  $current_WP_Post = get_post( _current_POST_ID_ );
  $current_WP_Post->acf = get_fields( _current_POST_ID_ );
  $currentLangCode = $GLOBALS['_CURRENT_LANG'];
  $_acf = $current_WP_Post->acf;
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
  <div class="text-center mb-12">
    <h1 class="h-36px h-36px--underlined"><?php echo $current_WP_Post->post_title ?></h1>
  </div>
</div>

<div class="cg-container">
  <?php print_gb_content( $current_WP_Post ) ?>
</div>

<div style="height:40px"></div>



<?php
  get_footer();
?>