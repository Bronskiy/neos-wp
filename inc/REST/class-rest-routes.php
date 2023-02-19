<?php
/* GET REST templates */

class MY_REST_ROUTES {
  public function register() {
    $this->register__REST__test();
    $this->register__REST__get_post_cards();
    $this->register__REST__send_files_to_client();
    $this->register__REST__single_master_class_form_handler();
    
    require_once TEMPLATEPATH . '/inc/REST/v1/regular_form_handler.php';
    $this->register__REST__regular_form_handler();

    require_once TEMPLATEPATH . '/inc/REST/v1/get_products.php'; // can use in templates
    $this->register__REST__get_products();

    require_once TEMPLATEPATH . '/inc/REST/v1/get_news.php'; // can use in templates
    $this->register__REST__get_news();

    $GLOBALS["REST_ENDPOINTS"] = (object) [
      'test' => '/wp-json/myrest/v1/test',
      'regular_form_handler' => '/wp-json/myrest/v1/regular_form_handler',
      'single_master_class_form_handler' => '/wp-json/myrest/v1/single_master_class_form_handler',
      'send_files_to_client' => '/wp-json/myrest/v1/send_files_to_client',
      'get_post_cards' => '/wp-json/myrest/v1/get_post_cards',
      'get_products' => '/wp-json/myrest/v1/get_products',
      'get_news' => '/wp-json/myrest/v1/get_news',
    ];
  }

  private function register__REST__test() {
    add_action('rest_api_init', function(){
      // .../wp-json/myrest/v1/test
      register_rest_route('myrest/v1', 'test', [
        'methods' => "GET, POST",
        'callback' => 'REST__test',
        'permission_callback' => '__return_true',
      ]);
      require_once TEMPLATEPATH . '/inc/REST/v1/test.php';
    });
  }

  private function register__REST__regular_form_handler() {
    add_action('rest_api_init', function(){
      // .../wp-json/myrest/v1/regular_form_handler
      register_rest_route('myrest/v1', 'regular_form_handler', [
        'methods' => "POST",
        'callback' => 'REST__regular_form_handler',
        'permission_callback' => '__return_true',
      ]);
    });
  }

  private function register__REST__single_master_class_form_handler() {
    add_action('rest_api_init', function(){
      // .../wp-json/myrest/v1/single_master_class_form_handler
      register_rest_route('myrest/v1', 'single_master_class_form_handler', [
        'methods' => "POST",
        'callback' => 'REST__single_master_class_form_handler',
        'permission_callback' => '__return_true',
      ]);
      require_once TEMPLATEPATH . '/inc/REST/v1/single_master_class_form_handler.php';
    });
  }

  private function register__REST__get_post_cards() {
    add_action('rest_api_init', function(){
      // .../wp-json/myrest/v1/get_post_cards
      register_rest_route('myrest/v1', 'get_post_cards', [
        'methods' => "GET",
        'callback' => 'REST__get_post_cards',
        'permission_callback' => '__return_true',
      ]);
      require_once TEMPLATEPATH . '/inc/REST/v1/get_post_cards.php';
    });
  }

  private function register__REST__send_files_to_client() {
    add_action('rest_api_init', function(){
      // .../wp-json/myrest/v1/send_files_to_client
      register_rest_route('myrest/v1', 'send_files_to_client', [
        'methods' => "GET, POST",
        'callback' => 'REST__send_files_to_client',
        'permission_callback' => '__return_true',
      ]);
      require_once TEMPLATEPATH . '/inc/REST/v1/send_files_to_client.php';
    });
  }

  private function register__REST__get_products() {
    add_action('rest_api_init', function(){
      // .../wp-json/myrest/v1/get_products
      register_rest_route('myrest/v1', 'get_products', [
        'methods' => "GET",
        'callback' => 'REST__get_products',
        'permission_callback' => '__return_true',
      ]);
    });
  }

  private function register__REST__get_news() {
    add_action('rest_api_init', function(){
      // .../wp-json/myrest/v1/get_products
      register_rest_route('myrest/v1', 'get_news', [
        'methods' => "GET",
        'callback' => 'REST__get_news',
        'permission_callback' => '__return_true',
      ]);
    });
  }
}