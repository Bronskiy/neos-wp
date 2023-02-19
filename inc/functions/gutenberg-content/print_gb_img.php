<?php 

function print_gb_img( $args ) {
  /* hide figure WARNING */libxml_use_internal_errors(true);
  $block = $args['block'];

  [ 'image_object' => $imgObj
  , 'all_image_sizes' => $all_image_sizes
  , 'srcset_arr' => $srcset_arr
  ] = get__image__object_by_id($block['attrs']['id'], true);

  $dom = new DOMDocument();
  __GB_SHOW_ERRORS__?
    $dom->loadHTML( $block['innerHTML'], LIBXML_HTML_NODEFDTD | LIBXML_HTML_NOIMPLIED )
    : $dom->loadHTML( $block['innerHTML'], LIBXML_HTML_NODEFDTD | LIBXML_HTML_NOIMPLIED | LIBXML_NOERROR | LIBXML_NOWARNING )
  ;

  $el = $dom->getElementsByTagName( 'img' )[0];
  if ($el) {
    // data-common-pswp-item
    $data_common_pswp_item = $dom->createAttribute('data-common-pswp-item');
    $data_common_pswp_item->value = htmlspecialchars( json_encode([
      'src' => $imgObj->sizes['large'],
      'w' => $imgObj->sizes['large-width'],
      'h' => $imgObj->sizes['large-height'],
      'msrc' => $imgObj->sizes['placeholder'],
      'title' => $imgObj->caption? $imgObj->caption : null,
    ]) );
    $el->appendChild($data_common_pswp_item);

    // srcset
    $srcset = $dom->createAttribute('srcset');
    $srcset->value = join($srcset_arr, ",\n");
    $el->appendChild($srcset);

    // sizes
    $sizes = $dom->createAttribute('sizes');
    $max_size = isset($block['attrs']['width'])?
      $block['attrs']['width']
      : $all_image_sizes[$block['attrs']['sizeSlug']][1];
    $sizes->value = "(max-width: {$max_size}px) 100vw, {$max_size}px";
    $el->appendChild($sizes);
  }

  echo utf8_decode($dom->saveHTML($dom->documentElement));
  /* unable WARNING */libxml_clear_errors();
}
