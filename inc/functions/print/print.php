<?php


function print__page_loader() {
?>
  <div id="pagePreloader" class="page-loader-wrp">
    <div class="cube-loader-wrp">
      <div class="caption">
        <div class="cube-loader">
          <div class="cube loader-1"></div>
          <div class="cube loader-2"></div>
          <div class="cube loader-4"></div>
          <div class="cube loader-3"></div>
        </div>
      </div>
    </div>
  </div>
<?php }

function print__page_loader_syles() { ?>
  <style>
    .page-loader-wrp {
      position: fixed;
      top:0;
      left:0;
      height: 100vh;
      width: 100vw;
      background-color: #fff;
      z-index: 500;
    }
    .cube-loader-wrp {
      align-items: center;
      display: flex;
      height: 100%;
      width: 100%;
      position: fixed;
    }
    .cube-loader-wrp .caption {
      margin: 0 auto;
    }
    .cube-loader-wrp .cube-loader {
      width: 73px;
      height: 73px;
      margin: 0 auto;
      margin-top: 49px;
      position: relative;
      transform: rotateZ(45deg);
    }
    .cube-loader-wrp .cube-loader .cube {
      position: relative;
      transform: rotateZ(45deg);
      width: 50%;
      height: 50%;
      float: left;
      transform: scale(1.1);
    }
    .cube-loader-wrp .cube-loader .cube:before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: #f15a29;
      animation: cube-loader 2.76s infinite linear both;
      transform-origin: 100% 100%;
    }
    .cube-loader-wrp .cube-loader .loader-2 {
      transform: scale(1.1) rotateZ(90deg);
    }
    .cube-loader-wrp .cube-loader .loader-3 {
      transform: scale(1.1) rotateZ(180deg);
    }
    .cube-loader-wrp .cube-loader .loader-4 {
      transform: scale(1.1) rotateZ(270deg);
    }
    .cube-loader-wrp .cube-loader .loader-2:before {
      animation-delay: 0.35s;
    }
    .cube-loader-wrp .cube-loader .loader-3:before {
      animation-delay: 0.69s;
    }
    .cube-loader-wrp .cube-loader .loader-4:before {
      animation-delay: 1.04s;
    }
    @keyframes cube-loader {
      0%, 10% {
        transform: perspective(136px) rotateX(-180deg);
        opacity: 0;
      }
      25%, 75% {
        transform: perspective(136px) rotateX(0deg);
        opacity: 1;
      }
      90%, 100% {
        transform: perspective(136px) rotateY(180deg);
        opacity: 0;
      }
    }
  </style>
<?php }








function print__section_with_company_logos( $args ) {
  $title = $args['title'];
  $companies = $args['companies'];
  $use_default_wrp = isset($args['use_default_wrp'])? $args['use_default_wrp'] : true;
  $colored = isset($args['colored'])? $args['colored'] : false;
  if (!$companies || !count($companies)) return;
?>
  <?php if ($use_default_wrp): ?><div class="section-with-company-logos"><?php endif ?>
    <div class="cg-container">
      <div class="section-with-company-logos__title text-center">
        <h2 class="h-36px h-36px--underlined">
          <?php echo $title ?>
        </h2>
      </div>
  
      <div class="cg-row justify-content-center">
        <?php foreach ($companies as $i => $company) {
          $link = isset($company['link']) && isset($company['link']['url'])? $company['link']['url'] : false;
        ?>
          <?php if ($link): ?>
            <a href="<?php echo $link ?>" target="_blank" class="cg-col-4 cg-col-mt400-3 cg-col-mt768-2 pos-rel">
          <?php else: ?>
            <div class="cg-col-4 cg-col-mt400-3 cg-col-mt768-2 pos-rel">
          <?php endif ?>
          
            <div role="img" aria-label="<?php echo $company['alt'] ?>">
            </div>
            <?php if ($company['svg_logo']): ?>
              <div class="section-with-company-logos__logo-wrp <?php if (!$colored) echo 'section-with-company-logos__logo-wrp--decolorized' ?> svg-inherit-wrp">
                <?php echo $company['svg_logo'] ?>
              </div>
              
            <?php elseif ($company['img_logo']): ?>
              <div class="section-with-company-logos__logo-wrp <?php if (!$colored) echo 'section-with-company-logos__logo-wrp--decolorized' ?>">
                <img
                  class="u-img-contain lazy"
                  src="<?php echo $company['img_logo']['sizes']['placeholder'] ?>"
                  data-src="<?php echo $company['img_logo']['sizes']['w400'] ?>"
                  data-srcset="
                    <?php echo $company['img_logo']['sizes']['w400'] ?> 400w,
                    <?php echo $company['img_logo']['sizes']['w576'] ?> 576w,
                  "
                  data-sizes="33vw"
                  alt=""
                />
              </div>
  
            <?php else: ?>
              <div class="section-with-company-logos__logo-wrp <?php if (!$colored) echo 'section-with-company-logos__logo-wrp--decolorized' ?> svg-inherit-wrp">
                <div class="svg-icon-wrp" style="fill:#ffcd00; height:80px; width:100%;">
                  <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M13,14H11V10H13M13,18H11V16H13M1,21H23L12,2L1,21Z"/></svg>
                </div>
              </div>
            <?php endif ?>

            <?php if ($link): ?>
              </a>
            <?php else: ?>
              </div>
            <?php endif ?>

        <?php } ?>
      </div>
    </div>
  <?php if ($use_default_wrp): ?></div><?php endif ?>
<?php }




function print__direct_speach_card( $args ) {
  $avatar = $args['direct_speach_args']['avatar'];
  $direct_speech = $args['direct_speach_args']['direct_speech'];
  $signature = $args['direct_speach_args']['signature'];
?>
  <div class="direct-speech-card">
    <div class="direct-speech-card__quote-left">
      <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M10,7L8,11H11V17H5V11L7,7H10M18,7L16,11H19V17H13V11L15,7H18Z"/></svg>
    </div>

    <?php if ( isset($avatar) && $avatar ): ?>
      <div class="direct-speech-card__img-wrp">
        <img
          class="u-img-cover lazy"
          src="<?php echo $avatar['sizes']['placeholder'] ?>"
          data-src="<?php echo $avatar['sizes']['w400'] ?>"
          data-srcset="
            <?php echo $avatar['sizes']['w400'] ?> 400w,
            <?php echo $avatar['sizes']['w576'] ?> 576w,
          "
          data-sizes="100vw"
          alt="<?php echo $avatar['alt'] ?>"
        />
      </div>
    <?php endif ?>

    <!-- content -->
    <div class="direct-speech-card__content my-ui-wp-content">
      <div><?php echo $direct_speech ?></div>
      <div class="text-right color--000-57"><?php echo $signature ?></div>
    </div>

    <div class="direct-speech-card__quote-right">
      <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M14,17H17L19,13V7H13V13H16M6,17H9L11,13V7H5V13H8L6,17Z"/></svg>
    </div>
  </div>
<?php }







function print__photoswipe_gallery_layout() { ?>
  <!-- Root element of PhotoSwipe. Must have class pswp. -->
  <div id="commonPSWP" class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
    <!-- Background of PhotoSwipe. 
      It's a separate element as animating opacity is faster than rgba(). -->
    <div class="pswp__bg"></div>

    <!-- Slides wrapper with overflow:hidden. -->
    <div class="pswp__scroll-wrap">

      <!-- Container that holds slides. 
        PhotoSwipe keeps only 3 of them in the DOM to save memory.
        Don't modify these 3 pswp__item elements, data is added later on. -->
      <div class="pswp__container">
        <div class="pswp__item"></div>
        <div class="pswp__item"></div>
        <div class="pswp__item"></div>
      </div>

      <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
      <div class="pswp__ui pswp__ui--hidden">

        <div class="pswp__top-bar">

          <!--  Controls are self-explanatory. Order can be changed. -->
          <div class="pswp__counter"></div>
          <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
          <button class="pswp__button pswp__button--share" title="Share"></button>
          <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
          <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

          <!-- Preloader demo https://codepen.io/dimsemenov/pen/yyBWoR -->
          <!-- element will get class pswp__preloader--active when preloader is running -->
          <div class="pswp__preloader">
            <div class="pswp__preloader__icn">
              <div class="pswp__preloader__cut">
              <div class="pswp__preloader__donut"></div>
              </div>
            </div>
          </div>
        </div>

        <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
          <div class="pswp__share-tooltip"></div> 
        </div>

        <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
        </button>

        <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
        </button>

        <div class="pswp__caption">
          <div class="pswp__caption__center"></div>
        </div>
        
      </div><!-- .pswp__ui.pswp__ui--hidden -->
    </div><!-- .pswp__scroll-wrap -->
  </div><!-- .pswp -->
<?php }





/**
 * $args['post'] - post + post->acf[...all ACFs]
 */
function print__feature_section_items($args) {
  $about_us_page = $args['post'];

  foreach ($about_us_page->acf['company_features'] as $index => $feature) { ?>
    <!-- divider -->
    <?php if ($index !== 0 && $index % 3 === 0) { ?>
      <div class="cg-col-12" data-d-if="{ 0:0, 960:1 }">
        <div class="company-feature-section__divider"></div>
      </div>
    <?php } else if ($index !== 0 && $index % 2 === 0) { ?>
      <div class="cg-col-12" data-d-if="{ 0:0, 576:1, 960:0 }">
        <div class="company-feature-section__divider"></div>
      </div>
    <?php } ?>

    <div class="cg-col-12 cg-col-mt576-6 cg-col-mt960-4">
      <div class='company-feature-section__card d-flex'>
        <!-- Icon -->
        <div class="company-feature-section__card__icon-wrp mr-4">
          <div class="company-feature-section__card__icon">
            <?php echo $feature['svg'] ?>
          </div>
        </div>

        <!-- Content -->
        <div>
          <h3
            class="company-feature-section__card__title pa-0 <?php if (!$feature['description']) echo 'd-flex align-center' ?>"
            <?php if (!$feature['description']) echo 'style="height:80px"' ?>
          >
            <?php echo $feature['title'] ?>
          </h3>

          <?php if ($feature['description']) { ?>
            <p class="pt-3"><?php echo $feature['description'] ?></p>
          <?php } ?>
          <?php if ($feature['btn']['link']) { ?>
            <button class="mdc-button mdc-button--outlined my__mdc-button--primary" style="width:100%;">
              <span class="mdc-button__ripple"></span>
              <span class="mdc-button__label"><?php echo $feature['btn']['link']['title'] ?></span>
            </button>
          <?php } ?>
        </div>
      </div>
    </div>
  <?php } ?>
<?php }









/**
 * @param Array $infographics = WP_Post->acf['infographics']
 */
function print__product_category_infographics($infographics) {
    if ($infographics && count($infographics)) {
  ?>
    <div class="cg-row d-flex justify-content-center mb-12" style="margin-top:-48px;">
      <?php foreach ($infographics as $infographic) { ?>
        <div class="cg-col-12 cg-col-mt768-6 cg-col-mt960-3 mt-12">
          <div class="infographic-card">
            <!-- ICON -->
            <div class="infographic-card__svg-wrp"><?php
              $svg_icon = $infographic['svg_icon']? $infographic['svg_icon'] : get_field('svg_icon', $infographic['built_in_svg_icon']);
              echo $svg_icon;
            ?></div>
            <!-- TITLE -->
            <div class="h-20px mt-3">
              <?php
                if ($infographic['number_props']['prefix']) echo $infographic['number_props']['prefix'];
                $ln = strlen($infographic['number_props']['value']);
                $extraW = $ln > 3? intdiv($ln, 3) * 12 : 0;
                $minWidth = $ln * 19.4 + $extraW;
              ?>
              <b><span
                class="infographic-animated-number d-inline-block h-36px text-left"
                style="letter-spacing: 1px; min-width:<?php echo $minWidth ?>px;"
                data-count-up-params="<?php echo htmlspecialchars( json_encode([
                  'value' => +$infographic['number_props']['value'],
                  'startVal' => +$infographic['number_props']['start_value'],
                  'duration' => +$infographic['number_props']['duration'],
                  'decimalPlaces' => +$infographic['number_props']['decimal_places'],
                ]) ) ?>"
              >
                <?php echo $infographic['number_props']['start_value'] ?>
              </span></b>
              <?php if ($infographic['number_props']['suffix']) echo $infographic['number_props']['suffix'];?>
            </div>

            <?php /* DESCRIPTION */ if ($infographic['description']): ?>
              <div class="t-14px mt-3"><?php echo $infographic['description'] ?></div>
            <?php endif ?>
          </div>
        </div>
      <?php } ?>
    </div>
  <?php } ?>
<?php }










/**
 * @param Array $args
 *   @param Array $args[bgr_video_section_data]* - WP_Post->acf[name] // result of MY_ACF->my_acf_bgr_viedo_section(...)
 *   @param String $args[video_tag_id]*
 *   @param String $args[btn_attrs] = null - string with any tag attrs exept style and classes!
 */
function print__video_bgr_section($args) {
  $d = $args['bgr_video_section_data'];
  $btn_id = isset($args['btn_id']) ? $args['btn_id'] : null;
  if ($d && count($d)) {
?>
  <div class="video-bgr-section">
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
      <video id="<?php echo $args['video_tag_id'] ?>" autoplay muted loop data-src="<?php echo $d['bgr_video'] ?>">
        <?php // sets in js ?>
        <!-- <source src="<?php echo $d['bgr_video'] ?>" type="video/mp4"> -->
      </video>
    </div>
    <div class="video-bgr-section__dark-layout"></div>

    <div class="cg-container video-bgr-section__content">
      <div class="text-center pb-8">
        <h2 class="h-36px h-36px--underlined h-36px--underlined--fff color--fff">
          <?php echo $d['title'] ?>
        </h2>
      </div>

      <?php echo $d['text'] ?>

      <div class="text-center">
        <div
          <?php if ($btn_id) echo "id='$btn_id'" ?>
          class="mdc-button mdc-button--raised text-ff-Barkentina color--fff"
          style="min-width:220px"
          <?php if (isset($args['btn_attrs'])) echo $args['btn_attrs'] ?>
        >
          <div class="my__mdc-ripple-fff my__mdc-ripple--is-child"></div>
          <span class="mdc-button__label"><?php echo $d['btn_text'] ?></span>
        </div>
        <?php print__add_js_event_listener('click', $btn_id, $d['btn_onclick_js_code']) ?>
      </div>
    </div>
  </div>
<?php }
}





/**
 * @param Array $args*
 *   @param String $args[title]
 *   @param Array $args[feedbacks]
 *   @param String $args[avatar_style]=default  default | person
 */
function print__feedbacks($args) {
  $title = $args['title'];
  $feedbacks = $args['feedbacks'];
  $avatar_style = isset($args['avatar_style'])? $args['avatar_style'] : 'default';
?>
  <div class="feedback-slider__section">
    <div class="text-center mb-8">
      <h2 class="h-36px h-36px--underlined">
        <?php echo $title ?>
      </h2>
    </div>
  
    <div class="cg-container">
      <div class="default-slider__slider-wrp" data-default-slider>
        <div class="default-slider">
          <div class="swiper-wrapper">
            <!-- Slides -->
            <?php foreach ($feedbacks as $index => $feedback) { ?>
              <!-- Slide -->
              <div class="swiper-slide">
                <div class="feedback-slider__slide" data-my-slide-index="<?php echo $index ?>">
                  <?php 
                    if ($feedback['alt']) {
                      $alt = $feedback['alt'];
                    }
                    else if (isset($feedback['img_logo']) && $feedback['img_logo']) {
                      $alt = $feedback['img_logo']['alt'];
                    }
                  ?>
                  <!-- logo -->
                  <div
                    class="feedback-slider__slide-avatar"
                    role="img"
                    aria-label="<?php echo $alt ?>"
                    <?php if ( !isset($feedback['img_logo']) || !$feedback['img_logo'] ) { ?>
                      style="min-width:0px;"
                    <?php } ?>
                  >
                    <?php if ( $avatar_style === 'default' ) { ?>
                      <?php if (isset($feedback['svg_logo']) && $feedback['svg_logo']): ?>
      
                        <div class="feedback-slider__slide-svg-wrp svg-inherit-wrp">
                          <?php echo $feedback['svg_logo'] ?>
                        </div>
      
                      <?php elseif (isset($feedback['img_logo']) && $feedback['img_logo']): ?>
                        <div class="feedback-slider__slide-img-wrp">
                          <img
                            class="u-img-contain lazy"
                            src="<?php echo $feedback['img_logo']['sizes']['placeholder'] ?>"
                            data-src="<?php echo $feedback['img_logo']['sizes']['w240'] ?>"
                            data-srcset="
                              <?php echo $feedback['img_logo']['sizes']['w240'] ?> 240w,
                              <?php echo $feedback['img_logo']['sizes']['medium'] ?> 300w,
                              <?php echo $feedback['img_logo']['sizes']['w400'] ?> 400w,
                              <?php echo $feedback['img_logo']['sizes']['w576'] ?> 576w,
                            "
                            data-sizes="150px"
                            alt="<?php echo $alt ?>"
                          />
                        </div>
                      <?php endif ?>

                    <?php } else if ( $avatar_style === 'person' ) { ?>
                      <?php if (isset($feedback['img_logo']) && $feedback['img_logo']): ?>
                        <div class="feedback-slider__slide-person-img-wrp">
                          <img
                            class="
                              u-img-<?php echo (isset($feedback['img_logo_conatin']) && $feedback['img_logo_conatin']) ? 'contain' : 'cover' ?>
                              lazy
                            "
                            src="<?php echo $feedback['img_logo']['sizes']['placeholder'] ?>"
                            data-src="<?php echo $feedback['img_logo']['sizes']['w240'] ?>"
                            data-srcset="
                              <?php echo $feedback['img_logo']['sizes']['w240'] ?> 240w,
                              <?php echo $feedback['img_logo']['sizes']['medium'] ?> 300w,
                              <?php echo $feedback['img_logo']['sizes']['w400'] ?> 400w,
                              <?php echo $feedback['img_logo']['sizes']['w576'] ?> 576w,
                            "
                            data-sizes="150px"
                            alt="<?php echo $alt ?>"
                          />
                        </div>
                      <?php endif ?>
                    <?php } ?>
                  </div><!-- .feedback-slider__slide-avatar -->

  
                  <!-- description -->
                  <div class="feedback-slider__slide-text-wrp">
                    <?php if ($feedback['author']): ?>
                      <h3 class="feedback-slider__author-name h-20px text-fw-bold"><?php echo $feedback['author'] ?></h3>
                    <?php endif ?>
                    <p>
                      <?php echo $feedback['text'] ?>
                    </p>
                  </div>
  
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      
        <!-- prev -->
        <div class="default-slider__swiper-btn-prev" >
          <div class="my__mdc-ripple-dark my__mdc-ripple--is-child mdc-ripple-upgraded"></div>
          <div class="my-ui-icon-btn bgr-color--transparent">
            <span class="material-icons">chevron_left</span>
          </div>
        </div>
        <!-- next -->
        <div class="default-slider__swiper-btn-next">
          <div class="my__mdc-ripple-dark my__mdc-ripple--is-child mdc-ripple-upgraded"></div>
          <div class="my-ui-icon-btn bgr-color--transparent">
            <span class="material-icons">chevron_right</span>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php }








/**
 * @param Array $posts - [WP_Post+acf, ...]
 * @param String $card_type - 'small flexible width cards' | 'browsing'
 */
function print__nap_posts( $args ) {
  $posts = $args['posts'];
  $card_type = isset($args['card_type'])? $args['card_type'] : 'browsing';

  if ($card_type === 'small flexible width cards') {
    $card_type_class="product-card-small";
    $card_col_class="cg-col-12 cg-col-mt576-6 cg-col-mt960-4";
    $data_sizes='
      (max-width: 576px) '. 376 *1.3 .'px,
      (max-width: 768px) '. 264 *1.3 .'px,
      (min-width: 960px) '. 360 *1.3 .'px,
      (min-width: 1140px) '. 296 *1.3 .'px,
      (max-width: 1140px) '. 356 *1.3 .'px,
    ';
  }
  else {
    $card_type_class="card-type-3";
    $card_col_class="cg-col-auto";
    $data_sizes="350px";
  }


  if (count($posts)) {
    foreach ($posts as $index => $WP_Post) { ?>

      <div class="<?php echo $card_col_class ?>" <?php
        if ($index%4 === 3 && $card_type === 'small flexible width cards') {
          echo 'data-d-if="{ 0:1, 960:0 }"';
        } ?>
      >
        <div class="<?php echo $card_type_class ?>">
        <!-- avatar -->
        <?php [ $avatar_is_set, $hor_avatar, $vert_avatar ] = get__card_avatar_data($WP_Post); ?>
        <?php if ($avatar_is_set) { ?>
          <div class="<?php echo $card_type_class ?>__img-wrp">
            <a href="<?php echo get_permalink($WP_Post->ID) ?>"
               class="<?php echo $card_type_class ?>__img-horizontal-avatar"
               style="width:100%"
            >
              <img
                class="lazy <?php echo $WP_Post->acf['card']['avatar_size_conatin']? 'u-img-contain' : 'u-img-cover'?>"
                src="<?php echo $hor_avatar['sizes']['placeholder'] ?>"
                data-src="<?php echo $hor_avatar['sizes']['w240'] ?>"
                data-srcset="
                  <?php echo $hor_avatar['sizes']['w240'] ?> 240w,
                  <?php echo $hor_avatar['sizes']['medium'] ?> 300w,
                  <?php echo $hor_avatar['sizes']['w400'] ?> 400w,
                  <?php echo $hor_avatar['sizes']['w576'] ?> 576w,
                  <?php echo $hor_avatar['sizes']['w640'] ?> 640w,
                  <?php echo $hor_avatar['sizes']['medium_large'] ?> 768w,
                "
                data-sizes="<?php echo $data_sizes ?>"
                alt="<?php echo $WP_Post->acf['card']['avatar_alt']? $WP_Post->acf['card']['avatar_alt'] : $hor_avatar['alt'] ?>"
              />
            </a>
            <a href="<?php echo get_permalink($WP_Post->ID) ?>"
               class="<?php echo $card_type_class ?>__img-vertical-avatar"
               style="width:100%"
            >
              <img
              class="lazy <?php echo $WP_Post->acf['card']['vertical_avatar_size_conatin']? 'u-img-contain' : 'u-img-cover'?>"
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
                data-sizes="<?php echo $data_sizes ?>"
                alt="<?php echo $WP_Post->acf['card']['avatar_alt']? $WP_Post->acf['card']['avatar_alt'] : $vert_avatar['alt'] ?>"
              />
            </a>
          </div>
        <?php } else { ?>
          <a href="<?php echo get_permalink($WP_Post->ID) ?>"
             class="<?php echo $card_type_class ?>__img-wrp"
             style="background-color:#dadada"
          ></a>
        <?php } ?>

          <!-- content -->
          <div class="<?php echo $card_type_class ?>__content-wrp">

            <div class="<?php echo $card_type_class ?>__description text--secondary">
              <div class="pb-2">
                <a href="<?php echo get_permalink($WP_Post->ID) ?>" class="a-link t-16px text-fw-bold color--000-87">
                  <?php echo $WP_Post->post_title ?>
                </a>
              </div>
            
              <?php if ( $WP_Post->acf && isset($WP_Post->acf['card']) ): ?>
                <?php echo $WP_Post->acf['card']['description'] ?>
              <?php endif ?>
            </div>

            <div class="text-right">
              <a href="<?php echo get_permalink($WP_Post->ID) ?>"
                 class="mdc-button my__mdc-button--primary mr-n3"
              >
                <span class="mdc-button__ripple"></span>
                <span class="mdc-button__label">
                  <?php _e('Подробнее', '_my_theme_') ?>
                </span>
              </a>
            </div>
          </div>
        </div>
      </div><!-- .cg-col-auto -->
    <?php } ?>

  <?php } else { ?>
    <div class="text-center" style="width:100%;">Ничего не найдено</div>
  <?php }
}










/**
 * @param Array $posts - [WP_Post+acf, ...]
 * @param String $card_type - 'small flexible width cards' | 'browsing'
 */
function print__img_hover_posts( $args ) {
  $posts = $args['posts'];
  if (count($posts)) { ?>
    <div class="cg-row img-hover-card__row">
      <?php foreach ($posts as $index => $WP_Post) {
        if ($WP_Post->acf && isset($WP_Post->acf['card']) && $WP_Post->acf['card']['avatar']) { 
          $avatar = $WP_Post->acf['card']['avatar'];
        }
        else $avatar = null;
      ?>
        <div class="cg-col-12 cg-col-mt576-6 cg-col-mt960-4 img-hover-card__col" <?php if ($index%4 === 3) echo 'data-d-if="{ 0:1, 960:0 }"'; ?>>
          <a href="<?php the_permalink($WP_Post) ?>" class="img-hover-card">
            <div class="img-hover-card__bgr-img">
              <?php if ($avatar): ?>
                <img
                  class="u-img-cover lazy"
                  src="<?php echo $avatar['sizes']['placeholder'] ?>"
                  data-src="<?php echo $avatar['sizes']['w240'] ?>"
                  data-srcset="
                    <?php echo $avatar['sizes']['w240'] ?> 240w,
                    <?php echo $avatar['sizes']['medium'] ?> 300w,
                    <?php echo $avatar['sizes']['w400'] ?> 400w,
                    <?php echo $avatar['sizes']['w576'] ?> 576w,
                    <?php echo $avatar['sizes']['w640'] ?> 640w,
                    <?php echo $avatar['sizes']['medium_large'] ?> 768w,
                  "
                  data-sizes="
                    (max-width: 576px) '. 376 *1.3 .'px,
                    (max-width: 768px) '. 264 *1.3 .'px,
                    (min-width: 960px) '. 360 *1.3 .'px,
                    (min-width: 1140px) '. 296 *1.3 .'px,
                    (max-width: 1140px) '. 356 *1.3 .'px
                  "
                  alt="<?php echo $WP_Post->acf['card']['avatar_alt']? $WP_Post->acf['card']['avatar_alt'] : $avatar['alt'] ?>"
                />
              <?php else: ?>
                <img
                  class="u-img-cover lazy"
                  src="<?php echo get_template_directory_uri() ?>/assets/images/img-empty-placeholder/w400.jpg"
                  alt=''
                />
              <?php endif ?>
            </div>

            <div class="img-hover-card__content-wrp" data-styles-if-touch-screen="opacity:1">
              <div class="img-hover-card__content">
                <div>
                  <h3 class="h-20px-uppercase"><?php echo $WP_Post->post_title ?></h3>
                  <?php if (isset($WP_Post->acf['card']['city']) && $WP_Post->acf['card']['city']) { ?>
                    <p class="mt-n2 mb-2"><?php echo $WP_Post->acf['card']['city'] ?></p>
                  <?php } ?>
    
                  <div class="mdc-button mdc-button--outlined my__mdc-button--fff mt-2" style="min-width:200px;">
                    <span class="my__mdc-ripple-fff my__mdc-ripple--is-child"></span>
                    <?php _e('Подробнее', '_my_theme_') ?>
                  </div>
                </div>
              </div>
            </div>

          </a>
        </div>
      <?php } ?>
    </div><!-- .cg-row -->
  <?php } 
}










/**
 * @param Array $args[items]
 *   @param String $args[items][n][topic_title]
 *   @param String $args[items][n][description]
 */
function print__collapsible_list($args) {
  $items = $args['items'];
?>
  <ul class="my-ui-accordion-list master-class-page__accordion">
    <?php foreach ($items as $i => $item) { ?>
      <li class="my-ui-accordion-list__item my-ui-wp-content">
        <div class="my-ui-accordion-list__item-title">
          <h3 class="mb-0 h-20px h-20px-uppercase"><?php echo $item['topic_title'] ?></h3>
        </div>
        <div class="my-ui-accordion-list__item-content-wrp">
          <div class="my-ui-accordion-list__item-content">
            <?php echo $item['description'] ?>
          </div>
        </div>
      </li>
    <?php } ?>
  </ul>
<?php }








/**
 * @param Array $args
 *   @param Array $args['post_acf']
 *   @param String $args['extra_btn_onclick_js_code']
 *   @param Array $args['price_cards']
 *   @param Array $args['bgr_svg_code']
 *   @param Array $args['bgr_svg_code'] = ''
 *   @param Array $args['action_btn_text'] = 'Do it!'
 *   @param Array $args['leran_more_btn_text'] = 'Подробнее' // can be false
 *   @param Array $args['card_extra_class'] = 'Подробнее'
 */
function print__price_cards($args) {
  $__acf = isset($args['post_acf'])? $args['post_acf'] : trigger_error('Set post_acf!', E_ERROR);
  $price_cards = $args['price_cards'];
  $extra_btn_onclick_js_code = isset($args['extra_btn_onclick_js_code'])? $args['extra_btn_onclick_js_code'] : null;
  $btn_onclick_js_code = $__acf['open_form_btn_onclick_js_code'];
  $bgr_svg_code = isset($args['bgr_svg_code'])? $args['bgr_svg_code'] : '';
  $action_btn_text = isset($args['action_btn_text'])? $args['action_btn_text'] : 'Do it!';
  $leran_more_btn_text = isset($args['leran_more_btn_text'])? $args['leran_more_btn_text'] : __('Подробнее', '_my_theme_');
  $card_extra_class = isset($args['card_extra_class'])? $args['card_extra_class'] : "";
?>
  <div class="cg-row">
    <?php foreach ( $price_cards as $i =>  $price_card) {?>
      <?php $btn_id = uniqid(); ?>

      <div class="cg-col-12 cg-col-mt576-6 cg-col-mt960-4 mt-8">
        <div class="price-card elevation-3 <?php echo $card_extra_class ?>" data-price-card="<?php echo htmlspecialchars( json_encode($price_card) ) ?>">
          <div class="price-card__bgr-svg-wrp">
            <div class="svg-inherit-wrp price-card__bgr-svg">
              <?php echo $bgr_svg_code ?>
            </div>
          </div>

          <div class="price-card__content">
            <h3 class="h-24px text-uppercase mb-n2">
              <?php echo $price_card['title'] ?>
            </h3>
  
            <div>
              <div class="price-card__price">
                <?php echo $price_card['price'] ?>
              </div>
              <div class="price-card__price-description"><?php echo $price_card['price_description'] ?></div>
            </div>
  
            <div>
              <?php if ($action_btn_text): ?>
                <div id="<?php echo $btn_id ?>" class="text-center">
                  <div class="price-card-open-dialog-btn mdc-button mdc-button--raised text-ff-Barkentina color--fff elevation-0" style="min-width:220px">
                    <div class="my__mdc-ripple-fff my__mdc-ripple--is-child"></div>
                    <span class="mdc-button__label"><?php echo $action_btn_text ?></span>
                  </div>
                </div>
                <?php print__add_js_event_listener('click', $btn_id, $btn_onclick_js_code) ?>
                <?php print__add_js_event_listener('click', $btn_id, $extra_btn_onclick_js_code) ?>
              <?php endif ?>

              <?php if ($leran_more_btn_text): ?>
                <div class="text-center mt-1">
                  <div class="price-card-open-dialog-btn mdc-button text-ff-Barkentina" style="min-width:220px">
                    <span class="mdc-button__ripple"></span>
                    <span class="mdc-button__label"><?php echo $leran_more_btn_text ?></span>
                  </div>
                </div>
              <?php endif ?>
            </div>
          </div>

        </div>
      </div>

    <?php } ?>
  </div>
<?php }









function print__google_map() { ?>
  <?php
    global $_CONTACTS_;
    $first_selected_pin = $_CONTACTS_['map']['first_selected_pin'];
    $contact_us_form_WP_Post = wp_post__get_lang_post( get_option('__contact_us_from_template_id__'), $GLOBALS["_CURRENT_LANG"]);
    $contact_us_form = get_fields($contact_us_form_WP_Post->ID)['form'];

    print_form__dialog_form([
      'form_data' => $contact_us_form,
      'dialog_id' => 'contactUsFormDialog',
      'form_id' => 'contactUsFormDialogForm',
      'layout' => 'only-form',
    ]);
  ?>
  <section class="google-map-section" style="height: 500px;">
    <div id="googleMap" style="height: 500px;"></div>

    <div class="map-pin-card-wrp">
      <div class="cg-container pos-rel" style="height:100%;">
        <div
          id="googleMapPinCard"
          class="map-pin-card elevation-4"
          style="pointer-events: initial;"
        >
          <button class="closePinCardBtn map-pin-card__close-btn mdc-icon-button material-icons my__mdc-icon-button--x-small"
          >close</button>

          <div class="pa-4">
            <div class="d-flex align-center">
              <img
                src="<?php echo get_template_directory_uri() ?>/assets/images/svg/logo.svg"
                alt="NEOS Ingredients. НЕОС Ингредиентс"
                class="map-pin-card__logo"
              />
              <h3 class="pa-0 ml-4">
                <?php echo $_CONTACTS_['map_contact_card']['logo_title'] ?>
              </h3>
            </div>

            <ul id="googleMapPinCardUl" class="map-card-ul">
              <?php if ($first_selected_pin['address'] && isset($first_selected_pin['caption'])) { ?>  
                <li><?php echo $first_selected_pin['caption'] ?></li>
              <?php } ?>

              <?php if ($first_selected_pin['address']) { ?>  
                <li>
                  <div class="map-card-ul__icon material-icons color--gray_2">location_on</div>
                  <?php echo $first_selected_pin['address'] ?>
                </li>
              <?php } ?>
              
              <?php if ($first_selected_pin['phone']) { ?>
                <li>
                  <div class="map-card-ul__icon material-icons color--gray_2">phone</div>
                  <a href="tel:<?php echo string__remove_whitespaces($first_selected_pin['phone']) ?>" class="a-link a-link--blue-style">
                    <?php echo $first_selected_pin['phone'] ?>
                  </a>
                </li>
              <?php } ?>

              <?php if ($first_selected_pin['email']) { ?>
                <li>
                  <div class="map-card-ul__icon material-icons color--gray_2">email</div>
                  <a href="mailto:<?php echo $first_selected_pin['email'] ?>" class="a-link a-link--blue-style">
                    <?php echo $first_selected_pin['email'] ?>
                  </a>
                </li>
              <?php } ?>
            </ul>

            <div class="text-center">
              <button id="contactUsActionBtn"
                class="pinCardContactBtn mdc-button mdc-button--raised text-ff-Barkentina color--fff"
                style="width:100%"
              >
                <span class="mdc-button__label"><?php
                  echo $_CONTACTS_['map_contact_card']['btn_text']
                ?></span>
              </button>
              <?php print__add_js_event_listener('click', 'contactUsActionBtn', $_CONTACTS_['map_contact_card']['btn_onclick_js_code']) ?>
            </div>
          </div>
        </div><!-- #googleMapPinCard -->
      </div>
    </div><!-- .map-pin-card-wrp -->
  </section>
<?php }







function print__property_list($args) {
  global $_PRODUCT_PROPERTY_POSTS_, $_COLORS_;
  if (!$_PRODUCT_PROPERTY_POSTS_) {
    $_PRODUCT_PROPERTY_POSTS_ = get__product__property_posts();
  }
  $item_properties = $args['properties'];
  $ul_class = isset($args['ul_class'])? $args['ul_class'] : 'mb-2';
  $ul_style = isset($args['ul_style'])? $args['ul_style'] : null;

  if ($item_properties && count($item_properties)) { ?>
    <ul class="<?php echo $ul_class ?>" <?php if ($ul_style) echo " style='$ul_style'" ?> >
      <?php foreach ($item_properties as $index => $prop) {
        $property_post = $_PRODUCT_PROPERTY_POSTS_[$prop['property_id']];
        $title = $prop['new_title']? $prop['new_title'] :$property_post->post_title;
      ?>
        <li>
          <div class="d-flex">
            <div class="svg-icon-wrp mt-1 mr-2 mb-1" style="fill:<?php echo $_COLORS_['primary'] ?>">
              <?php echo $property_post->acf['svg_icon'] ?>
            </div>
            <div class="d-flex align-center" style="min-height:24px">
              <span><b><?php echo $title ?></b>: <?php echo $prop['value'] ?></span>
            </div>
          </div>
        </li>
      <?php } ?>
    </ul>
  <?php }
}




/**
 * Fire function only after target HTMLElement!
 * @param String $event_name - js event names like 'click', 'submit', ...
 * @param String $id
 * @param String $js_code
 */
function print__add_js_event_listener($event_name, $id, $js_code) {
  if ($js_code) echo "<script>;
    var el = document.getElementById('$id');
    if (el) { el.addEventListener('$event_name', function(e){ $js_code }); }
  </script>";
}