<?php
/**
 * Template Name: landing-page
 */
?>
<?php get_header(null, ['seo_title_descr_type' => 'pages']) ?>
<input id="wpPageNameInput" type="hidden" value="landing-page">
<?php
  $current_WP_Post = get_post( _current_POST_ID_ );
  $current_WP_Post->acf = get_fields( _current_POST_ID_ );
  $currentLangCode = $GLOBALS['_CURRENT_LANG'];
  $dwl_files = [];

  /* FILES */
  if ($current_WP_Post->acf['files_for_dwl']) {
    foreach ($current_WP_Post->acf['files_for_dwl'] as $key => $file) {
      $dwl_files[] = [
        'ID' => $file['file']['ID'],
        'filename' => $file['file']['filename'],
        'url' => $file['file']['url'],
      ];
    }
  }
  js__print_js_object_in_html_from_php_array( ['_$_', 'afterFormFillLpDwlFiles'], $dwl_files );
?>

<div class="cg-container common-page__flex-grid-container">
  <!-- BREADCRUMBS -->
  <div class="common-page__breadcrumbs-wrp" style="padding-right:52px">
    <?php print_ui__breadcrumbs([
      [
        'title' => __('Главная', '_my_theme_'),
        'href' => pll_home_url( $currentLangCode )
      ],
      [
        'title' => $current_WP_Post->post_title,
        'disabled' => true,
      ],
    ]) ?>
  </div>
  <!-- Title -->
  <div class="text-center mb-4">
    <h1 class="h-36px h-36px--underlined"><?php echo $current_WP_Post->post_title ?></h1>
  </div>
</div>


<?php if ($current_WP_Post->post_content): ?>
  <section>
    <div class="cg-container">
      <div style="height:24px"></div>
      <?php  print_gb_content( $current_WP_Post ) ?>
    </div>
  </section>
<?php endif ?>



<?php
  $contact_form = get__form__acf_form_data([
    'form_template_id' => isset($current_WP_Post->acf['form_template_id'])? $current_WP_Post->acf['form_template_id'] : null,
    'use_custom_form' => $current_WP_Post->acf['use_custom_form'],
    'form_options' => isset($current_WP_Post->acf['form_options'])? $current_WP_Post->acf['form_options'] : [],
    'custom_form' => isset($current_WP_Post->acf['custom_form'])? $current_WP_Post->acf['custom_form'] : [],
  ]);
?>
<div class="cg-container">
  <?php print_form__default_form_template(
    $contact_form,
    [
      'form_id' => 'dwlDataForm',
      'extra_before_submit_btns' => count($dwl_files)? [
        [
          'text' => $current_WP_Post->acf['dwl_btn']['text'],
          'id' => 'dwlFilesFormBtn'
        ]
      ] : null,
      'endpoint' => $GLOBALS["REST_ENDPOINTS"]->send_files_to_client
    ]
  ) ?>
</div>

<?php get_footer() ?>