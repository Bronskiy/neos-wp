<?php

add_action( 'wp_enqueue_scripts', function () {
	$themeDir = get_template_directory_uri();

	wp_enqueue_style( 'Material_Icons', "https://fonts.googleapis.com/icon?family=Material+Icons",  NULL, NULL );
	wp_enqueue_style( 'Bbarkentina-1-font', "$themeDir/assets/fonts/Barkentina_1.css",  NULL, NULL );
	// wp_enqueue_style( 'vendor-styles', "$themeDir/assets/css/vendors-styles.css",  NULL, '1.0.12'/*microtime()*/ );
	wp_enqueue_style( 'main', "$themeDir/assets/css/main.css",  NULL, '1.0.15'/*microtime()*/ );


	if (is_front_page()) {
		//Remove Gutenberg Block Library CSS from loading on the frontend
		add_action( 'wp_enqueue_scripts', function() {
			wp_dequeue_style( 'wp-block-library' );
			wp_dequeue_style( 'wp-block-library-theme' );
			wp_dequeue_style( 'wc-block-style' ); // Remove WooCommerce block CSS
		}, 100 );
	}
});