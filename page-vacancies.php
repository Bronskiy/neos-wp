<?php
/**
 * Template Name: Page of vacancies
 */

add_action( 'wp_head', function() { ?>
  <style type="text/css">
    .our_team_photo {
      display: none;
    }
    @media (max-width: 400px) {
      .our_team_photo__photo_0_400 { display: block } 
    }
    @media (min-width: 400px) and (max-width: 576px) {
      .our_team_photo__photo_400_576 { display: block } 
    }
    @media (min-width: 576px) and (max-width: 768px) {
      .our_team_photo__photo_576_768 { display: block } 
    }
    @media (min-width: 768px) and (max-width: 960px) {
      .our_team_photo__photo_768_960 { display: block } 
    }
    @media (min-width: 960px) and (max-width: 1140px) {
      .our_team_photo__photo_960_1140 { display: block } 
    }
    @media (min-width: 1140px) {
      .our_team_photo__photo_from_1140 { display: block } 
    }
  </style>
<?php });
  get_header(null, ['seo_title_descr_type' => 'pages']);
?>

<input id="wpPageNameInput" type="hidden" value="page-of-vacancies">
<?php
  $current_WP_Post = get_post( _current_POST_ID_ );
  $current_WP_Post->acf = get_fields( _current_POST_ID_ );
  $currentLangCode = $GLOBALS['_CURRENT_LANG'];

  $vacancy_query = new WP_Query([
    'post_type' => MY_CPT_JOB_VACANCY,
    'posts_per_page' => -1,
  ]);
  wp_reset_query();

  $vacancies = $vacancy_query->posts;
  foreach ($vacancies as $i => $WP_Post) {
    $vacancies[$i]->acf = get_fields($WP_Post->ID);
  }

  function _template_function__print_our_team_img( $key, $photo ) { ?>
    <img
      class="u-img-contain lazy our_team_photo <?php echo "our_team_photo__$key" ?>"
      style="width:100%; height: 100%;"
      src="<?php echo $photo['sizes']['placeholder'] ?>"
      data-src="<?php echo $photo['sizes']['w640'] ?>"
      data-srcset="
        <?php echo $photo['sizes']['w240'] ?> 240w,
        <?php echo $photo['sizes']['medium'] ?> 300w,
        <?php echo $photo['sizes']['w400'] ?> 400w,
        <?php echo $photo['sizes']['w576'] ?> 576w,
        <?php echo $photo['sizes']['w640'] ?> 640w,
        <?php echo $photo['sizes']['medium_large'] ?> 768w,
        <?php echo $photo['sizes']['w860'] ?> 860w,
        <?php echo $photo['sizes']['w960'] ?> 960w,
        <?php echo $photo['sizes']['large'] ?> 1024w,
        <?php echo $photo['sizes']['w1140'] ?> 1140w,
        <?php echo $photo['sizes']['w1366'] ?> 1366w,
      "
      data-sizes="
        (max-width: 1140px) 100vw,
        (mim-width: 1140px) 1140px,
      "
      alt="<?php echo $photo['alt'] ?>"
      data-our-production-pswp-item="<?php echo htmlspecialchars( json_encode([
        'src' => $photo['sizes']['large'],
        'w' => $photo['sizes']['large-width'],
        'h' => $photo['sizes']['large-height'],
        'msrc' => $photo['sizes']['placeholder'],
        'title' => $photo['caption']? $photo['caption'] : null,
      ]) ) ?>"
    />
  <?php }
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
  <div class="text-center mb-8">
    <h1 class="h-36px h-36px--underlined"><?php echo $current_WP_Post->post_title ?></h1>
  </div>
</div>


<div class="cg-container">

  
  <div class="pos-rel">
    <?php foreach ($current_WP_Post->acf['our_team'] as $key => $photo) { 
      _template_function__print_our_team_img( $key, $photo );
    } ?>
  </div>
  <div style="height:60px"></div>


  <?php if ($current_WP_Post->post_content): ?>
    <?php print_gb_content( $current_WP_Post ) ?>
    <div style="height:60px"></div>
  <?php endif ?>




  <div class="cg-row">
    <?php foreach ($vacancies as $WP_Post) { ?>
      <div class="cg-col-12 mb-8" data-vacancy-json="<?php echo htmlspecialchars( json_encode( [
        'vacancy_name' => $WP_Post->acf['working_position'],
        'wage' => $WP_Post->acf['wage'],
        'city' => $WP_Post->acf['city'],
      ] ) ) ?>">
        <h3 class="t-18px">
          <span class="text-color-highlight mr-2"><?php echo $WP_Post->acf['working_position'] ?></span>
          <b><?php echo $WP_Post->acf['wage'] ?></b> (<?php echo $WP_Post->acf['city'] ?>)
        </h3>
        <div class="color--000-67">
          <?php print_gb_content( $WP_Post ) ?>
        </div>
        <div class="text-right">
          <div class="mdc-button mdc-button--outlined my__mdc-button--primary open-vacancy-form-dialog">
            <span class="mdc-button__ripple"></span>
            <span class="mdc-button__label"><?php echo __('Подать резюме', '_my_theme_') ?></span>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
  <div style="height:60px"></div>
</div>


<?php
  $vacancy_form_WP_Post = wp_post__get_lang_post( get_option('__vacancy_from_template_id__'), $GLOBALS["_CURRENT_LANG"]);
  $vacancy_form = get_fields($vacancy_form_WP_Post->ID)['form'];
  array_unshift($vacancy_form['fields'], [
    'acf_fc_layout' => 'textfield',
    'label' => __('Вакансия', '_my_theme_'),
    'name' => 'vacancy',
    'required' => true,
    'disabled' => true,
    'input_type' => 'text',
    'value' => '4',
  ]);
  print_form__dialog_form([
    'form_data' => $vacancy_form,
    'dialog_id' => 'vacancyFormDialog',
    'form_id' => 'vacancyFormDialogForm',
    'layout' => 'only-form',
  ]);
?>




<?php 
  $contact_form = get__form__acf_form_data([
    'form_template_id' => isset($current_WP_Post->acf['form_template_id'])? $current_WP_Post->acf['form_template_id'] : null,
    'use_custom_form' => $current_WP_Post->acf['use_custom_form'],
    'form_options' => isset($current_WP_Post->acf['form_options'])? $current_WP_Post->acf['form_options'] : [],
    'custom_form' => isset($current_WP_Post->acf['custom_form'])? $current_WP_Post->acf['custom_form'] : [],
  ]);
?>
<div class="composed-bgr-waves">
  <?php print_form__default_form_template($contact_form) ?>
</div>





<?php
	$GLOBALS["_FOOTER_"] = [
		'top-margin' => false,
	];
  get_footer();
?>