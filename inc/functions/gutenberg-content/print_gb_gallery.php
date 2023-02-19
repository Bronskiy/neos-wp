<?php 

function print_gb_gallery( $args ) {
  /* hide figure WARNING */libxml_use_internal_errors(true);
  $block = $args['block'];
  $sizeSlug = isset($block['attrs']['sizeSlug'])? $block['attrs']['sizeSlug'] : 'large';

  $dom = new DOMDocument();
  __GB_SHOW_ERRORS__?
    $dom->loadHTML( $block['innerHTML'], LIBXML_HTML_NODEFDTD | LIBXML_HTML_NOIMPLIED )
    : $dom->loadHTML( $block['innerHTML'], LIBXML_HTML_NODEFDTD | LIBXML_HTML_NOIMPLIED | LIBXML_NOERROR | LIBXML_NOWARNING )
  ;

  $els = $dom->getElementsByTagName( 'img' );
  foreach ($els as $n => $el) {
    $imgObj = null;
    $all_image_sizes = null;
    $srcset_arr = [];

    [ 'image_object' => $imgObj
    , 'all_image_sizes' => $all_image_sizes
    , 'srcset_arr' => $srcset_arr
    ] = get__image__object_by_id($block['attrs']['ids'][$n], true);

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
    $sizeSlugW = $all_image_sizes[$sizeSlug][1];
    $sizes = $dom->createAttribute('sizes');
    $sizes->value = "(max-width: {$sizeSlugW}px) 100vw, {$sizeSlugW}px";
    $el->appendChild($sizes);
  }

  echo utf8_decode($dom->saveHTML($dom->documentElement));
  // /* unable WARNING */libxml_clear_errors();
}
