<?php

class MY_ACF_GT_GALLERY_SLIDER extends MY_ACF {

  public $acf_group_key = 'gt_section_gallery_slider_group_key';

  public $active_acf;

  public $acf;

  public $block_name = 'gallery-slider'; /* DO NOT USE '_'!!! */

  public $active_acf_1_title = 'Настройка разметки сетки';
  public $active_acf_1;

  public $location;

  public $unique_id_prefix = 'gt_gallery_slider';

  public function register() {
    $this->acf = (object) [];

    $this->location = [
      array(
        [
          'param' => 'block',
          'operator' => '==',
          'value' => 'acf/' . $this->block_name,
        ],
      ),
    ];
    $this->register_gutenberg_block();

    $this->active_acf_1 = [
      $this->acf_gallery([
        'id' => $this->id(['aa1', 100]),
        'label' => __('Галерея', '_my_theme_'),
        'name' => 'gallery',
      ])
    ]; // $this->active_acf_1
    // 'enqueue_style' => get_stylesheet_directory_uri() . '/template-parts/blocks/restricted/restricted.css',
    add_action( 'acf/init', [$this, 'acf_init'] );
  }





  private function register_gutenberg_block() {
    add_action('acf/init', function() {
      // register a section block
      acf_register_block_type([
        'name' => $this->block_name,
        'title' => __('Слайдер "Галерея"'),
        'description' => __(''),
        'render_callback'	=> function($block) {
          $template_folder = get_template_directory() . '/inc/ACF/gutenberg-blocks/templates';
          /* convert name ("acf/blockName") into path friendly slug ("blockName") */
          $slug = str_replace('acf/', '', $block['name']);
          /* include a templates part from within the "templates/gutenberg-blocks" folder */
          if ( file_exists("$template_folder/{$slug}.php") ) {
            include( "$template_folder/{$slug}.php" );
          }
        },
        'category' => 'media',
        'icon'		 => 'images-alt2',
        'keywords' => [ $this->block_name ], /* for searching in blocks */
      ]);
    });
  }
  



  public function acf_init() {
    if( function_exists('acf_add_local_field_group') ) {
      $this->register_acf_group([
        'title' => $this->active_acf_1_title,
        'group_key' => $this->acf_group_key,
        'fields' => $this->active_acf_1,
        'location' => $this->location,
      ]);
    };
  }

}