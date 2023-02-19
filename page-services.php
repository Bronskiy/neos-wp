<?php
/**
 * Template Name: Page of services
 */
?>
<?php get_header(null, ['seo_title_descr_type' => 'pages']) ?>
<input id="wpPageNameInput" type="hidden" value="page-of-services">
<?php
  $current_WP_Post = get_post( _current_POST_ID_ );
  $current_WP_Post->acf = get_fields( _current_POST_ID_ );
  $currentLangCode = $GLOBALS['_CURRENT_LANG'];

  $contact_form = get__form__acf_form_data([
    'form_template_id' => isset($current_WP_Post->acf['form_template_id'])? $current_WP_Post->acf['form_template_id'] : null,
    'use_custom_form' => $current_WP_Post->acf['use_custom_form'],
    'form_options' => isset($current_WP_Post->acf['form_options'])? $current_WP_Post->acf['form_options'] : [],
    'custom_form' => isset($current_WP_Post->acf['custom_form'])? $current_WP_Post->acf['custom_form'] : [],
  ]);
?>





<?php 
  $hs = $current_WP_Post->acf['hero_section'];
  $hs_photo = $hs['bgr_img'];
  $hs_h1 = $hs['h1']? $hs['h1'] : $current_WP_Post->post_title;
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

        <!-- BREADCRUMBS -->
        <div class="mb-n2">
          <?php print_ui__breadcrumbs([
            [
              'title' => __('Главная', '_my_theme_'),
              'href' => pll_home_url( $currentLangCode ),
              'class' => 'a-link--fff'
            ],
            [
              'title' => $current_WP_Post->post_title,
              'disabled' => true,
            ],
          ]) ?>
        </div>

        <!-- h1 -->
        <div class="img-bgr-hs__h1-wrp">
          <h1 class="img-bgr-hs__h1"><?php echo $hs_h1 ?></h1>
        </div>

        <?php if ($hs['h2']) {
          ?><div><?php echo $hs['h2'] ?></div><?php
        } ?>
          
      </div>
    </div>
  </div>
</section>









<?php /*
<div class="cg-container mt-12">
  <?php print__direct_speach_card([
    'direct_speach_args' => $current_WP_Post->acf['hs_direct_speech']
  ]); ?>
</div>
*/ ?>




<!-- SERVICE DESCRIPTION -->
<?php if (isset($current_WP_Post->acf['description_of_services']) && $current_WP_Post->acf['description_of_services'] && count($current_WP_Post->acf['description_of_services'])): ?>
  <section>
    <div style="height:60px"></div>
    <div class="cg-container">

      <?php print__collapsible_list([
        'items' => $current_WP_Post->acf['description_of_services']
      ]); ?>

    </div>
    <div style="height:60px"></div>
  </section>
<?php endif ?>





<!-- CONSULTANTS -->
<section class="composed-bgr-waves-light">
  <?php print__feedbacks([
    'title' => $current_WP_Post->acf['consultant_section_title'],
    'feedbacks' => $current_WP_Post->acf['consultants'],
    'avatar_style' => 'person',
  ]) ?>
</section>



<!-- PRICING -->
<?php if ($current_WP_Post->acf['prices'] && count($current_WP_Post->acf['prices'])): ?>
  <section class="composed-bgr-waves">
    <div style="height:60px"></div>
    <div class="cg-container">
      <div class="text-center mb-8">
        <h2 class="h-36px h-36px--underlined">
          <?php echo $current_WP_Post->acf['price_section_title'] ?>
        </h2>
      </div>

      <?php print__price_cards([
        'post_acf' => $current_WP_Post->acf,
        'price_cards' => $current_WP_Post->acf['prices'],
        'action_btn_text' => __('Рассчитать стоимость', '_my_theme_'),
        'leran_more_btn_text' => false,
        'card_extra_class' => 'price-card--h240px pb-8',
        'extra_btn_onclick_js_code' => __IN_DEV__? "console.log(\"ym(73972975,'reachGoal','yslygi-rasschet-vyzov')\")" : "ym(73972975,'reachGoal','yslygi-rasschet-vyzov')",
      ]); ?>
    </div>
    <div style="height:80px"></div>
  </section>

  <?php
    $price_card_contact_form = $contact_form;
    if ($current_WP_Post->acf['price_card_form_cta']) {
      $price_card_contact_form['cta']['text'] = $current_WP_Post->acf['price_card_form_cta'];
    }
    print_form__dialog_form([
      'form_data' => $price_card_contact_form,
      'dialog_id' => 'priceDialog',
      'form_id' => 'priceDialogForm',
      'price_section' => 1,
      'onsubmit_js_code' => __IN_DEV__? "console.log(\"ym(73972975,'reachGoal','yslygi-rasschet-otpr')\")" : "ym(73972975,'reachGoal','yslygi-rasschet-otpr')",
    ]);
  ?>
<?php endif ?>





<?php
  $_pp = 8;
  $news_query = REST__get_news([
    '_pp' => $_pp,
    'tag_id' => get_option( '__news_completed_projects_tag_id__' ),
    '_lang' => $GLOBALS["_CURRENT_LANG"],
  ]);
?>

<?php if (count($news_query['posts'])) {
  $newsUrl = get__news__cat_tag_url([
    'category_id_option_name' => '__news_completed_project_category_id__',
    'tag_id_option_name' => '__news_completed_projects_tag_id__'
  ]);
?>
  <section class="bgr-color--fff">
    <div class="cg-container">
      <div style="height:60px"></div>

      <div class="text-center mb-12">
        <a href="<?php echo $newsUrl ?>" class="a-link-unset">
          <h2 class="h-36px h-36px--underlined h-36px--underlined-link">
            <?php echo $current_WP_Post->acf['completed_projects_section_title'] ?>
          </h2>
        </a>
      </div>

      <?php print__img_hover_posts([ 'posts' => $news_query['posts'] ]); ?>

      <?php if ($news_query['found_posts'] >= $_pp): ?>
        <div class="text-right mt-4"
          <?php if ($news_query['found_posts'] == $_pp) echo 'data-d-if="{ 0:0, 960:1 }"'?>
        >
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
<?php } ?>





<!-- FORM -->
<div class="composed-bgr-waves">
  <?php print_form__default_form_template($contact_form, [
    'before_form_text' => $current_WP_Post->acf['bottom_form_cta']
  ]) ?>
</div>



<?php
	$GLOBALS["_FOOTER_"] = [
		'top-margin' => false,
	];
  get_footer();
?>