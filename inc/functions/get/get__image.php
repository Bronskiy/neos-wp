<?php

function get__image__all_sizes($attachment_id = 0) {
  $sizes = get_intermediate_image_sizes();
  $sizes[] = 'full';
  if(!$attachment_id) $attachment_id = get_post_thumbnail_id();

  $all_image_sizes = array();
  $sizes_def_arr = [];
  $srcset_arr = [];
  foreach ( $sizes as $sizeName ) {
    $img_arr = wp_get_attachment_image_src( $attachment_id, $sizeName );
    $all_image_sizes[$sizeName] = $img_arr;

    $srcset_arr[] = "{$img_arr[0]} {$img_arr[1]}w";

    $sizes_def_arr[$sizeName] = $img_arr[0];
    $sizes_def_arr[$sizeName . '-width'] = $img_arr[1];
    $sizes_def_arr[$sizeName . '-height'] = $img_arr[2];
  }
  $srcset_arr = array_unique( $srcset_arr );

  return (array) [
    'all_image_sizes' => $all_image_sizes,
    'srcset_arr' => $srcset_arr,
    'sizes' => $sizes_def_arr,
  ];
}



function get__image__object_by_id($id, $get_addition_data=false) {
  $imgObj = get_posts( ['post_type' => 'attachment', 'include' => $id] )[0];
  $imgObj->alt = get_post_meta( $id, '_wp_attachment_image_alt', true );
  $imgObj->caption = $imgObj->post_excerpt;
  $imgObj->sizes = [];
  $get__image__all_sizes = get__image__all_sizes( $id );
  ['sizes' => $imgObj->sizes] = $get__image__all_sizes;

  if ($get_addition_data) {
    return array_merge(
      ['image_object' => $imgObj],
      $get__image__all_sizes    
    );
  }

  return $imgObj;
}