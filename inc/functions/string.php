<?php

/**
 * Removes all spaces (regular space, new line, tab, ...)
 */
function string__remove_whitespaces($str, $replacement='') {
  return preg_replace('/\s+/', $replacement, $str);
}


function string__split_by_spaces_commas_semicolon($str) {
  $str = string__remove_whitespaces($str, ';');
  $str = preg_replace('/,/', ';', $str);
  $str = array_filter( explode(';', $str), function($el) { if ($el) return 1; });
  return $str;
}