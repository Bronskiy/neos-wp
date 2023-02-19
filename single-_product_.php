<?php add_action( 'wp_head', function() { ?>
  <style type="text/css">
    .my-ui-wp-content h2 {
      font-size: 18px;
      line-height: 1.3;
      font-weight: bold;
      text-transform: none;
      font-family: "Barkentina 1", sans-serif;
      position: relative;
      display:inline-block;
      text-transform: uppercase;
      margin: 0 4px;
      z-index: 1;
      margin-bottom: 4px;
    }
    .my-ui-wp-content h2:before {
      content: '';
      position: absolute;
      top: 0px;
      left: -6px;
      display: block;
      width: calc(100% + 12px);
      height: 100%;
      background-color: #ffd9c4;
      border-radius: 4px;
      z-index: -1;
    }

    .my-ui-wp-content h3 {
      font-size: 16px;
      margin-bottom: 4px;
    }

    .my-ui-wp-content h4 {
      font-size: 14px;
      margin-bottom: 4px;
    }
  </style>
<?php });
  get_header(null, ['seo_title_descr_type' => 'products_and_their_taxonomies']);
?>





<input id="wpPageNameInput" type="hidden" value="single-product-page">
<?php
  $current_WP_Post = get_post( _current_POST_ID_ );
  $current_WP_Post->acf = get_fields(_current_POST_ID_);
  $currentLangCode = $GLOBALS['_CURRENT_LANG'];

  $product_property_posts = get__product__property_posts();

  function _template_function__get_breadcrumbs_($current_WP_Post, $current_term, $terms, $catRootTitle) {
    if (isset($current_term['parent_ids'][0])) {
      $productTypesUrl = $terms[ $current_term['parent_ids'][0] ]['page_url'];
    } else {
      $productTypesUrl = $current_term['page_url'];
    }
  
    /* BREADCRUMBS */
    $breadcrumb_items = array(
      [
        'title' => __('Главная', '_my_theme_'),
        'href' => pll_home_url( $GLOBALS['_CURRENT_LANG'] )
      ],
      [
        'title' => $catRootTitle,
        'href' => $productTypesUrl,
      ],
    );
    $breadcrumb_items[] = [
      'title' => __($terms[ $current_term['parent_ids'][0] ]['name'], '_my_theme_'),
      'href' => $terms[ $current_term['parent_ids'][0] ]['page_url'],
    ];
    $breadcrumb_items[] = [
      'title' => $current_WP_Post->post_title,
      'disabled' => true,
    ];
    return $breadcrumb_items;
  }
  
  /* data of categories */
  $product_types = get__product__product_or_industry_types_of_post( $current_WP_Post->ID, MY_TAX_PRODUCT_TYPE )['ordered_terms'];
  if (!count($product_types)) {
    echo '<div class="h-36px" style="color:red">УКАЖИТЕ ТИП ПРОДУКТА!</div><br>';
  }
  $industry_types = get__product__product_or_industry_types_of_post( $current_WP_Post->ID, MY_TAX_PRODUCT_INDUSTRY_TYPE )['ordered_terms'];
  if (!count($industry_types)) {
    echo '<div class="h-36px" style="color:red">УКАЖИТЕ ОТРАСЛЬ!</div><br>';
  }

  $current_product_type = end($product_types);
  $current_industry_type = end($industry_types);


  /* layout */
  $layout = isset($_GET['layout'])? $_GET['layout'] : 'product_type';
  if (!in_array($layout, ['product_type', 'industry_type'])) $layout = 'product_type';
  $drawerTitle = __('Тип продукта', '_my_theme_');
  if ($layout === 'product_type') {
    /* product_types */
    $prod_type_terms_data = get__product__product_type_terms_data();
    $___term_map_tree___ = $prod_type_terms_data['map_tree'];
    $term_structure_data = term__get_term_structure_data(
      (object) $current_product_type,
      $current_product_type['parent'],
      MY_TAX_PRODUCT_TYPE
    );
    $drawer_bgr_img = get__product__category_drawer_bgr_img($term_structure_data['active_id_path']);
    $breadcrumb_items = _template_function__get_breadcrumbs_(
      $current_WP_Post,
      $current_product_type,
      $product_types,
      __('Тип продукта', '_my_theme_')
    );
    $drawerTitle = __('Тип продукта', '_my_theme_');
  }

  else if ($layout === 'industry_type') {
    /* industry_type */
    $prod_industry_type_terms_data = get__product__product_industry_type_terms_data();
    $___term_map_tree___ = $prod_industry_type_terms_data['map_tree'];
    $term_structure_data = term__get_term_structure_data(
      (object) $current_industry_type,
      $current_industry_type['parent'],
      MY_TAX_PRODUCT_INDUSTRY_TYPE
    );
    $drawer_bgr_img = get__product__category_drawer_bgr_img($term_structure_data['active_id_path']);
    $breadcrumb_items = _template_function__get_breadcrumbs_(
      $current_WP_Post,
      $current_industry_type,
      $industry_types,
      __('Тип отрасли', '_my_theme_')
    );
    $drawerTitle = __('Тип отрасли', '_my_theme_');
  }

  /* page settings */
  $show_form_btn = get__acf_btn_data(null, [
    'default_text' => __('Задать вопрос', '_my_theme_'),
  ]);
  $call_btn = get__acf_btn_data(null, [
    'default_text' => __('Позвонить', '_my_theme_'),
  ]);

  $appsi = get_option('__single_product_page__settings_id__');
  $page_settings_WP_Post = wp_post__get_lang_post( $appsi );
  if ($page_settings_WP_Post) {
    $page_settings_WP_Post->acf = get_fields( $appsi );

    $show_form_btn = get__acf_btn_data($page_settings_WP_Post->acf['show_form_btn'], [
      'default_text' => __('Задать вопрос', '_my_theme_'),
    ]);
    $call_btn = get__acf_btn_data($page_settings_WP_Post->acf['call_btn'], [
      'default_text' => __('Позвонить', '_my_theme_'),
    ]);
  }
?>














<script>
  if (window.innerWidth >= 960) {
    document.write( '<div id="pseudoProductBrowsingSection" class="product-browsing-section product-browsing-section--opened-drawer">' );
  }
  else {
    document.write( '<div id="pseudoProductBrowsingSection" class="product-browsing-section">' );
  }
</script>
<!-- <div id="pseudoProductBrowsingSection" class="product-browsing-section"> -->
  <!-- BREADCRUMBS -->
  <div class="cg-container">
    <div class="common-page__pbs-breadcrumbs-wrp">
      <?php print_ui__breadcrumbs( $breadcrumb_items ) ?>
    </div>
  </div>

  <div class="cg-container">
    <!-- Title -->
    <div class="text-center mb-4">
      <h1 class="h-36px"><?php echo $post->post_title ?></h1>
    </div>
  </div>


  <!-- OPEN DRAWER BTN -->
  <div id="pbsDrawerOpenBtn" class="pbs-drawer-open-btn my-ui-icon-btn my-ui-icon-btn--large bgr-color--primary color--fff elevation-3">
    <div class="my__mdc-ripple-dark my__mdc-ripple--is-child"></div>
    <span class="material-icons">menu_open</span>
  </div>

  <!-- DRAWER -->
  <?php print_pbs__drawer([
    'drawer_title' => $drawerTitle,
    'bgr_img' => $drawer_bgr_img,
    'term_map_tree' => $___term_map_tree___,
    'active_id_path' => $term_structure_data['active_id_path']
  ]) ?>
  
  
  <!-- PSEUDO BROWSING SECTION -->
  <div class="cg-container-fluid pos-rel">
    <!-- CONTENT -->
    <div id="pbsContentWrp" class="cg-row">

      <div class="cg-container mt-6">
        <div class="product-card-2">
          <?php if (isset($current_WP_Post->acf['card'])): ?>
            <?php if ($current_WP_Post->acf['card']['avatar']):
              $photo = $current_WP_Post->acf['card']['avatar'];
            ?>
              <div class="product-card-2__avatar">
                <div class="single-product-page__avatar-wrp mb-4">
                  <img
                    class="lazy <?php echo $current_WP_Post->acf['card']['avatar_size_conatin']? 'u-img-contain' : 'u-img-cover' ?>"
                    data-single-prod-avatar-pswp-item="<?php echo htmlspecialchars( json_encode([
                      'src' => $photo['sizes']['large'],
                      'w' => $photo['sizes']['large-width'],
                      'h' => $photo['sizes']['large-height'],
                      'msrc' => $photo['sizes']['placeholder'],
                      'title' => $photo['caption']? $photo['caption'] : null,
                    ]) ) ?>"
                    src="<?php echo $photo['sizes']['placeholder'] ?>"
                    data-src="<?php echo $photo['sizes']['w240'] ?>"
                    data-srcset="
                      <?php echo $photo['sizes']['w400'] ?> 240w,
                      <?php echo $photo['sizes']['medium'] ?> 300w,
                      <?php echo $photo['sizes']['w400'] ?> 400w,
                      <?php echo $photo['sizes']['w576'] ?> 576w,
                      <?php echo $photo['sizes']['w640'] ?> 640w,
                    "
                    data-sizes="100vw"
                    style="width:100%; height:100%"
                    alt="<?php echo $photo['alt'] ?>"
                  />
                </div>
              </div>
            <?php endif ?>

            <div class="product-card-2__content">
              <div class="mb-4">
                <div class="cg-row">
                  <?php
                    $card_properties = $current_WP_Post->acf['card']['properties'];
                    if ( $product_property_posts && count($product_property_posts) && $card_properties ) {
                      $chunks = array_chunk($card_properties, ceil(count($card_properties)/2));
                      foreach ($chunks as $props) { ?>
                        <div class="cg-col-auto">
                          <?php print__property_list([
                            'properties' => $props,
                            'ul_class' => 'd-inline-block mb-0',
                            'ul_style' => 'max-width:300px;',
                          ]) ?>
                        </div>
                      <?php }
                    }
                  ?>
                </div>
              </div>

              <div class="d-flex justify-content-end mb-4" style="flex-wrap: wrap;">
                <a href="#bottomForm"
                   class="mdc-button mdc-button--outlined my__mdc-button--primary mt-1"
                   id="<?php echo $show_form_btn['id'] ?>"
                >
                  <span class="mdc-button__ripple"></span>
                  <i class="material-icons mdc-button__icon" style="font-size: 24px; width:24px; height:24px;">help_outline</i><?php
                  echo $show_form_btn['text']
                ?></a>
                <?php print__add_js_event_listener('click', $show_form_btn['id'], $show_form_btn['onclick_js_code']) ?>
                
                <a href="tel:<?php echo string__remove_whitespaces( $GLOBALS['_CONTACTS_']['manager_tel'] ) ?>"
                   class="mdc-button mdc-button--unelevated my__mdc-button--fff ml-2 mt-1"
                   id="<?php echo $call_btn['id'] ?>"
                >
                  <span class="my__mdc-ripple-fff my__mdc-ripple--is-child"></span>
                  <i class="material-icons mdc-button__icon" style="font-size: 24px; width:24px; height:24px;">phone</i><?php
                  echo $call_btn['text']
                ?></a>
                <?php print__add_js_event_listener('click', $call_btn['id'], $call_btn['onclick_js_code']) ?>
                <?php  ?>

              </div>
            </div>
          <?php endif ?>
        </div><!-- .row -->

        <?php print_gb_content( $current_WP_Post ) ?>

        <div style="height:80px"></div>
      </div>





    </div><!-- #pbsContentWrp -->
  </div><!-- .cg-container-fluid -->
<script>document.write('</div>'); /* .product-browsing-section */ </script>
























<?php
  // /* GET relative products */
  // $tax_query = [
  //   'relation' => 'AND', // OR will load other languages
  // ];
  // $tq = [
  //   'relation' => 'OR',
  // ];
  // if (end($industry_types)) {
  //   $tq[] = [
  //     'taxonomy' => MY_TAX_PRODUCT_INDUSTRY_TYPE,
  //     'field'    => 'id',
  //     'terms'    => end($industry_types)['term_id'],
  //   ];
  // }
  // $tq[] = [
  //   'taxonomy' => MY_TAX_PRODUCT_TYPE,
  //   'field'    => 'id',
  //   'terms'    => array_keys($product_types),
  // ];
  // $tax_query[] = $tq;

  // $WP_Query = new WP_Query([
  //   'post_type' => MY_CPT_PRODUCT,
  //   'posts_per_page' => 4,
  //   'paged' => 1,
  //   'orderby' => 'rand',
  //   'tax_query' => $tax_query,
  //    'post__not_in' => [$current_WP_Post->ID],
  // ]);
  // wp_reset_query();

  // $relative_product_posts = $WP_Query->posts;
  // foreach ($relative_product_posts as $i => $WP_Post) {
  //   $relative_product_posts[$i]->acf = get_fields( $WP_Post->ID );
  //   $relative_product_posts[$i]->page_url = get_permalink($WP_Post->ID);
  // }
?>
<?php /* if (count($relative_product_posts)): ?>
  <section class="section-block__wrp bgr-color--gray_1">
    <div class="cg-container">
      <p class="h-20px-uppercase text-center">С этим вы можете купить</p>
      <div class="cg-row card-type-3-small__container">
        <?php print_pbs__posts([
          'posts' => $relative_product_posts,
          'properties' => $product_property_posts,
          'card_type' => 'small flexible width cards',
          'layout' => isset($_GET['layout'])? $_GET['layout'] : 'product_type'
        ]); ?>
      </div>

      <div class="text-right mt-3">
        <a class="mdc-button mdc-button--outlined my__mdc-button--primary">
          <span class="mdc-button__ripple"></span>
          <span class="mdc-button__label"><?php echo __('Смотреть все', '_my_theme_') ?></span>
        </a>
      </div>
    </div>
  </section>
<?php endif */ ?>










<!-- FORM -->
<div id="sectionAfterPbs" style="position:relative; z-index:1;">
  <?php 
    $contact_form = get__form__acf_form_data([
      'form_template_id' => wp_post__get_lang_post_id( get_option('__default_from_template_id__'), $GLOBALS["_CURRENT_LANG"]),
      'use_custom_form' => false,
    ]);
  ?>
  <div id="bottomForm" class="composed-bgr-waves">
    <?php print_form__default_form_template($contact_form) ?>
  </div>
</div>



<?php
	$GLOBALS["_FOOTER_"] = [ 'top-margin' => false ];
  get_footer();
?>