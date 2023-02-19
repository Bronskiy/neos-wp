<?php

function get__month_name_by_num__dd_month($num) {
  $mounths = [
    __('Января', '_my_theme_'),
    __('Февраля', '_my_theme_'),
    __('Марта', '_my_theme_'),
    __('Апреля', '_my_theme_'),
    __('Мая', '_my_theme_'),
    __('Июня', '_my_theme_'),
    __('Июля', '_my_theme_'),
    __('Августа', '_my_theme_'),
    __('Сентября', '_my_theme_'),
    __('Октября', '_my_theme_'),
    __('Ноября', '_my_theme_'),
    __('Декабря', '_my_theme_'),
  ];
  return $mounths[+$num];
}









function get__sorted_news_categories() {
  $news_categories = get_terms( [
    'taxonomy' => MY_TAX_NEWS_CATEGORY,
    'hide_empty' => false,
  ]);
  foreach ($news_categories as $key => $cat) {
    $cat->acf = [];
    $cat->acf['order'] = get_field('order', MY_TAX_NEWS_CATEGORY . '_' . $cat->term_id);
  }
  usort($news_categories, function ($a, $b) {
    $o1 = $a->acf['order'];
    $o2 = $b->acf['order'];
    if ($o1 === $o2) return 0;
    return ($o1 < $o2)? -1 : 1;
  });
  return $news_categories;
}









function get__user_IP() {
  // Get real visitor IP behind CloudFlare network
  if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
            $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
  }
  $client  = @$_SERVER['HTTP_CLIENT_IP'];
  $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
  $remote  = $_SERVER['REMOTE_ADDR'];

  if ( filter_var($client, FILTER_VALIDATE_IP) ) $ip = $client;
  elseif ( filter_var($forward, FILTER_VALIDATE_IP) ) $ip = $forward;
  else $ip = $remote;
  return $ip;
}









function get_rus_reg_code() {
  $current_region_code = $GLOBALS["_USER_IP_DATA_"]['region_code'];
  $bound_regs = get_field( 'rus_region_location_binding', get_option('__contact_us_settings__') );

  $target_region = null;
  for ($i=0; $i < count($bound_regs); $i++) { 
    $data = $bound_regs[$i];
    $bound_region_codes = string__split_by_spaces_commas_semicolon($data['bound_region_codes']);
    if (in_array($current_region_code, $bound_region_codes)) {
      $target_region = $data['targer_region_code'];
      break;
    }
  }
  return $target_region;
}








/**
 * @param Object $WP_Post. Must contains $WP_Post->acf['card']
 */
function get__card_avatar_data($WP_Post) {
  $hor_avatar = $WP_Post->acf['card']['avatar'];
  $vert_avatar = $WP_Post->acf['card']['vertical_avatar'];
  if (!$hor_avatar && $vert_avatar) $hor_avatar = $vert_avatar;
  if ($hor_avatar && !$vert_avatar) $vert_avatar = $hor_avatar;
  $avatar_size_conatin = $WP_Post->acf['card']['avatar_size_conatin']? 'contain' : 'cover';
  $vertical_avatar_size_conatin = $WP_Post->acf['card']['vertical_avatar_size_conatin']? 'contain' : 'cover';

  $avatar_is_set = boolval($hor_avatar || $vert_avatar);
  return [
    $avatar_is_set,
    $hor_avatar,
    $vert_avatar,
    $avatar_size_conatin,
    $vertical_avatar_size_conatin
  ];
}





/**
 * @param Array $btn_acf - btn acf arrray
 * @param Array $args
 *   @param String $args[text]='Текст'
 *   @param String $args[onclick_js_code]=''
 */
function get__acf_btn_data($btn_acf=[], $args=[]) {
  $default_text = isset($args['default_text']) ? $args['default_text'] : __('Текст', '_my_theme_');
  $id = isset($args['btn_id']) ? $args['btn_id'] : uniqid();

  return [
    'id' => $id,
    'text' => $btn_acf['text']? $btn_acf['text'] : $default_text,
    'onclick_js_code' => $btn_acf['onclick_js_code']? $btn_acf['onclick_js_code'] : '',
  ];
}