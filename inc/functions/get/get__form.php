<?php

/**
 * @param Array $args
 * @param Number $args[form_template_id]
 * @param Boolean $args[use_custom_form]
 * @param Array $args[form_options]
 * @param Array $args[custom_form]
 * 
 * @return [ // the same as $args[use_custom_form]
 *    cta => [
 *      text => '...'
 *    ],
 *    confirm_btn => [
 *      text => '...'
 *    ],
 *    fields => [
 *      [0] => [...],
 *      ...
 *    ],
 *  ]
 */
function get__form__acf_form_data( $args=[] ) {
  $use_custom_form = isset($args['use_custom_form'])? $args['use_custom_form'] : false;
  $form_template_id = isset($args['form_template_id'])?
    $args['form_template_id']
    : ($use_custom_form? null : trigger_error("Укажите \$args['form_template_id']", E_USER_ERROR));
  $form_template = null;
  $form_options = isset($args['form_options'])? $args['form_options'] : [];
  if ($use_custom_form) {
    $custom_form = isset($args['custom_form'])? $args['custom_form'] : trigger_error("Укажите \$args['custom_form']", E_USER_ERROR);
  }

  $form = [];
  if ($use_custom_form) {
    return $custom_form;
  }
  else {
    $form_template = get_post($form_template_id);
    wp_reset_query();
    $form_template->acf = get_fields($form_template_id);

    $form = $form_template->acf['form'];
    if (isset($form_options['cta']) && $form_options['cta']['text']) {
      $form['cta'] = $form_options['cta'];
    }
    if (isset($form_options['confirm_btn']) && $form_options['confirm_btn']['text']) {
      $form['confirm_btn'] = $form_options['confirm_btn'];
    }
  }

  return $form;
}