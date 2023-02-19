<?php


function print_pbs__drawer($args) {
  $drawer_title = $args['drawer_title'];
  $term_map_tree = $args['term_map_tree'];
  $active_id_path = $args['active_id_path'];
  $bgr_img = $args['bgr_img'];
?>
  <div id="pbsDrawerOverlay" class="pbs-drawer-overlay"></div>
  
  <script>
    if (window.innerWidth >= 960) {
      document.write( '<div id="pbsDrawer" class="product-browsing-section__drawer product-browsing-section__drawer--opened">' );
    }
    else {
      document.write( '<div id="pbsDrawer" class="product-browsing-section__drawer">' );
    }
  </script>
  <!-- <div id="pbsDrawer" class="product-browsing-section__drawer"> -->
    <!-- <div id="pbsDrawerCloseBtn" class="pbs-drawer-close-btn-old my-ui-icon-btn elevation-3">
      <div class="my__mdc-ripple-dark my__mdc-ripple--is-child"></div>
      <span class="material-icons">chevron_right</span>
    </div> -->
    <div id="pbsDrawerCloseBtn" class="pbs-drawer-close-btn my-ui-icon-btn bgr-color--transparent">
      <div class="my__mdc-ripple-fff my__mdc-ripple--is-child"></div>
      <span class="material-icons color--fff">close</span>
    </div>

    <div class="pbs__drawer-bgr-img__wrp">
      <?php if ( $bgr_img) {
        $sizes = $bgr_img['sizes'];
      ?>
        <img
          class="u-img-cover lazy"
          src="<?php echo $sizes['placeholder'] ?>"
          data-src="<?php echo $sizes['w400'] ?>"
          data-srcset="
            <?php echo $sizes['w576'] ?> 576w,
            <?php echo $sizes['w640'] ?> 640w,
            <?php echo $sizes['medium_large'] ?> 768w,
            <?php echo $sizes['w860'] ?> 860w,
            <?php echo $sizes['w960'] ?> 960w,
            <?php echo $sizes['large'] ?> 1024w,
            <?php echo $sizes['w1140'] ?> 1140w,
            <?php echo $sizes['w1366'] ?> 1366w,
          "
          data-sizes="256px"
          alt="<?php echo  $bgr_img['alt'] ?>"
        />
      <?php } ?>
      <div class="pbs__drawer-bgr-img__dark-gradient"></div>
      <div class="pbs__drawer-bgr-img__overlay"></div>
    </div>
    
    <div class="pbs__drawer-content">
      <div id="pbsDrawerContent">
        <h3 class="pbs__drawer-h">
          <?php echo $drawer_title ?>
        </h3>
    
        <?php print_pbs__drawer_list([
          'term_map_tree' =>  $term_map_tree,
          'active_id_path' => $active_id_path
        ]) ?>
        
      </div>
    </div>

    <div class="pbs-drawer-highlighter"></div>
  <script>document.write('</div>') /* .product-browsing-section__drawer */</script>
<?php
}




function print_pbs__drawer_list($args) {
  global $_COLORS_;
  $term_map_tree = $args['term_map_tree'];
  $active_id_path = $args['active_id_path'];
  $lvl = isset($args['lvl'])? $args['lvl'] : 1;
  $selected_id = $active_id_path[count($active_id_path) - 1];
?>
  <ul  class="my-list pbs__drawer-list my-list--bgr-transparent pt-0 pb-0 ma-0 <?php
      if ($lvl > 1) { echo 'pr-0 '; }
    ?>"
  >
    <?php foreach ($term_map_tree as $term_id => $product_type_lvl1) {
      $expandable = isset($product_type_lvl1['children']) && count($product_type_lvl1['children'])? true : false;
    ?>

      <li class="my-list__item my-list__item--no-css-hover-active my-list__item--type-2
        <?php if (in_array( $term_id, $active_id_path)) echo 'my-list__item--expanded' ?>
      ">
        <a
          href="<?php echo $product_type_lvl1['page_url'] ?>"
          class="a-link-unset <?php
            if (!$product_type_lvl1['page_url']) echo 'a-link--disabled ';
            if ($expandable) echo ' pr-11';
          ?>"
          style="padding-left: <?php echo 12 + 16 * $lvl ?>px; <?php if (in_array($product_type_lvl1['term_id'], $active_id_path) ) {
            echo $product_type_lvl1['term_id'] === $selected_id? 'background-color:' . $_COLORS_['primary'] : 'background-color:rgba(241, 90, 41, .4)';
            echo ";";
          } ?>"
        >
          <div class="my__mdc-ripple-fff my__mdc-ripple--is-child"></div>
          <div class="pos-rel">
            <?php if ($lvl > 1) { ?>
              <div class="pbs__drawer-list-item-marker" style="width:<?php echo ($lvl - 1) * 8 ?>px"></div>
            <?php }
              _e($product_type_lvl1['name'], '_my_theme_')
              // echo "($term_id)";
            ?>
          </div>



          <?php if ($expandable) { ?>
            <div
              data-my-ui-nested-list-expand-toggle
              class="pbs__drawer-list-item-expand-icon my-icon-btn my-icon-btn--small"
            >
              <div class="my__mdc-ripple-fff my__mdc-ripple--is-child"></div>
              <span class="material-icons my-list__item-expand-icon color--fff <?php if (in_array( $term_id, $active_id_path)) echo 'my-list__item-expand-icon--expanded' ?>">expand_more</span>
            </div>
          <?php } ?>
        </a>


        <?php if (count($product_type_lvl1['children'])) { ?>

          <?php print_pbs__drawer_list([
            'term_map_tree' => $product_type_lvl1['children'],
            'active_id_path' => $active_id_path,
            'lvl' => $lvl + 1,
          ]); ?>

        <?php } ?>
      </li>
    <?php } ?>
  </ul>
<?php }







/**
 * @param Array $posts - [WP_Post+acf, ...]
 * @param String $card_type - 'small flexible width cards' | 'browsing'
 */
function print_pbs__posts( $args ) {
  $card_type = isset($args['card_type'])? $args['card_type'] : 'browsing';
  $posts = $args['posts'];
  // $layout = $args['layout'];
  $getParams = '';
  if ($args['layout'] !== 'product_type') $getParams .= '?layout=' . $args['layout'];

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
        <div class="<?php echo $card_type_class ?> pbs__card-type-3">
          <!-- avatar -->
          <?php [ $avatar_is_set, $hor_avatar, $vert_avatar ] = get__card_avatar_data($WP_Post); ?>
          <?php if ($avatar_is_set) { ?>
            <div class="<?php echo $card_type_class ?>__img-wrp pbs__card-type-3__img-wrp">
              <a href="<?php echo get_permalink($WP_Post->ID) . $getParams ?>"
                class="<?php echo $card_type_class ?>__img-horizontal-avatar"
                style="width:100%"
              >
                <img
                  class="lazy u-img-<?php echo ($WP_Post->acf['card']['avatar_size_conatin'])? 'contain' : 'cover' ?>"
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
            <a href="<?php echo get_permalink($WP_Post->ID) . $getParams ?>"
              class="<?php echo $card_type_class ?>__img-wrp pbs__card-type-3__img-wrp"
              style="background-color:#dadada"
            ></a>
          <?php } ?>

          <!-- content -->
          <div class="<?php echo $card_type_class ?>__content-wrp">

            <div class="<?php echo $card_type_class ?>__description text--secondary">
              <div class="pb-2">
                <a href="<?php echo get_permalink($WP_Post->ID) . $getParams ?>" class="a-link t-16px text-fw-bold color--000-87">
                  <?php echo $WP_Post->post_title ?>
                </a>
              </div>

              <?php print__property_list(['properties' => $WP_Post->acf['card']['properties']]) ?>
              <?php echo $WP_Post->acf['card']['description'] ?>
              
            </div>

            <div class="text-right">
              <a href="<?php echo get_permalink($WP_Post->ID) . $getParams ?>"
                 class="mdc-button my__mdc-button--primary mr-n3"
              >
                <span class="mdc-button__ripple"></span>
                <span class="mdc-button__label"><?php
                  _e('Подробнее', '_my_theme_');
                ?></span>
              </a>
            </div>
          </div>
        </div>
      </div><!-- .cg-col-auto -->
    <?php } ?>

  <?php } else { ?>
    <div class="text-center pt-6" style="width:100%;">Ничего не найдено</div>
  <?php }
}







function print_bps__top_action_btns() {
  global $PRODUCT_ARCHIVE_SETTINGS;
  $show_form_btn = get__acf_btn_data(null, [
    'default_text' => __('Задать вопрос', '_my_theme_'),
  ]);
  $upload_docs_btn = get__acf_btn_data(null, [
    'btn_id' => 'uploadDocsActionBtn',
    'default_text' => __('Загрузить документы', '_my_theme_'),
  ]);

  if ($PRODUCT_ARCHIVE_SETTINGS) {
    $show_form_btn = get__acf_btn_data($PRODUCT_ARCHIVE_SETTINGS->acf['show_form_btn'], [
      'default_text' => __('Задать вопрос', '_my_theme_'),
    ]);
    $upload_docs_btn = get__acf_btn_data($PRODUCT_ARCHIVE_SETTINGS->acf['upload_docs_btn'], [
      'btn_id' => 'uploadDocsActionBtn',
      'default_text' => __('Загрузить документы', '_my_theme_'),
    ]);
  }

  $upload_docs_form_WP_Post = wp_post__get_lang_post( get_option('__pbs_upload_files_from_template_id__'), $GLOBALS["_CURRENT_LANG"]);
  $upload_docs_form_acf = get_fields($upload_docs_form_WP_Post->ID);
  $upload_docs_form = $upload_docs_form_acf['form'];
  $upload_docs_form_data = $upload_docs_form_acf['dialog_data'];

  print_form__dialog_form([
    'form_data' => $upload_docs_form,
    'dialog_id' => 'uploadDocsFormDialog',
    'form_id' => 'uploadDocsFormDialogForm',
  ]);
?>
  <div class="pbs-top-action-btn-wrp mt-1" data-upload-docs-form-json="<?php echo htmlspecialchars( json_encode( $upload_docs_form_data ) ) ?>">
    <div id="<?php echo $upload_docs_btn['id'] ?>"
         class="mdc-button mdc-button--outlined my__mdc-button--primary mt-2"
    >
      <span class="mdc-button__ripple"></span>
      <i class="material-icons mdc-button__icon" style="font-size: 24px; width:24px; height:24px;">upload_file</i><?php
      echo $upload_docs_btn['text']
    ?></div>
    <?php print__add_js_event_listener('click', $upload_docs_btn['id'], $upload_docs_btn['onclick_js_code']) ?>

    <a href="#mainForm"
       class="mdc-button mdc-button--unelevated my__mdc-button--fff ml-2 mt-2"
       id="<?php echo $show_form_btn['id'] ?>"
    >
      <div class="my__mdc-ripple-fff my__mdc-ripple--is-child"></div>
      <i class="material-icons mdc-button__icon" style="font-size: 24px; width:24px; height:24px;">help_outline</i><?php
      echo $show_form_btn['text']
    ?></a>
    <?php print__add_js_event_listener('click', $show_form_btn['id'], $show_form_btn['onclick_js_code']) ?>

  </div>
<?php }







function print_bps__FABs() {
  $tel_number = $GLOBALS['_CONTACTS_']['manager_tel'];
  $contact_email = $GLOBALS['_CONTACTS_']['manager_email'];
?>
  <a href="tel:<?php echo string__remove_whitespaces($tel_number) ?>"
    class="pbs-call-btn my-ui-icon-btn my-ui-icon-btn--large bgr-color--primary color--fff elevation-3 text-decor-none"
  >
    <div class="my__mdc-ripple-fff my__mdc-ripple--is-child"></div>
    <span class="material-icons">phone</span>
  </a>

  <a href="mailto:<?php echo trim($contact_email) ?>"
    class="pbs-email-btn my-ui-icon-btn my-ui-icon-btn--large bgr-color--primary color--fff elevation-3 text-decor-none"
  >
    <div class="my__mdc-ripple-fff my__mdc-ripple--is-child"></div>
    <span class="material-icons">email</span>
  </a>
<?php }