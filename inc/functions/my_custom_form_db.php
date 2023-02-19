<?php

// CREATE TABLE IF NOT EXISTS `wp_my_custom_form_data` (
//   `id` int(11) NOT NULL AUTO_INCREMENT,
//   `lang` varchar(24) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
//   `form_id` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
//   `from_post_id` int(11) DEFAULT NULL,
//   `from_post_title` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
//   `inserted_at` datetime NOT NULL DEFAULT current_timestamp(),
//   `json_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
//   UNIQUE KEY `id` (`id`)
// ) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

function my_custom_form_db__get_csv( $args=[] ) {
  if ( !current_user_can('administrator') ) { 
    echo "Скрипт может выполнить только администратор сайта";
    exit;
  }

  global $wpdb;
  $count = isset($args['count'])? $args['count'] : 25;
  $use_sql = isset($args['use_sql'])? trim($args['use_sql']) : false;
  $sql = isset($args['sql'])? trim($args['sql']) : null;
  $sql_password = isset($args['sql_password'])? trim($args['sql_password']) : null;
  $from_post_title = isset($args['from_post_title'])? trim($args['from_post_title']) : null;
  $from_post_id = isset($args['from_post_id'])? trim($args['from_post_id']) : null;
  $from_datetime = isset($args['from_datetime'])? trim($args['from_datetime']) : null;
  $to_datetime = isset($args['to_datetime'])? trim($args['to_datetime']) : null;
  $_SQL = null;

  if ($use_sql) {
    if ( $sql_password === MY_FORM_DATA_SQL_PASSWORD) {
      $_SQL = $sql;
    }
    else {
      echo 'Неверный пароль!';
      exit;
    }
  }
  else {
    $sql_WHERE = [];
    if ($from_post_title) $sql_WHERE[] = "from_post_title='$from_post_title'";
    if ($from_post_id) $sql_WHERE[] = "from_post_id='$from_post_id'";
    if ($from_datetime) $sql_WHERE[] = "inserted_at >= '$from_datetime'";
    if ($to_datetime) $sql_WHERE[] = "inserted_at <= '$to_datetime'";
    $sql_WHERE = count($sql_WHERE)? 'WHERE ' . implode(' AND ', $sql_WHERE) : '';

    $_SQL = "SELECT * FROM
      {$wpdb->prefix}my_custom_form_data
      $sql_WHERE
      ORDER BY inserted_at DESC
      LIMIT $count
    ";
  }

  $data = $wpdb->get_results($_SQL);

  if (!$data || !count($data)) {
    echo 'Данных по данному запросу нет';
    exit;
  };

  foreach ($data as $key => $value) {
    $json = json_decode( html_entity_decode( stripslashes($value->json_data) ) );
    if (!$json) continue;
    foreach ($json as $key2 => $v2) {
      $data[$key]->{'~' . $key2} = $v2;
    }
  }

  $csv_list = [
    []
  ];

  foreach ($data[0] as $key => $value) {
    // if ($key === 'json_data') continue;
    $csv_list[0][] = [$key];
  }

  $index = 0;
  foreach ($data as $i => $stdClass) {
    ++$index;
    $_ind = -1;

    // parse every column in row
    foreach ($stdClass as $col_name => $value) {
      ++$_ind;
      if ($col_name === 'json_data') {
        $csv_list[$index][] = 'скрыто';
      }
      else {
        $csv_list[$index][] = $value;
      }
      // update column title 
      $csv_list[0][$_ind][] = $col_name;
    }
  }

  foreach ($csv_list[0] as $_ind => $value) {
    if ($key === 'json_data') continue;
    $csv_list[0][$_ind] = implode( ' || ', array_unique($value) );
  }

  return $csv_list;
}





add_action( 'admin_post_dwl_my_custom_form_data_csv', 'prefix_admin_dwl_my_custom_form_data_csv');
add_action( 'admin_post_nopriv_dwl_my_custom_form_data_csv', 'prefix_admin_add_foobar' );
function prefix_admin_dwl_my_custom_form_data_csv() {

  array__to_csv_download( my_custom_form_db__get_csv([
    'count' => isset($_POST['count'])? $_POST['count'] : 25,
    'from_post_title' => isset($_POST['from_post_title'])? $_POST['from_post_title'] : null,
    'from_post_id' => isset($_POST['from_post_id'])? $_POST['from_post_id'] : null,
    'from_datetime' => isset($_POST['from_datetime'])? $_POST['from_datetime'] : null,
    'to_datetime' => isset($_POST['to_datetime'])? $_POST['to_datetime'] : null,
    'use_sql' => isset($_POST['use_sql'])? $_POST['use_sql'] : false,
    'sql' => isset($_POST['sql'])? $_POST['sql'] : null,
    'sql_password' => isset($_POST['sql_password'])? $_POST['sql_password'] : null,
  ]) );
}