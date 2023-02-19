<?php
/***
  /wp-json/myrest/v1/single_master_class_form_handler
***/
function REST__single_master_class_form_handler() {
  $data = isset($_POST['jsonData'])? (array) json_decode( html_entity_decode( stripslashes($_POST['jsonData']) ) ) : [];
  $pageData = isset($_POST['pageData'])? (array) json_decode( html_entity_decode( stripslashes($_POST['pageData']) ) ) : [];
  $client_recipient = isset($data['email'])? $data['email'] : null;
  $sent = true;

  if ($client_recipient) {
    $subject = "NEOS-Ingredients. Запись на мастер-класс \"{$pageData['post_title']}\"";
    $headers = [ 'content-type: text/html' ];

    /*1*/$registration_close_date = get_field('registration_close_date', $pageData['ID'] );
    /*2*//* должно быть после получения даты! */ date_default_timezone_set( 'Europe/Moscow' );
    $response_to_client__success = get_field('response_to_client__success', $pageData['ID'] );
    $response_to_client__late = get_field('response_to_client__late', $pageData['ID'] );
    $success_default_text = 'Вы успешно зарегистрировались!';
    $late_default_text = 'Приносим свои извинения, но регистрация уже закрыта!';
    $success_text = $response_to_client__success ? $response_to_client__success : $success_default_text;
    $msg = '';

    if ($registration_close_date) {
      if ( strtotime('now') <= strtotime($registration_close_date) ) {
        $msg .= $success_text;
      } else {
        $msg .= $response_to_client__late ? $response_to_client__late : $late_default_text;
      }
    } else {
      $msg .= $success_text;
    }
    $msg .= "<br>С уважением, NEOS-ингредиентс.";

    if ( !wp_mail( $client_recipient, $subject, $msg, $headers, []) ) $sent = false;
  }
  else $sent = false;

  if ($sent) {
    return REST__regular_form_handler();
  }
  return $sent
    ? ['status' => 'ok']
    : [
        'status' => 'error',
        'errors' => ['Письмо-подтверждение не было отправлено на почту клиента']
      ]
    ;
}