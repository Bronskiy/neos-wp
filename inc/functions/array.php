<?php
/**
 * @param String $prop_key
 * @param Array $arr
 *   array__set_item_prop_val_as_item_key('id', [
 *     0 => [id: 23, ...],
 *     1 => [id: 75, ...],
 *     ...
 *   ]);
 * 
 *   returns [
 *     23 => [id: 23, ...],
 *     75 => [id: 75, ...],
 *     ...
 *   ]
 */
function array__set_item_prop_val_as_item_key( $prop_key, $arr ) {
  if (!$arr) return [];
  $new_arr = [];
  foreach ($arr as $v) {
    // if (object) use as array
    $_v = (array) $v;
    $new_arr[ $_v[$prop_key] ] = $v;
  }
  return $new_arr;
}


/**
 *   array__set_key_1_value_array('key_2', [
 *     0 => [
 *       key_1 => val_1,
 *       key_2 => val_2,
 *       ...
 *     ],
 *     1 => ...,
 *     ...
 *   ]);
 *   
 *   returns [
 *     0 => val_2,
 *     1 => val_3,
 *     ...
 *   ]
 */
function array__set_key_1_value_array($key, $array) {
  $arr = [];
  foreach ($array as $k => $v) {
    $v = (array) $v;
    $arr[$k] = $v[$key];
  }
  return $arr;
}





/**
 * @param Array $args=[]
 *   @param Array $args[map]*
 *   @param Array $args[childPropName] = children
 *   @param Array $args[callback] = null // function( el ) { ...; return el; }
 */
function array__recursive_handler($args=[]) {
  $map = isset($args['map']) ? $args['map'] : [];
  $childPropName = isset($args['childPropName']) ? $args['childPropName'] : 'children';
  $callback = isset($args['callback']) ? $args['callback'] : null;
  $map = array__recursive_handler__($map, $childPropName, $callback);
  return $map;
}

function array__recursive_handler__($map, $childPropName, $callback) {
  if (!$callback) {
    trigger_error('callback is not set in array__recursive_handler([callback: ..., ...])!', E_USER_ERROR);
    return;
  }
  foreach ($map as $i_1 => $el_1) {
    $map[$i_1] = call_user_func($callback, $map[$i_1]);
    $map[$i_1][$childPropName] = array__recursive_handler__($map[$i_1][$childPropName], $childPropName, $callback);
  }
  return $map;
}





function array__to_csv_download($array, $filename = "export.csv", $delimiter=";") {
  // open raw memory as file so no temp files needed, you might run out of memory though
  $f = fopen('php://memory', 'w'); 
  // loop over the input array
  foreach ($array as $line) { 
    // generate csv lines from the inner arrays
    fputcsv($f, $line, $delimiter); 
  }
  // reset the file pointer to the start of the file
  fseek($f, 0);
  // tell the browser it's going to be a csv file
  // header('Content-Type: application/csv; charset=UTF-8');
  header('Content-Type: application/csv; charset=UTF-8');
  // tell the browser we want to save it instead of displaying it
  header('Content-Disposition: attachment; filename="'.$filename.'";');
  // make php send the generated csv lines to the browser
  fpassthru($f);
}