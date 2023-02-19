<?php get_header(null, ['seo_title_descr_type' => 'pages']) ?>
<input id="wpPageNameInput" type="hidden" value="front-page">
<?php
  /* front-page */
  $id = wp_post__get_lang_post_id( get_option('page_on_front') );
  $front_page_WP_Post = get_post( $id );
  $front_page_WP_Post->acf = get_fields( $id );

  $currentLangCode = $GLOBALS['_CURRENT_LANG'];

  /* about-us info */
  $id = wp_post__get_lang_post_id( get_option('__about_us_post_id__') );
  $about_us_page = get_post( $id );
  $about_us_url = get_permalink($id);
  $about_us_page->acf = [];
  $about_us_page->acf['company_features'] = get_field('company_features', $id);
  $about_us_page->acf['fp_feature_section_title'] = get_field('fp_feature_section_title', $id);
  $about_us_page->acf['our_client_section_title'] = get_field('our_client_section_title', $id);
  $about_us_page->acf['our_clients'] = get_field('our_clients', $id);
  // $about_us_page->acf = get_fields( $id );

  $GLOBALS["_FOOTER_"]['top-margin'] = false;

  /* NEWS CATEGORY */
  $news_cat_WP_Terms = get_terms([
    'taxonomy' => MY_TAX_NEWS_CATEGORY,
    'hide_empty' => false,
    'orderby' => 'meta_value_num',
    'order' => 'ASC',
    'meta_key' => 'order',
  ]);
  foreach ($news_cat_WP_Terms as $i => $WP_Term) {
    $WP_Term->acf = get_fields($WP_Term);
  }

  global $_CONTACTS_;
  $first_selected_pin = $_CONTACTS_['map']['first_selected_pin'];

  $prod_industry_type_terms_data = get__product__product_industry_type_terms_data();
  $prod_industry_type_term_tree = $prod_industry_type_terms_data['map_tree'];
?>






<section>
  <div
    id="frontPageHeroSectionSlider"
    class="slider-hs"
    data-slide-count="<?php echo count($prod_industry_type_term_tree) ?>"
  >
    <div class="swiper-wrapper">
      <?php 
        $hs_data_sizes = [
          '(max-width: 499px) 100vh',
          '(min-width: 500px) 50vh',
          '(min-width: 799px) 33.333vh',
          '(min-width: 1239px) 25vh',
          '(min-width: 1400px) 20vh',
          '(min-width: 1700px) 16,667vh',
          '(min-width: 2399px) 14,286vh'
        ];
      ?>
      <!-- Slides -->
      <?php foreach ($prod_industry_type_term_tree as $category) { ?>
        <!-- Slide -->
        <div class="swiper-slide">
          <?php if ($category['acf']['category_avatar']) { ?>
            <img
              class="slider-hs__bgr-img u-img-cover lazy"
              src="<?php echo $category['acf']['category_avatar']['sizes']['placeholder'] ?>"
              data-src="<?php echo $category['acf']['category_avatar']['sizes']['w860'] ?>"
              data-srcset="
                <?php echo $category['acf']['category_avatar']['sizes']['medium_large'] ?> 768w,
                <?php echo $category['acf']['category_avatar']['sizes']['w860'] ?> 860w
              "
              data-sizes="<?php echo implode(',', $hs_data_sizes) ?>"
              alt="<?php echo $category['acf']['category_avatar']['alt'] ?>"
            />
          <?php } ?>
  
          <div class="slider-hs__slide-dark-overlay" data-styles-if-touch-screen="opacity:1"></div>
          <div class="slider-hs__slide-dark-overlay-const"></div>

          <div class="slider-hs__slide-wrp">
            <div class="slider-hs__slide-title-wrp">
              <h2 class="h-16px pa-0">
                <?php echo string__remove_whitespaces( __($category['name'], '_my_theme_'), '<br>') ?>
              </h2>
            </div>

            <div class="slider-hs__slide-content pos-rel pa-4" data-styles-if-touch-screen="opacity:1">
              <div class="slider-hs__slide-divider"></div>
              <div class="pb-4">
                <div class="slider-hs__slide-ul-wrp">
                  <ul class="pl-0 mb-0">
                    <?php foreach ($category['children'] as $subCategory) { ?>
                      <li>
                        <a
                          <?php /* href */ if ($subCategory['page_url']) echo 'href=\'' .  $subCategory['page_url'] . '\'' ?>
                          class="a-link a-link--color-light <?php if (!$subCategory['page_url']) echo 'a-link--inactive' ?>"
                        >
                          <?php _e($subCategory['name'], '_my_theme_') ?>
                        </a>  
                      </li>
                    <?php } ?>
                  </ul>
                </div>
              </div>

              <div class="text-center">
                <a href="<?php echo $category['page_url'] ?>" class="mdc-button mdc-button--outlined my__mdc-button--fff slider-hs__slide-learn-more-btn">
                  <span class="my__mdc-ripple-fff my__mdc-ripple--is-child"></span>
                  <?php _e('Подробнее', '_my_theme_') ?>
                </a>
              </div>
            </div>
          </div>
  
        </div>
      <?php } ?>
    </div>
  
    <!-- If we need pagination -->
    <div class="swiper-pagination"></div>
  
    <!-- If we need navigation buttons -->
    <div class="slider-hs__swiper-btn-prev">
      <div class="my-icon-btn my-icon-btn--small">
        <div class="my__mdc-ripple-fff my__mdc-ripple--is-child"></div>
        <div class="material-icons">chevron_left</div>
      </div>
    </div>
    <div class="slider-hs__swiper-btn-next">
      <div class="my-icon-btn my-icon-btn--small">
        <div class="my__mdc-ripple-fff my__mdc-ripple--is-child"></div>
        <div class="material-icons">chevron_right</div>
      </div>
    </div>
  </div>
</section>










<!-- FEATURES -->
<section class="company-feature-section section-block__wrp">
  <div class="cg-container">
    <div class="company-feature-section__h text-center">
      <a href="<?php the_permalink( $about_us_page->ID ) ?>" class="a-link-unset">
        <h2 class="h-36px h-36px--underlined h-36px--underlined-link"><?php echo $about_us_page->acf['fp_feature_section_title'] ?></h2>
      </a>
    </div>

    <div class="cg-row">
      <?php print__feature_section_items([ 'post' => $about_us_page ]); ?>
    </div>
  </div>
</section>


  





<!-- TESTING -->
<?php
  $testing_form_WP_Post = wp_post__get_lang_post( get_option('__sign_up_for_testing_from_template_id__'), $GLOBALS["_CURRENT_LANG"]);
  $testing_form_WP_Post->acf = get_fields($testing_form_WP_Post->ID);
  $testing_form = get_fields($testing_form_WP_Post->ID)['form'];
  print_form__dialog_form([
    'form_data' => $testing_form,
    'dialog_id' => 'testingFormDialog',
    'form_id' => 'testingFormDialogForm',
  ]);
?>
<section>
  <div testing-form-json-data="<?php echo htmlspecialchars( json_encode( $testing_form_WP_Post->acf['dialog_data'] ) ) ?>">
    <?php print__video_bgr_section([
      'bgr_video_section_data' => $front_page_WP_Post->acf['testing_section'],
      'video_tag_id' => 'testingVideo',
      'btn_id' => 'testingVideoActionBtn',
    ]); ?>
  </div>
</section>








<!-- NEWS -->
<section class="company-feature-section section-block__wrp bgr-color--gray_1">
  <div class="cg-container">

    <div class="section-block__h text-center">
      <a href="<?php the_permalink( $about_us_page->ID ) ?>" class="a-link-unset">
        <h2 class="h-36px h-36px--underlined h-36px--underlined-link">
          <?php echo $front_page_WP_Post->acf['news_section']['title'] ?>
        </h2>
      </a>
    </div>

    <div class="cg-row">
      <?php $nap_post_id = wp_post__get_lang_post_id( get_option('__news_archive_post_id__'), $currentLangCode ) ?>
      <?php foreach ($news_cat_WP_Terms as $i => $WP_Term) {
        $url = get_permalink( $nap_post_id ) . "?_category=" . $WP_Term->slug;
      ?>
        <div class="cg-col-12 cg-col-mt576-6 cg-col-mt768-4">
          <div class="card-type-1 mx-auto mb-6">
            <a href="<?php echo $url ?>" class="pos-rel d-block">
              <div class="my__mdc-ripple-fff my__mdc-ripple--is-child"></div>
              <img
                class="card-type-1__avatar u-img-cover lazy"
                src="<?php echo $WP_Term->acf['category_avatar']['sizes']['placeholder'] ?>"
                data-src="<?php echo $WP_Term->acf['category_avatar']['sizes']['w640'] ?>"
                data-srcset="
                  <?php echo $WP_Term->acf['category_avatar']['sizes']['medium'] ?> 300w,
                  <?php echo $WP_Term->acf['category_avatar']['sizes']['w400'] ?> 400w,
                  <?php echo $WP_Term->acf['category_avatar']['sizes']['w576'] ?> 576w,
                  <?php echo $WP_Term->acf['category_avatar']['sizes']['w640'] ?> 640w,
                  <?php echo $WP_Term->acf['category_avatar']['sizes']['medium_large'] ?> 768w,
                  <?php echo $WP_Term->acf['category_avatar']['sizes']['w860'] ?> 860w,
                  <?php echo $WP_Term->acf['category_avatar']['sizes']['w960'] ?> 960w,
                "
                alt="<?php echo $WP_Term->acf['category_avatar']['alt'] ?>"
                data-sizes="
                  (max-width: 576px) 100vw,
                  (max-width: 768px) 50vw,
                  (min-width: 768px) 33.333vw,
                "
              />
            </a>

            <div class="pa-4">
              <a href="<?php echo $url ?>" class="a-link">
                <h3 class="mb-0 pb-0 h-16px d-inline" style="font-weight: bold;">
                  <?php echo $WP_Term->name ?>
                </h3>
              </a>
            </div>

            <div class="card-type-1__text text-body-1 color--000-57">
              <?php echo $WP_Term->description ?>
            </div>

            <div class="text-right pr-2 pb-2 ">
              <a href="<?php echo $url ?>" class="mdc-button text-ff-Barkentina">
                <span class="mdc-button__ripple"></span>
                <span class="mdc-button__label">
                  <?php _e('Подробнее', '_my_theme_' ) ?>
                </span>
              </a>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</section>







<!-- CLIENTS -->
<section>
  <?php print__section_with_company_logos([
    'title' => $about_us_page->acf['our_client_section_title'],
    'companies' => $about_us_page->acf['our_clients']
  ]) ?>
</section>










<!-- SOCIALS CTA -->
<?php $_sc_ = $front_page_WP_Post->acf['social_cta'] ?>
<section class="social-cta-section section-block__wrp composed-bgr-waves">
  <div class="cg-container">
    <div class="d-flex">
      <div class="social-cta-section__content pr-6">
        <div class="section-block__h pb-8">
          <h2 class="h-36px h-36px--underlined">
            <?php echo $_sc_['title'] ?>
          </h2>
        </div>

        <div>
          <?php echo $_sc_['text'] ?>
        </div>

        <div class="d-flex pt-2">
          <?php foreach ($_sc_['socials'] as $i => $network) { ?>
            <v-btn
              fab
              color="#fff"
              class="mr-4"
            >
              <a href="<?php echo $network['link']? $network['link']['url'] : '' ?>"
                 class="mdc-fab bgr-color--fff"
                 target="_blank"
              >
                <div class="mdc-fab__ripple"></div>
                <span
                  class="mdc-fab__icon material-icons"
                  data-set-svg-child-style="
                    font-size: <?php echo $network['icon_size']? $network['icon_size'] : 32 ?>px;
                    width: <?php echo $network['icon_size']? $network['icon_size'] : 32 ?>px;
                    height: <?php echo $network['icon_size']? $network['icon_size'] : 32 ?>px;
                    <?php if ($network['icon_color']) echo "fill: {$network['icon_color']} !important;" ?>
                    <?php if ($network['icon_color']) echo "color: {$network['icon_color']} !important;" ?>
                  "
                >
                  <?php echo $network['svg_or_icon_name'] ?>
                </span>
              </a>

            </v-btn>
          <?php } ?>
        </div>
      </div>

      <div class="social-cta-section__phone-img-block">
        <div class="social-cta-section__phone-img-block__wrp">
          <img
            class="social-cta-section__phone-img-block__mobile-img u-img-cover lazy"
            src="<?php echo $_sc_['screen_img']['sizes']['placeholder'] ?>"
            data-src="<?php echo $_sc_['screen_img']['sizes']['w240'] ?>"
            data-srcset="
              <?php echo $_sc_['screen_img']['sizes']['w240'] ?>,
              <?php echo $_sc_['screen_img']['sizes']['w400'] ?> 2x
            "
            data-sizes="190px"
            alt="<?php echo $_sc_['screen_img']['alt'] ?>"
          />
          <img
            class="u-img-cover lazy"
            style="position:relative; z-index:1"
            src="<?php echo get_template_directory_uri() ?>/assets/images/mobile/mobile-w190.png"
            data-srcset="
              <?php echo get_template_directory_uri() ?>/assets/images/mobile/mobile-w190.png,
              <?php echo get_template_directory_uri() ?>/assets/images/mobile/mobile-w380.png 2x
            "
            data-sizes="190px"
            alt="mobile frame"
          />
        </div>
      </div>
    </div>
  </div>
</section>










<?php print__google_map() ?>










<?php get_footer() ?>