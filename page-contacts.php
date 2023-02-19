<?php
/**
 * Template Name: Contact page
 */
?>
<?php get_header(null, ['seo_title_descr_type' => 'pages']) ?>
<input id="wpPageNameInput" type="hidden" value="contact-page">
<?php
  $current_WP_Post = get_post( _current_POST_ID_ );
  $current_WP_Post->acf = get_fields( _current_POST_ID_ );
  $currentLangCode = $GLOBALS['_CURRENT_LANG'];

  global $_CONTACTS_;
  $address_cols = array_chunk( $_CONTACTS_['all_addresses'], ceil(count($_CONTACTS_['all_addresses'])/2));
  $address_col_1 = $address_cols[0];
  $address_col_2 = $address_cols[1];

  function page_func__print_addresses($addresses) {
    foreach ($addresses as $i => $addressArr) { ?>
      <ul class="pb-4 pl-0">
        <li>
          <a href="https://www.google.com/maps/place/<?php echo urlencode($addressArr['address']) ?>"
            target="_blank"
            class="a-link font-weight-bold"
          >
            <?php echo $addressArr['address'] ?>
          </a>
        </li>
        <li>
          <a href="tel:<?php echo string__remove_whitespaces($addressArr['phone']) ?>"
            class="a-link a-link--blue-style"
          ><?php
            echo $addressArr['phone'];
          ?></a>
      </li>
        <li>
          <a href="mailto:<?php echo trim($addressArr['email']) ?>"
            class="a-link a-link--blue-style"
          ><?php
            echo $addressArr['email'];
          ?></a>
        </li>
      </ul>
    <?php }
  }
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






<div class="cg-container pt-8 pb-12">
  <div class="cg-row" style="margin:auto">
    <div class="cg-col-12 cg-col-mt768-6">
      <?php page_func__print_addresses($address_col_1) ?>
    </div>

    <div class="cg-col-12 cg-col-mt768-6">
      <?php page_func__print_addresses($address_col_2) ?>
    </div>
  </div>
</div>






<?php print__google_map() ?>







<?php
	$GLOBALS["_FOOTER_"] = [
		'top-margin' => false,
	];
  get_footer();
?>