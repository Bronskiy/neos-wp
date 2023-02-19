<?php
	/* COOKIES */
	$cookie_policy_WP_Post = wp_post__get_lang_post( get_option('__cookie_policy_post_id__') );
	$cookie_policy_WP_Post->acf = get_fields($cookie_policy_WP_Post->ID);
  
  /* CONTACTS */
  global $_CONTACTS_;
  $address_cols = array_chunk( $_CONTACTS_['all_addresses'], ceil(count($_CONTACTS_['all_addresses'])/2));
  $address_col_1 = $address_cols[0];
  $address_col_2 = $address_cols[1];

  /* page FUNCTIONS */
  function footer_func__print_addresses($addresses) {
    foreach ($addresses as $i => $addressArr) { ?>
      <ul class="page-footer__address-list pb-4">
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


    </div><!-- .global-page-layout__content -->

    <?php print__photoswipe_gallery_layout(); ?>

    <!-- snackbar -->
    <div class="mdc-snackbar mdc-snackbar--leading">
      <div class="mdc-snackbar__surface" role="status" aria-relevant="additions">
        <div class="mdc-snackbar__label" aria-atomic="false">
          Text
        </div>
        <div class="mdc-snackbar__actions" aria-atomic="true">
          <button type="button" class="mdc-button mdc-snackbar__action">
            <div class="mdc-button__ripple"></div>
            <span class="mdc-button__label">Btn text</span>
          </button>
        </div>
      </div>
    </div>



    <div id="cookieUsageConfirmationDialog" class="my-ui-banner elevation-8">
      <div>
        <div style="float: left; margin-right: 16px;">
          <svg style="width:48px; fill:<?php echo $GLOBALS["_COLORS_"]['primary'] ?>" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 122.88 122.25" style="enable-background:new 0 0 122.88 122.25" xml:space="preserve"><g><path d="M101.77,49.38c2.09,3.1,4.37,5.11,6.86,5.78c2.45,0.66,5.32,0.06,8.7-2.01c1.36-0.84,3.14-0.41,3.97,0.95 c0.28,0.46,0.42,0.96,0.43,1.47c0.13,1.4,0.21,2.82,0.24,4.26c0.03,1.46,0.02,2.91-0.05,4.35h0v0c0,0.13-0.01,0.26-0.03,0.38 c-0.91,16.72-8.47,31.51-20,41.93c-11.55,10.44-27.06,16.49-43.82,15.69v0.01h0c-0.13,0-0.26-0.01-0.38-0.03 c-16.72-0.91-31.51-8.47-41.93-20C5.31,90.61-0.73,75.1,0.07,58.34H0.07v0c0-0.13,0.01-0.26,0.03-0.38 C1,41.22,8.81,26.35,20.57,15.87C32.34,5.37,48.09-0.73,64.85,0.07V0.07h0c1.6,0,2.89,1.29,2.89,2.89c0,0.4-0.08,0.78-0.23,1.12 c-1.17,3.81-1.25,7.34-0.27,10.14c0.89,2.54,2.7,4.51,5.41,5.52c1.44,0.54,2.2,2.1,1.74,3.55l0.01,0 c-1.83,5.89-1.87,11.08-0.52,15.26c0.82,2.53,2.14,4.69,3.88,6.4c1.74,1.72,3.9,3,6.39,3.78c4.04,1.26,8.94,1.18,14.31-0.55 C99.73,47.78,101.08,48.3,101.77,49.38L101.77,49.38z M59.28,57.86c2.77,0,5.01,2.24,5.01,5.01c0,2.77-2.24,5.01-5.01,5.01 c-2.77,0-5.01-2.24-5.01-5.01C54.27,60.1,56.52,57.86,59.28,57.86L59.28,57.86z M37.56,78.49c3.37,0,6.11,2.73,6.11,6.11 s-2.73,6.11-6.11,6.11s-6.11-2.73-6.11-6.11S34.18,78.49,37.56,78.49L37.56,78.49z M50.72,31.75c2.65,0,4.79,2.14,4.79,4.79 c0,2.65-2.14,4.79-4.79,4.79c-2.65,0-4.79-2.14-4.79-4.79C45.93,33.89,48.08,31.75,50.72,31.75L50.72,31.75z M119.3,32.4 c1.98,0,3.58,1.6,3.58,3.58c0,1.98-1.6,3.58-3.58,3.58s-3.58-1.6-3.58-3.58C115.71,34.01,117.32,32.4,119.3,32.4L119.3,32.4z M93.62,22.91c2.98,0,5.39,2.41,5.39,5.39c0,2.98-2.41,5.39-5.39,5.39c-2.98,0-5.39-2.41-5.39-5.39 C88.23,25.33,90.64,22.91,93.62,22.91L93.62,22.91z M97.79,0.59c3.19,0,5.78,2.59,5.78,5.78c0,3.19-2.59,5.78-5.78,5.78 c-3.19,0-5.78-2.59-5.78-5.78C92.02,3.17,94.6,0.59,97.79,0.59L97.79,0.59z M76.73,80.63c4.43,0,8.03,3.59,8.03,8.03 c0,4.43-3.59,8.03-8.03,8.03s-8.03-3.59-8.03-8.03C68.7,84.22,72.29,80.63,76.73,80.63L76.73,80.63z M31.91,46.78 c4.8,0,8.69,3.89,8.69,8.69c0,4.8-3.89,8.69-8.69,8.69s-8.69-3.89-8.69-8.69C23.22,50.68,27.11,46.78,31.91,46.78L31.91,46.78z M107.13,60.74c-3.39-0.91-6.35-3.14-8.95-6.48c-5.78,1.52-11.16,1.41-15.76-0.02c-3.37-1.05-6.32-2.81-8.71-5.18 c-2.39-2.37-4.21-5.32-5.32-8.75c-1.51-4.66-1.69-10.2-0.18-16.32c-3.1-1.8-5.25-4.53-6.42-7.88c-1.06-3.05-1.28-6.59-0.61-10.35 C47.27,5.95,34.3,11.36,24.41,20.18C13.74,29.69,6.66,43.15,5.84,58.29l0,0.05v0h0l-0.01,0.13v0C5.07,73.72,10.55,87.82,20.02,98.3 c9.44,10.44,22.84,17.29,38,18.1l0.05,0h0v0l0.13,0.01h0c15.24,0.77,29.35-4.71,39.83-14.19c10.44-9.44,17.29-22.84,18.1-38l0-0.05 v0h0l0.01-0.13v0c0.07-1.34,0.09-2.64,0.06-3.91C112.98,61.34,109.96,61.51,107.13,60.74L107.13,60.74z M116.15,64.04L116.15,64.04 L116.15,64.04L116.15,64.04z M58.21,116.42L58.21,116.42L58.21,116.42L58.21,116.42z"/></g></svg>
        </div>
        <?php echo $cookie_policy_WP_Post->acf['cookie_usage_confirmation_dialog']['text'] ?>
      </div>

      <div class="text-right">
        <div id="cookieUsageConfirmationDialogBtn" class="mdc-button mdc-button--unelevated text-ff-Barkentina color--fff" style="min-width:220px">
          <div class="my__mdc-ripple-fff my__mdc-ripple--is-child"></div>
          <span class="mdc-button__label"><?php _e('Принять и закрыть') ?></span>
        </div>
      </div>
    </div>





    <footer id="mainFooter" class="global-page-layout__footer page-footer__wrp <?php if ($GLOBALS["_FOOTER_"]['top-margin']) echo 'page-footer__wrp--top-margin' ?>">
      <div class="cg-container common-page__flex-grid-container">
        <!-- ROW 1 -->
        <div class="d-flex align-center">
          <!-- Logo -->
          <!-- <div class="page-footer__logo-block__logo-patch"></div> -->
          <div class="page-footer__logo-block">
            <div class="page-footer__logo-block__circle"></div>
            <div class="page-footer__logo-block__circle-outline"></div>
            <div class="page-footer__logo-block__bgr-patch"></div>
            <div class="page-footer__logo-block__img">
              <a href="/" class="goToFrontPage">
                <img
                  src="<?php echo get_template_directory_uri() ?>/assets/images/svg/logo.svg"
                  alt="NEOS Ingredients. НЕОС Ингредиентс"
                />
              </a>
            </div>
          </div>

          <!-- Line -->
          <div class="page-footer__1st-row__divaider"></div>

          <!-- btns -->
          <div class="page-footer__1st-row__icons d-flex align-center ml-3">

            <div class="openHeaderSearchBar mdc-icon-button material-icons my__mdc-icon-button--small color--gray_3">
              <div class="my__mdc-icon-button__svg-wrp" style="width: 24px; height: 24px;">search</div>
            </div>

            <?php if ($_CONTACTS_['socials']) { ?>
              <?php foreach ($_CONTACTS_['socials'] as $i => $network) { ?>
                <a href="<?php echo $network['link']? $network['link']['url'] : '' ?>"
                  class="mdc-icon-button material-icons my__mdc-icon-button--small color--gray_3"
                  target="_blank"
                  style="<?php echo $network['icon_color']? "color:{$network['icon_color']}!important" : null ?>"
                >
                  <div class="my__mdc-icon-button__svg-wrp"
                    style="
                      width: <?php echo $network['icon_size']? $network['icon_size'] : 24 ?>px;
                      height: <?php echo $network['icon_size']? $network['icon_size'] : 24 ?>px;
                    "
                  >
                    <?php echo $network['svg_or_icon_name'] ?>
                  </div>
                </a>
              <?php } ?>
            <?php } ?>

            <!-- phone icon -->
            <?php if ($_CONTACTS_['current_target_address']['phone']) { ?>
              <a href="tel:<?php echo string__remove_whitespaces($_CONTACTS_['current_target_address']['phone']) ?>"
                class="mdc-icon-button material-icons my__mdc-icon-button--small color--gray_3"
              >phone</a>
            <?php } ?>
            <!-- WhatsApp -->
            <?php if ($_CONTACTS_['whatsapp_link']) { ?>
             <a href="https://wa.me/<?php echo string__remove_whitespaces($_CONTACTS_['whatsapp_link']) ?>"
							class="mdc-icon-button material-icons my__mdc-icon-button--small color--gray_3"
						><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 1190.6 841.9" style="enable-background:new 0 0 1190.6 841.9; width: 28px; height: 24px;" xml:space="preserve">
<style type="text/css">
	.st0{fill:#949494;}
</style>
<path class="st0" d="M802.8,508.8c-14.8-7.7-28.8-15.5-43.6-23.2c-13.4-7-26-13.4-39.4-19.7c-9.1-4.2-13.4-2.1-19.7,5.6  c-11.2,13.4-23.2,26.7-35.2,40.1c-4.9,5.6-11.2,7-18.3,3.5c-3.5-1.4-7-3.5-10.5-4.9c-57.6-26.7-100.5-69.6-130.8-124.4  c-6.3-11.2-4.9-15.5,4.2-24.6c9.8-10.5,20.4-20.4,26.7-33.7c2.8-5.6,3.5-11.2,1.4-17.6c-9.8-26.7-19.7-53.4-30.2-80.1  c-1.4-3.5-3.5-7.7-5.6-11.2c-2.8-5.6-7.7-7.7-14.1-7.7c-4.9,0-9.8-0.7-14.8-0.7c-12-1.4-23.9,0-33,8.4  c-28.1,24.6-42.9,54.8-43.6,92.1c0.7,6.3,0.7,12.7,2.1,19c3.5,23.2,12,45,23.9,65.4c18.3,31.6,39.4,62.6,63.3,90.7  c27.4,31.6,58.4,60.5,94.9,81.6c30.9,18.3,64.7,30.2,98.4,42.2c19.7,7,39.4,7,59.8,2.8s38-14.8,53.4-28.1c7.7-7,13.4-15.5,16.2-25.3  c2.1-9.1,4.2-19,6.3-28.1C816.1,517.9,814,515.1,802.8,508.8z M1001,317.6C978.5,224.1,929.3,146.7,854.1,87  C785.9,33.5,707.8,4.7,621.4,0.5c-30.9-1.4-61.2,0-91.4,5.6c-98.4,18.3-179.3,65.4-243.2,142c-52.7,63.3-83.7,135.7-92.8,217.2  c-3.5,33.7-3.5,67.5,1.4,101.2c7,53.4,24.6,103.3,52,150.4c2.1,4.2,2.8,7.7,1.4,12c-23.2,68.2-46.4,137.1-68.9,205.3  c-0.7,2.1-1.4,4.2-2.1,7.7c3.5-0.7,5.6-1.4,7.7-2.1c71-22.5,141.3-45,212.3-68.2c4.9-1.4,8.4-1.4,12.7,1.4  c52.7,28.1,108.3,43.6,168,47.1c35.9,2.1,71.7,0,107.6-7.7C781,792.1,859.7,745,920.9,669.8c56.9-69.6,87.2-149.7,92.1-239  C1013.7,392.8,1010.1,354.8,1001,317.6z M943.4,428.6c-4.2,73.1-28.8,138.5-74.5,195.4c-52.7,65.4-120.2,106.2-202.5,123  c-26.7,5.6-53.4,7-80.8,6.3c-60.5-2.8-116-20.4-167.3-52.7c-4.2-2.8-7.7-2.8-12-1.4c-39.4,12.7-79.4,25.3-118.8,38  c-1.4,0.7-3.5,0.7-6.3,1.4c0.7-2.8,1.4-4.9,2.1-7.7c12.7-38,25.3-76.6,38.7-114.6c1.4-3.5,0.7-6.3-1.4-9.8  c-31.6-44.3-51.3-93.5-58.4-147.6c-13.4-100.5,12-190.5,77.3-268.6c54.1-64.7,123-104.8,206.7-118.1  c101.9-16.2,193.3,8.4,273.5,74.5c62.6,51.3,101.9,118.1,118.1,197.6C943.4,371.7,945.5,399.8,943.4,428.6z"/>
</svg></a>
            <?php } ?>

            <?php /* print_ui__lang_list_selection([
              'menu_id' => 'lm2'
            ]) */ ?>

          </div>
        </div>

        <!-- ROW 2 -->
        <div class="page-footer__content">
          <div class="cg-row">
            <div class="cg-col-4 cg-col-mt768-3 d-mt576-block d-none">
              <!-- MENU -->
              <ul class="page-footer__menu-list">
                <?php foreach ($GLOBALS["_MENU_MAP"] as $index => $menuItem) { ?>
                  <li>
                    <a
                      href="<?php echo $menuItem['url'] ?>"
                      class="a-link <?php if ($menuItem['active']) echo 'color--primary' ?>"
                    >
                      <?php echo $menuItem['title'] ?>
                    </a>
                  </li>
                <?php } ?>
              </ul>
            </div>

            <div class="cg-col-12 cg-col-mt576-8 cg-col-mt768-9">
              <div class="cg-row" style="margin:auto">
                <div class="cg-col-12 cg-col-mt768-6">
                  <?php footer_func__print_addresses($address_col_1) ?>
                </div>

                <div class="cg-col-12 cg-col-mt768-6">
                  <?php footer_func__print_addresses($address_col_2) ?>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div><!-- .cg-container -->
    </footer>

  </div><!-- .global-page-layout -->

<?php wp_footer(); ?>

</body>
</html>