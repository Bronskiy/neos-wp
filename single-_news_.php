<?php get_header(null, ['seo_title_descr_type' => 'single_news']) ?>
<input id="wpPageNameInput" type="hidden" value="single-news-page">
<?php
  $current_WP_Post = get_post( _current_POST_ID_ );
  $current_WP_Post->acf = get_fields(_current_POST_ID_);
  $currentLangCode = $GLOBALS['_CURRENT_LANG'];

  $news_archive_page_WP_Post = wp_post__get_lang_post( get_option('__news_archive_post_id__ '), $currentLangCode );

  /* get CATEGORIES */
  $news_categories = get__sorted_news_categories();
  $post_category = wp_get_post_terms( _current_POST_ID_, MY_TAX_NEWS_CATEGORY );
  $current_cat_slug = $post_category[0]->slug;

  /* post tags */
  $post_tags = wp_get_post_terms( _current_POST_ID_, MY_TAX_NEWS_TAG );
?>



<div class="cg-container common-page__flex-grid-container">
  <!-- BREADCRUMBS -->
  <div class="common-page__breadcrumbs-wrp" style="padding-right:52px; padding-bottom:0;">
    <?php print_ui__breadcrumbs([
      [
        'title' => __('Главная', '_my_theme_'),
        'href' => pll_home_url( $currentLangCode )
      ],
      [
        'title' => $news_archive_page_WP_Post->post_title,
        'href' => get_permalink( $news_archive_page_WP_Post->ID )
      ],
      [
        'title' => $current_WP_Post->post_title,
        'disabled' => true,
      ],
    ]) ?>
  </div>
</div>





<div class="cg-container">
  <!-- TABS -->
  <div id="newsCatTabs" class="mdc-tab-bar" role="tablist">
    <div class="mdc-tab-scroller">
      <div class="mdc-tab-scroller__scroll-area">
        <div class="mdc-tab-scroller__scroll-content">
  
          <?php foreach ($news_categories as $category) { ?>
            <a href="<?php echo get_permalink( $news_archive_page_WP_Post->ID ) . "?_category=" . $category->slug ?>"
              class="mdc-tab <?php if ($category->slug === $current_cat_slug) echo 'mdc-tab--active' ?>"
              role="tab"
              aria-selected="true"
              tabindex="0"
              data-tab-category-slug="<?php echo $category->slug ?>"
            >
              <span class="mdc-tab__content">
                <!-- <span class="mdc-tab__icon material-icons" aria-hidden="true">favorite</span> -->
                <span class="mdc-tab__text-label text-ff-Barkentina"><?php _e($category->name, '_my_theme_') ?></span>
              </span>
              <span class="mdc-tab-indicator <?php if ($category->slug === $current_cat_slug) echo 'mdc-tab-indicator--active' ?>">
                <span class="mdc-tab-indicator__content mdc-tab-indicator__content--underline"></span>
              </span>
              <span class="mdc-tab__ripple"></span>
            </a>
          <?php } ?>
  
        </div>
      </div>
    </div>
  </div>
</div>







<?php 
  $hs_photo = isset($current_WP_Post->acf['hs_bgr_img'])? $current_WP_Post->acf['hs_bgr_img'] : null;
  if (!$hs_photo) $hs_photo = $current_WP_Post->acf['card']['avatar'];
  if (!$hs_photo) $hs_photo = $current_WP_Post->acf['card']['vertical_avatar'];
?>
<section>
  <div class="img-bgr-hs">
    <div class="img-bgr-hs__img-wrp">
      <?php if ($hs_photo) { ?>
        <img
          class="u-img-cover lazy"
          src="<?php echo $hs_photo['sizes']['placeholder'] ?>"
          data-src="<?php echo $hs_photo['sizes']['w400'] ?>"
          data-srcset="
            <?php echo $hs_photo['sizes']['w400'] ?> 400w,
            <?php echo $hs_photo['sizes']['w576'] ?> 576w,
            <?php echo $hs_photo['sizes']['w640'] ?> 640w,
            <?php echo $hs_photo['sizes']['medium_large'] ?> 768w,
            <?php echo $hs_photo['sizes']['w860'] ?> 860w,
            <?php echo $hs_photo['sizes']['w960'] ?> 960w,
            <?php echo $hs_photo['sizes']['large'] ?> 1024w,
            <?php echo $hs_photo['sizes']['w1140'] ?> 1140w,
            <?php echo $hs_photo['sizes']['w1366'] ?> 1366w,
            <?php echo $hs_photo['sizes']['w1536'] ?> 1536w,
            <?php echo $hs_photo['sizes']['w1920'] ?> 1920w,
            <?php echo $hs_photo['sizes']['w2560'] ?> 2560w,
          "
          data-sizes="100vw"
          alt="<?php echo $hs_photo['alt'] ?>"
        />
      <?php } ?>
      <div class="img-bgr-hs__img-dark-overlay"></div>
    </div>

    <div class="img-bgr-hs__content">
      <div class="cg-container">

        <!-- h1 -->
        <div class="img-bgr-hs__h1-wrp">
          <h1 class="img-bgr-hs__h1"><?php echo $current_WP_Post->post_title ?></h1>
          <?php if (isset($current_WP_Post->acf['card']['city']) && $current_WP_Post->acf['card']['city']) { ?>
            <p class="mt-n2 mb-2"><?php echo $current_WP_Post->acf['card']['city'] ?></p>
          <?php } ?>

          <div class="d-flex">
            <?php foreach ($post_tags as $tag) { ?>
              <a href="<?php echo get_permalink( $news_archive_page_WP_Post->ID ) . "?_category=" . $current_cat_slug . "&tag_id=" . $tag->term_id ?>"
                 class="my-ui-chip"
              >
                <span class="my__mdc-ripple-dark my__mdc-ripple--is-child"></span>
                #<?php _e( $tag->name, '_my_theme_' ) ?>
              </a>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>











<section class="bgr-color--gray_1">
  <div class="cg-container">
    <div style="height:60px"></div>
    <?php  print_gb_content( $current_WP_Post ) ?>
    <div style="height:60px"></div>
  </div>
</section>

























<?php
  /* GET relative news */
  $tax_query = [
    'relation' => 'AND', // OR will load other languages
  ];
  $tq = [
    'relation' => 'AND',
  ];
  $tq[] = [
    'taxonomy' => MY_TAX_NEWS_CATEGORY,
    'field'    => 'slug',
    'terms'    => $current_cat_slug,
  ];
  // if only 1 tag - get this kind posts
  if (count($post_tags) === 1) {
    $tq[] = [
      'taxonomy' => MY_TAX_NEWS_TAG,
      'field'    => 'id',
      'terms'    => $post_tags[0]->term_id,
    ];
  }

  $tax_query[] = $tq;
  $WP_Query = new WP_Query([
    'post_type' => MY_CPT_NEWS,
    'posts_per_page' => 4,
    'paged' => 1,
    'orderby' => 'rand',
    'post__not_in' => [$current_WP_Post->ID],
    'tax_query' => $tax_query,
  ]);
  wp_reset_query();

  $relative_news_posts = $WP_Query->posts;
  foreach ($relative_news_posts as $i => $WP_Post) {
    $relative_news_posts[$i]->acf = get_fields( $WP_Post->ID );
    $relative_news_posts[$i]->page_url = get_permalink($WP_Post->ID);
  }
?>

<?php if (count($relative_news_posts)): ?>
  <section class="section-block__wrp bgr-color--fff">
    <div class="cg-container">
      <p class="h-20px-uppercase text-center">Смотрите также:</p><?php // TODO:translations ?>
      <div class="cg-row card-type-3-small__container">
        <?php print__nap_posts([
          'posts' => $relative_news_posts,
          'card_type' => 'small flexible width cards',
        ]); ?>
      </div>

      <div class="text-right mt-3">
        <a href="<?php echo get__news__cat_tag_url([
            'category_slug' => $current_cat_slug,
            'tag_id' => count($post_tags) === 1? $post_tags[0]->term_id : null
          ]); ?>"
           class="mdc-button mdc-button--outlined my__mdc-button--primary"
        >
          <span class="mdc-button__ripple"></span>
          <span class="mdc-button__label"><?php echo __('Смотреть все', '_my_theme_') ?></span>
        </a>
      </div>
    </div>
  </section>
<?php endif ?>









<!-- FORM -->
<div id="sectionAfterPbs" style="position:relative; z-index:1;">
  <?php 
    $contact_form = get__form__acf_form_data([
      'form_template_id' => wp_post__get_lang_post_id( get_option('__default_from_template_id__'), $GLOBALS["_CURRENT_LANG"]),
      'use_custom_form' => false,
    ]);
  ?>
  <div class="composed-bgr-waves">
    <?php print_form__default_form_template($contact_form) ?>
  </div>
</div>



<?php
	$GLOBALS["_FOOTER_"] = [ 'top-margin' => false ];
  get_footer();
?>