<?php

function print_form__outlined_textfield( $field, $args=[] ) {
  $disabled = isset($field['disabled'])? $field['disabled'] : false;
  $name = (isset($field['name']) && $field['name'])? $field['name'] : $field['label'];
  $value = (isset($field['value']) && $field['value'])? $field['value'] : null;
  $hidden = (isset($field['hidden']) && $field['hidden']) ? $field['hidden'] : false;
?>
  <label 
    class="mdc-text-field
      mdc-text-field--outlined my__mdc-text-field--dark
      <?php if ($disabled) echo 'mdc-text-field--disabled' ?>
      <?php if ($hidden) echo 'd-none' ?>
    "
    <?php if (isset($args['wrp_style']) && $args['wrp_style']) echo 'style="' . $args['wrp_style'] .'"' ?>
  >
    <span class="mdc-notched-outline">
      <span class="mdc-notched-outline__leading"></span>
      <span class="mdc-notched-outline__notch">
        <span class="mdc-floating-label"><?php echo $field['label'] ?></span>
      </span>
      <span class="mdc-notched-outline__trailing"></span>
    </span>
    <input
      class="mdc-text-field__input"
      style="width:100%"
      name="<?php echo $name ?>"
      <?php if ($field['input_type']) echo 'type="' . $field['input_type'] . '"' ?>
      <?php if ($field['required']) echo 'required' ?>
      <?php if ($disabled) echo 'disabled' ?>
      <?php if ($value) echo "value='$value'" ?>
    >
  </label>
<?php }



function print_form__outlined_textarea( $field, $args=[] ) {
  $name = (isset($field['name']) && $field['name'])? $field['name'] : $field['label'];
?>
  <label class="mdc-text-field mdc-text-field--outlined mdc-text-field--textarea my__mdc-text-field--dark"
    <?php if (isset($args['wrp_style']) && $args['wrp_style']) echo 'style="' . $args['wrp_style'] .'"' ?>
  >
    <span class="mdc-notched-outline">
      <span class="mdc-notched-outline__leading"></span>
      <span class="mdc-notched-outline__notch">
        <span class="mdc-floating-label"><?php echo $field['label'] ?></span>
      </span>
      <span class="mdc-notched-outline__trailing"></span>
    </span>
    <span class="mdc-text-field__resizer">
      <textarea
        class="mdc-text-field__input"
        <?php if ($field['rows']) echo 'rows="' . $field['rows'] . '"' ?>
        <?php if ($field['required']) echo 'required' ?>
        name="<?php echo $name ?>"
        aria-label="Label"
      ></textarea>
    </span>
  </label>
<?php }



function print_form__my_ui_checkbox( $field, $args=[] ) {
  $name = (isset($field['name']) && $field['name'])? $field['name'] : $field['label'];
?>
  <label class="my-ui-checkbox__wrp"
    <?php if (isset($args['wrp_style']) && $args['wrp_style']) echo 'style="' . $args['wrp_style'] .'"' ?>
  >
    <span class="my-ui-checkbox__icon-wrp">
      <span class="my__mdc-ripple-dark my__mdc-ripple--is-child"></span>
      <input
        type="checkbox"
        class="my-ui-checkbox"
        data-max-size="1"
        name="<?php echo $name ?>"
        <?php if ($field['required']) echo 'required' ?>
      >
      <span class="material-icons my-ui-checkbox__icon my-ui-checkbox__checked-icon" style="display:none">check_box</span>
      <span class="material-icons my-ui-checkbox__icon my-ui-checkbox__unchecked-icon" style="display:none">check_box_outline_blank</span>
    </span>
    <span class="my-ui-checkbox__label">
      <?php echo do_shortcode($field['label']) ?>&nbsp;<?php
        if ($field['required']) { ?><span class="color--error">*</span><?php }
      ?>
    </span>
  </label>
<?php }



function print_form__fileinput( $field, $args=[] ) {
  $name = ( isset($field['name']) && $field['name'])? $field['name'] : $field['label'];
  $max_file_size = ( isset($field['max_file_size']) && $field['max_file_size'])? $field['max_file_size'] : null;
?>
  <div class="my-form-file-input-wrp pos-rel mb-2"><?php // parent div is needed for js?>
    <div class="d-flex align-center">
      <div class="my-form-file-input mdc-button mdc-button--unelevated my__mdc-button--primary" style="background-color:#f1f1f1;">
        <input type="file"
          name="<?php echo $name ?>"
          <?php if ($max_file_size) echo "data-max-file-size='$max_file_size'" ?>
          <?php if ($field['required']) echo 'required' ?>
          style="position:absolute; left:0; opacity:0; z-index:-1; margin-left:16px;"
          <?php if ($field['multiple']) echo 'multiple' ?>
        >
        <span class="mdc-button__ripple"></span>
        <span class="material-icons mr-2 ml-n1 color--default_icon_color">upload_file</span><?php
          echo $field['label']
        ?></div>
      <div class="my-ui-icon-btn my-form-file-input-reset-btn ml-1">
        <div class="my__mdc-ripple-dark my__mdc-ripple--is-child"></div>
        <span class="mdc-fab__icon material-icons">close</span>
      </div>
    </div>
    <div class="my-form-file-input-value-container"></div>
  </div>
<?php }



function print_form__radio_group( $field, $args=[] ) {
  $name = (isset($field['name']) && $field['name'])? $field['name'] : $field['label'];
  if (!$field['radio_btns']) return;
?>
  <div class="my-ui-radio-group <?php if ($field['layout'] === 'horizontal') echo 'my-ui-radio-group--horizontal' ?>"
    <?php if (isset($args['wrp_style']) && $args['wrp_style']) echo 'style="' . $args['wrp_style'] .'"' ?>
  >
    <div class="my-ui-radio-group__group-label"><?php
      echo $field['label'];
      if ($field['required']) echo '<span class="color--error">* </span>';
    ?></div>

    <div class="my-ui-radio-group__btns-wrp">
      <?php foreach ($field['radio_btns'] as $i => $radio) {
        $radio_id = uniqid();
      ?> 
        <div class="mdc-form-field">
          <div class="mdc-radio my__mdc-radio">
            <input  class="mdc-radio__native-control"
                    type="radio"
                    id="<?php echo $radio_id ?>"
                    name="<?php echo $name ?>"
                    <?php if ($radio['default_selected'] == 1) echo 'checked' ?>
                    value="<?php echo $radio['value'] ? $radio['value'] : $radio['label'] ?>"
            >
            <div class="mdc-radio__background">
              <div class="mdc-radio__outer-circle"></div>
              <div class="mdc-radio__inner-circle"></div>
            </div>
            <!-- <div class="mdc-radio__ripple"></div> -->
            <label for="<?php echo $radio_id ?>" class="my__mdc-ripple-dark my__mdc-ripple-dark--circled my__mdc-ripple--is-child"></label>
          </div>
          <label for="<?php echo $radio_id ?>"><?php
            echo $radio['label']
          ?></label>
        </div>
      <?php } ?>
    </div>

  </div>
<?php }



function print_form__checkbox_group( $field, $args=[] ) {
  $name = (isset($field['name']) && $field['name'])? $field['name'] : $field['label'];
  
  if (!$field['items']) {
    return;
  }

  $group_id = uniqid();
?>
  <div  data-group-id="<?php echo $group_id ?>"
        data-group-name="<?php echo $name ?>"
        data-group-title="<?php echo $field['label'] ?>"
        class="my-ui-radio-group <?php if ($field['layout'] === 'horizontal') echo 'my-ui-radio-group--horizontal' ?>"
        <?php if (isset($args['wrp_style']) && $args['wrp_style']) echo 'style="' . $args['wrp_style'] .'"' ?>
        <?php if ($field['required']) echo 'data-required="true"' ?>
  >
    <div class="my-ui-radio-group__group-label pb-1"><?php
      echo $field['label'];
      if ($field['required']) echo '<span class="color--error">* </span>';
    ?></div>

    <div class="my-ui-radio-group__btns-wrp">

      <?php foreach ($field['items'] as $i => $chbx) { ?> 
        <label class="my-ui-checkbox__wrp"
          <?php if (isset($args['wrp_style']) && $args['wrp_style']) echo 'style="' . $args['wrp_style'] .'"' ?>
        >
          <span class="my-ui-checkbox__icon-wrp">
            <span class="my__mdc-ripple-dark my__mdc-ripple--is-child"></span>
            <input
              type="checkbox"
              class="my-ui-checkbox"
              data-max-size="1"
              name="<?php echo $name ?>"
              group_id="<?php echo $group_id ?>"
              <?php if ($chbx['default_selected'] == 1) echo 'checked' ?>
              value="<?php echo $chbx['value'] ? $chbx['value'] : $chbx['label'] ?>"
            >
            <span class="material-icons my-ui-checkbox__icon my-ui-checkbox__checked-icon" style="display:none">check_box</span>
            <span class="material-icons my-ui-checkbox__icon my-ui-checkbox__unchecked-icon" style="display:none">check_box_outline_blank</span>
          </span>
          <span class="my-ui-checkbox__label">
            <?php echo $chbx['label'] ?>
          </span>
        </label>

      <?php } ?>
    </div>

  </div>
<?php }









/**
 * @param Array $contact_form - result of get__form__acf_form_data()
 * @param Array $args
 *   @param Boolean $args['use_wrapper'] = true
 *   @param Array $args['extra_before_submit_btns'] = []
 *   @param String $args['submit_btn_type'] = default | large_full_w
 *   @param String $args['before_form_text'] = null
 *   @param String $args['form_id'] = mainForm
 *   @param String $args['endpoint'] = $GLOBALS["REST_ENDPOINTS"]->regular_form_handler
 *   @param String $args['onsubmit_js_code'] = ''
 *   @param String $args['inline_layout'] = null // классы шага сетки, например cg-col-4
 */
function print_form__default_form_template( $contact_form, $args=[] ) {
  $extra_before_submit_btns = isset($args['extra_before_submit_btns'])? $args['extra_before_submit_btns'] : [];
  $before_form_text = isset($args['before_form_text'])? $args['before_form_text'] : null;
  $use_wrapper = isset($args['use_wrapper'])
    ? $args['use_wrapper']
    : true;
  $form_id = isset($args['form_id'])? $args['form_id'] : 'mainForm';
  $submit_btn_type = isset($args['submit_btn_type'])? $args['submit_btn_type'] : 'default';
  $endpoint = isset($args['endpoint'])? $args['endpoint'] : $GLOBALS["REST_ENDPOINTS"]->regular_form_handler;
  $inline_layout = isset($args['inline_layout'])
    ? $args['inline_layout']
    : null;
  $field_wrp_class = $inline_layout
    ? $inline_layout . ' pb-4'
    : 'pos-rel pb-4';
  $main_form_class = isset($args['main_form_class'])
    ? $args['main_form_class']
    : 'main-form';

  $onsubmit_js_code = isset($args['onsubmit_js_code'])? $args['onsubmit_js_code'] : '';
  if (!$onsubmit_js_code) $onsubmit_js_code = $contact_form['confirm_btn']['onsumbit_js_code'];
?>
  <?php if ($use_wrapper): ?><div class="cg-container main-form__container"><?php endif ?>
    <div class="<?php echo $main_form_class ?>">
      <form id="<?php echo $form_id ?>"
        data-default-form-endpoin="<?php echo $endpoint ?>"
      >
        <?php if ($before_form_text): ?>
          <div class="mb-4">
            <?php echo $before_form_text ?>
          </div>
        <?php endif ?>
        <div class="mb-4">
          <h2 class="h-20px"><?php echo $contact_form['cta']['text'] ?></h2>
        </div>
    
        <?php if ($inline_layout) { ?><div class="cg-row"><?php } ?>
          <?php foreach ($contact_form['fields'] as $index => $field) { ?>
            <div class="<?php echo $field_wrp_class ?>">
              <?php
                if ($field['acf_fc_layout'] === 'textfield') {
                  print_form__outlined_textfield( $field, ['wrp_style' => 'width:100%'] );
                }
                else if ($field['acf_fc_layout'] === 'textarea') {
                  print_form__outlined_textarea( $field, ['wrp_style' => 'width:100%'] );
                }
                else if ($field['acf_fc_layout'] === 'checkbox') {
                  print_form__my_ui_checkbox( $field, ['wrp_style' => 'margin-left: -8px'] );
                }
                else if ($field['acf_fc_layout'] === 'fileinput') {
                  print_form__fileinput( $field, ['wrp_style' => 'width: 100%'] );
                }
                else if ($field['acf_fc_layout'] === 'radio_group') {
                  print_form__radio_group( $field, ['wrp_style' => 'width: 100%'] );
                }
                else if ($field['acf_fc_layout'] === 'checkbox_group') {
                  print_form__checkbox_group( $field, [] );
                }
              ?>
            </div>
          <?php } ?>
        <?php if ($inline_layout) { ?></div><?php } ?>
    
        <!-- button -->
        <?php if ($submit_btn_type === 'default'): ?>
          <div class="text-right mt-n2">
            <?php foreach ($extra_before_submit_btns as $key => $btn) { ?>
              <?php if ($btn['text']) { ?>
                <button
                  <?php if (isset($btn['id'])) echo 'id="' . $btn['id'] . '"'; ?>
                  type="button"
                  class="mdc-button mdc-button--raised text-ff-Barkentina color--fff"
                >
                  <span class="my__mdc-ripple-fff my__mdc-ripple--is-child"></span>
                  <span class="mdc-button__label"><?php echo $btn['text'] ?></span>
                </button>
              <?php } ?>
            <?php } ?>

            <?php if ($contact_form['confirm_btn']['text']) { ?>
              <button class="my-submit-btn mdc-button mdc-button--raised text-ff-Barkentina color--fff">
                <span class="my-submit-btn-prepend-icon-wrp d-flex align-center">
                  <span class="my-submit-btn-prepend-icon--loading" style="display:none">
                    <svg class="my-ui-progress-circular my-ui-progress-circular--r8 my-ui-progress-circular--fff">
                      <circle class="path" cx="12" cy="12" r="8" fill="none" stroke-width="3" stroke-miterlimit="10" />
                    </svg>
                  </span>
                  <span class="my-submit-btn-prepend-icon--error" style="display:none">
                    <span class="material-icons color--fff">close</span>
                  </span>
                  <span class="my-submit-btn-prepend-icon--success" style="display:none">
                    <span class="material-icons color--fff">check</span>
                  </span>
                </span>
                <span class="my__mdc-ripple-fff my__mdc-ripple--is-child"></span>
                <span class="mdc-button__label"><?php
                  echo $contact_form['confirm_btn']['text']
                ?></span>
              </button>
            <?php } ?>
            <?php print__add_js_event_listener('submit', $form_id, $onsubmit_js_code) ?>
          </div>

        <?php elseif ($submit_btn_type === 'large_full_w'): ?>
          <div class="text-right mt-n2">
            <?php if ($contact_form['confirm_btn']['text']) { ?>
              <button class="my-submit-btn mdc-button mdc-button--raised text-ff-Barkentina color--fff elevation-0"
                      style="height: 48px; font-size: 16px; width: 100%;"
              >
                <span class="my-submit-btn-prepend-icon-wrp d-flex align-center">
                  <span class="my-submit-btn-prepend-icon--loading" style="display:none">
                    <svg class="my-ui-progress-circular my-ui-progress-circular--r8 my-ui-progress-circular--fff">
                      <circle class="path" cx="12" cy="12" r="8" fill="none" stroke-width="3" stroke-miterlimit="10" />
                    </svg>
                  </span>
                  <span class="my-submit-btn-prepend-icon--error" style="display:none">
                    <span class="material-icons color--fff">close</span>
                  </span>
                  <span class="my-submit-btn-prepend-icon--success" style="display:none">
                    <span class="material-icons color--fff">check</span>
                  </span>
                </span>
                <span class="my__mdc-ripple-fff my__mdc-ripple--is-child"></span>
                <span class="mdc-button__label"><?php
                  echo $contact_form['confirm_btn']['text']
                ?></span>
              </button>
            <?php } ?>
            <?php print__add_js_event_listener('submit', $form_id, $onsubmit_js_code) ?>
          </div>

        <?php endif ?>
      </form>
    </div>
  <?php if ($use_wrapper): ?></div><?php endif ?>
<?php }









/**
 * FORM DIALOG
 * @param Array $args
 *   @param Array $args['form_data']* result of get__form__acf_form_data()
 *   @param Boolean $args['price_section'] = true
 *   @param String $args['dialog_id']*
 *   @param String $args['form_id']*
 *   @param String $args['layout'] = 2-col-form | only-form
 *   @param String $args['onsubmit_js_code'] = null
 */
function print_form__dialog_form($args) {
  $form_data = $args['form_data'];
  $price_section = isset($args['price_section'])? $args['price_section'] : false;
  $dialog_id = $args['dialog_id'];
  $form_id = $args['form_id'];
  $layout = isset($args['layout'])? $args['layout'] : '2-col-form';
  $onsubmit_js_code = isset($args['onsubmit_js_code'])? $args['onsubmit_js_code'] : null;
?>
  <div id="<?php echo $dialog_id ?>" class="mdc-dialog">
    <div class="mdc-dialog__container">
      <div class="mdc-dialog__surface my-ui-dialog-form__surface"
        role="dialog"
        aria-modal="true"
        aria-describedby="my-dialog-content"
      >
        <button class="my-ui-dialog-form__plug-btn" data-mdc-dialog-initial-focus/></button>
        <div class="mdc-dialog__content my-ui-dialog-form__all-content" id="my-dialog-content">
          <div class="cg-container">

            <div id="priceDialogCloseBtn" class="my-ui-dialog-form__dialog-close-btn">
              <div class="my-ui-icon-btn">
                <div class="my__mdc-ripple-dark my__mdc-ripple--is-child"></div>
                <span class="mdc-fab__icon material-icons">close</span>
              </div>
            </div>

            <?php if ($layout === '2-col-form'): ?>
              <div class="cg-row my-ui-dialog-form__2-col-form-cg-row">
            <?php else: ?>
              <div class="cg-row">
            <?php endif ?>

              <?php if ($layout === '2-col-form'): ?>
                <div class="cg-col-12 cg-col-mt768-6 cg-col-mt1140-6 pos-rel">
                  <div class="my-ui-dialog-form__content my-ui-wp-content">
                    <div>
                      <div class="mb-4">
                        <span id="priceDialogCardTitle" class="my-ui-dialog-form__title"></span>
                      </div>
                      <div id="priceDialogContent"></div>
                    </div>

                    <div>
                      <?php if ($price_section): ?>
                        <div class="my-ui-dialog-form__price">
                          <?php _e('Цена', '_my_theme_') ?>: <span id="priceDialogPrice"></span>
                        </div>
                      <?php endif ?>
                    </div>
                  </div>
                </div>
              <?php endif ?>
    
              <?php if ($layout === '2-col-form'): ?>
                <div class="cg-col-12 cg-col-mt768-6 cg-col-mt1140-6">
              <?php else: ?>
                <div class="cg-col-12">
              <?php endif ?>
                <?php print_form__default_form_template($form_data, [
                  'use_wrapper' => 0,
                  'form_id' => $form_id,
                  'submit_btn_type' => 'large_full_w',
                  'onsubmit_js_code' => $onsubmit_js_code,
                ]) ?>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
    <div class="mdc-dialog__scrim"></div>
  </div>
<?php }