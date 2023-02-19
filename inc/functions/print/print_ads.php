<?php
function print__ads() {

  $form_id = uniqid('adFormId');

  /* Берем первую рекламу */ 
  $post_id = get_posts([
    'post_type' => MY_CPT_AD,
    'numberposts' => 1,
    'fields' => 'ids',
  ]);

  if (count($post_id)) {
    $ad_WP_Post = wp_post__get_lang_post( $post_id[0] );
    $ad_WP_Post->acf = get_fields($ad_WP_Post->ID);
  
    $contact_form = get__form__acf_form_data([
      'form_template_id' => isset($ad_WP_Post->acf['form_template_id'])
        ? $ad_WP_Post->acf['form_template_id']
        : null,
      'use_custom_form' => $ad_WP_Post->acf['use_custom_form'],
      'form_options' => isset($ad_WP_Post->acf['form_options'])
        ? $ad_WP_Post->acf['form_options']
        : [],
      'custom_form' => isset($ad_WP_Post->acf['custom_form'])
        ? $ad_WP_Post->acf['custom_form']
        : [],
    ]);

    $ad_max_width = (isset($ad_WP_Post->acf['max_width']) && $ad_WP_Post->acf['max_width'])
      ? $ad_WP_Post->acf['max_width']
      : 744;

    $contact_form['fields'][] = [
      'acf_fc_layout' => 'textfield',
      'input_type' => 'text',
      'label' => '',
      'required' => false,
      "hidden" => true,
      "name" => 'РЕКЛАМА',
      "value" => preg_replace("/'/", '"', $ad_WP_Post->post_title),
    ];
  
    js__print_js_object_in_html_from_php_array( ['_$_', 'ads'], [
      'count' => count($post_id),
      'list' => [
        [
          'delay' => $ad_WP_Post->acf['delay'],
          'used' => $ad_WP_Post->acf['use_ad'],
          'expire' => $ad_WP_Post->acf['expire'],
          'cookieName' => 'ad_' . $ad_WP_Post->acf['cookie_name'],
        ]
      ]
    ]);
  ?>

<div id="adDialog" class="mdc-dialog">
  <div class="mdc-dialog__container ml-2 mr-2">
    <div class="mdc-dialog__surface my-ui-dialog-form__surface"
      style="max-width: <?php echo $ad_max_width ?>px !important"
      role="dialog"
      aria-modal="true"
      aria-describedby="my-dialog-content"
    >
      <button class="my-ui-dialog-form__plug-btn" data-mdc-dialog-initial-focus/></button>

      <div class="mdc-dialog__content pa-0" id="my-dialog-content">
        <div>
          <img
            class="u-img-cover lazy"
            style="width:100%"
            src="<?php echo $ad_WP_Post->acf['banner']['main']['sizes']['placeholder'] ?>"
            data-src="<?php echo $ad_WP_Post->acf['banner']['main']['sizes']['medium_large'] ?>"
            data-srcset="
              <?php echo $ad_WP_Post->acf['banner']['main']['sizes']['w640'] ?> 640w,
              <?php echo $ad_WP_Post->acf['banner']['main']['sizes']['w576'] ?> 576w,
              <?php echo $ad_WP_Post->acf['banner']['main']['sizes']['w400'] ?> 400w
            "
            alt="<?php echo $ad_WP_Post->post_title ?>"
          />
        </div>
      
        <div class="cg-container pa-10">

          <div data-close-btn id="priceDialogCloseBtn" class="my-ui-dialog-form__dialog-close-btn">
            <div class="my-ui-icon-btn">
              <div class="my__mdc-ripple-dark my__mdc-ripple--is-child"></div>
              <span class="mdc-fab__icon material-icons">close</span>
            </div>
          </div>

          <div class="cg-row">
            <div class="cg-col">

              <?php print_form__default_form_template(
                $contact_form,
                [
                  'form_id' => 'adDialogForm',
                  'endpoint' => $GLOBALS["REST_ENDPOINTS"]->regular_form_handler,
                  'use_wrapper' => false,
                  'inline_layout' => 'cg-col-12 cg-col-mt576-6',
                  'main_form_class' => '',
                ]
              ) ?>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
  <div class="mdc-dialog__scrim"></div>
</div>

  <?php } ?>
<?php }