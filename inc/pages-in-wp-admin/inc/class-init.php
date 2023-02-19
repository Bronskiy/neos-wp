<?php

final class Init {
  /**
   * Store all the classes inside an array
   * @return array Full list of classes
   */
  public static function get_services() {
    require_once 'pages/class-admin.php';
    
    return [
      Admin::class,
    ];
  }

  /**
   * Loop through the classes, initialize them,
   * and call the register() methoid if it exists
   */
  public static function register_services() {
    foreach ( self::get_services() as $class ) {
      $service = self::instantiate( $class );
      if ( method_exists( $service, 'register' )) {
        $service->register();
      }
    }
  }

  /**
   * Initialiaze the class
   * @param class $class class from the service array
   * @return class instance new instance of the class
   */
  private static function instantiate( $class ) {
    return new $class();
  }
}