<?php
/**
 * Template Name: News Archive
 */
?>
<?php get_header(null, ['seo_title_descr_type' => 'pages']) ?>
<input id="wpPageNameInput" type="hidden" value="news-archive-page">
<?php
  $current_WP_Post = get_post( _current_POST_ID_ );
  $current_WP_Post->acf = get_fields( _current_POST_ID_ );
  $currentLangCode = $GLOBALS['_CURRENT_LANG'];

  /* get CATEGORIES */
  $news_categories = get__sorted_news_categories();

  $allowed_cat_slugs = [];
  foreach ($news_categories as $key => $cat) $allowed_cat_slugs[] = $cat->slug;

  /* collect category tags */
  $tags_of_categories = [];
  foreach ($news_categories as $key => $cat) {
    $tags = [];
    $all_lang_tags /* with all langs */ = term__tags_of_category_by_category_id([
      'category_ids' => [$cat->term_id],
      'category_tax_name' => MY_TAX_NEWS_CATEGORY,
      'tag_tax_name' => MY_TAX_NEWS_TAG,
    ]);

    // leave only needed tags by check post count
    foreach ($all_lang_tags as $lang_tag) {
      $WP_Query = new WP_Query([
        'post_type' => MY_CPT_NEWS,
        'posts_per_page' => 1,
        'paged' => 1,
        'lang' => $currentLangCode,
        'tax_query' => [
          [
            'taxonomy' => MY_TAX_NEWS_TAG,
            'field'    => 'id',
            'terms'    => $lang_tag->term_id
          ],
          [
            'taxonomy' => MY_TAX_NEWS_CATEGORY,
            'field'    => 'slug',
            'terms'    => $cat->slug
          ],
        ],
      ]);
      // if post exists add this tag
      if ($WP_Query->post_count) $tags[] = $lang_tag;
    }
    $tags_of_categories[$cat->slug] = array__set_key_1_value_array('term_id', $tags);
  }

  // current_cat
  $current_cat_slug = isset($_GET['_category'])? $_GET['_category'] : $allowed_cat_slugs[0];
  if (!in_array($current_cat_slug, $allowed_cat_slugs)) $current_cat_slug = $allowed_cat_slugs[0];

  // tags
  $tags = get_terms( [
    'taxonomy' => MY_TAX_NEWS_TAG,
    'hide_empty' => false,
  ]);
  $allowed_tags = $tags_of_categories[$current_cat_slug];
  $tags = array__set_item_prop_val_as_item_key('term_id', $tags);
  foreach ($tags as $key => $v) {
    $tags[$key]->name = __($v->name, '_my_theme_');
  }
  $current_tag_id = isset($_GET['tag_id'])? $_GET['tag_id'] : null;
  if (!in_array($current_tag_id, $allowed_tags)) $current_tag_id = null;


  $postsPerPage = get_option('posts_per_page');
  $news_query = REST__get_news([
    '_pp' => $postsPerPage,
    '_category' => $current_cat_slug,
    '_lang' => $GLOBALS["_CURRENT_LANG"],
  ]);
  $max_num_pages = $news_query['max_num_pages'];
  $page = $news_query['page'];
  $news_posts = $news_query['posts'];
  
  js__print_js_object_in_html_from_php_array( ['_$_', 'napInitData'], [
    '_p' => $page,
    '_pp' => $postsPerPage,
    'lang' => $GLOBALS["_CURRENT_LANG"],
    'posts' => $news_posts,
    'currentTagId' => $current_tag_id, // "50"
    'currentCatSlug' => $current_cat_slug, // slug
    'categorySlugs' => $allowed_cat_slugs,
    'tags' => $tags,
    'tagsOfCategories' => $tags_of_categories,
    'translations' => [
      'Не выбрано' => __('Не выбрано', '_my_theme_'),
      'Подробнее' => __('Подробнее', '_my_theme_'),
    ]
  ]);
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
            <button
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
            </button>
          <?php } ?>
  
        </div>
      </div>
    </div>
  </div>
</div>





<section id="napSection" class="bgr-color--gray_1 pos-rel">
  <div id="napLoadingOverlay" class="product-browsing-section__loading-overlay product-browsing-section__loading-overlay--hidden">
    <?php echo print_ui__progress_circular() ?>
  </div>

  <div id="newsPostNav" class="nap-post-nav">
    

    <div class="cg-row align-center">
      <!-- Top PAGINATION -->
      <div class=cg-col-auto>
        <div id="topPagination"
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
      <div class="cg-col-auto">
        <div id="tagSelect"
         class="mdc-select my__mdc-select nap-mdc-select mdc-select--filled"
         <?php if (!count($tags_of_categories[$current_cat_slug])) echo 'style="display:none"' ?>
        >
          <div class="mdc-select__anchor">
            <span class="mdc-select__ripple"></span>
            <span class="mdc-floating-label mdc-floating-label--float-above">
              <?php _e('Тег', '_my_theme_') ?>
            </span>
            <span class="mdc-select__selected-text-container">
              <span id="tagSelectSelectedText" class="mdc-select__selected-text"><?php _e('Не выбрано', '_my_theme_') ?></span>
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

          <div class="mdc-select__menu mdc-menu mdc-menu-surface">
            <ul id="tagSelectList" class="mdc-list" style="min-width:210px;">
              <li class="mdc-list-item tag-select-list-item mdc-list-item--selected" data-value="none">
                <span class="mdc-list-item__ripple"></span>
                <span class="mdc-list-item__text"><?php _e('Не выбрано', '_my_theme_') ?></span>
              </li>
              <?php foreach ($tags_of_categories[$current_cat_slug] as $term_id) {
                $term = $tags[$term_id];
              ?>
                <li class="mdc-list-item tag-select-list-item" data-value="<?php echo $term->term_id ?>">
                  <span class="mdc-list-item__ripple"></span>
                  <span class="mdc-list-item__text"><?php echo $term->name ?></span>
                </li>
              <?php } ?>
            </ul>
          </div>
        </div>
      </div>

    </div><!-- .cg-row -->
  </div>
  <div id="newsPostNavPatch"></div>



  <!-- POSTS -->
  <div id="napPostWrp">
    <div class="cg-container-fluid">
      <div id="newsPostWrp" class="cg-row card-type-3__card-container">
        <?php print__nap_posts( ['posts' => $news_posts] ); ?>
      </div>
    </div>
  </div>


  <!-- Bottom PAGINATION -->
  <div class=cg-col-auto>
    <div class="d-flex">
      <div id="bottomPagination"
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
      <div style="display:inline-block; height:52px"></div>
    </div>
  </div>


</section>








<!-- <div class="pos-rel" style="z-index:1"> -->
<div>
  <!-- FORM -->
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
	$GLOBALS["_FOOTER_"] = [
		'top-margin' => false,
	];
  get_footer();
?>