<?php get_header(null, ['seo_title_descr_type' => 'products_and_their_taxonomies']) ?>
<input id="wpPageNameInput" type="hidden" value="single-product-industry-type-page">
<?php
  $current_WP_Post = get_post( _current_POST_ID_ );
  $current_WP_Post->acf = get_fields(_current_POST_ID_);

  $currentLangCode = $GLOBALS['_CURRENT_LANG'];

  $prod_industry_type_terms_data = get__product__product_industry_type_terms_data();
  $prod_industry_type_term_tree = $prod_industry_type_terms_data['map_tree'];
  $current_industry_type = get_term_by( 'id', $current_WP_Post->acf['attached_product_industry_type_id'], MY_TAX_PRODUCT_INDUSTRY_TYPE );
  $term_structure_data = term__get_term_structure_data($current_industry_type, $current_industry_type->parent, MY_TAX_PRODUCT_INDUSTRY_TYPE);

  // set drawer_bgr_img
  $drawer_bgr_img = get__product__category_drawer_bgr_img($term_structure_data['active_id_path']);

  // get attached product types
  $product_type_data = get__product__tax_product_types_by_industry_type([
    'industry_type_term_id' => $current_industry_type->term_id,
    'lang' => $currentLangCode,
  ]);
  $sorted_product_type_list = map__collapse_tree_to_1_lvl_array($product_type_data['term_map']);
  $arr = []; foreach ($sorted_product_type_list as $v) { $arr[$v['term_id']] = $v; } $sorted_product_type_list = $arr;

  /* ARCHIVE SETTINGS */
  $apid = get_option('__product_archive_pages__settings_id__');
  $archive_settings_post = wp_post__get_lang_post( $apid );
  $GLOBALS['PRODUCT_ARCHIVE_SETTINGS'] = null;
  if ($archive_settings_post) {
    $archive_settings_post->acf = get_fields( $apid );
    $GLOBALS['PRODUCT_ARCHIVE_SETTINGS'] = $archive_settings_post;
  }


  /* BREADCRUMBS */
  $breadcrumb_items = array(
    [
      'title' => __('Главная', '_my_theme_'),
      'href' => pll_home_url( $currentLangCode )
    ],
    [
      'title' => __('Тип отрасли', '_my_theme_'),
      'class' => 'pbsBreadcrumbHighlightDrawer a-link a-link--blue-style',
    ],
  );
  foreach ($term_structure_data['active_id_path'] as $index => $id) {
    $term = $prod_industry_type_terms_data['all_terms'][$id];
    if ($index === 0) {
      $breadcrumb_items[] = [
        'title' => __($term['name'], '_my_theme_'),
        'class' => 'pbsBreadcrumbHighlightDrawer a-link a-link--blue-style',
      ];
    }
    else if ($index === count($term_structure_data['active_id_path']) - 1) {
      $breadcrumb_items[] = [
        'title' => __($term['name'], '_my_theme_'),
        'disabled' => true,
      ];      
    }
    // else {
    //   $breadcrumb_items[] = [
    //     'title' => __($term['name'], '_my_theme_'),
    //     'href' => $term['page_url'],
    //   ];
    // }
  }
  

  /* PRODUCT PROPERTIES */
  global $_PRODUCT_PROPERTY_POSTS_;
  if (!$_PRODUCT_PROPERTY_POSTS_) $_PRODUCT_PROPERTY_POSTS_ = get__product__property_posts();

  /* PRODUCTS */
  $postsPerPage = get_option('posts_per_page');
    $product_type_id = isset($_GET['product_type_id'])? $_GET['product_type_id'] : false;
    if ($product_type_id && !array_key_exists($product_type_id, $sorted_product_type_list)) $product_type_id = 'all';
  $product_query = REST__get_products([
    '_pp' => $postsPerPage,
    '_lang' => $GLOBALS["_CURRENT_LANG"],
    'industry_type_id' => $term_structure_data['current_id'],
  ]);
  $max_num_pages = $product_query['max_num_pages'];
  $page = $product_query['page'];
  $product_posts = $product_query['posts'];

	js__print_js_object_in_html_from_php_array( ['_$_', 'pbsInitData'], [
    '_p' => $page,
    '_pp' => $postsPerPage,
    'lang' => $GLOBALS["_CURRENT_LANG"],
    'layout' => 'industry_type',
    'const_industry_type_id' => $term_structure_data['current_id'],
    'industry_type_id' => $term_structure_data['current_id'],
    // 'const_product_type_id' => null,
    'product_type_id' => $product_type_id,
    'product_property_posts' => $_PRODUCT_PROPERTY_POSTS_,
    'posts' => $product_posts,
    'translations' => [
      'learnMore' => __('Подробнее', '_my_theme_'),
    ]
  ]);
?>










<script>
  if (window.innerWidth >= 960) {
    document.write( '<div id="industryType_productBrowsingSection" class="product-browsing-section product-browsing-section--opened-drawer">' );
  }
  else {
    document.write( '<div id="industryType_productBrowsingSection" class="product-browsing-section">' );
  }
</script>
<!-- <div id="industryType_productBrowsingSection" class="product-browsing-section"> -->
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
    'drawer_title' => __( 'Тип отрасли', '_my_theme_'), // __( $current_term['name'], '_my_theme_')
    'bgr_img' => $drawer_bgr_img,
    'term_map_tree' => $prod_industry_type_term_tree,
    'active_id_path' => $term_structure_data['active_id_path']
  ]) ?>

  
  <!-- BROWSING SECTION -->
  <div id="productBrowsingSection" class="cg-container-fluid pos-rel">
    <div id="pbsLoadingOverlay" class="product-browsing-section__loading-overlay product-browsing-section__loading-overlay--hidden">
      <?php echo print_ui__progress_circular() ?>
    </div>

    <div id="pbsProductNav" class="pbs-product-nav">
      <div class="cg-row align-center">
        <!-- Top PAGINATION -->
        <div class=cg-col-auto>
          <div id="pbsTopPagination"
            class="my-ui-pagination pt-4 pb-4"
            data-page-count="<?php echo $max_num_pages ?>"
            data-page="<?php echo $page ?>"
            data-length="7"
          >
            <div class="my-ui-pagination__prev-arrow my-ui-pagination__btn">
              <span class="material-icons">chevron_left</span>
            </div>
            <div class="my-ui-pagination__content"></div>
            <div class="my-ui-pagination__next-arrow my-ui-pagination__btn">
              <span class="material-icons">chevron_right</span>
            </div>
          </div>
        </div>

        <!-- SELECT -->
        <?php if (count($sorted_product_type_list)) { ?>
          <div class="cg-col-auto pbs-mdc-select-col">
            <div id="pbsSelect" class="mdc-select my__mdc-select pbs-mdc-select mdc-select--filled">
              <div class="mdc-select__anchor">
                <span class="mdc-select__ripple"></span>
                <span class="mdc-floating-label mdc-floating-label--float-above">
                  <?php _e('Тип продукта', '_my_theme_') ?>
                </span>
                <span class="mdc-select__selected-text-container">
                  <span class="mdc-select__selected-text"><?php _e('Все', '_my_theme_') ?></span>
                </span>
                <span class="mdc-select__dropdown-icon">
                  <svg
                      class="mdc-select__dropdown-icon-graphic"
                      viewBox="7 10 10 5" focusable="false">
                    <polygon
                        class="mdc-select__dropdown-icon-inactive"
                        stroke="none"
                        fill-rule="evenodd"
                        points="7 10 12 15 17 10">
                    </polygon>
                    <polygon
                        class="mdc-select__dropdown-icon-active"
                        stroke="none"
                        fill-rule="evenodd"
                        points="7 15 12 10 17 15">
                    </polygon>
                  </svg>
                </span>
                <span class="mdc-line-ripple"></span>
              </div>

              <div class="mdc-select__menu mdc-menu mdc-menu-surface pbs__mdc-select__menu">
                <ul class="mdc-list" style="min-width:210px;">
                  <li class="mdc-list-item mdc-list-item--selected" style="height:32px" data-value="all">
                    <span class="mdc-list-item__ripple"></span>
                    <span class="mdc-list-item__text"><?php _e('Все', '_my_theme_') ?></span>
                  </li>
                  <?php foreach ($sorted_product_type_list as $term_id => $term) { ?>
                    <li class="mdc-list-item scroll-to-top"
                        data-value="<?php echo $term['term_id'] ?>"
                        style="height:32px"
                    >
                      <span class="mdc-list-item__ripple"></span>
                      <span class="mdc-list-item__text" style="padding-left: <?php echo count($term['parent_ids']) * 16 ?>px"><?php
                        _e($term['name'], '_my_theme_');
                      ?></span>
                    </li>
                  <?php } ?>
                </ul>
              </div>
            </div>
          </div>
        <?php } ?>

      </div><!-- .cg-row -->
    </div>
    <div id="pbsProductNavPatch"></div>



    <?php print_bps__top_action_btns(); ?>




    <!-- CONTENT -->
    <div id="pbsContentWrp" class="cg-row card-type-3__card-container pbs__card-type-3__card-container">
      <?php print_pbs__posts([
        'posts' => $product_posts,
        'layout' => 'industry_type',
      ]) ?>
    </div><!-- #pbsContentWrp -->

    <div style="height:48px"></div>


    <!-- Bottom PAGINATION -->
    <div id="pbsBottomPagination"
      class="my-ui-pagination pt-4 pb-4"
      data-page-count="<?php echo $max_num_pages ?>"
      data-page="<?php echo $page ?>"
      data-length="7"
    >
      <div class="my-ui-pagination__prev-arrow my-ui-pagination__btn">
        <span class="material-icons">chevron_left</span>
      </div>
      <div class="my-ui-pagination__content"></div>
      <div class="my-ui-pagination__next-arrow my-ui-pagination__btn">
        <span class="material-icons">chevron_right</span>
      </div>
    </div>


    <?php print_bps__FABs(); ?>


  </div><!-- .cg-container-fluid -->
<script>document.write('</div>'); /* .product-browsing-section */ </script>



<div id="sectionAfterPbs" style="position:relative; z-index:1; background-color:#fff">
  <?php if ( (isset($current_WP_Post->acf['infographics']) && $current_WP_Post->acf['infographics']) || $current_WP_Post->post_content ): ?>
    <section class="section-block__wrp">
      <div class="cg-container">
        <?php
          if (isset($current_WP_Post->acf['infographics'])) print__product_category_infographics( $current_WP_Post->acf['infographics'] );
          print_gb_content( $current_WP_Post );
        ?>
      </div>
    </section>
  <?php endif ?>
</div>







<!-- FORM -->
<?php 
  $contact_form = get__form__acf_form_data([
    'form_template_id' => wp_post__get_lang_post_id( get_option('__default_from_template_id__'), $GLOBALS["_CURRENT_LANG"]),
    'use_custom_form' => false,
  ]);
?>
<div class="composed-bgr-waves pos-rel" style="z-index:1">
  <?php print_form__default_form_template($contact_form) ?>
</div>



<?php
	$GLOBALS["_FOOTER_"] = [ 'top-margin' => false ];
  get_footer();
?>