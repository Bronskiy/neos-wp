<?php 

function print_gb_youtube( $args ) {
  $block = $args['block'];
  echo "<pre class='r'>";
  print_r($block);
  echo "</pre>";
  $block_className = isset($block['attrs']['className'])? $block['attrs']['className'] : '';

  
  $url = isset($block['attrs']['url'])? $block['attrs']['url'] : ''; // https://www.youtube.com/watch?smth=2&v=i3TQQCxRxZk&t=12&...
  $url_v = get_youtube_v_id_from_url( $url );

?>
    
  
  <div
    tile
    flat
    class="mb-4 <?php echo $block_className ?> u-cursor-pointer"
  >
    <div class="video-container"
      data-youtube-src="https://www.youtube.com/embed/<?php echo $url_v ?>?hl=ru&modestbranding=1&rel=0&showinfo=0&start=0&color=white&iv_load_policy=3&autoplay=1"
      :style="{
        backgroundImage: 'url(https://i.ytimg.com/vi/<?php echo $url_v ?>/maxresdefault.jpg)', /*hqdefault.jpg*/
        backgroundSize: 'cover',
        backgroundPosition: 'center',
      }"
    >
      <svg class="video__icon" id="Layer_1" viewBox="0 0 512 512"><g><path d="M255.7,446.3c-53.3,0.3-106.6-0.4-159.8-3.3c-17.3-1-34.6-2.5-50.3-11c-10.5-5.7-18.6-13.6-23.7-24.8   C13.3,388.6,10.6,369,9,349c-3.4-41.3-3.6-82.6-1.8-123.8c0.9-21.9,1.6-44,6.8-65.5c2-8.4,4.9-16.6,8.8-24.4   c9.2-18.3,25.2-27.4,44.5-31.2c16.2-3.2,32.8-3.1,49.3-3.8c55.9-2.3,111.9-3.5,167.9-2.9c43.1,0.5,86.3,1.6,129.4,3.8   c13.3,0.7,26.7,0.9,39.4,5.6c17.2,6.4,30,17.2,36.9,34.7c6.7,16.8,9.3,34.2,10.7,52.1c3.9,48.6,4,97.2,0.8,145.8   c-1.1,16.4-2.2,32.8-6.5,48.9c-9.7,37-32.8,51.5-66.7,53.8c-36.2,2.4-72.5,3.7-108.8,4.2C298.4,446.5,277,446.3,255.7,446.3z    M203.2,344c48.4-26.5,96.2-52.7,144.8-79.3c-48.7-26.7-96.5-52.8-144.8-79.3C203.2,238.7,203.2,291,203.2,344z" fill="#DD2C28"/><path d="M203.2,344c0-53,0-105.3,0-158.5c48.3,26.4,96.1,52.6,144.8,79.3C299.4,291.4,251.6,317.5,203.2,344z" fill="#FEFDFD"/></g></svg>
    </div>
    <!-- <div
      v-if="visualSet.video.caption"
      class="pa-1 text--disabled font-weight-light caption text-center"
      v-html="visualSet.video.caption"
    ></div> -->
  </div>

<?php }

function get_youtube_v_id_from_url($url='') {
  /* if url contains '?' */
  if ( strpos($url, '?') !== false ) {
    $url_v = explode('?', $url)[1]; // smth=2&v=i3TQQCxRxZk&t=12&...
    $url_v = explode('v=', $url_v)[1]; // i3TQQCxRxZk&t=12&...
    $url_v = explode('&', $url_v)[0]; // i3TQQCxRxZk
    $url = $url_v;
  }
  return $url;
}