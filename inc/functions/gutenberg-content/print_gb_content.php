<?php
/**
 * @param Array $args
 *    @param Object $args[WP_Post] 
 */
function print_gb_content($WP_Post, $args=[]) { ?>
  <div class='my-ui-wp-content'>
    <?php if ( has_blocks( $WP_Post->post_content ) ) {
      $blocks = parse_blocks( $WP_Post->post_content );
      print_gb_content_block_parser($blocks, $args);
    } ?>
  </div>
<?php }


function print_gb_content_block_parser($blocks, $args=[]) {
  foreach ($blocks as $i => $block) {
    /* LIST */
    if ($block['blockName'] == 'core/list') {
      print_gb_list([
        'block' => $block,
        'ul_class' => 'my-ui-simple-list',
      ]);
    }

    /* TABLE */
    else if ($block['blockName'] == 'core/table') {
      echo "<div class='my-ui-table'>";
      echo apply_filters( 'the_content', render_block($block) );
      echo "</div>";
    }

    /* IMAGE */
    else if ($block['blockName'] == 'core/image') {
      print_gb_img([
        'block' => $block,
      ]);
    }

    /* GALLERY */
    else if ($block['blockName'] == 'core/gallery') {
      print_gb_gallery([
        'block' => $block,
      ]);
    }
    
    else if ($block['blockName'] == 'acf/gallery-slider') {
      echo render_block($block);
    }

    else echo apply_filters( 'the_content', render_block($block) );
  } // foreach
}