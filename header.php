<?php
	/*0!*/ define('_current_POST_ID_', get_the_id());

	$GLOBALS["_CURRENT_POST"] = get_post(_current_POST_ID_);
	if (!$GLOBALS["_CURRENT_POST"]) $GLOBALS["_CURRENT_POST"] = (object) [];
	
	$GLOBALS["_CURRENT_POST"]->acf = get_fields(_current_POST_ID_);
	$seo = isset($GLOBALS["_CURRENT_POST"]->acf['seo'])? $GLOBALS["_CURRENT_POST"]->acf['seo'] : [];
	wp_reset_query();
	
	/*1*/// Set window._$_.langs
	$langs = pll_the_languages(['raw' => 1]);
	$current_lang_code = pll_current_language();
	$GLOBALS["_CURRENT_LANG"] = pll_current_language();
	foreach ($langs as $lang_code => $lang) {
		if ($lang['current_lang']) {
			// js__print_js_object_in_html_from_php_array(['_$_', 'currentLangCode'], $lang_code);
		}
		// get url params string
		$url_params = explode('?', $_SERVER['REQUEST_URI']);
		array_shift($url_params);
		$url_params = join('?', $url_params);
		// compose url for other lang
		$langs[$lang_code]['url'] = get_permalink( wp_post__get_lang_post_id( _current_POST_ID_, $lang_code ) ) . ($url_params? "?$url_params" : '');
	}
	// js__print_js_object_in_html_from_php_array(['_$_', 'langs'], $langs);

	/* TRANSLATIONS */
	js__print_js_object_in_html_from_php_array(['_$_', 'translations'], [
		'__FormIsSent' =>  __('Форма отправлена', '_my_theme_'),
		'__FormIsNotSent' =>  __('Форма не отправлена', '_my_theme_'),
		'__AnErrorHasOccurred' =>  __('Произошла ошибка', '_my_theme_'),
		'__CallUsByTel' =>  __('Свяжитесь с нами по телефону', '_my_theme_'),
	]);


	/*2*/// Set window._$_.headerMenu
	$polylang_options = get_option( 'polylang' );
	$menu_id = $polylang_options['nav_menus'][ 'custom-theme' ][ 'my__header_menu' ][ $current_lang_code ];
	$menu = wp_menu__get( $menu_id );
	$menu_obj = wp_get_nav_menu_object($menu_id);
	$menu_obj->acf = get_fields($menu_obj);
	$GLOBALS["_MENU_MAP"] = $menu->map;
	$GLOBALS["_MENU_ITEMS"] = $menu->items;
	$GLOBALS["_MENU_PROPS"] = $menu_obj;

	$display_menu_from = $GLOBALS["_MENU_PROPS"]->acf['display_menu_from']? $GLOBALS["_MENU_PROPS"]->acf['display_menu_from'] : 0;
	// js__print_js_object_in_html_from_php_array( ['_$_', 'headerMenu'], $menu->map );
	

	/*3*/// REST ENDPOINTS
	js__print_js_object_in_html_from_php_array( ['_$_', 'RESTendpoints'], $GLOBALS["REST_ENDPOINTS"] );
	

	/*4*/// CONTACTS
  global $_CONTACTS_;
  $contacts_WP_Post = wp_post__get_lang_post( get_option('__contact_post_id__') );
	$contacts_WP_Post->acf = get_fields($contacts_WP_Post->ID);
	$_CONTACTS_ = $contacts_WP_Post->acf;
	$_CONTACTS_['all_addresses'] = array_merge( array($contacts_WP_Post->acf['head_office_address']), $contacts_WP_Post->acf['addresses'] );
	$first_selected_pin = null;






	// new
	$addressIndexCountryCodeMap = [];
	foreach ($_CONTACTS_['all_addresses'] as $i => $address) {
		$code = strtoupper($address['country_code']);
		if ($code === 'RU') {
			$addressIndexCountryCodeMap[] = "$code-" . strtoupper($address['region_code']);
		}
		else {
			$addressIndexCountryCodeMap[] = $code;
		}
	}


	if (isset($GLOBALS["_USER_IP_DATA_"]) && !isset($GLOBALS["_USER_IP_DATA_"]['message'])) {
		$current_country_code = $GLOBALS["_USER_IP_DATA_"]['country_code'];
		if ($current_country_code === 'RU') {
			$rus_reg_code = get_rus_reg_code();
			if ( $index = array_search("RU-$rus_reg_code", $addressIndexCountryCodeMap) ) {
				$_CONTACTS_['all_addresses'][$index]['selected_in_map'] = true;
				$first_selected_pin = $_CONTACTS_['all_addresses'][$index];
			}
			else {
				$_CONTACTS_['all_addresses'][0]['selected_in_map'] = true;
				$first_selected_pin = $_CONTACTS_['all_addresses'][0];
			}
		}
		else if ( $index = array_search($current_country_code, $addressIndexCountryCodeMap) ) {
			$_CONTACTS_['all_addresses'][$index]['selected_in_map'] = true;
			$first_selected_pin = $_CONTACTS_['all_addresses'][$index];
		}
		else {
			$_CONTACTS_['all_addresses'][0]['selected_in_map'] = true;
			$first_selected_pin = $_CONTACTS_['all_addresses'][0];
		}
	}
	else {
		$_CONTACTS_['all_addresses'][0]['selected_in_map'] = true;
		$first_selected_pin = $_CONTACTS_['all_addresses'][0];
	}
	$_CONTACTS_['current_target_address'] = $first_selected_pin;














	$_CONTACTS_['map'] = [
		'first_selected_pin' => $first_selected_pin,
	];
	// window._$_.map
	js__print_js_object_in_html_from_php_array( ['_$_', 'map'], [
    'addresses' => $_CONTACTS_['all_addresses'],
    'map_center' => $contacts_WP_Post->acf['map_center'],
		'map_contact_card' => $contacts_WP_Post->acf['map_contact_card'],
		'first_selected_pin' => $first_selected_pin,
	]);

	// window._$_.contacts
	unset($contacts_WP_Post->acf['head_office_address']);
	unset($contacts_WP_Post->acf['addresses']);
	unset($contacts_WP_Post->acf['map_center']);
	unset($contacts_WP_Post->acf['map_contact_card']);


	$contact_us_setting_post = get_post( get_option('__contact_us_settings__') );
	$contact_us_setting_post->acf = [];
	$contact_us_setting_post->acf = get_fields( $contact_us_setting_post->ID );
	$manager_tel = $contact_us_setting_post->acf['tel_settings']['manager_tel'];
	$whatsapp_link = $contact_us_setting_post->acf['whatsapp']['tel'];
	$manager_email = $contact_us_setting_post->acf['email_settings']['manager_email'];

	$_CONTACTS_['manager_tel'] = $manager_tel;
	$_CONTACTS_['manager_email'] = $manager_email;
	$_CONTACTS_['whatsapp_link'] = $whatsapp_link;

	js__print_js_object_in_html_from_php_array( ['_$_', 'contacts'], [
		'manager_tel' => $manager_tel,
		'manager_email' => $manager_email,
	]);


	/*4*/// FOOTER
	$GLOBALS["_FOOTER_"] = [
		'top-margin' => true,
	];

	$prod_type_terms_data = get__product__product_type_terms_data();
	$prod_type_terms_data['map_tree'];

	$themeDir = get_template_directory_uri();
?>




<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<title><?php echo wp_title('') ?></title>
	<?php if (isset($seo['raw_head_code'])) echo $seo['raw_head_code'] . "\n"; ?>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<?php wp_head(); ?>

	<!-- <link rel="canonical" href="<?php the_permalink(_current_POST_ID_); ?>"> -->

	<meta name="facebook-domain-verification" content="tnlm01uzu9bpylt7fgu497r0ckumca" />

	<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
	<link rel="manifest" href="/site.webmanifest">
	<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
	<meta name="msapplication-TileColor" content="#2b5797">
	<meta name="theme-color" content="#ffffff">

	<script>
		// if IE
		if ( navigator.userAgent.indexOf('MSIE')!==-1 || navigator.appVersion.indexOf('Trident/') > -1 ) {
			if (window.confirm('Этот браузер слишком стар для корректной работы данного сайта. Рекомендуем вам установить Google Chrom. Скачать Google?')) {
				window.location.href='https://www.google.com/chrome/?brand=CHBD&gclid=Cj0KCQiArozwBRDOARIsAHo2s7sp7VjWi08gsx0u8I0lMX2vadD_sinly4uxv8wrfadQ7Iy07yXC5fYaAqGuEALw_wcB&gclsrc=aw.ds';
			};
		};
	</script>

	<!-- Google Tag Manager -->
	<script>
		(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-N6XWV7R');
	</script>
	<!-- End Google Tag Manager -->

	
	<!-- Facebook Pixel Code -->
	<script>
		!function(f,b,e,v,n,t,s)
		{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
		n.callMethod.apply(n,arguments):n.queue.push(arguments)};
		if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
		n.queue=[];t=b.createElement(e);t.async=!0;
		t.src=v;s=b.getElementsByTagName(e)[0];
		s.parentNode.insertBefore(t,s)}(window, document,'script',
		'https://connect.facebook.net/en_US/fbevents.js');
		fbq('init', '512955210096167');
		fbq('track', 'PageView');
	</script>
	<noscript><img height="1" width="1" style="display:none"
		src="https://www.facebook.com/tr?id=512955210096167&ev=PageView&noscript=1"
	/></noscript>
	<!-- End Facebook Pixel Code -->

	<!-- Yandex metrika -->
	<script>
		(function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
		m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
		(window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
	</script>
	<!-- End:Yandex metrika -->
<script type="text/javascript">!function(){var t=document.createElement("script");t.type="text/javascript",t.async=!0,t.src='https://vk.com/js/api/openapi.js?169',t.onload=function(){VK.Retargeting.Init("VK-RTRG-1351551-sZDu"),VK.Retargeting.Hit()},document.head.appendChild(t)}();</script><noscript><img src="https://vk.com/rtrg?p=VK-RTRG-1351551-sZDu" style="position:fixed; left:-999px;" alt=""/></noscript>
	<?php // print__page_loader_syles(); ?>
	<style>
		.my-ui-menu { opacity: 0 }
		[data-d-if] { display: none }
		.mdc-drawer { display: none }
		.slider-hs { min-height: 100vh }
	</style>
</head>









<body <?php body_class(['my-theme']); ?>>
	<!-- Google Tag Manager (noscript) -->
	<noscript>
		<iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N6XWV7R" height="0" width="0" style="display:none;visibility:hidden"></iframe>
	</noscript>
	<!-- End Google Tag Manager (noscript) -->

	<!-- bug fix "beforeunload" event --><iframe name="hidden-iframe" style="position:absolute; visibility:hidden"></iframe>
	<?php // print__page_loader(); ?>




	<div class="global-page-layout">
		<div class="global-page-layout__content">

    <header class="page-header">
      <div class="cg-container common-page__flex-grid-container d-flex align-center pos-rel">
				<!-- logo -->
        <div class="page-header__logo-block__logo-patch"></div>
        <div class="page-header__logo-block" style="color:red">
          <div class="page-header__logo-block__circle"></div>
          <div class="page-header__logo-block__circle-outline"></div>
          <div class="page-header__logo-block__bgr-patch"></div>
          <div class="page-header__logo-block__img">
            <a href="/" class="goToFrontPage">
              <img
                src="<?php echo get_template_directory_uri() ?>/assets/images/svg/logo.svg"
                alt="NEOS Ingredients. НЕОС Ингредиентс"
              />
            </a>
          </div>
        </div>

				<div style="flex-grow:1"></div>

				<!-- menu -->
				<nav class="page-header__top-menu" data-d-if="{ 0:0, <?php echo $display_menu_from ?>:1 }">
					<ul>
						<?php foreach ($GLOBALS["_MENU_MAP"] as $index => $menuItem) { ?>
							<li>
								<?php if (count($menuItem['children'])) { ?>

									<div data-my-ui-menu-activator="<?php echo "hm$index" ?>">
										<span class="a-link text-nowrap <?php if ($menuItem['active']) echo 'color--primary' ?>"><?php
											echo $menuItem['title'];
										?></span>
	
										<div class="my-ui-menu" data-my-ui-menu="<?php echo "hm$index" ?>">
											<ul class="page-header__top-menu__nested-list-1 my-list elevation-4">
												<?php foreach ($menuItem['children'] as $menuSubItem) { ?>
													<li class="my-list__item" data-my-ui-menu-item="<?php echo "hm$index" ?>">
														<a href="<?php echo $menuSubItem['url'] ?>"
															 class="a-link-unset text-trim-string-with-dots t-16px <?php if ($menuSubItem['active']) echo 'color--primary' ?>"
															 style="text-decoration: none"
														><?php
															echo $menuSubItem['title'];
														?></a>
													</li>
												<?php } ?>
											</ul>
										</div>
									</div>

								<?php } else { ?>
									<a href="<?php echo $menuItem['url'] ?>"
										 class="a-link text-nowrap <?php if ($menuItem['active']) echo 'color--primary' ?>"
									><?php
										echo $menuItem['title']
									?></a>
								<?php } ?>
							</li>
						<?php } ?>
					</ul>
				</nav>
				

        <div style="flex-grow:1"></div>

				<?php get_search_form() ?>

        <div class="d-flex align-center">

					<!-- socials block -->
					<?php if ($_CONTACTS_['socials']) { ?>
						<?php foreach ($_CONTACTS_['socials'] as $i => $network) { ?>
							<a href="<?php echo $network['link']? $network['link']['url'] : '' ?>"
								class="mdc-icon-button material-icons my__mdc-icon-button--small color--gray_3"
								target="_blank"
								style="<?php echo $network['icon_color']? "color:{$network['icon_color']}!important" : null ?>"
							>
								<div class="my__mdc-icon-button__svg-wrp"
									style="
										width: <?php echo $network['icon_size']? $network['icon_size'] : 24 ?>px;
										height: <?php echo $network['icon_size']? $network['icon_size'] : 24 ?>px;
									"
								><?php
									echo $network['svg_or_icon_name'];
								?></div>
							</a>
						<?php } ?>
					<?php } ?>
					<!-- phone icon -->
					<?php if ($_CONTACTS_['current_target_address']['phone']) { ?>
						<a href="tel:<?php echo string__remove_whitespaces($_CONTACTS_['current_target_address']['phone']) ?>"
							class="mdc-icon-button material-icons my__mdc-icon-button--small color--gray_3"
						>phone</a>
					<?php } ?>
					<?php if ($_CONTACTS_['whatsapp_link']) { ?>
						<a href="https://wa.me/<?php echo string__remove_whitespaces($_CONTACTS_['whatsapp_link']) ?>"
							class="mdc-icon-button material-icons my__mdc-icon-button--small color--gray_3"
						><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 1190.6 841.9" style="enable-background:new 0 0 1190.6 841.9; width: 28px; height: 24px;" xml:space="preserve">
<style type="text/css">
	.st0{fill:#949494;}
</style>
<path class="st0" d="M802.8,508.8c-14.8-7.7-28.8-15.5-43.6-23.2c-13.4-7-26-13.4-39.4-19.7c-9.1-4.2-13.4-2.1-19.7,5.6  c-11.2,13.4-23.2,26.7-35.2,40.1c-4.9,5.6-11.2,7-18.3,3.5c-3.5-1.4-7-3.5-10.5-4.9c-57.6-26.7-100.5-69.6-130.8-124.4  c-6.3-11.2-4.9-15.5,4.2-24.6c9.8-10.5,20.4-20.4,26.7-33.7c2.8-5.6,3.5-11.2,1.4-17.6c-9.8-26.7-19.7-53.4-30.2-80.1  c-1.4-3.5-3.5-7.7-5.6-11.2c-2.8-5.6-7.7-7.7-14.1-7.7c-4.9,0-9.8-0.7-14.8-0.7c-12-1.4-23.9,0-33,8.4  c-28.1,24.6-42.9,54.8-43.6,92.1c0.7,6.3,0.7,12.7,2.1,19c3.5,23.2,12,45,23.9,65.4c18.3,31.6,39.4,62.6,63.3,90.7  c27.4,31.6,58.4,60.5,94.9,81.6c30.9,18.3,64.7,30.2,98.4,42.2c19.7,7,39.4,7,59.8,2.8s38-14.8,53.4-28.1c7.7-7,13.4-15.5,16.2-25.3  c2.1-9.1,4.2-19,6.3-28.1C816.1,517.9,814,515.1,802.8,508.8z M1001,317.6C978.5,224.1,929.3,146.7,854.1,87  C785.9,33.5,707.8,4.7,621.4,0.5c-30.9-1.4-61.2,0-91.4,5.6c-98.4,18.3-179.3,65.4-243.2,142c-52.7,63.3-83.7,135.7-92.8,217.2  c-3.5,33.7-3.5,67.5,1.4,101.2c7,53.4,24.6,103.3,52,150.4c2.1,4.2,2.8,7.7,1.4,12c-23.2,68.2-46.4,137.1-68.9,205.3  c-0.7,2.1-1.4,4.2-2.1,7.7c3.5-0.7,5.6-1.4,7.7-2.1c71-22.5,141.3-45,212.3-68.2c4.9-1.4,8.4-1.4,12.7,1.4  c52.7,28.1,108.3,43.6,168,47.1c35.9,2.1,71.7,0,107.6-7.7C781,792.1,859.7,745,920.9,669.8c56.9-69.6,87.2-149.7,92.1-239  C1013.7,392.8,1010.1,354.8,1001,317.6z M943.4,428.6c-4.2,73.1-28.8,138.5-74.5,195.4c-52.7,65.4-120.2,106.2-202.5,123  c-26.7,5.6-53.4,7-80.8,6.3c-60.5-2.8-116-20.4-167.3-52.7c-4.2-2.8-7.7-2.8-12-1.4c-39.4,12.7-79.4,25.3-118.8,38  c-1.4,0.7-3.5,0.7-6.3,1.4c0.7-2.8,1.4-4.9,2.1-7.7c12.7-38,25.3-76.6,38.7-114.6c1.4-3.5,0.7-6.3-1.4-9.8  c-31.6-44.3-51.3-93.5-58.4-147.6c-13.4-100.5,12-190.5,77.3-268.6c54.1-64.7,123-104.8,206.7-118.1  c101.9-16.2,193.3,8.4,273.5,74.5c62.6,51.3,101.9,118.1,118.1,197.6C943.4,371.7,945.5,399.8,943.4,428.6z"/>
</svg></a>
					<?php } ?>

					
					<?php /* print_ui__lang_list_selection([
						'menu_id' => 'lm1',
						'current_lang_code' => $current_lang_code,
						'langs' => $langs,
					]) */ ?>


					<button
						id="headerMenuBtn"
						class="mdc-icon-button material-icons my__mdc-icon-button--small color--gray_3"
						data-d-if="{ 0:1, <?php echo $display_menu_from ?>:0 }"
					>menu</button>

        </div>
      </div><!-- .cg-container -->
		</header>
		

		<!-- DRAWER -->
		<aside class="mdc-drawer mdc-drawer--modal" style="width:272px">
			<div class="mdc-drawer__content">
				<div class="main-drawer__header">
					<div class="main-drawer__header__bottom-line"></div>
					<div class="main-drawer__logo">
						<div class="main-drawer__logo__circle-line"></div>
						<div class="main-drawer__logo__circle-patch"></div>
						<img
							src="<?php echo get_template_directory_uri() ?>/assets/images/svg/logo.svg"
							alt="NEOS Ingredients. НЕОС Ингредиентс"
						/>
					</div>
				</div>

				<nav>
					<ul class="my-list">
						<?php foreach ($GLOBALS["_MENU_MAP"] as $index => $menuItem) { ?>
							
							<li class="my-list__item my-list__item--no-css-hover-active">
							
								<?php if (count($menuItem['children'])) { ?>
									<span class="a-link-unset u-cursor-pointer <?php if ($menuItem['active']) echo 'color--primary' ?>" data-my-ui-nested-list-expand-toggle>
										<span class="my__mdc-ripple-dark my__mdc-ripple--is-child"></span>
										<?php echo $menuItem['title'] ?>
									</span>
									<ul class="my-list pa-0">
										<?php foreach ($menuItem['children'] as $menuSubItem) { ?>
											<li class="my-list__item my-list__item--no-css-hover-active">
												<a href="<?php echo $menuSubItem['url'] ?>"
													class="a-link-unset t-16px <?php if ($menuSubItem['active']) echo 'color--primary' ?>"
													style="text-decoration: none; padding-left: 32px"
												>
													<span class="my__mdc-ripple-dark my__mdc-ripple--is-child"></span>
													<?php echo $menuSubItem['title'] ?>
												</a>
											</li>
										<?php } ?>
									</ul>

									<div data-my-ui-nested-list-expand-toggle class="my-list__item-expand-icon-wrp my-icon-btn my-icon-btn--small">
										<span class="my__mdc-ripple-dark my__mdc-ripple--is-child"></span>
										<span class="material-icons my-list__item-expand-icon">expand_more</span>
									</div>

								<?php } else { ?>
									<a href="<?php echo $menuItem['url'] ?>"
										 class="a-link-unset <?php if ($menuItem['active']) echo 'color--primary' ?>"
									>
										<span class="my__mdc-ripple-dark my__mdc-ripple--is-child"></span>
										<?php echo $menuItem['title'] ?>
									</a>
								<?php } ?>

							</li>
						<?php } ?>

					</ul>
				</nav>
			</div>
		</aside>
		<div class="mdc-drawer-scrim"></div>

		<div class="page-header__patch"></div>

		<?php print__ads(); ?>