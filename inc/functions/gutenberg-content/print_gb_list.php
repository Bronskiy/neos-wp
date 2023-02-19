<?php
/**
 * @param Array $args['block'] - block from parse_blocks() where $block['blockName'] == 'core/columns'
 * @param String $args['class']
 * @param String $args['ul_class']
 * @param String $args['ol_class']
 * @param String $args['dl_class']
 */
function print_gb_list( $args ) {
  $block = $args['block'];
  $block_className = isset($block['attrs']['className'])? $block['attrs']['className'] : '';

  $dom = new DOMDocument();
  __GB_SHOW_ERRORS__?
    $dom->loadHTML( $block['innerHTML'], LIBXML_HTML_NODEFDTD | LIBXML_HTML_NOIMPLIED )
    : $dom->loadHTML( $block['innerHTML'], LIBXML_HTML_NODEFDTD | LIBXML_HTML_NOIMPLIED | LIBXML_NOERROR | LIBXML_NOWARNING )
  ;

  // $list_type = null;
  $extra_class = '';
  $list = null;
  $el = $dom->getElementsByTagName( 'ul' )[0];
  if ($el) {
    // $list_type = 'ul';
    $list = $el;
    $extra_class = isset($args['ul_class'])? $args['ul_class'] : '';
  }
  $el = $dom->getElementsByTagName( 'ol' )[0];
  if ($el) {
    // $list_type = 'ol';
    $list = $el;
    $extra_class = isset($args['ol_class'])? $args['ol_class'] : '';
  }
  $el = $dom->getElementsByTagName( 'dl' )[0];
  if ($el) {
    // $list_type = 'dl';
    $list = $el;
    $extra_class = isset($args['dl_class'])? $args['dl_class'] : '';
  }

  $domClass = $dom->createAttribute('class');
  $domClass->value = isset($args['class'])? $args['class'] : '' . " $extra_class" . " $block_className";
  $list->appendChild($domClass);

  echo utf8_decode($dom->saveHTML($dom->documentElement));
}