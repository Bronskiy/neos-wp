<?php

function print_ui__lang_list_selection($args) {
  $menu_id = isset($args['menu_id'])? $args['menu_id'] : pll_current_language();
  $current_lang_code = isset($args['current_lang_code'])? $args['current_lang_code'] : pll_current_language();
  $langs = isset($args['langs'])? $args['langs'] : pll_the_languages(['raw' => 1]);
?>

  <div class="lang-list" data-my-ui-menu-activator="<?php echo $menu_id ?>">
    <div class="lang-list__img-wrp elevation-2">
      <img src="<?php echo get_template_directory_uri() . "/assets/images/svg/flags/1x1/$current_lang_code.svg" ?>" alt="<?php echo $current_lang_code ?>"/>
    </div>
    <div class="text-uppercase">
      <?php echo $current_lang_code ?>
    </div>

    <div class="lang-list__menu my-ui-menu" data-my-ui-menu="<?php echo $menu_id ?>">
      <ul class="my-list elevation-4">
        <?php foreach ($langs as $langCode => $lang) { ?>
          <li class="my-list__item">
            <a href="<?php echo $lang['url'] ?>" class="a-link-unset">
              <div class="d-flex align-center">
                <div class="lang-list__img-wrp elevation-2">
                  <img src="<?php echo get_template_directory_uri() . "/assets/images/svg/flags/1x1/{$langCode}.svg" ?>" alt="<?php echo $langCode ?>"/>
                </div>
                <div>
                  <?php echo $lang['name'] ?>
                </div>
              </div>
            </a>
          </li>
        <?php } ?>
      </ul>
    </div>
  </div>
<?php }





function print_ui__breadcrumbs($items=[]) { ?>
  <nav class="my-ui-breadcrumbs">
    <ul>
      <?php foreach ($items as $index => $item) {
        $href = isset($item['href'])? $item['href'] : null;
        $title = isset($item['title'])? $item['title'] : '';
        $disabled = isset($item['disabled'])? $item['disabled'] : false;
        $id = isset($item['id'])? $item['id'] : null;
        $class = isset($item['class'])? $item['class'] : null;
      ?>
        <li><!--
        --><div <?php if ($id) echo "id='$id'" ?>><?php
            if ($index !== 0) {
              ?><span class="ml-1 mr-2">/</span><?php
            }
            if ($href) {
              ?><a
                href="<?php echo $href ?>"
                class="a-link a-link--blue-style <?php if ($disabled) echo 'a-link--disabled'; if ($class) echo " $class" ?>"
              ><?php
                echo $title
              ?></a><?php
            } else {
              ?><span class="<?php if ($disabled) echo 'a-link--disabled'; if ($class) echo " $class" ?>"><?php
                echo $title
              ?></span><?php
            }
          ?></div><!--
        --></li>
      <?php } ?>
    </ul>
  </nav>
<?php }





function print_ui__progress_circular($r=20) { ?>
  <?php if ($r === 12) { ?>
    <div class="my-ui-progress-circular__wrp">
      <svg class="my-ui-progress-circular my-ui-progress-circular--r12">
        <circle class="path" cx="16" cy="16" r="12" fill="none" stroke-width="3" stroke-miterlimit="10" />
      </svg>
    </div>
  <?php } else { ?>
    <div class="my-ui-progress-circular__wrp">
      <svg class="my-ui-progress-circular">
        <circle class="path" cx="24" cy="24" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
      </svg>
    </div>
  <?php } ?>
<?php }