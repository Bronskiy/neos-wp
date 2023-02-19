<?php
/***
  /wp-json/myrest/v1/regular_form_handler
***/
function REST__regular_form_handler( $args=[] ) {
  $save_form_data_in_db = true;
  if (isset($args['save_form_data_in_db']) && !$args['save_form_data_in_db']) $save_form_data_in_db = false;

  $send_files = isset($args['send_files'])?
    $args['send_files']
    : (isset($_POST['send_files'])? $_POST['send_files'] : true)
  ;

  $WP_Post = get_post( get_option('__contact_us_settings__ ') );
  $WP_Post->acf = get_fields($WP_Post->ID);

  $data = isset($_POST['jsonData'])? (array) json_decode( html_entity_decode( stripslashes($_POST['jsonData']) ) ) : [];
  $pageData = isset($_POST['pageData'])? (array) json_decode( html_entity_decode( stripslashes($_POST['pageData']) ) ) : [];

  $recipient = isset($_POST['recipient'])? $_POST['recipient'] : $WP_Post->acf['email_settings']['get_all_letters_emails'];
  $recipient = string__split_by_spaces_commas_semicolon($recipient);


  date_default_timezone_set( 'Europe/Moscow' );
  $attachments = []; 
  $subject = 'NEOS-Ingredients. Форма со страницы "' . $pageData['post_title'] . '"';
  $headers = [ 'content-type: text/html' ];
  $MOWdate = date("j.m.o G:i");

  $br = "\n<br>";
  $tab="&nbsp;&nbsp;&nbsp;&nbsp;";
  $msg = '';
  $msgHeader = "<b>". get_bloginfo( 'name' ) ."</b>$br<b>$MOWdate</b> (по Московскому).$br";
  $msgHeader .= isset($pageData)? "Письмо пришло со страницы \"<a href='". $pageData['page_url']  ."'>". $pageData['post_title'] ."</a>\"$br".$br : '';

  /* DATA parse */
  foreach ($data as $fieldName => $fieldVal) {
    $fieldName? $fieldName = $fieldName : $fieldName = 'Без имени';
    if ($fieldName === '____send_to_client___') {
      if (!isset($_POST['____send_to_client___']) && !$_POST['____send_to_client___']) continue;
      $fieldName = 'Файлы отправлены клиенту';
    }
    if ( in_array($fieldName, ['___acf_files_name___', '___acf_post_id___']) ) {
      continue;
    }
    
    if (is_array($fieldVal)) {
      $msg .= "<b>$fieldName</b>:$br";
      foreach ($fieldVal as $i => $value) {
        $msg .= $tab . ($i+1) . ") $value;$br";
      }
    }

    else {
      $msg .= "<b>$fieldName</b>:  $fieldVal;$br";
    }
    $msg .= "$br";
  }

  if ($save_form_data_in_db) {
    global $wpdb;
    $wpdb->insert( "{$wpdb->prefix}my_custom_form_data", [
      'from_post_title' => $pageData['post_title'],
      'from_post_id' => $pageData['ID'],
      'json_data' => $_POST['jsonData'],
      'lang' => $pageData['lang'],
    ]);
  }

  
  /* FILES */
  if ($send_files && count($_FILES)) {
    foreach ($_FILES as $_fieldName_ => $file) {
      /* UPLOAD file */
      // .../wp-content/uploads/mail_order_files/...
      $uploads_dir =  wp_get_upload_dir()["basedir"] . "/mail_order_files";
      // if folder is not exists - create it
      if (!file_exists($uploads_dir)) mkdir($uploads_dir, 0777, true);
      if ($file["error"] == UPLOAD_ERR_OK) {
        $newFileName = time() ."_". basename($file['name']);
        // save new file
        move_uploaded_file( $file["tmp_name"], "$uploads_dir/$newFileName");
        $attachments[] = "$uploads_dir/$newFileName";
      }
    }
  }

  $msg = $msgHeader . $msg;

  $sent = true;
  if (!count($recipient)) return [
    'status' => 'error',
    'errors' => ['Recipient is not assigned']
  ];
  if ( !wp_mail( $recipient, $subject, $msg, $headers, $attachments ) ) {
    $sent = false;
  }
  return $sent
      ? ['status' => 'ok']
      : [
          'status' => 'error',
          'errors' => ['Email did not send']
        ]
      ;
}