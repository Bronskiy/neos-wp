<?php

function acf_constructor__u__print_js_object_in_html_from_php_array( $varName, $obj, $asArray=1 ) {
  $args = (object) [
    'varName' => $varName,
    'obj' => $obj? $obj : (object) [],
    'asArray' => $asArray? 1 : JSON_OBJECT_AS_ARRAY,
  ];
  
  add_action( 'wp_footer', function() use ( $args ) {
    $windowStricture = '';
    $path = "";
    if (is_array($args->varName)) {
      foreach ($args->varName as $value) {
        $path .= "['$value']";
        $windowStricture .= "\nif (!window$path) window$path = {};";
      }
    } else $path = ".{$args->varName}";
    echo "
      <script>
        $windowStricture
        window" . $path . " = " . json_encode( $args->obj, $args->asArray+JSON_UNESCAPED_UNICODE ) . ";
      </script>
    ";
  });
}


function acf_constructor__u__add_acf_to_WP_Post_arr( $WP_Post_arr ) {
  foreach ($WP_Post_arr as $n => $WP_Post) {
    $WP_Post_arr[$n]->acf = get_fields( $WP_Post->ID );
  }
  return $WP_Post_arr;
}