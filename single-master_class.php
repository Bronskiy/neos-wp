<?php get_header(null, ['seo_title_descr_type' => 'single_master_classe']) ?>
<input id="wpPageNameInput" type="hidden" value="single-master-class">
<?php
  $current_WP_Post = get_post( _current_POST_ID_ );
  $current_WP_Post->acf = get_fields(_current_POST_ID_);
  $currentLangCode = $GLOBALS['_CURRENT_LANG'];
  $page_of_master_classes = wp_post__get_lang_post( get_option('__page_of_master_classes_id__'), $currentLangCode );

  $contact_form = get__form__acf_form_data([
    'form_template_id' => wp_post__get_lang_post_id( get_option('__master_class_from_template_id__'), $GLOBALS["_CURRENT_LANG"]),
    'use_custom_form' => false,
  ]);
?>




<section>
  <div class="img-bgr-hs-type-2">
    <div class="img-bgr-hs-type-2__img-wrp">
      <img
        <?php $photo = $current_WP_Post->acf['event']['city_bgr'] ?>
        class="u-img-cover lazy"
        src="<?php echo $photo['sizes']['placeholder'] ?>"
        data-src="<?php echo $photo['sizes']['w400'] ?>"
        data-srcset="
          <?php echo $photo['sizes']['w400'] ?> 400w,
          <?php echo $photo['sizes']['w576'] ?> 576w,
          <?php echo $photo['sizes']['w640'] ?> 640w,
          <?php echo $photo['sizes']['medium_large'] ?> 768w,
          <?php echo $photo['sizes']['w860'] ?> 860w,
          <?php echo $photo['sizes']['w960'] ?> 960w,
          <?php echo $photo['sizes']['large'] ?> 1024w,
          <?php echo $photo['sizes']['w1140'] ?> 1140w,
          <?php echo $photo['sizes']['w1366'] ?> 1366w,
          <?php echo $photo['sizes']['w1536'] ?> 1536w,
          <?php echo $photo['sizes']['w1920'] ?> 1920w,
          <?php echo $photo['sizes']['w2560'] ?> 2560w,
        "
        data-sizes="100vw"
        alt="<?php echo $photo['alt'] ?>"
      />
      <div class="img-bgr-hs-type-2__img-dark-overlay"></div>
    </div>

    <?php 
      $dd = substr($current_WP_Post->acf['event']['date'], 0, 2);
      $mm = substr($current_WP_Post->acf['event']['date'], 3, 2);
      $yyyy = substr($current_WP_Post->acf['event']['date'], -4);
    ?>
    <div class="img-bgr-hs-type-2__content">
      <div class="cg-container">
        <!-- date -->
        <div class="img-bgr-hs-type-2__date-wrp">
          <div>
            <div class="img-bgr-hs-type-2__dd"><?php echo $dd ?></div>
            <div class="img-bgr-hs-type-2__mm"><?php echo get__month_name_by_num__dd_month($mm - 1) ?></div>
            <!-- <div class="img-bgr-hs-type-2__yyyy"><?php echo $yyyy ?></div> -->
          </div>
          <hr class="color--fff mt-2 mb-2" style="opacity:.5"/>
          <div class="img-bgr-hs-type-2__city">
            <?php echo $current_WP_Post->acf['event']['city'] ?>
          </div>
          <div>
            <?php echo $current_WP_Post->acf['event']['date'] ?>
            <?php echo $current_WP_Post->acf['event']['time'] ?>
          </div>
        </div>

        <!-- icon -->
        <div class="img-bgr-hs-type-2__icon-wrp">
          <div class="svg-inherit-wrp img-bgr-hs-type-2__h1-icon">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12.5,1.5C10.73,1.5 9.17,2.67 8.67,4.37C8.14,4.13 7.58,4 7,4A4,4 0 0,0 3,8C3,9.82 4.24,11.41 6,11.87V19H19V11.87C20.76,11.41 22,9.82 22,8A4,4 0 0,0 18,4C17.42,4 16.86,4.13 16.33,4.37C15.83,2.67 14.27,1.5 12.5,1.5M12,10.5H13V17.5H12V10.5M9,12.5H10V17.5H9V12.5M15,12.5H16V17.5H15V12.5M6,20V21A1,1 0 0,0 7,22H18A1,1 0 0,0 19,21V20H6Z"/></svg>
          </div>
        </div>

        <!-- h1 -->
        <div class="img-bgr-hs-type-2__h1-wrp">
          <div class="mb-n2">
            <?php print_ui__breadcrumbs([
              [
                'title' => __('Главная', '_my_theme_'),
                'href' => pll_home_url( $currentLangCode ),
                'class' => 'a-link--fff'
              ],
              [
                'title' => $page_of_master_classes->post_title,
                'href' => get_permalink( $page_of_master_classes->ID ),
                'class' => 'a-link--fff'
              ],
              [],
            ]) ?>
          </div>
          <h1 class="img-bgr-hs-type-2__h1"><?php echo $current_WP_Post->post_title ?></h1>
          <?php if ($current_WP_Post->acf['event']['address']): ?>
            <div class="d-flex align-center">
              <span class="material-icons colo--fff mr-2">location_on</span>
              <a href="https://www.google.com/maps/place/<?php echo urlencode($current_WP_Post->acf['event']['address']) ?>"
                target="_blank"
                class="a-link a-link--fff"
              >
                <?php echo $current_WP_Post->acf['event']['address'] ?>
              </a>
            </div>
          <?php endif ?>
        </div>
      </div>
    </div>
  </div>
</section>














<!-- SPEAKERS -->
<?php if ($current_WP_Post->acf['speakers'] && count($current_WP_Post->acf['speakers'])): ?>
  <section class="composed-bgr-waves">
    <div style="height:60px"></div>
    <div class="cg-container">
      <div class="text-center mb-8">
        <h2 class="h-36px h-36px--underlined">
          <?php echo $current_WP_Post->acf['speaker_section_title'] ?>
        </h2>
      </div>

      <div class="cg-row">
        <?php foreach ( $current_WP_Post->acf['speakers'] as $speaker) { ?>
          <div class="cg-col-12 cg-col-mt576-6 cg-col-mt768-4 mt-8">
            <div class="person-card">
              <div class="person-card__avatar">
                <img
                  class="u-img-cover lazy"
                  src="<?php echo $speaker['avatar']['sizes']['placeholder'] ?>"
                  data-src="<?php echo $speaker['avatar']['sizes']['w240'] ?>"
                  data-srcset="
                    <?php echo $speaker['avatar']['sizes']['w240'] ?> 240w,
                    <?php echo $speaker['avatar']['sizes']['medium'] ?> 300w,
                    <?php echo $speaker['avatar']['sizes']['w400'] ?> 400w,
                    <?php echo $speaker['avatar']['sizes']['w576'] ?> 576w,
                  "
                  data-sizes="300px"
                  alt="<?php echo $alt ?>"
                />
              </div>
              <div>
                <div class="h-24px mt-2 mb-2 text-center">
                  <?php echo $speaker['name'] ?>
                </div>
                <div><?php echo $speaker['description'] ?></div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
    <div style="height:80px"></div>
  </section>
<?php endif ?>







<!-- SCHEDULE -->
<?php if (isset($current_WP_Post->acf['schedule']) && $current_WP_Post->acf['schedule'] && count($current_WP_Post->acf['schedule'])): ?>
  <section>
    <div style="height:60px"></div>
    <div class="cg-container">
      <div class="text-center mb-8">
        <h2 class="h-36px h-36px--underlined">
          <?php echo $current_WP_Post->acf['schedule_title'] ?>
        </h2>
      </div>

      <?php print__collapsible_list(['items' => $current_WP_Post->acf['schedule']]) ?>
    </div>
    <div style="height:80px"></div>
  </section>
<?php endif ?>










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
        'bgr_svg_code' => '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12.5,1.5C10.73,1.5 9.17,2.67 8.67,4.37C8.14,4.13 7.58,4 7,4A4,4 0 0,0 3,8C3,9.82 4.24,11.41 6,11.87V19H19V11.87C20.76,11.41 22,9.82 22,8A4,4 0 0,0 18,4C17.42,4 16.86,4.13 16.33,4.37C15.83,2.67 14.27,1.5 12.5,1.5M12,10.5H13V17.5H12V10.5M9,12.5H10V17.5H9V12.5M15,12.5H16V17.5H15V12.5M6,20V21A1,1 0 0,0 7,22H18A1,1 0 0,0 19,21V20H6Z"/></svg>',
        'action_btn_text' => __('Зарегистрироваться', '_my_theme_'),
        'leran_more_btn_text' => false,
        'card_extra_class' => 'price-card--h240px pb-8',
        'extra_btn_onclick_js_code' => __IN_DEV__? "console.log(\"ym(73972975,'reachGoal','kart-mk-vyzov')\")" : "ym(73972975,'reachGoal','kart-mk-vyzov')",
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
      'onsubmit_js_code' => __IN_DEV__? "console.log(\"ym(73972975,'reachGoal','kart-mk-otpr')\")" : "ym(73972975,'reachGoal','kart-mk-otpr')",
    ]);
  ?>
<?php endif ?>













<!-- PARTNERS -->
<?php
  $become_a_partner_form_WP_Post = wp_post__get_lang_post( get_option('__become_a_partner_from_template_id__'), $GLOBALS["_CURRENT_LANG"]);
  $become_a_partner_form_acf = get_fields($become_a_partner_form_WP_Post->ID);
  $become_a_partner_form = $become_a_partner_form_acf['form'];

  print_form__dialog_form([
    'form_data' => $become_a_partner_form,
    'dialog_id' => 'becomeAPartnerFormDialog',
    'form_id' => 'becomeAPartnerFormDialogForm',
    'layout' => 'only-form',
  ]);
?>
<?php if (
    ($current_WP_Post->acf['our_partners'] && count($current_WP_Post->acf['our_partners']))
    || ($current_WP_Post->acf['our_inf_partners'] && count($current_WP_Post->acf['our_inf_partners']))
  ): ?>
  <section class="">
    <div style="height:60px;"></div>
    <?php print__section_with_company_logos([
      'title' => $current_WP_Post->acf['our_partner_section_title'],
      'companies' => $current_WP_Post->acf['our_partners'],
      'use_default_wrp' => false,
      'colored' => true,
    ]) ?>

    <div style="height:40px;"></div>

    <?php print__section_with_company_logos([
      'title' => $current_WP_Post->acf['our_inf_partner_section_title'],
      'companies' => $current_WP_Post->acf['our_inf_partners'],
      'use_default_wrp' => false,
      'colored' => true,
    ]) ?>

    <div class="text-center">
      <div id="becomeAPartnerActionBtn" 
          class="mdc-button mdc-button--raised text-ff-Barkentina color--fff elevation-0 mt-8"
          style="min-width:300px; height:48px; font-size:18px;"
      >
        <div class="my__mdc-ripple-fff my__mdc-ripple--is-child"></div>
        <span class="mdc-button__label"><?php _e('Стать партнером', '_my_theme_') ?></span>
      </div>
    </div>
    
    <div style="height:80px;"></div>
  </section>
<?php endif ?>







<!-- HOW IT WAS -->
<section class="bgr-color--gray_1">
  <div style="height:60px"></div>
  <div class="text-center">
    <h2 class="h-36px h-36px--underlined">
      <?php echo $current_WP_Post->acf['how_it_was_section_title'] ?>
    </h2>
  </div>
  <div style="height:60px"></div>

  <div class="cg-container">
    <div class="default-slider__slider-wrp">
      <div class="default-slider">
        <div class="swiper-wrapper">
          <!-- Slides -->
          <?php foreach ($current_WP_Post->acf['how_it_was_media'] as $media) {
            $youtubeID = $media['youtube_video_id'];
          ?>
            <!-- Slide -->
            <div class="swiper-slide">
              <div class="video__container" style="width:100%">
                <div
                  class="video__wrp"
                  data-youtube-block="https://www.youtube.com/embed/<?php echo $youtubeID ?>?hl=<?php echo $currentLangCode ?>&amp;modestbranding=1&amp;rel=0&amp;showinfo=0&amp;start=0&amp;color=white&amp;iv_load_policy=3&amp;autoplay=1"
                >
                  <img
                    class="video__block u-img-cover lazy"
                    src="<?php echo get_template_directory_uri() ?>/assets/images/img-empty-placeholder/placeholder.jpg"
                    data-src="http://i.ytimg.com/vi/<?php echo $youtubeID ?>/mqdefault.jpg"
                    alt=""
                  />
                  <svg class="video__icon" viewBox="0 0 512 512"><g><path d="M255.7,446.3c-53.3,0.3-106.6-0.4-159.8-3.3c-17.3-1-34.6-2.5-50.3-11c-10.5-5.7-18.6-13.6-23.7-24.8   C13.3,388.6,10.6,369,9,349c-3.4-41.3-3.6-82.6-1.8-123.8c0.9-21.9,1.6-44,6.8-65.5c2-8.4,4.9-16.6,8.8-24.4   c9.2-18.3,25.2-27.4,44.5-31.2c16.2-3.2,32.8-3.1,49.3-3.8c55.9-2.3,111.9-3.5,167.9-2.9c43.1,0.5,86.3,1.6,129.4,3.8   c13.3,0.7,26.7,0.9,39.4,5.6c17.2,6.4,30,17.2,36.9,34.7c6.7,16.8,9.3,34.2,10.7,52.1c3.9,48.6,4,97.2,0.8,145.8   c-1.1,16.4-2.2,32.8-6.5,48.9c-9.7,37-32.8,51.5-66.7,53.8c-36.2,2.4-72.5,3.7-108.8,4.2C298.4,446.5,277,446.3,255.7,446.3z    M203.2,344c48.4-26.5,96.2-52.7,144.8-79.3c-48.7-26.7-96.5-52.8-144.8-79.3C203.2,238.7,203.2,291,203.2,344z" fill="#DD2C28"></path><path d="M203.2,344c0-53,0-105.3,0-158.5c48.3,26.4,96.1,52.6,144.8,79.3C299.4,291.4,251.6,317.5,203.2,344z" fill="#FEFDFD"></path></g></svg>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    
      <!-- prev -->
      <div class="default-slider__swiper-btn-prev" >
        <div class="my-ui-icon-btn bgr-color--transparent">
          <div class="my__mdc-ripple-dark my__mdc-ripple--is-child mdc-ripple-upgraded"></div>
          <span class="material-icons">chevron_left</span>
        </div>
      </div>
      <!-- next -->
      <div class="default-slider__swiper-btn-next">
        <div class="my-ui-icon-btn bgr-color--transparent">
          <div class="my__mdc-ripple-dark my__mdc-ripple--is-child mdc-ripple-upgraded"></div>
          <span class="material-icons">chevron_right</span>
        </div>
      </div>
    </div>
  </div>
  <div style="height:120px"></div>
</section>















<!-- FORM -->
<div class="composed-bgr-waves">
  <?php print_form__default_form_template(
    $contact_form,
    [ 'endpoint' => $GLOBALS["REST_ENDPOINTS"]->single_master_class_form_handler ]
  ) ?>
</div>



<?php
	$GLOBALS["_FOOTER_"] = [ 'top-margin' => false ];
  get_footer();
?>