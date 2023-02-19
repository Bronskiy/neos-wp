<?php get_header() ?>
<?php
  $currentLangCode = $GLOBALS['_CURRENT_LANG'];
  $search_str = get_search_query();
?>
<input id="wpPageNameInput" type="hidden" value="search-page">

<div class="cg-container common-page__flex-grid-container">
  <!-- BREADCRUMBS -->
  <div class="common-page__breadcrumbs-wrp" style="padding-right:52px">
    <?php print_ui__breadcrumbs([
      [
        'title' => __('Главная', '_my_theme_'),
        'href' => pll_home_url( $currentLangCode ),
        'class' => 'goToFrontPage'
      ],
      [
        'title' => __('Поиск', '_my_theme_'),
        'disabled' => true,
      ],
      [
        'title' => "\"$search_str\"",
        'disabled' => true,
      ],
    ]) ?>
  </div>

  <!-- Title -->
  <!-- <div class="text-center mb-4">
    <h1 class="h-36px h-36px--underlined"><?php _e('Поиск', '_my_theme_') ?></h1>
  </div> -->


  <form role="search" method="get" style="width: 100%;" action="<?php echo pll_home_url() ?>">
    <label
      id="searchPageSearchLabel"
      class="search-bar__label mdc-text-field mdc-text-field--filled mdc-text-field--no-label align-center"
      style="width:100%; height:36px;"
    >
      <span class="mdc-text-field__ripple"></span>

      <span class="sumbitSearchPageSearchForm mdc-icon-button material-icons my__mdc-icon-button--small color--gray_3 mr-1">
        <div class="my__mdc-icon-button__svg-wrp">search</div>
      </span>

      <input
        id="searchPageSearchInput"
        class="mdc-text-field__input search-bar__input"
        type="search"
        name="s"
        value="<?php echo get_search_query() ?>"
        placeholder="<?php _e('Поиск', '_my_theme_') ?>"
        aria-label="Label"
      >

      <span class="clearSearchPageSearchInput mdc-icon-button material-icons my__mdc-icon-button--small color--gray_3 mr-n2">
        <div class="my__mdc-icon-button__svg-wrp">close</div>
      </span>

      <span class="mdc-line-ripple"></span>
    </label>
    <!-- <input type="submit" class="search-submit" value="Поиск"> -->
  </form>



  <?php if ( have_posts() ) {
    // sort posts by post_type
    array_multisort(
      array_column($posts, 'post_type'), SORT_ASC, $posts, array_keys($posts)
    );
  ?>

    <?php while ( have_posts() ) {
        the_post();
        get_template_part( 'content/content', 'search' );
      }
    ?>

    <div id="paginationWrp"
      class="my-ui-pagination pt-8 pb-4"
      data-page-count="<?php echo $wp_query->max_num_pages ?>"
      data-page="<?php echo $wp_query->query_vars['paged'] ?>"
      data-length="7"
    >
      <?php previous_posts_link('
        <div class="my-ui-pagination__prev-arrow my-ui-pagination__btn">
          <span class="material-icons">chevron_left</span>
        </div>
      '); ?>
      <div class="my-ui-pagination__content"></div>
      <?php next_posts_link('
        <div class="my-ui-pagination__next-arrow my-ui-pagination__btn">
          <span class="material-icons">chevron_right</span>
        </div>
      '); ?>
    </div><!-- #paginationWrp -->


  <?php } else { ?>
    <p class="text-center mt-12"><?php _e('Ничего не найдено', '_my_theme_') ?></p>
  <?php } ?>
</div>

<div style="height:40px"></div>

<?php get_footer() ?>