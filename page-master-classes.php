<?php
/**
 * Template Name: Page of master classes
 */
?>
<?php get_header(null, ['seo_title_descr_type' => 'pages']) ?>
<input id="wpPageNameInput" type="hidden" value="page-of-master-classes">
<?php
  $current_WP_Post = get_post( _current_POST_ID_ );
  $current_WP_Post->acf = get_fields( _current_POST_ID_ );
  $currentLangCode = $GLOBALS['_CURRENT_LANG'];
?>


<?php
  $hs_form_WP_Post = wp_post__get_lang_post( get_option('__page_of_master_classes_hs_from_template_id__'), $GLOBALS["_CURRENT_LANG"]);
  $hs_form_WP_Post->acf = get_fields($hs_form_WP_Post->ID);
  $hs_form = get_fields($hs_form_WP_Post->ID)['form'];
  print_form__dialog_form([
    'form_data' => $hs_form,
    'dialog_id' => 'pageOfMasterClassesHsFormDialog',
    'form_id' => 'pageOfMasterClassesHsFormDialogForm',
  ]);
?>
<section hs-form-json-data="<?php echo htmlspecialchars( json_encode( $hs_form_WP_Post->acf['dialog_data'] ) ) ?>">
  <?php $d = $current_WP_Post->acf['hs_video_block']; ?>
  <div class="video-bgr-section pomc__video-bgr-section">
    <div class="video-bgr-section__img">
      <img
        class="u-img-cover lazy"
        src="<?php echo $d['bgr_img']['sizes']['placeholder'] ?>"
        data-src="<?php echo $d['bgr_img']['sizes']['w400'] ?>"
        data-srcset="
          <?php echo $d['bgr_img']['sizes']['w400'] ?> 400w,
          <?php echo $d['bgr_img']['sizes']['w576'] ?> 576w,
          <?php echo $d['bgr_img']['sizes']['w640'] ?> 640w,
          <?php echo $d['bgr_img']['sizes']['medium_large'] ?> 768w,
          <?php echo $d['bgr_img']['sizes']['w860'] ?> 860w,
          <?php echo $d['bgr_img']['sizes']['w960'] ?> 960w,
          <?php echo $d['bgr_img']['sizes']['large'] ?> 1024w,
          <?php echo $d['bgr_img']['sizes']['w1140'] ?> 1140w,
          <?php echo $d['bgr_img']['sizes']['w1366'] ?> 1366w,
        "
        data-sizes="100vw"
        alt="<?php echo $d['bgr_img']['alt'] ?>"
      />
    </div>
    <div class="video-bgr-section__video">
      <video id="masterClassHsVideoBlock" autoplay muted loop data-src="<?php echo $d['bgr_video'] ?>">
        <?php // sets in js ?>
        <!-- <source src="<?php echo $d['bgr_video'] ?>" type="video/mp4"> -->
      </video>
    </div>
    <div class="video-bgr-section__dark-layout"></div>

    <div class="cg-container video-bgr-section__content">
      <div class="text-center pb-8">
        <h1 class="h-48px text-uppercase color--fff">
          <?php echo $d['title'] ?>
        </h1>
      </div>

      <?php echo $d['text'] ?>

      <div class="text-center">
        <div id="hsFromActionBtn"
             class="mdc-button mdc-button--raised text-ff-Barkentina bgr-color--fff"
             style="min-width:220px;"
        >
          <div class="my__mdc-ripple-fff my__mdc-ripple--is-child"></div>
          <span class="mdc-button__label"><?php echo $d['btn_text'] ?></span>
        </div>
        <?php print__add_js_event_listener('click', 'hsFromActionBtn', $d['btn_onclick_js_code']) ?>
      </div>
    </div>
  </div>
</section>


<section class="bgr-color--gray_1">
  <div class="cg-container">
    <!-- BREADCRUMBS -->
    <div class="pt-4">
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
  </div>

  <!-- CONTENT -->
  <div class="cg-container">
    <div style="height:40px"></div>
    <?php print_gb_content( $current_WP_Post ) ?>
    <div style="height:80px"></div>
  </div>
</section>







<?php 
  $today = date('Ymd');
  $WP_Query = new WP_Query([
    'post_type' => MY_CPT_MASTER_CLASS,
    'posts_per_page' => -1,
    'orderby' => 'meta_value',
    'order' => 'DESC',
    'meta_key' => 'event' . '_' . 'date',
    'meta_type' => 'DATE',
    'meta_query' => [
      array(
        'meta_key' => 'event' . '_' . 'date',
        'compare' => '>=',
        'type' => 'DATE',
        'value' => $today,
      ),
    ]
  ]);
  foreach ($WP_Query->posts as $index => $WP_Post) {
    $futureEventPostIds[] = $WP_Post->ID;
    $WP_Query->posts[$index]->acf = [];
    $WP_Query->posts[$index]->acf = get_fields($WP_Post->ID);
    $WP_Query->posts[$index]->page_url = get_permalink($WP_Post->ID);
  }
  $masterClasses = $WP_Query->posts;
?>
<section>
  <div style="height:60px"></div>
  <div class="text-center mb-12">
    <h2 class="h-36px h-36px--underlined">
      <?php echo $current_WP_Post->acf['master_class_section_title'] ?>
    </h2>
  </div>

  <div class="cg-container">
    <div class="cg-row">
      <?php foreach ($masterClasses as $masterClass) { ?>
        <div class="cg-col-12 cg-col-mt576-6 cg-col-mt960-4 mb-6">
          <div class="master-class-card">
            <div class="master-class-card__bgr" style="background-image: url(<?php echo $masterClass->acf['event']['city_bgr']['sizes']['w400'] ?>)"></div>
            <div class="master-class-card__dark-layout"></div>
            <div class="master-class-card__content pa-4">
              <!-- h -->
              <h2 class="mb-0"><b>
                <a href="<?php echo $masterClass->page_url ?>" class="a-link a-link--fff">
                  <?php echo $masterClass->post_title ?>
                </a>
              </b></h2>
              <div class="mt-3 mb-3">
                <div style="font-size:48px;">
                  <?php echo $masterClass->acf['event']['date'] ?>
                </div>
                <div class="mt-n3" style="font-size:20px;"><?php echo $masterClass->acf['event']['city'] ?></div>
              </div>
              <?php /*
                <!-- text -->
                <div>
                  <?php echo $masterClass->acf['event']['card_description'] ?>
                </div>
              */ ?>
              <!-- btn -->
              <div class="text-center">
                <a href="<?php echo $masterClass->page_url ?>"
                  class="mdc-button mdc-button--raised text-ff-Barkentina color--fff" style="min-width:220px;">
                  <div class="my__mdc-ripple-fff my__mdc-ripple--is-child"></div>
                  <span class="mdc-button__label"><?php _e('Подробнее', '_my_theme_') ?></span>
                </a>
              </div>
            </div><!-- .master-class-card__content -->
          </div>
        </div><!-- .cg-col-4 -->
      <?php } ?>
    </div>
  </div>
  <div style="height:74px"></div>
</section>






<!-- FEEDBACKS -->
<section class="composed-bgr-waves-light">
  <?php print__feedbacks([
    'title' => $current_WP_Post->acf['feedback_section_title'],
    'feedbacks' => $current_WP_Post->acf['feedbacks'],
    'avatar_style' => 'person',
  ]) ?>
</section>






<?php 
  $news_query = REST__get_news([
    '_pp' => 4,
    'tag_id' => get_option( '__news_past_master_classes_tag_id__' ),
    '_lang' => $GLOBALS["_CURRENT_LANG"],
  ]);
?>

<?php if (count($news_query['posts'])):
  $newsUrl = get__news__cat_tag_url([
    'category_id_option_name' => '__news_past_master_class_category_id__',
    'tag_id_option_name' => '__news_past_master_classes_tag_id__'
  ]);
?>

  <section>
    <div class="cg-container">
      <div style="height:60px"></div>

      <div class="text-center mb-12">
        <a href="<?php echo $newsUrl ?>" class="a-link-unset">
          <h2 class="h-36px h-36px--underlined h-36px--underlined-link">
            <?php echo $current_WP_Post->acf['past_master_class_section_title'] ?>
          </h2>
        </a>
      </div>

      <div class="cg-row card-type-3-small__container">
        <?php print__nap_posts([
          'posts' => $news_query['posts'],
          'card_type' => 'small flexible width cards',
        ]); ?>
      </div>

      <?php if ($news_query['max_num_pages'] > 1): ?>
        <div class="text-center mt-12">
          <a href="<?php echo $newsUrl ?>"
            id="pmcShowMorePastEventsBtn"
            class="mdc-button mdc-button--raised text-ff-Barkentina color--fff"
            style="min-width:220px;"
          >
            <div class="my__mdc-ripple-fff my__mdc-ripple--is-child"></div>
            <span class="mdc-button__label"><?php _e('Смотреть все', '_my_theme_') ?></span>
          </a>
        </div>
      <?php endif ?>
    </div>
    <div style="height:100px"></div>
  </section>
<?php endif ?>



<?php 
  $contact_form = get__form__acf_form_data([
    'form_template_id' => isset($current_WP_Post->acf['form_template_id'])? $current_WP_Post->acf['form_template_id'] : null,
    'use_custom_form' => $current_WP_Post->acf['use_custom_form'],
    'form_options' => isset($current_WP_Post->acf['form_options'])? $current_WP_Post->acf['form_options'] : [],
    'custom_form' => isset($current_WP_Post->acf['custom_form'])? $current_WP_Post->acf['custom_form'] : [],
  ]);
?>
<div class="composed-bgr-waves">
  <?php print_form__default_form_template($contact_form) ?>
</div>





<?php
	$GLOBALS["_FOOTER_"] = [
		'top-margin' => false,
	];
  get_footer();
?>