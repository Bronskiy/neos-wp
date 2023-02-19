<?php

if (!function_exists('js__print_js_object_in_html_from_php_array')) {
  /**
   * @param String|Array $propName - window[$propName] | window[$propName[0]][$propName[1]]...
   * @param Object|Array $value - window[$propName] = $value
   */
  function js__print_js_object_in_html_from_php_array( $propName, $value=null, $asArray=1 ) {
    $args = (object) [
      'propName' => $propName,
      'obj' => $value? $value : (object) [],
      'asArray' => $asArray? 1 : JSON_OBJECT_AS_ARRAY,
    ];
    
    add_action ( 'wp_footer', function() use ( $args ) {
      $windowStricture = '';
      $path = "";
      if (is_array($args->propName)) {
        foreach ($args->propName as $value) {
          $path .= "['$value']";
          $windowStricture .= "\nif (window$path === undefined) window$path = {};";
        }
      } else {
        $path = ".{$args->propName}";
      }

      echo "
<script> $windowStricture
window" . $path . " = " . json_encode( $args->obj, $args->asArray+JSON_UNESCAPED_UNICODE ) . ";
</script>\n\n";
    });
  }
}