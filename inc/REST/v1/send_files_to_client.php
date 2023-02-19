<?php
/***
  /wp-json/myrest/v1/send_files_to_client
***/
function REST__send_files_to_client() {
  $data = isset($_POST['jsonData'])? (array) json_decode( html_entity_decode( stripslashes($_POST['jsonData']) ) ) : [];
  $pageData = isset($_POST['pageData'])? (array) json_decode( html_entity_decode( stripslashes($_POST['pageData']) ) ) : [];

  $files_post_id = $pageData['ID'];
  if (isset($data['___acf_post_id___']) && $data['___acf_post_id___']) {
    $files_post_id = $data['___acf_post_id___'];
  }

  if (!isset($data['___acf_files_name___'])) return [
    'status' => 'error',
    'errors' => ['there is no ___acf_files_name___ param in POST']
  ];

  $files_WP_Post = get_post( $files_post_id );
  $files_WP_Post->acf = get_fields( $files_post_id );

  $file_URIs = [];
  $file_array = $files_WP_Post->acf[ $data['___acf_files_name___'] ];
  foreach ($file_array as $x) {
    $file = $x['file'];
    if ($file) {
      $file_URIs[] = $file['url'];
    }
  }

  $recipient_email = $data['email'];

  unset($data['___acf_files_name___']);
  unset($data['___acf_post_id___']);

  if ( isset($data['____send_to_client___'])
    && $data['____send_to_client___'] === 'true'
    && $recipient_email
  ) {
    $_POST['____send_to_client___'] = 1;
    REST__regular_form_handler();

    $attachments = []; 
    $subject = 'NEOS Ingredients. Со страницы ' . $pageData['post_title'] . '"';
    $headers = [ 'content-type: text/html' ];
    $msg = 'Отправка файлов';
  
    // $file_URIs = isset($data['____sent_files___'])? $data['____sent_files___'] : '';
    // $file_URIs = explode(',', $file_URIs);
    foreach ($file_URIs as $key => $uri) {
      // $path = parse_url("http://neos-ingredients.job/wp-content/uploads/2021/02/certificate-17767fc-bg-oct-18.pdf", PHP_URL_PATH);
      $attachments[] = $_SERVER['DOCUMENT_ROOT'] . parse_url($uri, PHP_URL_PATH);
    }

    if ( wp_mail( $recipient_email, $subject, $msg, $headers, $attachments) ) {
      return ['status' => 'ok'];
    }
    else return ['status' => 'error'];
  }

  else {
    return REST__regular_form_handler();
  }
}
