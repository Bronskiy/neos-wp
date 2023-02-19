<?php
/**
 * Template Name: About-us-page
 */
?>
<?php get_header(null, ['seo_title_descr_type' => 'pages']) ?>
<input id="wpPageNameInput" type="hidden" value="about-us">
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
  <div class="text-center mb-4">
    <h1 class="h-36px h-36px--underlined"><?php echo $current_WP_Post->post_title ?></h1>
  </div>
</div>





<div class="cg-container mt-12">
  <?php print__direct_speach_card([
    'direct_speach_args' => $current_WP_Post->acf['hs_direct_speech']
  ]); ?>
  <div style="height:120px"></div>
</div>



<!-- FEATURES -->
<section class="company-feature-section">
  <div class="cg-container">
    <div class="company-feature-section__h text-center">
      <h2 class="h-36px h-36px--underlined">
        <?php echo $current_WP_Post->acf['au_feature_section_title'] ?>
      </h2>
    </div>

    <div class="cg-row">
      <?php print__feature_section_items([ 'post' => $current_WP_Post ]); ?>
    </div>
  </div>
  <div style="height:60px"></div>
</section>








<!-- OUR PRODUCTION -->
<?php $our_production = $current_WP_Post->acf['our_production'] ?>
<section class="composed-bgr-waves my-ui-wp-content">
  <div style="height:60px"></div>
  <div class="text-center mb-8">
    <h2 class="h-36px h-36px--underlined">
      <?php echo $our_production['title'] ?>
    </h2>
  </div>

  <div class="cg-container">
    <div class="cg-row">
      <div class="cg-col-12 cg-col-mt768-6 pos-rel">
        <div class="default-slider__slider-wrp pl-0 pr-0">
          <div class="default-slider">
            <div class="swiper-wrapper">
              <!-- Slides -->
              <?php foreach ($our_production['gallery'] as $photo) { ?>
                <!-- Slide -->
                <div class="swiper-slide">
                  <div class="aup-production-slider__slide">
                    <!-- <img src="<?php echo $photo['sizes']['placeholder'] ?>" class="aup-production-slider__slide-img-bgr"/> -->
                    <img
                      class="u-img-cover lazy"
                      src="<?php echo $photo['sizes']['placeholder'] ?>"
                      data-src="<?php echo $photo['sizes']['w240'] ?>"
                      data-srcset="
                        <?php echo $photo['sizes']['w240'] ?> 240w,
                        <?php echo $photo['sizes']['medium'] ?> 300w,
                        <?php echo $photo['sizes']['w400'] ?> 400w,
                        <?php echo $photo['sizes']['w576'] ?> 576w,
                      "
                      data-sizes="
                        (max-width: 576px) 376px,
                        (max-width: 768px) 552px,
                        (max-width: 960px) 360px,
                        (mim-width: 960px) 546px,
                      "
                      alt="<?php echo $photo['alt'] ?>"
                      data-our-production-pswp-item="<?php echo htmlspecialchars( json_encode([
                        'src' => $photo['sizes']['large'],
                        'w' => $photo['sizes']['large-width'],
                        'h' => $photo['sizes']['large-height'],
                        'msrc' => $photo['sizes']['placeholder'],
                        'title' => $photo['caption']? $photo['caption'] : null,
                      ]) ) ?>"
                    />
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
        
          <!-- prev -->
          <div class="default-slider__swiper-btn-prev" >
            <div class="my-ui-icon-btn bgr-color--transparent">
              <div class="my__mdc-ripple-dark my__mdc-ripple--is-child mdc-ripple-upgraded"></div>
              <span class="material-icons color--fff">chevron_left</span>
            </div>
          </div>
          <!-- next -->
          <div class="default-slider__swiper-btn-next">
            <div class="my-ui-icon-btn bgr-color--transparent">
              <div class="my__mdc-ripple-dark my__mdc-ripple--is-child mdc-ripple-upgraded"></div>
              <span class="material-icons color--fff">chevron_right</span>
            </div>
          </div>
        </div>
      </div><!-- cg-col -->

      <div class="cg-col-12 cg-col-mt768-6" style="line-height:1.5">
        <?php echo $our_production['text'] ?>
      </div>
    </div><!-- .cg-row -->
  </div>
  <div style="height:60px"></div>
</section>









<!-- HISTORY -->
<section class="history-slider__section">
  <div style="height:60px"></div>
  <div class="text-center mb-12">
    <h2 class="h-36px h-36px--underlined">
      <?php echo $current_WP_Post->acf['company_history_section_title'] ?>
    </h2>
  </div>

  <div class="cg-container">
    <div id="aboutUsHistorySlider" class="history-slider">
      <div class="swiper-wrapper">
        <!-- Slides -->
        <?php foreach ($current_WP_Post->acf['company_history'] as $history_stage) { ?>
          <!-- Slide -->
          <div class="swiper-slide">
            <div class="history-slider__slide">
              <div class="history-slider__slide-year-axis"></div>
              <div class="history-slider__slide-year">
                <?php echo $history_stage['year'] ?>
              </div>
              <div class="mt-3">
                <h3 class="h-16px text-fw-bold"><?php echo $history_stage['title'] ?></h3>
              </div>
              <p class="t-14px color--000-67">
                <?php echo $history_stage['description'] ?>
              </p>
            </div>
          </div>
        <?php } ?>
      </div>
    
      <!-- prev -->
      <div class="history-slider__swiper-btn-prev">
        <div class="my-ui-icon-btn elevation-3">
          <div class="my__mdc-ripple-dark my__mdc-ripple--is-child mdc-ripple-upgraded"></div>
          <span class="material-icons">chevron_left</span>
        </div>
      </div>
      <!-- next -->
      <div class="history-slider__swiper-btn-next">
        <div class="my-ui-icon-btn elevation-3">
          <div class="my__mdc-ripple-dark my__mdc-ripple--is-child mdc-ripple-upgraded"></div>
          <span class="material-icons">chevron_right</span>
        </div>
      </div>
    </div>
  </div>
  <div style="height:40px"></div>
</section>










<!-- CERTIFICATES -->
<section class="certificate-slider__section">
  <div style="height:60px"></div>
  <div class="text-center">
    <h2 class="h-36px h-36px--underlined">
      <?php _e('Сертификаты') ?>
    </h2>
  </div>

  <div class="cg-container">
    <div class="certificate-slider__slider-wrp">
      <div id="certificateSlider" class="certificate-slider">
        <div class="swiper-wrapper">
          <!-- Slides -->
          <?php foreach ($current_WP_Post->acf['certificates'] as $certificate) { ?>
            <!-- Slide -->
            <div class="swiper-slide pb-2 pt-2">
              <div class="certificate-slider__slide">
                <?php if (isset($certificate['image']) && $certificate['image']): ?>
                  <div class="certificate-slider__slide-img-wrp elevation-2 ml-1 mr-1">
                    <img
                      class="u-img-contain lazy"
                      src="<?php echo $certificate['image']['sizes']['placeholder'] ?>"
                      data-src="<?php echo $certificate['image']['sizes']['w240'] ?>"
                      data-srcset="
                        <?php echo $certificate['image']['sizes']['w240'] ?> 240w,
                        <?php echo $certificate['image']['sizes']['medium'] ?> 300w,
                        <?php echo $certificate['image']['sizes']['w400'] ?> 400w,
                        <?php echo $certificate['image']['sizes']['w576'] ?> 576w,
                      "
                      data-sizes="150px"
                      alt="<?php echo $certificate['image']['alt'] ?>"
                      data-our-certificates-pswp-item="<?php echo htmlspecialchars( json_encode([
                        'src' => $certificate['image']['sizes']['large'],
                        'w' => $certificate['image']['sizes']['large-width'],
                        'h' => $certificate['image']['sizes']['large-height'],
                        'msrc' => $certificate['image']['sizes']['placeholder'],
                        'title' => $certificate['image']['caption']? $certificate['image']['caption'] : null,
                      ]) ) ?>"
                    />
                  </div>
                <?php endif ?>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    
      <!-- prev -->
      <div class="certificate-slider__swiper-btn-prev" >
        <div class="my-ui-icon-btn bgr-color--transparent">
          <div class="my__mdc-ripple-dark my__mdc-ripple--is-child mdc-ripple-upgraded"></div>
          <span class="material-icons">chevron_left</span>
        </div>
      </div>
      <!-- next -->
      <div class="certificate-slider__swiper-btn-next">
        <div class="my-ui-icon-btn bgr-color--transparent">
          <div class="my__mdc-ripple-dark my__mdc-ripple--is-child mdc-ripple-upgraded"></div>
          <span class="material-icons">chevron_right</span>
        </div>
      </div>
    </div>
  </div>
  <div style="height:120px"></div>
</section>











<!-- FEEDBACKS -->
<section class="composed-bgr-waves">
  <?php print__feedbacks([
    'title' => $current_WP_Post->acf['feedback_section_title'],
    'feedbacks' => $current_WP_Post->acf['feedbacks'],
  ]) ?>
</section>


















<!-- CLIENTS -->
<section>
  <?php print__section_with_company_logos([
    'title' => $current_WP_Post->acf['our_client_section_title'],
    'companies' => $current_WP_Post->acf['our_clients']
  ]) ?>
</section>






<?php 
  $contact_form = get__form__acf_form_data([
    'form_template_id' => isset($_acf['form_template_id'])? $_acf['form_template_id'] : null,
    'use_custom_form' => $_acf['use_custom_form'],
    'form_options' => isset($_acf['form_options'])? $_acf['form_options'] : [],
    'custom_form' => isset($_acf['custom_form'])? $_acf['custom_form'] : [],
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