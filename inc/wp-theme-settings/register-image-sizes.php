<?php

add_action('after_setup_theme', function() {
  // default thumbnail 150px
  // default medium  300px
  // default medium_large  768px 
  // default large  1024px

  // add_image_size(name, width, height, hardCrop)
  add_image_size('placeholder', 7, 0);
  // default thumbnail 150px
  add_image_size('w240', 240, 0);
  // default medium  300px
  add_image_size('w320', 320, 0);
  add_image_size('w400', 400, 0);
  add_image_size('w576', 576, 0);
  add_image_size('w640', 640, 0);
  // default medium_large  768px 
  add_image_size('w860', 860, 0);
  add_image_size('w960', 960, 0);
  // default large  1024px
  add_image_size('w1140', 1140, 0);
  add_image_size('w1366', 1366, 0);
  add_image_size('w1536', 1536, 0);
  add_image_size('w1920', 1920, 0);
  add_image_size('w2560', 2560, 0);
});