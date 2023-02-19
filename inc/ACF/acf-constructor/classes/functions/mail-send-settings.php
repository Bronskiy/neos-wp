<?php
/**
 * @param Array $args
 *    @param  $args[settings_post_id] - the id of post containig the settings
 *    @param  $args[in_dev] - dev mode
 */
function acf_constructor__mail_to_send__get_emails( $args=[ 'settings_post_id' => null, 'in_dev' => null ]) {
  if (!$args['settings_post_id']) $args['settings_post_id'] = get_option('__mail_send_settings__');
  $in_dev = $args['in_dev'] === null? __ACF_BASE_IS_IN_DEV__ : $args['in_dev'];

  $WP_Post = get_post( $args['settings_post_id'] );
  $acf = get_fields( $WP_Post );
  $mails = [];

  $mails = $in_dev? $acf['dev_emails'] : $acf['order_emails'];

  $mails = preg_replace('/\s+/i', ' ', $mails);
  $mails = preg_replace('/,|;|/i', '', $mails);
  $mails = explode(' ', $mails);

  return $mails;
}